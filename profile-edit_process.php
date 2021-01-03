<?php session_start();?>
<?php
include 'db_common.php';

if(isset($_SESSION['id'])) {
	if(isset($_POST['input_pw']) != 0) {
		
		$id = $_SESSION['id'];
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

		$query = "UPDATE `USERS` SET `pw`='$pw', `name`='$name', `email`='$email', `comment`='$comment' WHERE `id`='$id';";
		$sql = mysqli_query($connect, $query);

		echo "<script>alert('프로필 변경에 성공했습니다.');</script>";
		echo "<script>location.replace('login.php');</script>";
	} else {
		echo "<script>location.replace('login.php');</script>";
	}
} else {
	echo "<script>location.replace('login.php');</script>";
}

mysqli_close($connect);
?>