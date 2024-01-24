<?php
include '../core/config.php';

$sql = "SELECT salary_date FROM tbl_loan_details WHERE `status` = 0 GROUP BY salary_date ORDER BY salary_date ASC";
$fetch = $mysqli->query($sql);

$response['data'] = array();
$count = 1;
while ($row = $fetch->fetch_assoc()) {
	$row['count'] = $count++;
	$row['salary_date_format'] = date("F d, Y",strtotime($row['salary_date']));
	array_push($response['data'], $row);
}

echo json_encode($response);
