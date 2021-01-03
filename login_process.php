<? session_start(); ?>

<?php
include 'db_common.php';

if(isset($_POST['input_id']) != 0 && isset($_POST['input_pw']) != 0) {
	$id = htmlspecialchars($_POST['input_id']);
	$pw = htmlspecialchars($_POST['input_pw']);

	$sql = mysqli_query($connect, "SELECT * FROM `USERS` WHERE `id` = '$id' AND `pw` = '$pw';");
	if(mysqli_num_rows($sql) == 1) {
		echo "<script>alert('로그인 성공');</script>";
		$_SESSION['id'] = $id;
	} else {
		echo "<script>alert('ID나 PW를 확인해 보세요.');</script>";
	}
	echo "<script>location.replace('login.php');</script>";
}

mysqli_close($connect);
?>