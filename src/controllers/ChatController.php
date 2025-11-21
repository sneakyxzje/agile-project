<?php 

namespace App\controllers;

use App\models\Chat;
use App\models\User;
use Exception;
use Predis\Client;
class ChatController {
    public function sendMessage() {
        if(session_status() === PHP_SESSION_NONE) session_start();
        header("Content-Type: application/json");
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $senderId = $_SESSION['user']['id'] ?? 0;
            $senderInfo = User::getChatInfo($senderId);
            $senderAvatar = $senderInfo['avatar'];
            $receiverId = $input['receiver_id'] ?? 0;
            $content = $input['message'] ?? '';
            
            if(!$senderId || !$receiverId || !$content) {
                echo json_encode(['status' => 'error', 'msg' => ['Thiếu dữ liệu']]);
                return;
            } 

            $newMsgId = Chat::sendMessage($senderId, $receiverId, $content);
            if (!$newMsgId) {
                throw new Exception("Lỗi: Không thể lưu tin nhắn vào Database!");
            }
            $client = new Client([
                'scheme' => 'tcp',
                'host' => '127.0.0.1',
                'port' => 6379,
            ]);

            $payload = [
                'type' => 'chat_messages',
                'from_id' => $senderId,
                'to_id' => $receiverId,
                'content' => $content,
                'avatar' => $senderAvatar,
                'time' => date('H:i')
            ];

            $client->publish('chat_channel', json_encode($payload));

            echo json_encode(['status' => 'success']);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function getConversations() {
        if(session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        try {
            $currentUserId = $_SESSION['user']['id'] ?? 0;
            if (!$currentUserId) {
                echo json_encode(['status' => 'error', 'msg' => 'Chưa đăng nhập']);
                return;
            }

            $conversations = Chat::getRecentConversations($currentUserId);

            echo json_encode([
                'status' => 'success', 
                'data' => $conversations
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }

    public function loadHistory() {
    if(session_status() === PHP_SESSION_NONE) session_start();
    header('Content-Type: application/json');
    try {
        $currentUserId = $_SESSION['user']['id'] ?? 0;
        $partnerId = $_GET['partner_id'] ?? 0; 

        if (!$currentUserId || !$partnerId) {
            echo json_encode(['status' => 'error', 'msg' => 'Thiếu ID']);
            return;
        }

        $messages = Chat::getConversation($currentUserId, $partnerId);

        echo json_encode([
            'status' => 'success', 
            'data' => $messages
        ]);

    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
    }
}
}