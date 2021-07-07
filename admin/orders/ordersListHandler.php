<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
/**
 * функция возвращает массив со списком заявок (проверка на права)
 */
function createList()
{
    if (isset($_COOKIE['login']) && isset($_SESSION['roles_id']) && $_SESSION['roles_id'] < 3) {
        getOrdersData();
    } else {
        return '<h3 class="red">Необходимо авторизоваться, возможно, 
        у вас не хватает прав доступа</h3>
        <div><button class="page-delivery__button button" OnClick="history.back();">Назад</и></div>';
    }
}

/**
 * функция возвращает таблицу с данными о заявках
 * @param массив с заявками
 */

function showOrderInfo ($arr)
{
    foreach($arr as $key => $data) {
        $delivery = ($data['delivery'] == '0' ? 'Самовывоз' : 'Курьерная доставка');
        $payment = ($data['payment'] == '0' ? 'Наличными' : 'Банковской картой');
        $price = number_format($data['total_price'], 0, '', ' ');
        $phone = '+7 ' . number_format($data['phone'], 0, '', ' ');
        $status = ($data['status'] ? 'Обработан' : 'Не обработан');
        echo '                
            <li class="order-item page-order__item">
            <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--id">
                <span class="order-item__title">Номер заказа</span> 
                <span class="order-item__info order-item__info--id">' . $data['orders_id'] . '</span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Сумма заказа</span>
                ' . $price . ' руб.
            </div>
            <button class="order-item__toggle toggle__orders-' . $data['orders_id'] . '"></button>
            </div>
            <div class="order-item__wrapper toggle__orders-' . $data['orders_id'] . '" >
            <div class="order-item__group order-item__group--margin">
                <span class="order-item__title">Заказчик</span>
                <span class="order-item__info">' . $data['name'] . ' ' . $data['surname'] . ' ' . $data['patronymic']. '</span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Номер телефона</span>
                <span class="order-item__info">' . $phone . '</span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Способ доставки</span>
                <span class="order-item__info">' . $delivery . '</span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Способ оплаты</span>
                <span class="order-item__info">' . $payment . '</span>
            </div>
            <div class="order-item__group order-item__group--status">
                <span class="order-item__title">Статус заказа</span>
                <span class="order-item__info order-item__info__status">' . $status . '</span>
                <button class="order-item__btn" id="change_id_' . $data['orders_id'] . '" onclick="changeStatusAjax(' . $data["orders_id"] . ', ' . $data['status'] . ')" >Изменить</button>
            </div>
            </div>
        ';
        if ($data['delivery']) {
            echo  '
            <div class="order-item__wrapper">
            <div class="order-item__group">
                <span class="order-item__title">Адрес доставки</span>
                <span class="order-item__info">г. ' . $data['city'] . ', ул. ' . $data['street'] . ', д.' . $data['building'] . ', кв. ' . $data['flat'] . '</span>
            </div>
            </div>
            ';
        }
        echo '                        
            <div class="order-item__wrapper">
            <div class="order-item__group good">
                <span class="order-item__title">Товар</span>
                <span class="order-item__info">ID ' . $data['good_id'] . '<br>Наименование товара:  ' . $data['good_name'] . '</span>
            </div>
        ';
        if (isset($data['comment'])) {
            echo '
                </div>
                <div class="order-item__wrapper">
                <div class="order-item__group">
                    <span class="order-item__title">Комментарий к заказу</span>
                    <span class="order-item__info">' . $data['comment'] . '</span>
                </div>
                </div>
            ';
        }
        echo '</li>';
    }
} 

/**
 * функция возвращает массив с данными о заявках из бд
 */
function getOrdersData()
{
    include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

    $connect = connectSQL();

    if (mysqli_connect_errno()) {
        echo 'Возникла ошибка, повторите попытку позже';
    } else {
        $result = mysqli_query($connect, "SELECT orders.id AS orders_id, i.payment, i.delivery, i.comment, 
        g.id AS good_id, g.name AS good_name,  orders.total_price,
        u.name, u.surname, u.patronymic, u.phone, orders.status,
        a.city, a.street, a.building, a.flat
        FROM orders 
        LEFT JOIN info as i on orders.id=i.orders_id
        LEFT JOIN address AS a ON i.orders_id = a.info_orders_id
        LEFT JOIN good_order AS go ON go.orders_id = i.orders_id 
        LEFT JOIN goods AS g ON go.goods_id = g.id
        LEFT JOIN users AS u ON u.id = orders.users_id
        ORDER BY orders_id DESC
        ;");
        
        if ($result && $result->num_rows > 0) {
            $orders = [];
            $executed = [];
            $notExecuted = [];
            while($row = mysqli_fetch_assoc($result)) {
                array_push($orders, $row);
            }
            foreach($orders as $key => $val) {
                if ($val['status'] == '0') {
                    array_push($notExecuted, $val);
                } else {
                    array_push($executed, $val);
                }
            }
            echo '<div><button class="page-delivery__button button" OnClick="history.back();">Назад</button></div><br>';
            echo '<div class="arrow-block" style="margin: 0 0 20px"><div class="arrow-area"><h2>Не обработаны:</h2><button class="order-item__toggle toggle__orders-22 arrow"></button></div><div class="show-list">';
            showOrderInfo($notExecuted);
            echo '</div></div>';
            echo '<div  class="arrow-block"><div  class="arrow-area"><h2>Обработаны:</h2><button class="order-item__toggle toggle__orders-22  arrow"></button></div><div class="show-list">';
            showOrderInfo($executed);
            echo '</div></div>';
        } else {
            echo ('Нет данных о заказе');
        }
    }
    mysqli_close($connect);
}
