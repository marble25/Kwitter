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

		$row = NULL;
		if(isset($_SESSION['id'])) {
			$id = $_SESSION['id'];
			$sql = mysqli_query($connect, "SELECT * FROM `USERS` WHERE `id` = '$id';");
			$row = mysqli_fetch_row($sql);
		} else {
			echo "<script>alert('로그인이 필요합니다.');location.replace('login.php');</script>";
		}
		?>
		<div id="wrapper">
			<div id="content">
				<div id="side-nav-left">
					<div class="profile-top"></div>
					<div class="profile-bottom">
						<div class="profile-photo">
							<form enctype="multipart/form-data" action="profile-process.php" method="post" id="profile-form">
								<label for="profile-input">
									<?php
									if($row[6] === NULL) {
										echo '<img src="icon-photo.png" width="60px" height="60px" style="margin: 20px;">';
									} else {
										echo '<img src="'.$row[6].'" width="100px" height="100px" style="background-color: white;">';
									}
									?>
								</label>
								<input type="file" name="profile" accept="image/*" id="profile-input" style="display: none;">
							</form>
						</div>
						<script>
							document.getElementById("profile-input").onchange = function() {
								document.getElementById("profile-form").submit();
							};
						</script>
						<h3 class="user-name"><? echo $row[1]; ?></h3>
						<p class="user-comment"><? echo $row[5]; ?></p>
					</div>
				</div>
				<div id="main">
					<div id="top-input">
						<form enctype="multipart/form-data" action="kwit-process.php" method="post">
							<input type="text" placeholder="무슨 일이 일어나고 있나요?" class="input-text kwit" name="kwit" id="kwit-normal">
							<textarea class="input-text kwit" name="kwit" rows="4" maxlength="140" style="resize: none; display: none;" id="kwit-click"></textarea>
							<div id="button-area" style="display: none;">
								<div class="image-upload">
									<label for="file-input">
										<img src="icon-photo-twit.png" width="40px" height="40px">
									</label>
									<input type="file" name="pic" accept="image/*" id="file-input">
								</div>
								<input type="submit" value="크윗하기" id="kwit-submit">
							</div>
						</form>
					</div>
					<div id="kwit-content">
					</div>
					<script>
						if (!String.prototype.format) {
							String.prototype.format = function() {
								var args = arguments;
								return this.replace(/{(\d+)}/g, function(match, number) { 
									return typeof args[number] != 'undefined'
									? args[number]
									: match
									;
								});
							};
						}
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

						getData = function() {
							$.ajax({
								url:'./kwits.php',
								datatype:'json',
								success:function(data) {
									var str = '';
									var obj = $.parseJSON(data);
									for(var i=0 ; i < obj.length ; i++){
										var temp = '';
										if('image' in obj[i]) {
											var close = '';
											if(obj[i]['userId'] == $('.user-name').text()) {
												close = 'x';
											}
											temp = `<div class="kwit-element">
											<div class="kwit-info">
												<span class="id">{0}</span>
												<span class="close">{4}</span>
											</div>
											<span class="date">{1}</span>
											<div class="kwit-image">
												<img class="image" src="{2}">
											</div>
											<p class="kwit-text">{3}</p>
											<p class="kwit-num">{5}</p>
										</div>`.format(obj[i]['userId'], obj[i]['time'], obj[i]['image'], obj[i]['kwit'], close, obj[i]['idx']);
									} else {
										temp = `<div class="kwit-element">
										<div class="kwit-info">
											<span class="id">{0}</span>
											<span class="close">{3}</span>
										</div>
										<span class="date">{1}</span>
										<p class="kwit-text">{2}</p>
										<p class="kwit-num">{4}</p>
									</div>`.format(obj[i]['userId'], obj[i]['time'], obj[i]['kwit'], close, obj[i]['idx']);
								}
								str += temp;
							}
							$('#kwit-content').html(str + `<style>
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
									float: right;
									color: gray;
								}

								.id {
									float: left;
									font-weight: bold;
									font-size: large;
								}
								
								.kwit-num {
									display: none;
								}

								.kwit-element:nth-of-type(even) {
									background-color: #f8ffef;
								}
							</style>`);
							$('.id').click(function() {
								id = $(this).text();
								location.replace('profile.php?id=' + id);
							});
							$('.id').mouseenter(function() {
								$(this).css('cursor', 'pointer');
							});
							$('.id').mouseleave(function() {
								$(this).css('cursor', 'default');
							});

							$('.close').click(function() {
								idx = $(this).closest('.kwit-element').find(".kwit-num").text();
								r = confirm("정말 삭제하시겠습니까?");
								if (r == true) {
									location.replace('kwit-delete.php?idx=' + idx);
								}
							});
							$('.close').mouseenter(function() {
								$(this).css('cursor', 'pointer');
							});
							$('.close').mouseleave(function() {
								$(this).css('cursor', 'default');
							});
						}
					});
						};
						getData();
						setInterval(getData, 100000);
					</script> 
				</div>
				<script>
					$('#kwit-normal').focusin(function(e) {
						$('#kwit-normal').hide();
						$('#kwit-click').show();
						$('#kwit-click').focus();
						$('#button-area').show();
					});

					$(document).click(function(e) {
						if($(e.target).parents('#top-input').length == 0) {
							$('#kwit-normal').show();
							$('#kwit-click').hide();
							$('#button-area').hide();
						}
					});
				</script>
			</div>
		</div>
	</div>
</body>
</html>