<?php

/**
 * функция возвращает список категорий
 * @param массив с вариантами категорий
 * @param строку выбрано или нет
 */

function options ($arr, $str)
{
    foreach($arr as $key => $val) {
        echo '<option value="' . ($key + 1) . '" ' . $str .  ' >' . $val . '</option>';
    }
}


/**
 * функция определяет выбранна категория или нет
 * @param массив с категориями из бд
 */
function createCategoriesOptions(array $data)
{  
    $arr=[];
    $catOptions = ['Женщины', 'Мужчины', 'Дети', 'Аксессуары'];

    foreach($data as $key => $val) {
        $arr[$val['categories_id'] - 1] = $val['cat_name'];
    }
    $difArr = array_diff($catOptions, $arr);
    options($arr, ' selected ');
    options($difArr, ''); 
}
