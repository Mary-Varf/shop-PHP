<?php

function connectSQL(): mysqli
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

    $connect = new mysqli(HOST, USER, PASSWORDSQL, DBNAME);
    mysqli_set_charset($connect,'utf8');
    return $connect;
}

