
<?php

$menu = [
    [
        'name' => 'Главная',
        'title' => 'all',
        'path' => '/',
    ],
    [
        'name' => 'Новинки',
        'title' => 'women',
        'path' => '/index.php?new=1',
    ],
    [
        'name' => 'Sale',
        'title' => 'men',
        'path' => '/index.php?sale=1',
    ],
    [
        'name' => 'Доставка',
        'title' => 'children',
        'path' => '/delivery.php',
    ],
];



/**
 * функция возвращает пункт меню
 * @param массив с меню
 * @param строку с цветом
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
 * @param массив с меню
 */
function createMenu(array $menu, $str = 'header')
{
    echo "<ul class='main-menu main-menu--" . $str . "'>";

        menuList($menu, 4);

    echo "</ul>";

}


/**
 * функция возвращает меню с разной длиной в зависимости от статуса юзера
 * @param массив с меню
 * @param строку с длиной масиива
 */

function menuList($menu, $menuLength)
{
    foreach($menu as $key => $val) {

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
                } 
                else {
                    createLi($val, '');
                }
            }
        } else {

        }
    } 
}