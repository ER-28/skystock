<?php

namespace lib\service;

class AuthService
{

    public static function checkAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login.php');
            exit();
        }
    }

    public static function login(string $email, string $password): void
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

    public static function register(string $username, string $password)
    {
        $user = Users::findByEmail($username);

        if ($user) {
            redirect_to_login('user already exists');
        }

        $user = new Users();
        $user->setData(
            [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'email' => $username,
            ]
        );
        $user->update();

        $_SESSION['user'] = $user;
        header('Location: /');
    }

}