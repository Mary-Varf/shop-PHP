<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$out = json_decode(file_get_contents('php://input'), true);
$connect = connectSQL();

if (mysqli_connect_errno()) {
    echo json_encode('Возникла ошибка, повторите попытку позже');
} else {
    if (!isset($out['usersname']) || !isset($out['password']) || !isset($out['passwordVer']) || !isset($out['surname']) || !isset($out['email']) || !isset($out['phone']) ||
    $out['usersname'] == '' || $out['password'] == '' || $out['surname'] == '' || $out['email'] == '' || $out['phone'] == ''|| $out['passwordVer'] == '') {
        echo json_encode('Необходимо заполнить все поля со звездочкой');
    } elseif ($out['password'] != $out['passwordVer']) {
        echo json_encode('Пароли не совпадают');
    } else {
        $name = $connect->real_escape_string($out['usersname']);
        $password = $connect->real_escape_string($out['password']);
        $surName = $connect->real_escape_string($out['surname']);
        $thirdName = $connect->real_escape_string($out['thirdname']);
        $phone = $connect->real_escape_string($out['phone']);
        $email = $connect->real_escape_string($out['email']);
        $phone = preg_replace('~\D+~', '', $phone);
        $phone = mb_substr($phone, 1);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $result = mysqli_query($connect, "SELECT login, id FROM users where login='$email';");
        if ($result && $result->num_rows > 0) {
            echo json_encode('Пользователь с этим email уже зарегистрирован');
        } else {
            $result = mysqli_query($connect, "INSERT INTO `users` (`login`, `name`, `surname`, `phone`, `patronymic`, `password`) VALUES ('$email', '$name', '$surName', '$phone', '$thirdName', '$hash');");
            $insert_id = $connect->insert_id;
            $resultRole = mysqli_query($connect, "INSERT INTO `role_user` (`users_id`, `roles_id`) VALUES ('$insert_id', '3');");
            if ($result && $resultRole) {
                $data = ['id' => $insert_id, 'name' => $name, 'password' => $hash, 'login' => $email];
                cookieHandler\createCookie($data);
                cookieHandler\setSession($data);
                echo json_encode(true);   
            } else {
                echo json_encode('Возникла ошибка, возможно, введен не корректный тип данных');
            }
        }
    }
}
mysqli_close($connect);
