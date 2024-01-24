<?php
include '../core/config.php';

$loan_detail_id = (int) $_POST['loan_detail_id'];

echo $mysqli->query("UPDATE tbl_loan_details SET paid_amount = amount, `status` = 1 WHERE loan_detail_id = '$loan_detail_id'");
