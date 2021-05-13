<?php
session_start(); //starting session. important when paasing data across pages.
include('includes/config.php'); //make available the database file in includes/config.php folder

//the below section checks the user email and password. it is responsible for loggin in users once their login details are proved to be true
if(isset($_POST['login_user'])){
	$user_email = $_POST['user_email'];
	$user_password = $_POST['user_password'];

	$sql = "SELECT * FROM users WHERE email=:user_email AND user_password=:user_password";
	$querry=$dbconn->prepare($sql);
	$querry->bindParam(':$user_email', $user_email, PDO::PARAM_STR);
	$querry->bindParam(':$user_password', $user_password, PDO::PARAM_STR);

	$querry->execute();
	$rows = $querry->fetchAll(PDO::FETCH_ASSOC);
	$count = $querry->rowCount();
	if($count > 0)
	{
		foreach($rows as $row) {
          // setting up session
          $_SESSION['user_id'] = $row->id;
        }
        header('Location: admin/index.php');
	}
}
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Sign in | Rubi's Production Management Software</title>
		<meta name="description" content="A software intended to provide complete solutions to  manufacturers to manage their raw materials inventory, the production process and product sells"/>
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="assets/css/custom-css.css">
		<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
		<link rel="icon" type="image/png" href="assets/img/logo/rubi_icon.png"/>
	</head>
	<body>
		<img class="wave" src="assets/img/wave.png">
		<div class="container">
			<div class="img">
				<img src="assets/img/set.png">
			</div>
			<div class="login-content">
					<img src="assets/img/logo/logo.png" style="height:60px">
					<div class="login-text">Log In</div>
					<!-- a form that collects user credentials and send them for verification -->
					<form method="POST">
					<div class="input-div one">
						<div class="i">
							<i class="fas fa-user"></i>
						</div>
						<div class="div">
							<h5>User email</h5>
							<input name="user_email" type="text" class="input">
						</div>
					</div>
					<div class="input-div pass">
						<div class="i">
							<i class="fas fa-lock"></i>
						</div>
						<div class="div">
							<h5>Password</h5>
							<input name="user_password" type="password" class="input">
						</div>
					</div>
					<a href="#">Forgot Password?</a>
					<input name="login_user" type="submit" class="btn" value="Login">
				</form>
			</div>
		</div>
		<script type="text/javascript" src="assets/js/extra-js.js"></script>
		<script type="text/javascript" src="assets/js/main.js"></script>
	</body>
	</html>
