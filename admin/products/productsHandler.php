<?php

/**
 * функция  возвращает массив с товарами
 */
function createProductsArray ()
{
  include $_SERVER['DOCUMENT_ROOT'] . '/php/serverCred.php';
   
    $line = 'SELECT goods.id as ID, goods.name as name, price, ct.ru_name as category, new, sale FROM goods 
    left join category_good as cg on goods.id = cg.goods_id
    left join categories as ct on cg.categories_id = ct.id order by ID';
    
    $connect = new mysqli($host, $user, $passwordSql, $dbname);
    mysqli_set_charset($connect,'utf8'); 
    if(mysqli_connect_errno()) {
   
      return  'Возникла ошибка, повторите попытку позже';

    } else {
      
      $result = mysqli_query($connect, $line);
      $goodsList = [];

      while($row = mysqli_fetch_assoc($result)) {
          array_push($goodsList, $row);
      }; 
      return $goodsList;
    } 
    mysqli_close($connect);

  
}
/**
 * функция  возвращает данные таблицы с товарами
 * @param принимает массив с товарами
 */
function createProductsTable ($array)
{
  echo '
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="/admin/products/add/">Добавить товар</a>
  
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
    <span class="page-products__header-field">Акция</span>
  </div>
  <ul class="page-products__list" style="position:relative;">
 
  ';
    foreach($array as $key => $val) {
        ($val['new'] == '0') ? ($new = 'Нет') : ($new = 'Да');
        ($val['sale'] == '0') ? ($sale = 'Нет') : ($sale = 'Да');
        echo         '
        <li class="product-item page-products__item " id="id_' . $val['ID'] . '">
        
          <b class="product-item__name">' . $val['name'] . '</b>
          <span class="product-item__field">' . $val['ID'] . '</span>
          <span class="product-item__field">' . $val['price'] . ' руб.</span>
          <span class="product-item__field">' . $val['category'] . '</span>
          <span class="product-item__field">' . $new . '</span>
          <span class="product-item__field">' . $sale . '</span>
          <a href="/admin/products/add/index.php?change_id=' . $val['ID'] .'" class="product-item__edit" aria-label="Редактировать"></a>
          <button class="product-item__delete" onclick="delProduct(' . $val['ID']. ')"></button>
          
        </li>';
    }
    echo '  </ul>';
}
