
<?php

$menuAdmin = [
    [
        'name' => 'Заказы',
        'path' => '/admin/orders/',
    ],
    [
        'name' => 'Товары',
        'path' => '/admin/products/',
    ],
    [
        'name' => 'Права доступа',
        'path' => '/admin/accessRights/',
    ],
];

/**
 * функция возвращает пункт меню
 * @param array с меню
 * @param string с цветом
 */

function createLi ($arr, $color) 
{
    echo "
        <li>
            <a class='main-menu__item' " . $color .  " href=" . $arr['path'] . ">" . $arr['name'] ."</a>
        </li>
    ";
}

/**
 * функция возвращает ul меню 
 * @param array с меню
 */
function createMenu(array $menu, $str)
{
    echo "<ul class='main-menu main-menu--" . $str . "'>";
    menuList($menu, 3);
    echo "</ul>";
}

/**
 * функция возвращает меню с разной длиной в зависимости от статуса юзера
 * @param array с меню
 * @param string с длиной масиива
 */

function menuList($menu, $menuLength)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
    foreach($menu as $key => $val) {
        if (isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == 1) {
            if ($key + 1 <= $menuLength)  {
                if ( strlen($_SERVER['REQUEST_URI']) == 1 || $_SERVER['REQUEST_URI'][1] == '?') {
                    if ($key < 1) {
                        createLi($menu[0], "style='color:#E45446;'");
                    } else {
                        createLi($val, '');
                    }
                } else {
                    if ($_SERVER['REQUEST_URI'] == $val['path']) {
                       createLi($val, "style='color:#E45446;'");
                    } else {
                        createLi($val, '');
                    }
                }
            } else {}
        } else {
            if ($key == 0) {
                createLi($val, "style='color:#E45446;'");
            }
        }
    } 
}
