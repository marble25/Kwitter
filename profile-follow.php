<? session_start(); ?>

<?php
include 'db_common.php';

if(isset($_SESSION['id']) != 0) {
	$id = htmlspecialchars($_SESSION['id']);
	$followId = htmlspecialchars($_GET['id']);

	$sql = mysqli_query($connect, "SELECT * FROM `FOLLOWS` WHERE `follower` = '$id' AND `following` = '$followId';");
	if(mysqli_num_rows($sql) == 1) {
		$sql = mysqli_query($connect, "DELETE FROM `FOLLOWS` WHERE `follower` = '$id' AND `following` = '$followId';");
	} else {
		$sql = mysqli_query($connect, "INSERT INTO `FOLLOWS` (`follower`, `following`) VALUES ('$id', '$followId');");
	}
}

echo '<script>history.go(-1);</script>';
mysqli_close($connect);
?>