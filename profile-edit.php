<?php session_start();?>
<?php
	include 'db_common.php';

	$row = NULL;
	if(isset($_SESSION['id'])) {
		$id = $_SESSION['id'];
		$sql = mysqli_query($connect, "SELECT * FROM `USERS` WHERE `id` = '$id';");
		$row = mysqli_fetch_row($sql);
	} else {
		echo "<script>alert('로그인이 필요합니다.');location.replace('login.php');</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>Kwitter</title>
</head>
<body>
	<div id="login">
		<form action="profile-edit_process.php" method="post">
			<legend>프로필 수정하기</legend>
			<hr>
			<div class="form-group">
				<label for="input_pw">비밀번호</label>
				<input type="password" id="input_pw" name="input_pw" placeholder="Type Your Password Check" class="input-text" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="input_pw_check">비밀번호 확인</label>
				<input type="password" id="input_pw_check" name="input_pw_check" placeholder="Type Your Password Check" class="input-text" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="input_name">이름</label>
				<?php echo '<input type="text" id="input_name" name="input_name" value="'.$row[3].'" class="input-text" maxlength="10" required>'; ?>
			</div>
			<div class="form-group">
				<label for="input_email">이메일</label>
				<?php echo '<input type="email" id="input_email" name="input_email" value="'.$row[4].'" class="input-text" maxlength="40" required>'; ?>
			</div>
			<div class="form-group">
				<label for="input_comment">한마디</label>
				<?php echo '<input type="text" id="input_comment" name="input_comment" value="'.$row[5].'" class="input-text" maxlength="20" required>'; ?>
			</div>
			<div class="form-group">
				<button type="submit">확인</button>
			</div>
		</form>
	</div>
</body>
</html>