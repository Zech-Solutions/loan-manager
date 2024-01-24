<?php

// START THE SESSION
session_start();

$mysqli = new mysqli("localhost", "root", "", "loan_db");
//$mysqli = new mysqli("localhost", "u814036432_root", "#VM>:m&8oQ", "u814036432_etally");
// Check connection
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	exit();
}
date_default_timezone_set('Asia/Manila');


function sql_update($table_name, $form_data, $where_clause = '')
{
	$whereSQL = '';
	if (!empty($where_clause)) {
		if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
			$whereSQL = " WHERE " . $where_clause;
		} else {
			$whereSQL = " " . trim($where_clause);
		}
	}
	$sql = "UPDATE " . $table_name . " SET ";
	$sets = array();
	foreach ($form_data as $column => $value) {
		$sets[] = "`" . $column . "` = '" . $value . "'";
	}
	$sql .= implode(', ', $sets);
	$sql .= $whereSQL;

	return $sql;
}

function sql_insert($table_name, $form_data)
{
	$fields = array_keys($form_data);

	$sql = "INSERT INTO " . $table_name . "
	    (`" . implode('`,`', $fields) . "`)
	    VALUES('" . implode("','", $form_data) . "')";

	return $sql;
}

function getUserData($user_id, $data_column = "account_name")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_users WHERE user_id = '$user_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function getSupplierData($supplier_id, $data_column = "supplier_name")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_suppliers WHERE supplier_id = '$supplier_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function sumLoanTotalAmount($loan_id,$inject = "")
{
	global $mysqli;
	$sql = "SELECT SUM(amount) AS amount FROM tbl_loan_details WHERE loan_id = '$loan_id' $inject";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_assoc();
	return (float) $row['amount'];
}

function checkIfUsernameExists($username)
{
	global $mysqli;
	$fetch = $mysqli->query("SELECT user_id FROM tbl_users WHERE username = '$username'");
	return $fetch->num_rows;
}

function generateRandomString($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function getTimeAgo($timestamp)
{
	$timeAgo = '';

	// Get the current timestamp
	$now = new DateTime();

	// Create a DateTime object from the provided timestamp
	$date = new DateTime($timestamp);

	// Calculate the difference between the current time and the provided timestamp
	$interval = $now->diff($date);

	// Define the time intervals
	$intervals = [
		'y' => 'yr',
		'm' => 'mo',
		'd' => 'day',
		'h' => 'hr',
		'i' => 'min',
		's' => 'sec'
	];

	// Iterate through the intervals and create the time ago string
	foreach ($intervals as $key => $value) {
		if ($interval->$key > 1) {
			$timeAgo = $interval->$key . ' ' . $value . 's';
			break;
		} elseif ($interval->$key == 1) {
			$timeAgo = $interval->$key . ' ' . $value;
			break;
		}
	}

	// If the time difference is less than a second, display "Just now"
	if ($timeAgo == '') {
		$timeAgo = 'Just now';
	}

	return $timeAgo;
}
