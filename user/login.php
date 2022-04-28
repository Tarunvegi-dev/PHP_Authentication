<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container login" style="margin-top: 100px;">
        <div class="card" style="padding: 40px;">
            <h3 class="title" style="text-align: center;">USER LOGIN</h3>
            <center>
                <form method="post" action="login.php"">
        <div class=" mb-3 col-sm-4">
                    <input type="email" name="email" class="form-control" style="padding: 15px; margin-bottom:25px; font-size: 18px; font-family:'Poppins';" placeholder="Email address" required>
        </div>
        <div class="mb-3 col-sm-4">
            <input type="password" name="password" class="form-control" style="padding: 15px; margin-bottom:25px; font-size: 18px; font-family:'Poppins';" placeholder="Password" required>
        </div><br />
        <input type="submit" class="btn btn-primary" value="Login" name="login_btn" style="font-family: Poppins; width:100px; padding-top:10px; padding-bottom:10px;"><br/><br/>
        <span style="font-family: Poppins;">Don't have an account?&nbsp;<a href="./Registration.php">Sign up here</a></span><br /><br />
        <?php
        if (isset($_SESSION['login_error'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['login_error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>
        </form>
        </center>
    </div>
    </div>
</body>

</html>