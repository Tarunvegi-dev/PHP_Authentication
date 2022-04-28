<?php
session_start();

if (isset($_POST['login_btn'])) {
    login();
}

function login()
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'admin' && $password == 'admin') {
        $_SESSION['admin'] = 'admin';
        $_SESSION['admin_success'] = 'admin login successful';
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

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['admin']);
    header("location: login.php");
}

$db = mysqli_connect('localhost', 'root', '', 'multi_login');

if (isset($_POST['add_user'])) {
    register();
}

// REGISTER USER
function register()
{
    global $db;

    // receive all input values from the form.
    $firstname = e($_POST['firstname']);
    $lastname = e($_POST['lastname']);
    $email = e($_POST['email']);
    $mobile = e($_POST['mobile']);
    $password = e($_POST['password']);
    $gender = e($_POST['gender']);
    $profile = $_POST['image'];

    $userId = getUserByEmail($email);
    if (isset($userId)) {
        $_SESSION['error']  = "User with this email already exists!!";
        echo "<script>alert('User with this email already exists!!')</script>";
    } else {
        $query = "INSERT INTO users (firstname, lastname, email, user_type, password, mobile, gender, profile) 
                          VALUES('$firstname', '$lastname', '$email',  'user' ,'$password', '$mobile', '$gender', '$profile')";
        mysqli_query($db, $query);
    }
}

if (isset($_POST['edit_user'])) {
    update();
}

// REGISTER USER
function update()
{
    global $db;

    // receive all input values from the form.
    $first_name = e($_POST['first_name']);
    $last_name = e($_POST['last_name']);
    $_mobile = e($_POST['_mobile']);
    $_password = e($_POST['_password']);
    $_gender = e($_POST['_gender']);
    $_profile = $_POST['_image'];
    $_email = $_POST['_email'];

    $query = "UPDATE users SET 
    firstname = '$first_name', 
    lastname = '$last_name', 
    user_type = 'user',
    password = '$_password', 
    mobile = '$_mobile', 
    gender = '$_gender',
    profile = '$_profile'
     WHERE email='$_email'";

    mysqli_query($db, $query);

}

if (isset($_POST['delete_user'])) {
    delete();
}

function delete() {
    global $db;

    $umail = $_POST['umail'];
    
    $query = "DELETE FROM users WHERE email='$umail'";
    mysqli_query($db, $query);
}


// escape string
function e($val)
{
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}

function getUserByEmail($email)
{
    global $db;
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}
