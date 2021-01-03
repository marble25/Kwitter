<? session_start(); ?>

<?php
include 'db_common.php';

if(isset($_GET['idx']) != 0 && isset($_SESSION['id']) != 0) {
	$idx = htmlspecialchars($_GET['idx']);
	$query = "SELECT * FROM `KWITS` WHERE `idx` = $idx;";
	$sql = mysqli_query($connect, $query);

	if(mysqli_num_rows($sql) == 1) {
		if(mysqli_fetch_row($sql)[1] == $_SESSION['id']) {
			$query = "DELETE FROM `KWITS` WHERE `idx` = $idx;";
			$sql = mysqli_query($connect, $query);
		}
	}

}
echo "<script>location.replace('main.php');</script>";
mysqli_close($connect);
?>