<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/accessRights/createUsersTable.php';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Права доступа</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">
  <script defer src="/js/jquery-3.5.1.min.js"></script>
  <script defer src="/js/scripts3.js"></script>

</head>
<body>


<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/headerAdmin.php'?>

<main class="page-products">
  <h1 class="h h--1">Настройка прав доступа</h1>
  
  <?=createUsersTable(createUsersArray())?>
  
</main>

<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/footerAdmin.php'?>

</body>

</html>
