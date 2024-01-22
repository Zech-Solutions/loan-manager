<?php
include '../core/config.php';

$user_id = $_SESSION['etally']['user_id'];

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $fileSize = $_FILES['image']['size'];
    $maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes

    if ($fileSize <= $maxFileSize) {
        $filename = generateRandomString(9).".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadDirectory = "../assets/img/profiles/";
        $uploadedFile = $uploadDirectory . $filename;

        if (!file_exists($uploadedFile)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadedFile)) {
                $form_data['image'] = $filename;
                if($user_id > 0){
                    $old_mechanics = getUserData($user_id,"user_img");
                    if($old_mechanics != "user_img.png"){
                        unlink($uploadDirectory . $old_mechanics);
                    }
                }
            }
        }

        $mysqli->query("UPDATE tbl_users SET user_img = '$filename' WHERE user_id = '$user_id'");
        if($_SESSION['etally']['user_category'] == 'J'){
            $judge_id = $_SESSION['etally']['account_id'];
            $mysqli->query("UPDATE tbl_judges SET judge_img = '$filename' WHERE judge_id = '$judge_id'");
        }
        $_SESSION['etally']['user_img'] = $filename;
        echo 1;
    }else{
        echo -1;
    }
}else{
    echo 0;
}
