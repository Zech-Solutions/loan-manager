<?php
include '../core/config.php';

$user_id        = $_SESSION['etally']['user_id'];
$username       = $_POST['username'];
$account_name   = $_POST['account_name'];

$_SESSION['etally']['username'] = $username;
$_SESSION['etally']['account_name'] = $account_name;

echo $mysqli->query("UPDATE tbl_users SET username = '$username', account_name = '$account_name' WHERE user_id = '$user_id'");