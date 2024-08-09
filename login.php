<?php
session_start();
include 'config.php';
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    
    if($username === 'admin' && $password === 'admin123') { 
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin';
        header("Location: admind.html");
        exit();
    } else {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';
        header("Location: dashboard.html");
        exit();
    }
}

?>

