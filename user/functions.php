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
    $profile = $_POST['image'];

    $epassword = md5($password); //encrypt the password before saving in the database

    if (isset($_POST['user_type'])) {
        $user_type = e($_POST['user_type']);
        $query = "INSERT INTO users (firstname, lastname, email, user_type, password, mobile, gender) 
					  VALUES('$firstname', '$lastname', '$email',  '$user_type' ,'$epassword', '$mobile', '$gender')";
        mysqli_query($db, $query);
        $_SESSION['success']  = "New user successfully created!!";
        header('location: home.php');
    } else {
        $userId = getUserByEmail($email);
        if (isset($userId)) {
            $_SESSION['error']  = "User with this email already exists!!";
            header('location: Registration.php');
        } else {
            $query = "INSERT INTO users (firstname, lastname, email, user_type, password, mobile, gender, profile) 
                          VALUES('$firstname', '$lastname', '$email',  'user' ,'$epassword', '$mobile', '$gender', '$profile')";
            mysqli_query($db, $query);

            $_SESSION['user'] = getUserByEmail($email); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            sendMail($firstname, $lastname, $email);
            header('location: index.php');  
        }
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
    $password = md5($password);

    $userId = getUserByEmail($email);


    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $results = mysqli_query($db, $query);


    if (mysqli_num_rows($results)) { // user found
        $_SESSION['user'] = $userId;
        $_SESSION['success']  = "You are now logged in";
        header('location: index.php');
    } else {
        $_SESSION['login_error']  = "Wrong username/password combination";
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
    $sub = "Welcome Note!";
    $message = "Hi " . $full_name . ",\n\n\nYou have successfully registered and you can now sign-in using with your mail " . "( " . $email . " )\n\n\nThank You!";
    mail($email, $sub, $message);
}
