<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>Kwitter</title>
</head>
<body>
	<div id="login">
		<form action="register_process.php" method="post">
			<legend>지금 Kwitter에 가입하세요</legend>
			<hr>
			<div class="form-group">
				<label for="input_id">아이디</label>
				<input type="text" id="input_id" name="input_id" placeholder="Type Your ID" class="input-text" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="input_pw">비밀번호</label>
				<input type="password" id="input_pw" name="input_pw" placeholder="Type Your Password" class="input-text" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="input_pw_check">비밀번호 확인</label>
				<input type="password" id="input_pw_check" name="input_pw_check" placeholder="Type Your Password Check" class="input-text" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="input_name">이름</label>
				<input type="text" id="input_name" name="input_name" placeholder="Type Your Name" class="input-text" maxlength="10" required>
			</div>
			<div class="form-group">
				<label for="input_email">이메일</label>
				<input type="email" id="input_email" name="input_email" placeholder="Type Your Email" class="input-text" maxlength="40" required>
			</div>
			<div class="form-group">
				<label for="input_comment">한마디</label>
				<input type="text" id="input_comment" name="input_comment" placeholder="Say Hello To Kwitter" class="input-text" maxlength="20" required>
			</div>
			<div class="form-group">
				<button type="submit">회원가입하기</button>
			</div>
			<div class="form-group">
				<button onclick="location.href='login.php'; return false;">로그인 하러가기</button>
			</div>
		</form>
	</div>
</body>
</html>