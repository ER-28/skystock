<?php
    
    use db\models\Users;
    use JetBrains\PhpStorm\NoReturn;
    use lib\orm\Query;
    
    require_once "../db/models/Users.php";
    require_once "../lib/orm/Query.php";
    
    if (
        !isset($_POST['username']) ||
        !isset($_POST['email']) ||
        !isset($_POST['role']) ||
        !isset($_GET['id'])
    ) {
        header('Location: /admin.php');
        exit();
    }
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $id = $_GET['id'];
    
    #[NoReturn] function redirect($err): void
    {
        header('Location: /edit_user.php?id='.$_GET['id'].'&error='.$err);
        exit();
    }
    
    if (empty($username) || empty($email) || ($role == null) || empty($id)) {
        redirect('empty fields');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect('invalid email');
    }
    
    if (!in_array($role, [0, 1])) {
        redirect('invalid role');
    }
    
    $query = new Query(new Users());
    $user = $query
        ->where('id', $id)
        ->get()
        ->first();
    
    if ($user === null) {
        redirect('user does not exist');
    }
    
    $user->setData([
        'username' => $username,
        'email' => $email,
        'role' => $role
    ]);
    
    $user->update();
    
    header('Location: /admin.php');