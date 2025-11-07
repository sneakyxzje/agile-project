<?php 

namespace App\controllers;

use App\models\BPlayer;
use App\models\Rent;
use App\models\User;

class AdminController {
    public function showDashboard() {
        $allUser = User::countUser();
        $allBPlayer = User::countBPlayer();
        $pendingRentsCount = Rent::countByStatus('pending');
        $latestUsers = User::findLatest(5);
        $latestBPlayers = BPlayer::findLatest(5);
        $latestCompletedRents = Rent::findLatestCompleted(5);
        $topBPlayers = BPlayer::findTopByRent(3);
        $data = [
            "allUser" => $allUser,
            "allBPlayer" => $allBPlayer,
            "pendingRentsCount" => $pendingRentsCount,
            'latestUsers' => $latestUsers,
            'latestBPlayers' => $latestBPlayers,
            'latestCompletedRents' => $latestCompletedRents,
            'topBPlayers'       => $topBPlayers,
        ];
        view('admin.dashboard', $data);
    }

    public function showAllUsers() {
        $allUsers = User::getAllUsersWithBPlayerInfo();
        $data = [
            'allUsers' => $allUsers,
        ];
        view('admin.user.list', $data);
    }

    public function editUserPage($userId) {
        $user = User::findWithBPlayerInfo($userId);
        view('admin.user.edit', ['user' => $user]);
    }
    public function updateUser($userId) {
        $updateData = [
            'fullname' => $_POST['fullname'] ?? '',
            'email' => $_POST['email'] ?? '',
            'role' => $_POST['role'] ?? 'user',
            'diamond' => $_POST['diamond'] ?? 0,
        ];

        if(!empty($_POST['new_password'])) {
            $updateData['password'] = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        }

        User::update($userId, $updateData);
        session_flash('success', "Cập nhật thông tin cho User #{$userId} thành công!");
        redirect('admin/users/');
    }

    public function addUserPage() {
        view('admin.user.add');
    }

    public function createUser() {
        if (empty($_POST['fullname']) || empty($_POST["email"]) || empty($_POST['password']) || empty($_POST['username'])) {
            session_flash('error', 'Vui lòng điền đầy đủ các trường bắt buộc.');
            redirect('admin/users/add'); 
            return; 
        }
        $createData = [
            'fullname' => $_POST['fullname'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'role' => $_POST['role'] ?? 'user',
            'diamond' => $_POST['diamond'] ?? 0
        ];

        if(!empty($_POST['password'])) {
            $createData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        User::create($createData);
        session_flash('success', "Tạo mới user thành công!");
        redirect('admin/users');
    }

    public function showPendingList() {
        $pendingRents = Rent::findAllByStatus('pending');

        view('admin.rent.pending', ['pendingRents' => $pendingRents]);
    }

    public function cancelRent($rentId) {
        $rent = Rent::find($rentId);

        if (!$rent) {
            redirect404();
            return;
        }

        if ($rent->status !== 'pending') {
            session_flash('error', "Không thể hủy đơn này vì nó đã được xử lý.");
            redirect("admin/rents/pending"); 
            return;
        }

        $user = User::find($rent->user_id);

        if ($user) {
            $newDiamond = $user->diamond + $rent->amount;
            User::update($user->id, ['diamond' => $newDiamond]);
        }
        
        Rent::update($rentId, ['status' => 'cancelled']);

        session_flash('success', "Đã hủy đơn hàng #{$rentId} và hoàn tiền cho người dùng thành công.");
        redirect("admin/rents/pending"); 
    }

    public function showBPlayerList() {
        $bPlayerList = BPlayer::findAllBPlayer();

        view("admin.bplayer.list", ['bPlayerList' => $bPlayerList]);
    }

    public function handleBPlayer($id) {
        $action = $_POST['action'] ?? null;
        $newStatus = '';
        if ($action === 'approve') {
            $newStatus = 'approved';
            session_flash('success', "Đã duyệt BPlayer #{$id} thành công.");
        } 
        elseif ($action === 'reject') {
            $newStatus = 'rejected'; 
            session_flash('info', "Đã từ chối BPlayer #{$id}.");
        }
        if ($newStatus) {
            BPlayer::update($id, ['status' => $newStatus]);
        }
        redirect('admin/bplayers/list');
    }
}