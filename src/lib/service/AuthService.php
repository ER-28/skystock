<?php
namespace lib\service {

    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/db/models/Users.php';
    require_once $root . '/lib/orm/Query.php';

    use db\models\Users;
    use lib\orm\Query;
    
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

            $_SESSION['user'] = $user->data['id'];
            header('Location: /');
        }

        public static function register(string $username, string $password): void
        {
            $user = new Users();
            $user = $user->findByEmailOrUsername($username);

            if ($user) {
                redirect_to_login('user already exists');
            }
            
            $all_users = new Query(new Users());
            $all_users = $all_users->get();
            
            $role = 0;
            if (count($all_users) === 0) {
                $role = 1;
            }

            $user = new Users();
            $user->setData(
                [
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'email' => $username,
                    'role' => $role
                ]
            );
            $user->save();
            
            $query = new Query($user);
            $user = $query
                ->select(['id'])
                ->where('username', $username)
                ->get()
                ->first();
            
            $_SESSION['user'] = $user->data['id'];
            header('Location: /');
        }
        
        public static function logout(): void
        {
            session_destroy();
            header('Location: /login.php');
        }

    }

}