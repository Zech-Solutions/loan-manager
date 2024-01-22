<?php
include '../core/config.php';

$user_id		= (int) $_POST['user_id'];
$account_name	= $_POST['account_name'];
$user_category	= $_POST['user_category'];
$username		= $_POST['username'];
$password		= md5($_POST['password']);

$form_data = array(
	'account_name'	=> $account_name,
	'user_category' => $user_category,
	'username'		=> $username,
	'password'		=> $password
);

$sql = $user_id > 0? sql_update("tbl_users", $form_data, "user_id = '$user_id'") : sql_insert("tbl_users", $form_data);
$mysqli->query($sql);

echo json_encode($form_data);
