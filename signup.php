<?php
session_start();


if(isset($_POST['signup'])) {
    include_once 'config.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO login (username, email, password_h) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password_hash);
    if ($stmt === false) {
        die("Error: Failed to prepare statement.");
    }
    if($stmt->execute() === true) {
        header("Location: Login.html");
        exit();
    } else {
        $_SESSION['signup_error'] = "Registration failed. Please try again.";
    }
}

        if(isset($_SESSION['signup_error'])) {
            echo '<p>' . $_SESSION['signup_error'] . '</p>';
            unset($_SESSION['signup_error']); 
        }
        ?>
        
