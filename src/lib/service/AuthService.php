<?php
namespace lib\service {

    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/db/models/Users.php';

    use db\models\Users;

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
            $user = new Users();
            $user = $user->findByEmailOrUsername($email);

            if (!$user) {
                redirect_to_login('user not found');
            }

            if (!password_verify($password, $user->getData()['password'])) {
                redirect_to_login('invalid password');
            }

            $_SESSION['user'] = $user;
            header('Location: /');
        }

        public static function register(string $username, string $password)
        {
            $user = new Users();
            $user = $user->findByEmailOrUsername($username);

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

}