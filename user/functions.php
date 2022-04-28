<?php
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

$firstname = "";
$lastname = "";
$email = "";
$mobile = "";
$password = "";
$gender = "";
$profile = "";
$_SESSION['error'] = '';

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

// REGISTER USER
function register()
{
    // call these variables with the global keyword to make them available in function
    global $db, $lastname, $firstname, $email, $mobile, $password, $gender, $profile;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $firstname = e($_POST['firstname']);
    $lastname = e($_POST['lastname']);
    $email = strtolower($_POST['email']);
    $mobile = e($_POST['mobile']);
    $password = e($_POST['password']);
    $gender = e($_POST['gender']);
    $profile = addslashes(file_get_contents($_FILES['image']['tmp_name'])); 

    $userId = getUserByEmail($email);
    if (isset($userId)) {
        $_SESSION['error']  = "User with this email already exists!!";
        echo '<script>alert("User with this email already exists!!")</script>';
        unset($_SESSION['error']);
    } else {
        $query = "INSERT INTO users (firstname, lastname, email, user_type, password, mobile, gender, profile) 
                          VALUES('$firstname', '$lastname', '$email',  'user' ,'$password', '$mobile', '$gender', '$profile')";
        mysqli_query($db, $query);

        $_SESSION['user'] = getUserByEmail($email); // put logged in user in session
        $_SESSION['success']  = "You are now logged in";
        sendMail($firstname, $lastname, $email);
        echo '<script>alert("Registration Successful")</script>';
        
    }
}

// escape string
function e($val)
{
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
    login();
}

// LOGIN USER
function login()
{
    global $db;
    // grap form values
    $email = e($_POST['email']);
    $password = e($_POST['password']);

    $userId = getUserByEmail($email);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $results = mysqli_query($db, $query);   

    if (mysqli_num_rows($results)) { // user found
        $_SESSION['user'] = $userId;
        $_SESSION['success']  = "You are now logged in";
        header('location: index.php');
    } else {
        $_SESSION['login_error']  = "Wrong Email/password combination";
    }
    // }
}

function getUserByEmail($email)
{
    global $db;
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}


function sendMail($firstname, $lastname, $email)
{
    $full_name = $firstname . $lastname;
    $sub = "Welcome";
    $message = "Hi " . $full_name . ",\n\n\nYou have successfully registered in Edgroom demo app and you can now sign-in using with your mail " . "( " . $email . " )\n\n\nThank You!";
    mail($email, $sub, $message);
}
