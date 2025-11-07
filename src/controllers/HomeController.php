<?php 

namespace App\Controllers;
use App\models\BPlayer;
class HomeController {
    public function index() {
        $bPlayers = BPlayer::findAllBPlayerWithStatus('approved');
        $data = [
            'bPlayers' => $bPlayers
        ];
        view('clients.home', $data);
    }
}