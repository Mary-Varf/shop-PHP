<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/categoryHandler.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/categoriesHandler.php';

    if (!isset($_COOKIE['login']) || !isset($_SESSION['roles_id'])) {
        include $_SERVER['DOCUMENT_ROOT'] . '/templates/header/index.php';
        echo 
        '<main class="page-add">
            <h3 style="color:red;">Ошибка прав доступа</h3>
            <div><a class="page-delivery__button button" href="/authorization/">Авторизация</a></div>
        </main>';
        exit;
    } elseif (isset($_SESSION['roles_id']) && !($_SESSION['roles_id'] == '2' || $_SESSION['roles_id'] == '1')) {
        include $_SERVER['DOCUMENT_ROOT'] . '/templates/header/index.php';
        echo 
        '<main class="page-add">
            <h3 style="color:red;">Ошибка прав доступа</h3>
            <div><a class="page-delivery__button button" href="/">Главная страница</a></div>
        </main>';
        exit;  
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Административный раздел</title>
    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">
    <meta name="theme-color" content="#393939">
    <link rel="icon" href="/img/favicon.png">
    <link rel="stylesheet" href="/css/style.min.css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/headerAdmin.php'; ?>
<main class="page-delivery">
    <h1 class="h h--1">Административный раздел</h1>
    <div><a class="page-delivery__button button" href="/admin/orders/">Заказы</a></div>
    <?php
        if (isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == 1) {
            echo '
            <div><a class="page-delivery__button button" href="/admin/products/">Товары</a></div>
            <div><a class="page-delivery__button button" href="/admin/accessRights/">Права доступа</a></div>
            ';
        }
    ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/footerAdmin.php'; ?>
</body>
</html>
