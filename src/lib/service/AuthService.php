<?php
require_once '../db/models/Users.php';

class AuthService
{

    public static function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login.php');
            exit();
        }
    }

    public static function login(string $email, string $password)
    {
        $user = Users::findByEmail($email);

        if (!$user) {
            redirect_to_login('user not found');
        }

        if (!password_verify($password, $user->password)) {
            redirect_to_login('invalid password');
        }

        $_SESSION['user'] = $user;
        header('Location: /');
    }

}