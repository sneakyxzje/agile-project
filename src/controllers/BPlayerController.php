<?php 

namespace App\Controllers;

use App\models\BPlayer;

class BPlayerController {
    public function showBPlayerPage() {
        view("clients.bplayer.register");
    }

    public function becomeBPlayerProcess() {
        $nickname = $_POST['nickname'] ?? null;
        $price = $_POST['price_per_hour'] ?? null;
        $games = $_POST['games'] ?? [];

        $uploadDir = dirname(__DIR__, 2) . '/public/temp/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $mainImagePath = null;
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . '_' . basename($_FILES['main_image']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $uploadFile)) {
                $mainImagePath = '/public/temp/' . $fileName;
            }
        }

        $mediaPaths = [];
        if (isset($_FILES['media']['name']) && is_array($_FILES['media']['name'])) {
            foreach ($_FILES['media']['name'] as $key => $name) {
                if ($_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = time() . '_' . basename($name);
                    $uploadFile = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['media']['tmp_name'][$key], $uploadFile)) {
                        $mediaPaths[] = '/public/temp/' . $fileName;
                    }
                }
            }
        }

        $voicePath = null;
        if (isset($_FILES['voice']) && $_FILES['voice']['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . '_' . basename($_FILES['voice']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['voice']['tmp_name'], $uploadFile)) {
                $voicePath = '/public/temp/' . $fileName;
            }
        }

        $bplayer = [
            'user_id' => $_SESSION['user']['id'], 
            'nickname' => $nickname,
            'price_per_hour' => $price,
            'games' => json_encode($games, JSON_UNESCAPED_UNICODE),
            'main_image' => $mainImagePath,
            'media' => json_encode($mediaPaths, JSON_UNESCAPED_UNICODE),
            'voice' => $voicePath,
        ];

        BPlayer::create($bplayer);
        redirect("");
    }

    public function showBPlayerDetails($id) {
        $bPlayer = BPlayer::findBPlayerById($id);
        $bPlayer->media = json_decode($bPlayer->media, true);
        if(!$bPlayer) {
            echo 'BPlayer not found';
            return;
        }

        view('clients.bplayer.detail', ['bPlayer' => $bPlayer, 'userId' => $bPlayer->id]);
    }
}
