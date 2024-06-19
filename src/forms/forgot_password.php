<?php
    
    use db\models\Users;
    use lib\orm\Query;
    use PHPMailer\PHPMailer\PHPMailer;
    
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/PHPMailer/PHPMailer.php';
    require_once $root . '/lib/orm/Query.php';
    require_once $root . '/db/models/Users.php';
    
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
    <div class="container">
        <h1>Skystock</h1>
        <p>Click the link below to reset your password</p>
        <a href="http://' . $server_url . '/reset_password.php?token=' . $token . '">Reset password</a>
    </div>
    ';
    
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'mailcatcher';
        $mail->SMTPAuth = false;
        $mail->Port = 1025;
    }
    catch (Exception $e) {
        echo 'Error setting up mailer';
        exit();
    }
    
    $mail->setFrom(
        'support@skystock.com',
        'Support',
    );
    
    $userQuery = new Query(new Users());
    $user = $userQuery->where('username', $username)->get()->first();
    
    $mail->addAddress(
        $user->data['email'],
        $user->data['username']
    );
    
    $mail->isHTML(true);
    
    $mail->Subject = 'Password recovery';
    
    $mail->Body = $html_msg;
    
    try {
        $mail->send();
    } catch (Exception $e) {
        echo 'Error sending email';
        exit();
    }
    
    header('Location: /login.php');
