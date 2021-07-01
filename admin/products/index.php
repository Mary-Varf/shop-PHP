<?php

include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/products/productsHandler.php';
if (isset($_COOKIE['add/change'])) {
  unset($_COOKIE['add/change']);  
  setcookie('add/change', '', time() - 1, '/');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Товары</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">
  <script defer src="/js/jquery-3.5.1.min.js"></script>
</head>
<body>

<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/headerAdmin.php'?>

<main class="page-products">
  
    <?
      if (isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == '1' && isset($_COOKIE['name'])) {
        createProductsTable(createProductsArray());
      } else {
        echo '<h3 class="red">Ошибка прав доступа</h3>
        <div><button class="page-delivery__button button" OnClick="history.back();">Назад</button></div>
        ';
      }
      
    ?>

</main>

<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/footerAdmin.php'?>

</body>

<script>

  const delProduct = (el_id) => {
    $.ajax({
      type: 'POST',
      url: '/admin/products/add/delProduct.php',
      cache: false,
      contentType: false,
      processData: false,
      data: el_id,
      dataType : 'json',
      success: function(msg){
        console.log(msg);

        if (!msg) {
            const error = document.createElement('div');
            error.classList.add('red'); 
            error.innerText = row.error;
            ul.appendChild(error);
            setTimeout(()=> {
              error.remove();
            }, 2000)
          } else {
            document.getElementById('id_'+ el_id).remove();
          }
        }
    });
  }
  

</script>
</html>
