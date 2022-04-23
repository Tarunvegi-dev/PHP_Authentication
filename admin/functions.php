<?php
session_start();

if(isset($_POST['login_btn'])) {
    login();
}

function login() {
    $username = $_POST['username'];
    $password = $_POST ['password'];

    if($username == 'admin' && $password == 'admin') {
        $_SESSION['admin'] = 'admin';
        $_SESSION['success'] = 'admin login successful';
        header('location: index.php');
    } else {
        $_SESSION['error'] = 'Invalid Credentials';
    }
}

function isLoggedIn()
{
    if (isset($_SESSION['admin'])) {
        return true;
    } else {
        return false;
    }
}