<?php 

namespace App\Controllers;

use App\models\User;
class AuthController {
    public function showLoginPage() {
        view("clients.auth.login");
    }

    public function loginProcess() {
        $email = $_POST['email'];
        $password = $_POST['password'];


        $user = User::findByEmail($email);

        if(!$user) {
            session_flash('error', 'Email or password is incorrect.');
            redirect('login');
            return;
        }
        if(password_verify($password, $user->password)) {
            $_SESSION['user'] = [
            'id' => $user->id,
            'fullname' => $user->fullname,
            'username' => $user->username,
            'role' => $user -> role
            ];

            redirect("");
        }
        else {
            session_flash('error', 'Email or password is incorrect.');
            redirect("login");
        }
    }

    public function showRegisterPage() {
        view("clients.auth.register");
    }

    public function registerProcess() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];

        $existingUser = User::findByEmail($email);

        if($existingUser) {
            echo `<script>alert("Email already registered")</script>`;
            redirect('register');
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'fullname' => $fullname,
            'username' => $username,
            'password' => $hashedPassword,
            'email' => $email
        ];

        User::create($data);

        session_flash('success', 'Register successfully.');
        redirect('login');
    }

    public function logout() {
        session_unset();
        redirect("");
    }
}