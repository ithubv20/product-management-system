<?php
require_once('../includes/config.php');;
// code user email availablity. it activates the password reset button if a correct email has been entered.
if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

		echo "error : You did not enter a valid email.";
	}
	else {
		$sql ="SELECT email FROM users WHERE email=:email";
		$query= $dbconn -> prepare($sql);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query-> execute();
		$results = $query -> fetchAll(PDO::FETCH_OBJ);
		$cnt=1;
		if($query -> rowCount() > 0)
		{
			echo "<span style='color:red'> Email already taken!</span>";
			 echo "<script>$('#reg_user').prop('disabled',true);</script>";
		} else{

			echo "<span style='color:green'> Email available for registration.</span>";
						echo "<script>$('#reg_user').prop('disabled',false);</script>";
		}
	}
}


?>
