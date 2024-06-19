<?php
    
    use db\models\RecoveryToken;
    use db\models\Users;
    use JetBrains\PhpStorm\NoReturn;
    use lib\orm\Query;
    
    require_once "../lib/orm/Query.php";
    require_once "../db/models/Users.php";
    require_once "../db/models/RecoveryToken.php";
    
    #[NoReturn] function redirect($err): void
    {
        header('Location: /reset_password.php?error='.$err.'&token='.$_GET['token']);
        exit();
    }
    
    if (
        !isset($_POST['password']) ||
        !isset($_POST['password_confirm']) ||
        !isset($_GET['token'])
    ) {
        redirect('empty fields');
    }
    
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $token = $_GET['token'];
    
    if ($password != $password_confirm) {
        redirect('passwords do not match');
    }
    
    if ($password < 8) {
        redirect('password too short');
    }
    
    // get username from token

    $query = new Query(new RecoveryToken());
    $recovery_token = $query
        ->where('token', $token)
        ->get()
        ->first();
    
    if ($recovery_token === null) {
        redirect('invalid token');
    }
    
    $query = new Query(new Users());
    $user = $query
        ->where('username', $recovery_token->getData()['username'])
        ->get()
        ->first();
    
    if ($user === null) {
        redirect('user does not exist');
    }
    
    $user->setData([
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
    
    $user->update();
    
    $recovery_token->delete();
    
    header('Location: /login.php');