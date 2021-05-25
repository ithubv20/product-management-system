<?php
include('includes/config.php'); //make available the database file in includes/config.php folder

//the below section checks the user credentials against the database. it resets user password given a correct email and phone number
if(isset($_POST['reset_pass'])){
	$user_email = $_POST['usr_email'];
	$user_password = md5($_POST['usr_pass']);

	$update_tbl_sql = "UPDATE users SET user_password = :user_password WHERE email = :user_email";
	$querry=$dbconn->prepare($update_tbl_sql);
	$querry->bindParam(':user_email', $user_email, PDO::PARAM_STR);
	$querry->bindParam(':user_password', $user_password, PDO::PARAM_STR);

	$querry->execute();
	$count = $querry->rowCount();
	if($count > 0)
	{
		echo"<script>alert('user password updated successfully')</script>";
	  echo"<script>window.location.href='index.php';</script>";
	}
	else{
		echo"<script>alert('something went wrong. please try again')</script>";
	}

}
?>
