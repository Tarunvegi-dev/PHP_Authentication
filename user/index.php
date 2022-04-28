<?php
include('functions.php');
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
	<script src="https://kit.fontawesome.com/057772d77f.js" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<style>
		body {
			overflow: hidden;
		}
	</style>
</head>

<body>
	<div class="row">
		<div class="col">
			<img src="https://images.unsplash.com/photo-1543599538-a6c4f6cc5c05?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80">
		</div>
		<div class="col" style="float: right;">
			<center>
				<h2 style="margin-top: 150px; font-family: Poppins;">WELCOME</h2>
				<br />
				<h1 style="font-family: Poppins; font-size:80px; text-transform: capitalize;"><?php echo $_SESSION['user']['firstname'];
																								echo "    ";
																								echo $_SESSION['user']['lastname'] ?></h1>
				<div style="display: flex; justify-content: center; padding: 40px;">
						<?php echo '<img src="data:image/png;base64, ' . base64_encode($_SESSION['user']['profile']) . '" height="200" width="250" style="border-radius:25px"' ?>;<br />
				</div>
				<strong style="font-family: Poppins; font-size:25px">Your Email:&nbsp;&nbsp;<i class="fa-solid fa-envelope"></i> &nbsp;<?php echo $_SESSION['user']['email']; ?></strong><br /><br />
				<strong style="font-family: Poppins; font-size:25px">Your Phone: &nbsp;&nbsp;<i class="fa-solid fa-phone"></i>&nbsp;<?php echo $_SESSION['user']['mobile']; ?></strong><br/><br/>
				<strong style="font-family: Poppins; font-size:25px">Gender: &nbsp;&nbsp;<i class="fa-solid fa-user"></i>&nbsp;<?php echo $_SESSION['user']['gender']; ?></strong>
				<small>
					<br /><br /><br />
					<a href="index.php?logout='1'" class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;LOGOUT</a>
				</small>
			</center>
		</div>
	</div>
</body>
</center>

</html>