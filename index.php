<?php
session_start(); //starting session. important when paasing data across pages.
include('includes/config.php'); //make available the database file in includes/config.php folder

//the below section checks the user email and password. it is responsible for loggin in users once their login details are proved to be true
if(isset($_POST['login_user'])){
	$user_email = $_POST['user_email'];
	$user_password = md5($_POST['user_password']);

	$sql = "SELECT * FROM users WHERE email=:user_email AND user_password=:user_password AND user_status = 0";
	$querry=$dbconn->prepare($sql);
	$querry->bindParam(':user_email', $user_email, PDO::PARAM_STR);
	$querry->bindParam(':user_password', $user_password, PDO::PARAM_STR);

	$querry->execute();
	$rows = $querry->fetchAll(PDO::FETCH_ASSOC);
	$count = $querry->rowCount();
	if($count > 0)
	{
		foreach($rows as $row) {
			// setting up session
			$_SESSION['user_id'] = $row['user_id'];
			$staff_role = $row['role'];
			if ($staff_role == '1'){
				// open admin manager panel
				header('Location: admin/index.php');
			}else {
				// open warehouse manager panel
				header('Location: warehouse-managers/index.php');
			}
		}

	}
	else{
		echo"<script>alert('something went wrong. please contact systems administrator')</script>";
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

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/custom-css.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<link rel="icon" type="image/png" href="assets/img/logo/rubi_icon.png"/>

	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script>
	function checkAvailability() {
		$("#loaderIcon").show();
		jQuery.ajax({
			url: "check_availability.php",
			data:'emailid='+$("#emailid").val(),
			type: "POST",
			success:function(data){
				$("#user-availability-status").html(data);
				$("#loaderIcon").hide();
			},
			error:function (){}
		});
	}
</script>
<script>
var check = function() {
	if (document.getElementById('password').value ==
	document.getElementById('confirm_password').value) {
		document.getElementById('message').style.color = 'green';
		document.getElementById('message').innerHTML = 'Matching';
	} else {
		document.getElementById('message').style.color = 'red';
		document.getElementById('message').innerHTML = 'Not Matching';
	}
}
</script>
</head>
<body>
	<img class="wave" src="assets/img/wave.png"/>
	<div class="container">
		<div class="img">
			<img src="assets/img/set.png">
		</div>
		<div class="login-content">
			<!-- a form that collects user credentials and send them for verification -->
			<form method="POST">
				<img src="assets/img/logo/logo.png" style="height:60px">
				<div class="login-text">Log In</div>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>User email</h5>
						<input  name="user_email" type="email" class="input"  autocomplete="no">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input name="user_password" type="password" class="input" autocomplete="off">
					</div>
				</div>
				<a data-toggle="modal" href="#forgotpassword">Forgot Password?</a>
				<input name="login_user" type="submit" class="btn" value="Login">
			</form>
		</div>
	</div>
	<script type="text/javascript">
	function valid()
	{
		if(document.reset_usr_password.usr_pass.value!= document.reset_usr_password.confirm_pass.value)
		{
			alert("New Password and Confirm Password Field do not match  !!");
			document.reset_usr_password.confirm_pass.focus();
			return false;
		}
		return true;
	}
	</script>
	<!-- reset password modal -->
	<div class="modal fade" id="forgotpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<img src="assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp| Reset Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="login-content">
						<form name="reset_usr_password" action="resetpassword.php" method="POST" onSubmit="return valid();">
							<div class="input-div one">
								<div class="i">
									<i class="fas fa-user"></i>
								</div>
								<div class="div">
									<h5>User email</h5>
									<input  id="emailid" onBlur="checkAvailability()" name="usr_email" type="email" class="input"  autocomplete="no" required>
								</div>
							</div>
							<div class="input-div">
								<div class="i">
									<i class="fas fa-lock"></i>
								</div>
								<div class="div">
									<h5>User Password</h5>
									<input type="password" name="usr_pass" class="input" required>
								</div>
							</div>
							<div class="input-div">
								<div class="i">
									<i class="fas fa-lock"></i>
								</div>
								<div class="div">
									<h5>Confirm User Password</h5>
									<input type="password" name="confirm_pass" class="input" required>
								</div>
							</div>

							<div class="form-group">
								<input type="submit" id="reset_ps" name="reset_pass" class="btn" value="Reset Password">
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<span id="user-availability-status" style="font-size:12px;"></span>
					<div class="btn-save" align="left">
						<a href=''>Log In?</a>
					</div>


				</div>
			</div>
		</div>

		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/extra-js.js"></script>
		<script type="text/javascript" src="assets/js/main.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</body>
	</html>
