<?php
	$hostname = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'KWITTER';

	global $connect;

	$connect = mysqli_connect($hostname, $username, $password, $database);

	if(mysqli_connect_errno($connect)) {
		die('실패');
	}
?>