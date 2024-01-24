<?php
include '../core/config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header('Content-Type: application/json');

$inputs = json_decode(file_get_contents("php://input"),true);

$form_data = array(
    'supplier_id'       => $inputs['supplier_id'],
    'loan_name'         => $inputs['loan_name'],
    'loan_amount'       => $inputs['loan_amount'],
    'loan_date'         => $inputs['loan_date'],
    'frequency'         => $inputs['frequency'],
    'loan_period'       => $inputs['loan_period'],
    'interest_rate'     => $inputs['interest_rate'],
    'monthly_payment'   => $inputs['monthly_payment'],
    'payment_start'     => $inputs['payment_start']
);

$sql = sql_insert("tbl_loans", $form_data);
$mysqli->query($sql);

$loan_id = $mysqli->insert_id;
if($loan_id > 0){
    foreach($inputs['ammortizations'] as $row){
    
        $form_data2 = array(
            'loan_id' => $loan_id,
            'loan_detail_name' => $row['loan_detail_name'],
            'amount' => $row['amount'],
            'due_date' => $row['due_date'],
            'salary_date' => $row['salary_date'],
        );
        
    
        $sql = sql_insert("tbl_loan_details", $form_data2);
        $mysqli->query($sql);
    }
    echo 1;
}else{
    echo 0;
}

