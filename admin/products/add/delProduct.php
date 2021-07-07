<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$out = json_decode(file_get_contents('php://input'));

$connect = connectSQL();

if (mysqli_connect_errno()) {
    $message = 'Возникла ошибка, повторите попытку позже';
} else {
    $id = intval($out);
    if (isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == '1') {
        $resultCG = mysqli_query($connect, "DELETE FROM `category_good` WHERE `goods_id` = '$id'");
        $resultG = mysqli_query($connect, "DELETE FROM `goods` WHERE `id` = '$id'");
        
        if ($resultCG && $resultG) {
            echo json_encode(true);
        } else {
            echo json_encode('Не удалось удалить товар');
        }
    } else {
        echo json_encode('Ошибка прав доступа');
    }
}
mysqli_close($connect);
