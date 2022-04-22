<?php
session_start();

$_SESSION['error'] = null;
// connect to database
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

$firstname = "";
$lastname = "";
$email = "";
$mobile = "";
$password = "";
$gender = "";

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

// REGISTER USER
function register()
{
    // call these variables with the global keyword to make them available in function
    global $db, $lastname, $firstname, $email, $mobile, $password, $gender;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $firstname = e($_POST['firstname']);
    $lastname = e($_POST['lastname']);
    $email = e($_POST['email']);
    $mobile = e($_POST['mobile']);
    $password = e($_POST['password']);
    $gender = e($_POST['gender']);

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
            $query = "INSERT INTO users (firstname, lastname, email, user_type, password, mobile, gender) 
                          VALUES('$firstname', '$lastname', '$email',  'user' ,'$epassword', '$mobile', '$gender')";
            mysqli_query($db, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($db);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: index.php');
        }
    }
}

// return user array from their id
function getUserById($id)
{
    global $db;
    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

function getUserByEmail($email)
{
    global $db;
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// escape string
function e($val)
{
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}
