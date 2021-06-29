<?php
include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php/serverCred.php';

$connect = new mysqli($host, $user, $passwordSql, $dbname);
mysqli_set_charset($connect,'utf8'); 
$out = json_decode(file_get_contents('php://input'));
if(mysqli_connect_errno()) {
    echo json_encode(false);
} else {    
    if (isset($out)) {
        $objArr = (array)$out;
        $id = '';
        $role = '';
        foreach ($objArr as $key => $val){
            if ($key == 'id') {
                $id = $val;
            } elseif ($key == 'role') {
                $role = $val;
            }
        }

        $result = mysqli_query($connect, "UPDATE `role_user` SET `roles_id` = '$role' WHERE (`users_id` = '$id');");
        if ($result) {
            echo json_encode($role);
        } else {
            echo json_encode(false);
        }
    }
}
mysqli_close($connect);
