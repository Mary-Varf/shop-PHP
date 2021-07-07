<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$out = json_decode(file_get_contents('php://input'), true);
$connect = connectSQL();

if (mysqli_connect_errno()) {
    echo json_encode('Не выполнено');
} else {
    $id = intval($out['id']);
    $getStatus = mysqli_query($connect, "SELECT status FROM `orders` WHERE `id` = '$id'");
    $statusArr = [];
    while($row = mysqli_fetch_assoc($getStatus)) {
        array_push($statusArr, $row);
    }
    $status = ($statusArr[0]['status'] == '0' ? '1' : '0');
    $result = mysqli_query($connect, "UPDATE `orders` SET `status` = '$status' WHERE `id` = '$id'");
    
    if ($result) {
        if ($status) {
            echo json_encode('Обработан');
        } else {
            echo json_encode('Не обработан');
        }
    } else {
        echo json_encode('Не выполнено');
    }
}
mysqli_close($connect);
