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
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
	<center>
		<div class="header" style="margin-top: 200px;">
			<h2 style="font-family: Montserrat;">Home Page</h2>
		</div>
		<div class="content">
			<!-- notification message -->
			<?php if (isset($_SESSION['success'])) : ?>
				<div class="error success">
					<h3 style="font-family: Montserrat;">
						<?php
						echo $_SESSION['success'];
						?>
					</h3>
				</div>
			<?php endif ?>
			<!-- logged in user information -->
			<div class="profile_info">
				<!-- <img src="<?php echo $_SESSION['user']['profile']; ?>" width="100" > -->

				<div>
					<?php if (isset($_SESSION['user'])) : ?>
						<br /><strong style="font-family: Montserrat;"><?php echo $_SESSION['user']['firstname'];
																		echo $_SESSION['user']['lastname'] ?></strong>
						<strong style="font-family: Poppins;">(<?php echo $_SESSION['user']['email']; ?>)</strong><br /><br />
						<strong style="font-family: Poppins;"><?php echo $_SESSION['user']['mobile']; ?></strong>
						<small>
							<br><br />
							<a href="index.php?logout='1'" class="btn btn-danger">LOGOUT</a>
						</small>

					<?php endif ?>
				</div>
			</div>
		</div>
	</center>
</body>

</html>