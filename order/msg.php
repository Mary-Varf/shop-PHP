<?php

$msg = [
    [
        'btnText' => 'Авторизоваться',
        'h2' => 'Возникла ошибка',
        'path' => '/authorization.php',
    ],
    [
        'btnText' => 'Продолжить покупки',
        'h2' => 'Спасибо за заказ!<br> С Вами свяжутся в ближайшее время',
        'path' => '/',
    ],
    [
        'btnText' => 'Вернуться',
        'h2' => 'Введенные данные получателя не корректны',
        'path' => '',
    ],
    [
        'btnText' => 'Вернуться',
        'h2' => 'Введенные данные адреса не корректны',
        'path' => '',
    ],
    [
        'btnText' => 'Вернуться',
        'h2' => 'Проблемы с сервером, повторите попытку позже',
        'path' => '',
    ],
    [
        'btnText' => 'Вернуться',
        'h2' => 'Возникла неизвестная ошибка, повторите попытку позже',
        'path' => '',
    ],
];

/**
 * функция  возвращает сообщение о результате отправки заявки
 * @param массив с вариантами сообщений
 */

function createMsg($msg) 
{
    $btnText = $msg['btnText'];

    $path = ($msg['path'] == '' ? $_SERVER['REQUEST_URI'] : $msg['path']);
    $errorText = $msg['h2'];
    echo '    
    <section class="shop-page__popup-end">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
        <p class="shop-page__end-message">' . $errorText . '</p>
        <a href="' . $path . '" class="button">' . $btnText . '</a>
        </div>
    </section> ';
}
  