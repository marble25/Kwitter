<?php
include 'db_common.php';

if(isset($_POST['input_id']) != 0 && isset($_POST['input_pw']) != 0) {
	$id = htmlspecialchars(substr($_POST['input_id'], 0, 20));
	$pw = htmlspecialchars(substr($_POST['input_pw'], 0, 20));
	$pw_check = htmlspecialchars(substr($_POST['input_pw_check'], 0, 20));
	$name = htmlspecialchars(substr($_POST['input_name'], 0, 10));
	$email = htmlspecialchars(substr($_POST['input_email'], 0, 40));
	$comment = htmlspecialchars(substr($_POST['input_comment'], 0, 20));

	if($pw != $pw_check) {
		echo "<script>alert('패스워드와 패스워드 확인이 같지 않습니다.');</script>";
		echo "<script>location.replace('register.php');</script>";

		mysqli_close($connect);
		exit();
	}

	$sql = mysqli_query($connect, "SELECT * FROM `USERS` WHERE `id` = '$id';");
	if(mysqli_num_rows($sql) == 1) {
		echo "<script>alert('동일한 아이디가 존재합니다.');</script>";
		echo "<script>location.replace('register.php');</script>";

		mysqli_close($connect);
		exit();
		
	} else {
		$query = "INSERT INTO `USERS` (`id`, `pw`, `name`, `email`, `comment`) VALUES ('$id', '$pw', '$name', '$email', '$comment');";
		$sql = mysqli_query($connect, $query);

		echo "<script>alert('회원가입에 성공했습니다.');</script>";
		echo "<script>location.replace('login.php');</script>";
	}
}

mysqli_close($connect);
?>