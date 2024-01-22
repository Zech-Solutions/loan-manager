<?php
include '../../core/config.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM tbl_users WHERE username = '$username' AND `password` = '$password'";
$fetch = $mysqli->query($sql);

if($fetch->num_rows > 0){
    $rows = $fetch->fetch_assoc();
    $_SESSION['loan'] = $rows;
    echo 1;
}else{
    echo 0;
}