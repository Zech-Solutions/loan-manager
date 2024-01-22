<?php
include '../core/config.php';

$sql = "SELECT * FROM tbl_users";
$fetch = $mysqli->query($sql);

$response['data'] = array();
$count = 1;
while ($row = $fetch->fetch_assoc()) {
	$row['count'] = $count++;
	array_push($response['data'], $row);
}

echo json_encode($response);
