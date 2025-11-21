<?php 

namespace App\models;


class Chat extends BaseModel {
    protected $table = "messages";

    public static function sendMessage($senderId, $receiverId, $content) {
        return self::create([
            'from_id' => $senderId, 
            'to_id' => $receiverId, 
            'content' => $content
        ]);
    }

    public static function getConversation($userId, $partnerId) {
    $model = new static;
    
    $sql = "SELECT * FROM messages 
            WHERE (from_id = :user_1 AND to_id = :partner_1) 
               OR (from_id = :partner_2 AND to_id = :user_2)
            ORDER BY created_at ASC"; 
            
    $stmt = $model->conn->prepare($sql);
    
    $stmt->execute([
        'user_1' => $userId,
        'partner_1' => $partnerId,
        'partner_2' => $partnerId,
        'user_2' => $userId
        ]);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getRecentConversations($currentUserId) {
        $model = new static;
        $sql = "
            SELECT 
                users.id as partner_id,
                users.fullname as partner_name,
                COALESCE(bplayers.main_image, users.avatar) as partner_avatar, -- Ưu tiên ảnh Player
                m.content as last_message,
                m.created_at as last_time,
                m.from_id as last_sender_id
            FROM users
            JOIN (
                SELECT 
                    IF(from_id = :me, to_id, from_id) as partner_id,
                    MAX(id) as max_msg_id
                FROM messages
                WHERE from_id = :me OR to_id = :me
                GROUP BY partner_id
            ) as latest_msg ON users.id = latest_msg.partner_id
            JOIN messages m ON m.id = latest_msg.max_msg_id
            LEFT JOIN bplayers ON users.id = bplayers.user_id -- Join để lấy ảnh nếu là Player
            ORDER BY m.created_at DESC
        ";

        $stmt = $model->conn->prepare($sql);
        $stmt->execute(['me' => $currentUserId]);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}