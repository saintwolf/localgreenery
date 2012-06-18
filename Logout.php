<?php 
    require_once('autoload.php');
    $session->init();
    
    $session->logout();
    $session->setFlash('You have been successfully logged out!');
    header('location:/main_login.php');
    exit;
?>