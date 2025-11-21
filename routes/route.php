<?php

use App\controllers\AdminController;
use App\Controllers\AuthController;
use App\controllers\BPlayerController;
use App\controllers\ChatController;
use App\Controllers\HomeController;
use App\Controllers\PaymentController;
use App\Controllers\RentController;

$router = new \Bramus\Router\Router();
$router->setBasePath('/project');

// Authentication
$router->get("/", HomeController::class . '@index');
$router->get("/login", AuthController::class . '@showLoginPage');
$router->post("/login-handle", AuthController::class . '@loginProcess');
$router->get("/register", AuthController::class . '@showRegisterPage');
$router->post("/register-handle", AuthController::class . '@registerProcess');
$router->get("/logout", AuthController::class . '@logout');
// End of authentication


// BPlayer
$router->get("/become-bplayer", BPlayerController::class . '@showBPlayerPage');
$router->post("/become-bplayer-process", BPlayerController::class . '@becomeBPlayerProcess');
$router->get("/bplayer/{id}", BPlayerController::class . '@showBPlayerDetails');
// End of BPlayer

// Payment
$router->get('/momo', PaymentController::class . '@showForm');
$router->post('/momo/payment', PaymentController::class . '@createPayment');
$router->post('/momo/ipn', PaymentController::class . '@handleIPN');
$router->get('/momo/return', PaymentController::class . '@handleReturn');
// End of payment

// Rent
$router->get("/rent-details/{id}", RentController::class . '@rentDetails');
$router->get("/rent-list", RentController::class . '@rentList');
$router->post('/rent', RentController::class . '@rentPlayer');
$router->post('/rent/{id}/handle', RentController::class . '@rentHandle');
$router->post('/rent-confirm/{id}', RentController::class . '@rentConfirm');
// End of rent


// Chat
$router->post('/chat/send', ChatController::class . '@sendMessage');
$router->get('/chat/history',ChatController::class . '@loadHistory');
$router->get('/chat/conversations', ChatController::class . '@getConversations');
// Admin zone
$router->before('GET|POST', '/admin/.*', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        redirect404(); 
        exit(); 
    }
});
$router->get("admin/dashboard", AdminController::class . '@showDashboard');
$router->get("admin/users", AdminController::class . '@showAllUsers');
$router->get("admin/users/edit/{id}", AdminController::class . '@editUserPage');
$router->post("admin/users/update/{id}", AdminController::class . '@updateUser');
$router->get("admin/users/add", AdminController::class . "@addUserPage");
$router->post("admin/users/create", AdminController::class . "@createUser");
$router->get("admin/rents/pending", AdminController::class . "@showPendingList");
$router->post("admin/rents/cancel/{id}", AdminController::class . "@cancelRent");
$router->get("admin/bplayers/list", AdminController::class . "@showBPlayerList");
$router->post("admin/bplayers/handle/{id}", AdminController::class . "@handleBPlayer");
//
$router->run();