<?php include('functions.php');
if (isLoggedIn()) {
	header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./login.css" rel="stylesheet">
</head>

<body>
    <div class="container login" style="margin-top: 100px;">
        <div class="card" style="padding: 40px;">
            <h3 class="title" style="text-align: center;">ADMIN LOGIN</h3><br/>
            <center>
                <form method="post" action="login.php">
                    <div class="mb-3 col-sm-4">
                        <input type="text" name="username" class="form-control" id="exampleFormControlInput1" placeholder="Username" required>
                    </div>
                    <div class="mb-3 col-sm-4">
                        <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="Password" required>
                    </div><br />
                    <button class="btn btn-primary" name="login_btn">Login</button><br /><br />
                    <?php
                        if(isset($_SESSION['error'])) {
                            echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
                            unset($_SESSION['error']);
                        }
                    ?>
                </form>
            </center>
        </div>
    </div>
</body>

</html>