<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<script src="../imports/jquery-3.1.1.min.js"></script>
	<title>Kwittter</title>
</head>
<body>
	<div id="background">
		<div id="top-bar">
			<a href="main.php"><h3>Kwitter</h3></a>
		</div>
		<?php
		include 'db_common.php';

		$userInfo = NULL;
		$id = NULL;
		if(isset($_SESSION['id'])) {
			if(isset($_GET['id'])) {
				$id = $_GET['id'];
				$sql = mysqli_query($connect, "SELECT * FROM `USERS` WHERE `id` = '$id';");
				$userInfo = mysqli_fetch_row($sql);
			}
		} else {
			echo "<script>alert('로그인이 필요합니다.');location.replace('login.php');</script>";
		}
		?>
		<div id="profile-wrapper">
			<div id="profile-container">
				<div id="profile-container-top"></div>
				<div id="profile-container-bottom">
					<div id="profile-container-photo">
						<form enctype="multipart/form-data" action="profile-process.php" method="post" id="profile-form">
							<label for="profile-input">
								<img src="icon-photo.png" width="110px" height="110px" style="margin: 20px;">
							</label>
							<?php
							$admin = False;
							if(isset($_GET['id']) && isset($_SESSION['id']) && $_GET['id'] == $_SESSION['id']) {
								$admin = True;
							}

							if($admin) {
								echo '<input type="file" name="profile" accept="image/*" id="profile-input" style="display: none;">';
							}
							?>
						</form>
					</div>
					<?php
					$query = "SELECT * FROM `KWITS` WHERE `userId` = '$id';";
					$sql = mysqli_query($connect, $query);
					$numOfKwits = mysqli_num_rows($sql);

					$query = "SELECT * FROM `FOLLOWS` WHERE `follower` = '$id';";
					$sql = mysqli_query($connect, $query);
					$numOfFollowing = mysqli_num_rows($sql);

					$query = "SELECT * FROM `FOLLOWS` WHERE `following` = '$id';";
					$sql = mysqli_query($connect, $query);
					$numOfFollower = mysqli_num_rows($sql);

					?>
					<div id="profile-container-top-container">
						<ul id="profile-nav">
							<li>
								<div class="tab-list">
									<a class="tab-link">
										<span class="tab-top">크윗</span>
										<p class="tab-bottom" id="num-kwit"><?php echo $numOfKwits; ?></p>
									</a>
								</div>
							</li>
							<li>
								<div class="tab-list">
									<a class="tab-link">
										<span class="tab-top">팔로윙</span>
										<p class="tab-bottom" id="num-following"><?php echo $numOfFollowing; ?></p>
									</a>
								</div>
							</li>
							<li>
								<div class="tab-list">
									<a class="tab-link">
										<span class="tab-top">팔로워</span>
										<p class="tab-bottom" id="num-follower"><?php echo $numOfFollower; ?></p>
									</a>
								</div>
							</li>
						</ul>
					<script>
						var getUrlParameter = function getUrlParameter(sParam) {
							var sPageURL = decodeURIComponent(window.location.search.substring(1)),
							sURLVariables = sPageURL.split('&'),
							sParameterName,
							i;

							for (i = 0; i < sURLVariables.length; i++) {
								sParameterName = sURLVariables[i].split('=');

								if (sParameterName[0] === sParam) {
									return sParameterName[1] === undefined ? true : sParameterName[1];
								}
							}
						};
						var id = getUrlParameter("id");
						var links = document.getElementsByClassName("tab-link");
						links[0].href = "profile.php?id=" + id + "&module=" + "kwit";
						links[1].href = "profile.php?id=" + id + "&module=" + "following";
						links[2].href = "profile.php?id=" + id + "&module=" + "follower";

						$(".tab-list").removeClass("active");

						if(getUrlParameter("module") == undefined || getUrlParameter("module") == "kwit") {
							document.getElementsByClassName("tab-list")[0].className += " active";
						} else if(getUrlParameter("module") == "following") {
							document.getElementsByClassName("tab-list")[1].className += " active"
						} else if(getUrlParameter("module") == "follower") {
							document.getElementsByClassName("tab-list")[2].className += " active"
						} 
					</script>
					<?php
						if($admin) {
							echo '<div id="profile-container-button-area">
							<button><a href="profile-edit.php">프로필 수정하기</a></button>
						</div>';
						} else {
							$followerId = $_SESSION['id'];
							$followingId = $_GET['id'];
							$sql = mysqli_query($connect, "SELECT * FROM `FOLLOWS` WHERE `follower` = '$followerId' AND `following` = '$followingId';");
							echo '<div id="profile-container-button-area">
							<a href="profile-follow.php?id='.$followingId.'"><button>';
							if(mysqli_num_rows($sql) == 1) {
								echo '언팔로우';
							} else {
								echo '팔로우';
							}
							echo '</button></a>
						</div>';
						}
						?>
				</div>
			</div>
		</div>
		<?php
		if((isset($_GET['module']) && $_GET['module'] == 'kwit') || !isset($_GET['module'])) {
			echo '<div id="content">
				<div id="side-nav-left" style="padding: 20px; width: 24%; height: 150px;">
						<h3 class="profile-user-name">'.$userInfo[1].'</h3>
						<p class="profile-user-comment">'.$userInfo[5].'</p>
						<p class="profile-user-email">'.$userInfo[4].'</p>
					</div>
				<div id="main">
					<div id="kwit-content">';
					$query = "SELECT * FROM `KWITS` WHERE `userId` = '$id';";
					$sql = mysqli_query($connect, $query);
					$close = ($admin ? "x" : "");
					while($row = mysqli_fetch_row($sql)) {
						echo '<div class="kwit-element">
											<div class="kwit-info">
												<span class="id">'.$row[1].'</span>
												<span class="close">'.$close.'</span>
											</div>
											<span class="date">'.$row[4]."</span>";
						if($row[3] == '') 	{
							echo '<div class="kwit-image">
												<img class="image" src="'.$row[3].'">
											</div>';
						}
						echo '<p class="kwit-text">'.$row[2].'</p>
									<p class="kwit-num" style="display: none;">'.$row[0].'</p>
										</div>';
					}
					echo '</div>';
					echo '<script>
						$(".profile-user-name").click(function(e) {
							id = $(this).text();
							location.replace("profile.php?id=" + id);
						});
						$(".profile-user-name").mouseenter(function() {
							$(this).css("cursor", "pointer");
						});
						$(".profile-user-name").mouseleave(function() {
							$(this).css("cursor", "default");
						});
							$(".id").click(function() {
								id = $(this).text();
								location.replace("profile.php?id=" + id);
							});
							$(".id").mouseenter(function() {
								$(this).css("cursor", "pointer");
							});
							$(".id").mouseleave(function() {
								$(this).css("cursor", "default");
							});
							$(".close").click(function() {
								idx = $(this).closest(".kwit-element").find(".kwit-num").text();
								r = confirm("정말 삭제하시겠습니까?");
								if (r == true) {
									location.replace("kwit-delete.php?idx=" + idx);
								}
							});
							$(".close").mouseenter(function() {
								$(this).css("cursor", "pointer");
							});
							$(".close").mouseleave(function() {
								$(this).css("cursor", "default");
							});
					</script> 
				</div>
			</div>
		</div>';
		echo '<style>

								.kwit-element {
									padding: 20px;
									word-wrap: break-word;
								}

								.kwit-info {
									height: 30px;
								}

								.kwit-image {
									margin-top: 10px;
									margin-bottom: 10px;
								}

								.image {
									margin: auto;
									display: block;
									max-width: 100%;
								}

								.date {
									color: gray;
								}

								.close {
									color: gray;
									float: right;
								}

								.id {
									float: left;
									font-weight: bold;
									font-size: large;
								}

								.kwit-element:nth-of-type(even) {
									background-color: #f8ffef;
								}
							</style>';
		} else if($_GET['module'] == 'following' || $_GET['module'] == 'follower') {
			echo '<div id="card-space">';
			$query = '';
			if($_GET['module'] == 'following') {
				$query = "SELECT * FROM `FOLLOWS` WHERE `follower` = '$id';";
			} else {
				$query = "SELECT * FROM `FOLLOWS` WHERE `following` = '$id';";
			}
			$sql = mysqli_query($connect, $query);
			while($row = mysqli_fetch_array($sql)) {
				$query2 = '';
				if($_GET['module'] == 'following') {
					$query2 = "SELECT * FROM `USERS` WHERE `id` = '$row[2]' LIMIT 1;";
				} else {
					$query2 = "SELECT * FROM `USERS` WHERE `id` = '$row[1]' LIMIT 1;";
				}
				$sql2 = mysqli_query($connect, $query2);
				$row2 = mysqli_fetch_array($sql2);

				echo '<div class="card">
				<div class="profile-top"></div>
				<div class="profile-bottom">
					<div class="profile-photo">
						<label>';
							if($row2[6] === NULL) {
								echo '<img src="icon-photo.png" width="60px" height="60px" style="margin: 20px;">';
							} else {
								echo '<img src="'.$row2[6].'" width="100px" height="100px" style="background-color: white;">';
							}
							echo '</label>
						</div>
						<h3 class="user-name">'.$row2[1].'</h3>
						<p class="user-comment" style="margin-top: -15px;">'.$row2[5].'</p>
					</div>
				</div>';
			}
			echo "</div>
			<script>
				$('.user-name').click(function(e) {
							id = $(this).text();
							location.replace('profile.php?id=' + id);
						});
						$('.user-name').mouseenter(function() {
							$(this).css('cursor', 'pointer');
						});
						$('.user-name').mouseleave(function() {
							$(this).css('cursor', 'default');
						});
						</script>";
		}

		?>
	</div>
</div>
</body>
</html>