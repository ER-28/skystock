<?php
require_once "../lib/service/AuthService.php";

use JetBrains\PhpStorm\NoReturn;
use lib\service\AuthService;
session_start();

if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
    header('Location: /register.php');
    exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

#[NoReturn] function redirect_to_login($err): void
{
    header('Location: /login.php?error='.$err);
    exit();
}

if ($password != $password_confirm) {
    redirect_to_login('passwords do not match');
}

if (empty($username) || empty($password)) {
    redirect_to_login('empty fields');
}

if ($password < 8) {
    redirect_to_login('password too short');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_to_login('invalid email');
}


AuthService::register($username, $password);
