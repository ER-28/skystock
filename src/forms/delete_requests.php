<?php
    session_start();
    
    require_once "../lib/SaveRequest.php";
    
    try {
        \lib\SaveRequest::drop();
    } catch (Exception $e) {
        header('Location: /?error=error deleting requests');
        exit();
    }
    
    header('Location: /');