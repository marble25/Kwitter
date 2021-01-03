<?php 
session_start();

if(isset($_SESSION['id'])) {
	echo "<script>location.replace('main.php');</script>";
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
		<form action="login_process.php" method="post">
			<legend>Kwitter에 로그인하기</legend>
			<hr>
			<div class="form-group">
				<label for="input_id">아이디</label>
				<input type="text" id="input_id" name="input_id" placeholder="Type Your ID" class="input-text">
			</div>
			<div class="form-group">
				<label for="input_pw">비밀번호</label>
				<input type="password" id="input_pw" name="input_pw" placeholder="Type Your Password" class="input-text">
			</div>
			<div class="form-group">
				<button type="submit">로그인하기</button>
			</div>
			<div class="form-group">
				<button onclick="location.href='register.php'; return false;">회원가입 하러가기</button>
			</div>
		</form>
	</div>
</body>
</html>