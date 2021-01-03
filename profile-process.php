<? session_start(); ?>

<?php
include 'db_common.php';

if(isset($_SESSION['id'])) {
	$milliseconds = round(microtime(true) * 1000);
	$target_file = "";
	if($_FILES['profile']['error'] == 4) {
		echo "<script>alert('업로드할 파일이 없습니다.');location.replace('main.php');</script>";
		exit();
	} else {
		$target_dir = "uploads/";
		$imageFileType = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
		$target_file = $target_dir . basename($milliseconds.(string)rand(100000, 999999).".".$imageFileType);

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["profile"]["tmp_name"]);
			if($check === false) {
				echo "<script>alert('파일이 이미지가 아닙니다.');location.replace('main.php');</script>";
				exit();
			}
		}
		// Check file size
		if ($_FILES["profile"]["size"] > 10485760) {
			echo "<script>alert('파일이 너무 큽니다. 10MB 이하의 파일만 업로드해주세요.');location.replace('main.php');</script>";
			exit();
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			echo "<script>alert('JPG, JPEG, PNG, GIF 파일만 업로드할 수 있습니다.');location.replace('main.php');</script>";
			exit();
		}
		// Check if $uploadOk is set to 0 by an error
		if (!move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
			echo "<script>alert('파일 업로드에 실패했습니다.');location.replace('main.php');</script>";
			exit();
		}
	}
	$id = $_SESSION['id'];

	$query = "UPDATE `USERS` SET `profile` = '$target_file' WHERE `id`='$id';";
	$sql = mysqli_query($connect, $query);

	echo "<script>alert('업로드 성공');location.replace('main.php');</script>";
} else {
	echo "<script>alert('로그아웃 되었습니다.');location.replace('login.php');</script>";
}

mysqli_close($connect);
?>