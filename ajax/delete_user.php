<?php
include '../core/config.php';

$user_id = (int) $_POST['user_id'];

$account_id = getUserData($user_id,'account_id');
if($account_id > 0){
    $mysqli->query("DELETE FROM tbl_judges WHERE judge_id = '$account_id'");
}
$sql = "DELETE FROM tbl_users WHERE user_id = '$user_id'";

echo $mysqli->query($sql);
