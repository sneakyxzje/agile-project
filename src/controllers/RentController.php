<?php
namespace App\controllers;

use App\models\Rent;
use App\models\User;
use App\models\BPlayer;
class RentController {
    public function rentPlayer() {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            session_flash('error', 'Bạn cần đăng nhập để thực hiện chức năng này.');
            redirect("login");
            return;
        }
        $bPlayerId = $_POST['bPlayerId'] ?? null;
        $hours     = $_POST['hours'] ?? null;
        $totals    = $_POST['total_price'] ?? null;
        $user = User::find($userId);
        $userDiamond = $user->diamond;
        if($userDiamond < $totals) {
            session_flash('error', 'You dont have enough diamonds!.');
            redirect("");
            return;
        }

        $newDiamond = $userDiamond - $totals;
        User::update($userId, ['diamond' => $newDiamond]);
        
        $rentData = [
            'user_id' => $userId,
            'bplayer_id' => $bPlayerId,
            'amount' => $totals,
            'hours' => $hours,
            'status' => "pending"
        ];
        Rent::create($rentData);
        session_flash('success', "Đơn thuê tạo thành công! Số kim cương còn lại: $newDiamond");
        redirect("rent-details/{$userId}");
    }

    public function rentDetails($id) {
  
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1; 

        $perPage = 10; 

        $totalRents = Rent::countByUserId($id);

        $totalPages = ceil($totalRents / $perPage);

        $rentDetails = Rent::findPaginatedByUserId($id, $page, $perPage);

        $data = [
            'rentDetails' => $rentDetails,
            'totalPages'  => $totalPages,
            'currentPage' => $page,
        ];

        view('clients.rent.detail', $data);
    }

    public function rentList() {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            redirect('');
            return;
        }

        $bplayer = BPlayer::findByUserId($userId); 

        if (!$bplayer) {
            session_flash('error', 'Bạn không phải là BPlayer.');
            redirect('');
            return;
        }

        $bplayerId = $bplayer['id']; 

        $rentNew = Rent::findAllByBPlayerIdAndStatus($bplayerId, 'pending');
        $rentAccepted = Rent::findAllByBPlayerIdAndStatus($bplayerId, 'accepted');
        $rentCompleted = Rent::findAllByBPlayerIdAndStatus($bplayerId, 'completed');
        $rentCancelled = Rent::findAllByBPlayerIdAndStatus($bplayerId, 'cancelled');
        $data = [
            'rentNew'       => $rentNew,
            'rentAccepted'  => $rentAccepted,
            'rentCompleted' => $rentCompleted,
            'rentCancelled' => $rentCancelled,
        ];
        view('clients.rent.list', $data);
    }
    public function rentHandle($rentId) {
        
        $userId = $_SESSION['user']['id'];
        $action = $_POST['action'] ?? null;

        $rent = Rent::find($rentId);
            if ($rent->status !== 'pending') {
            session_flash('error', 'Đơn thuê này đã được xử lý trước đó.');
            redirect("rent-list");
            return;
        }
        $status = '';
        if ($action === 'accept') {
            $status = 'accepted';
            $bplayer = BPlayer::find($rent->bplayer_id); 
            $bplayerUser = User::find($bplayer->user_id); 

            $newDiamond = $bplayerUser->diamond + $rent->amount;
            User::update($bplayerUser->id, ['diamond' => $newDiamond]);

        } elseif ($action === 'deny') {
            $status = 'cancelled';
        }

        if ($status) {
            Rent::update($rentId, ['status' => $status]);
            session_flash('success', "Đơn thuê đã được cập nhật thành '$status'.");
        }
        redirect("rent-list");
    }    

    public function rentConfirm($rentId) {
        $rent = Rent::find($rentId);

        if (!$rent) {
            redirect404(); 
            return;
        }

        if ($rent->status !== 'accepted') {
            session_flash('error', 'Không thể thực hiện hành động này. Đơn thuê không ở trạng thái "Đã nhận".');
            redirect("rent-details/" . $rent->user_id);
            return;
        }

        $action = $_POST['action'] ?? null;
        if ($action === 'confirm') {
            Rent::update($rentId, ['status' => 'completed']);
            session_flash('success', "Đã xác nhận hoàn thành đơn thuê #{$rentId}.");
        }
        redirect("rent-details/" . $rent->user_id);
    }
}