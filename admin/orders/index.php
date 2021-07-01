<? require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Список заказов</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">
  <style>
  .order-item__info__status.green{
    color: green;
  }
  .order-item__info__status.red{
    color:red;
  }
  </style>
</head>

<body>

<?
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/headerAdmin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/orders/ordersListHandler.php';
?>

<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  
  <div><button class="page-delivery__button button" OnClick="history.back();">Назад</button></div><br>
  <ul class="page-order__list">
    <?=createList()?>
  </ul>
</main>

<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/footerAdmin.php'?>
</body>
<script>

  const status = document.querySelectorAll('.order-item__info__status');
    status.forEach(el => {
        if (el.innerText == 'Обработан') {
          el.style.color = 'green';
        } else {
          el.style.color = 'red';
        }
    })

  

            
  const changeStatusAjax = (id, status) => {
    console.log(id, status)
      const block = document.querySelector('#change_id_' + id);
      const parent = block.parentNode;
      const statusContainer = parent.querySelector('.order-item__info__status');
      fetch('/admin/orders/changeStatus.php', {
          method: 'POST',
          body: JSON.stringify({id: id, status: status}),
      })
      .then(response => response.json())
      .then((data) => {
        console.log(data);
        if (data) {

          statusContainer.innerText='';
          statusContainer.innerText = data;
          if (data === 'Обработан') {
            statusContainer.style.color='green';
          } else {
            statusContainer.style.color='red';
          }
            
        }
        if (!data) {
          parent.classList.add('red'); 
          parent.innerText = 'Ошибка!';
        }
      })
    }
      

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

  });
}
const arrows = document.querySelectorAll('.arrow') 
const showList = document.querySelectorAll('.showList') 
console.log(arrows);
arrows.forEach(arrow => 
arrow.addEventListener('click', (e) => {
  const toggledList = e.target.parentNode.parentNode.lastChild;
  toggledList.classList.toggle('disabled');
  
})

)
</script>
</html>
