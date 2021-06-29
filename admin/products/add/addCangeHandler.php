<?php

/**
 * функция возвращает сообщение о добавлении или изменении товара
 */

function popupEnd()
{
  if (isset($_COOKIE['add/change'])) {
    $str = $_COOKIE['add/change'];
    unset($_COOKIE['add/change']);  
    setcookie('add/change', '', time() - 1, '/');
    echo '
    <section class="shop-page__popup-end page-add__popup-end">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно ' . $str . '</h2>
      <a href="/admin/products/" class="button" >Вернуться</a>
    </div>
    ';
  }
}


/**
 * функция возвращает сообщение об ошибке
 */
function popupError()
{
  if (isset($_GET['error'])) {
    if ($_GET['error'] == '1') {
      $add = 'ошибка подключения';
    } elseif ($_GET['error'] == '2') {
      $add = 'не заполнены все поля';
    } elseif ($_GET == '3') {
      $add = 'возникла ошибка, попробуйте повторить попытку позже';
    } elseif ($_GET['error'] == '5') {
      $add = 'нет изображения';
    }
    echo '
    <section class="shop-page__popup-end page-add__popup-end">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h3 class="shop-page__end-title">$add</h3>
      <a href="/admin/products/" class="button" >Вернуться</a>
    </div>
    ';
  }
}

/**
 * функция возвращает список категорий
 * @param массив с вариантами категорий
 * @param строку выбрано или нет
 */

function options ($arr, $str)
{
  foreach($arr as $key => $val) {
    echo '<option value="' . ($key +1) . '" ' . $str .  ' >' . $val . '</option>';
  }
}


/**
 * функция определяет выбранна категория или нет
 * @param массив с категориями из бд
 */
function createCategoriesOptions(array $data)
{
  
  $arr=[];
  foreach($data as $key => $val) {
    $arr[$val['categories_id'] -1 ] = $val['cat_name'];
  }

  $difArr = [];
  $catOptions = ['Женщины', 'Мужчины', 'Дети', 'Аксессуары'];

  $difArr = array_diff($catOptions, $arr);
  
  options($arr, ' selected ');
  options($difArr, ''); 

}

