<?php
	include 'db_common.php';

	$query = "SELECT * FROM `KWITS` ORDER BY `idx` DESC;";
	$sql = mysqli_query($connect, $query);

	$result = [];

	while($row = mysqli_fetch_array($sql)) {
		$tmp = array();
		$tmp['idx'] = $row[0];
		$tmp['userId'] = $row[1];
		$tmp['kwit'] = $row[2];
		$tmp['image'] = $row[3];
		$tmp['time'] = $row[4];
		array_push($result, $tmp);
	}

	echo json_encode($result);
?>