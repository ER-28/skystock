<?php
session_start();

require_once "../lib/service/AuthService.php";

use JetBrains\PhpStorm\NoReturn;
use lib\service\AuthService;

AuthService::logout();
