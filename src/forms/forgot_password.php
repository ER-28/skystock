<?php
    session_start();
    
    require_once "../db/models/RecoveryToken.php";
    require_once "../lib/orm/Query.php";
    
    if (!isset($_POST['username'])) {
        header('Location: /login.php');
        exit();
    }
    
    $username = $_POST['username'];
    
    $server_url = $_SERVER['HTTP_HOST'];
    
    try {
        $token = bin2hex(random_bytes(32));
    } catch (\Random\RandomException $e) {
        echo 'Error generating token';
        exit();
    }
    
    $token_model = new db\models\RecoveryToken();
    $token_model->setData([
        'username' => $username,
        'token' => $token
    ]);
    $token_model->save();
    
    $html_msg = '
        <a href="http://'.$server_url.'/reset_password.php?token='.$token_model->data['token'].'">
            Reset password
        </a>
    ';
    
    mail(
        $username,
        'Forgot password',
        $html_msg
    );
    
    echo 'Email sent';
    echo '<a href="/login.php">Back to login</a>';
    echo $html_msg;
