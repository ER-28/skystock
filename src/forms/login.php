<?php

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location: /login.php');
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

function redirect_to_login($err)
{
    header('Location: /login.php?error='.$err);
    exit();
}

if (empty($username) || empty($password)) {
    redirect_to_login('empty fields');
}

if ($password < 8) {
    redirect_to_login('password too short');
}

if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
    redirect_to_login('invalid email');
}


require_once '../lib/service/AuthService.php';

AuthService::login($username, $password);
