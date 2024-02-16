<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$sql = "SELECT * FROM tbl_loan_details $inject";
$fetch = $mysqli->query($sql);

$response['data'] = array();

if(isset($_POST['salary_date'])){
    $response['bb'] = sumPayablesAmount("AND salary_date < '".$_POST['salary_date']."'");
}

$count = 1;
while ($row = $fetch->fetch_assoc()) {
    $overdue = false;
    if(date('Y-m-d') > $row['due_date'] && $row['status'] == 0){
        $overdue = true;
    }
    $row['count'] = $count++;
    $row['overdue'] = $overdue;
	array_push($response['data'], $row);
}

echo json_encode($response);
