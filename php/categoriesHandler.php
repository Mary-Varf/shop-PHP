<?php

$categories = [
    [
        'name' => 'Все',
        'title' => 'all',
        'path' => '/',
    ],
    [
        'name' => 'Женщины',
        'title' => 'women',
        'path' => '/?category=women',
    ],
    [
        'name' => 'Мужчины',
        'title' => 'men',
        'path' => '/?category=men',
    ],
    [
        'name' => 'Дети',
        'title' => 'children',
        'path' => '/?category=children',
    ],
    [
        'name' => 'Аксессуары',
        'title' => 'accessories',
        'path' => '/?category=accessories',
    ],
];


/**
 * функция возвращает лишки с категориями 
 * @param массив категорий
 */

function createCategoriesList ($categories)
{
    if (isset($categories)) {
        foreach($categories as $key => $val) {
            if (isset($_GET['category']) && $_GET['category'] == $val['title'] || (isset($_GET['cat']) && $_GET['cat'] == $val['title']) || (!isset($_GET['category'])   && $val['path'] == '/')) {
                echo "
                    <li>
                        <a class='filter__list-item active' href='" . $val['path'] . "'>" . $val['name'] . "</a>
                    </li>
                ";              
            } else {
                echo "
                    <li>
                        <a class='filter__list-item' href='" . $val['path'] . "'>" . $val['name'] . "</a>
                    </li>
                ";
            }
            
        }
    } else {
        echo "
            <li>
                <a class='filter__list-item active' href='/'>Все</a>
            </li>
        ";
    }
}