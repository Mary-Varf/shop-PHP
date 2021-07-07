<?php

/**
 * функция  возвращает массив с товарами
 */
function createProductsArray ()
{
    include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
    $line = 'SELECT goods.id AS ID, goods.name AS name, price, ct.ru_name AS category, new, sale FROM goods 
    LEFT JOIN category_good AS cg ON goods.id = cg.goods_id
    LEFT JOIN categories AS ct ON cg.categories_id = ct.id ORDER BY ID DESC';
    
    $connect = connectSQL();
    if (mysqli_connect_errno()) {
        return  'Возникла ошибка, повторите попытку позже';
    } else {
        $result = mysqli_query($connect, $line);
        $goodsList = [];
        while($row = mysqli_fetch_assoc($result)) {
            array_push($goodsList, $row);
        }
        for ($i = count($goodsList) - 1; $i >= 0; $i--) {
            if ($i >= 1 && $goodsList[$i]['ID'] == $goodsList[$i - 1]['ID']) {
                $goodsList[$i - 1]['category'] = $goodsList[$i]['category'] . ', ' . $goodsList[$i - 1]['category'];
                unset($goodsList[$i]);
            }
        }
    }
    mysqli_close($connect);
    return $goodsList;
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
        <span class="page-products__header-field">Категории</span>
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
          <span class="product-item__field">' . number_format($val['price'],2,',',' ') . '</span>
          <span class="product-item__field">' . $val['category'] . '</span>
          <span class="product-item__field">' . $new . '</span>
          <span class="product-item__field">' . $sale . '</span>
          <a href="/admin/products/add/index.php?change_id=' . $val['ID'] .'" class="product-item__edit" aria-label="Редактировать"></a>
          <button class="product-item__delete" onclick="delProduct(' . $val['ID']. ')"></button>
        </li>';
    }
    echo '</ul>';
}
