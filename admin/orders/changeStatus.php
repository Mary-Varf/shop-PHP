<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php/serverCred.php';

$out = json_decode(file_get_contents('php://input'), true);
$connect = new mysqli($host, $user, $passwordSql, $dbname);
mysqli_set_charset($connect,'utf8'); 

if(mysqli_connect_errno()) {
        echo json_encode('Не выполнено');
} else {
    $id = $connect->real_escape_string($out['id']);
    $line1 = "select status from `orders` where (`id` = '$id')";
    $getStatus = mysqli_query($connect, $line1);
    $statusArr = [];
    while($row = mysqli_fetch_assoc($getStatus)) {
        array_push($statusArr, $row);
    };
    $status = ($statusArr[0]['status']=='0' ? '1' : '0');
    $line = "UPDATE `orders` SET `status` = '$status' WHERE (`id` = '$id');";
    $result = mysqli_query($connect, $line);
    
    if($result) {
        
        if ($status == '0') {
            echo json_encode('Не обработан');
        } else {
            echo json_encode('Обработан');
        }
    } else {
        echo json_encode('Не выполнено');
    }

    }

    mysqli_close($connect);
