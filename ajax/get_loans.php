<?php
include '../core/config.php';

$sql = "SELECT * FROM tbl_loans";
$fetch = $mysqli->query($sql);

$response['data'] = array();
$count = 1;
while ($row = $fetch->fetch_assoc()) {
	$row['count'] = $count++;
	$row['supplier_name'] = getSupplierData($row['supplier_id']);
	$row['total_amount'] = sumLoanTotalAmount($row['loan_id']);
	$row['paid_amount'] = sumLoanTotalAmount($row['loan_id'],"AND `status` = 1");
	$row['balance'] = $row['total_amount'] - $row['paid_amount'];
	array_push($response['data'], $row);
}

echo json_encode($response);
