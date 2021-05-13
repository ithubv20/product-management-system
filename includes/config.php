<?php
//establishing a connection to the database
	$host_name = 'localhost';
	$username = 'root';
	$user_passowrd = '';
	$database_name = 'pms';

	try {
    $dbconn = new PDO("mysql:host=$host_name;dbname=$database_name",$username, $user_passowrd);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
 ?>
