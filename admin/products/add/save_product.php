<?php
include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/img/tmp/';
$path = $_SERVER['DOCUMENT_ROOT'] . '/img/products/';
 
$connect = connectSQL();

/**
 * функция возвращает строку со строкой(ссылка для переадресации с сохранением всех гетов)
 */

function createHeaderLink()
{
    $ref = $_SERVER['HTTP_REFERER'];
    if (strpos($ref, 'php?')) {
        $headerLink = 'Location: ' . $ref . '&error=';
    } else {
        $headerLink = 'Location: ' . $ref . '?error=';
    }
    return $headerLink;
}
/**
 * возвращает тезультат внесения в бд или фолс
 * @param string с ИД изменяемого/добавляемого товара
 */
function saveCategoryDB(string $id, $connect)
{
    if (!empty($_POST['category'])) {
        $category = $_POST['category'];
        foreach($category as $key => $val) {
            $resultCat = mysqli_query($connect, "INSERT INTO `category_good` (`goods_id`, `categories_id`) VALUES ('$id', '$val')");
        }
    }
    if (isset($resultCat)) {
        return $resultCat;
    } else {
        return false;
    }
}

if (mysqli_connect_errno()) {
    header((createHeaderLink() . '1'), true, 301);
    echo json_encode(false);
} else {
    if (isset($_POST['addProduct'])) {
        if (!isset($_POST['productName']) || $_POST['productName'] == '' || !isset($_POST['productPrice']) || $_POST['productPrice'] == '' || !(isset($_POST['category'])) || empty($_POST['category']))  {
            header((createHeaderLink() . '2'), true, 301);
            echo json_encode(false);
        } else {
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']);
            } 
            $name = $connect->real_escape_string($_POST['productName']);
            $price = intval($_POST['productPrice']);
            $new = ((isset($_POST['newProd']) && $_POST['newProd'] == 'new') ? '1' : '0');
            $sale = ((isset($_POST['sale']) && $_POST['sale'] == 'sale') ? '1' : '0');            
            $oldImg = (isset($_POST['oldImg']) ? $connect->real_escape_string($_POST['oldImg']) : '0');

            if (!empty($_POST['images']) && $_POST['images'][0] != '' && !isset($_POST['change'])) {
                $filename = preg_replace("/[^a-z0-9\.-]/i", '', $_POST['images'][0]);
                if (!empty($filename)) {
                    $result = mysqli_query($connect, "INSERT INTO `goods` (`name`, `price`, `new`, `sale`, `img`) VALUES ('$name', '$price', '$new', '$sale', '/img/products/$filename');");
                    $insert_id = $connect->insert_id;
                    $resultCat = saveCategoryDB($insert_id, $connect);

                    if ($result && $resultCat) {
                        if (is_file($tmp_path . $filename)) {
                            rename($tmp_path . $filename, $path . $filename);
                            $nameArr = explode('.', $filename);
                            $file_name = pathinfo($filename, PATHINFO_FILENAME);
                            array_map( 'unlink', array_filter((array) glob($tmp_path . "*") ) );		
                        }
                        cookieHandler\createCookieAddChange('добавлен');
                        header('Location: /admin/products/add/', true, 301);
                        echo json_encode(true);
                        echo json_encode('Изменения внесены');
                    } else {
                        header((createHeaderLink() . '3'), true, 301);
                        echo json_encode(false);
                    }
                }    
            } elseif (isset($_POST['change']) && isset($_POST['id']) && !empty($_POST['images']) && $_POST['images'] != '') {
                $id = $connect->real_escape_string($_POST['id']);
                $filename = preg_replace("/[^a-z0-9\.-]/i", '', $_POST['images'][0]);
                $result = mysqli_query($connect, "UPDATE `goods` SET `name` = '$name', `price` = '$price', `new` = '$new', `sale`='$sale', `img` = '/img/products/$filename' WHERE `id` = '$id'");
                $resultDelCat = mysqli_query($connect, "DELETE FROM `category_good` WHERE `goods_id` = '$id'");
                $resultCat = saveCategoryDB($id, $connect);

                if ($result && $resultCat && $resultDelCat) {
                    if (("/img/products/" . $_POST['images'][0]) != $oldImg) {
                        $dir = $_SERVER['DOCUMENT_ROOT']  . strval($oldImg);
                        unlink($dir);
                        if (is_file($tmp_path . $filename)) {
                            rename($tmp_path . $filename, $path . $filename);
                            $nameArr = explode('.', $filename);
                            $file_name = pathinfo($filename, PATHINFO_FILENAME);
                            array_map( 'unlink', array_filter((array) glob($tmp_path . "*") ) );		
                        }
                    }
                    cookieHandler\createCookieAddChange('изменен');
                    header('Location: /admin/products/add/', true, 301);
                    echo json_encode(true);
                    echo json_encode("Изменения внесены (Изменен)");
                } else {
                    header((createHeaderLink() . '4'), true, 301);
                    echo json_encode(false);
                }
            } else {
                header((createHeaderLink() . '5'), true, 301);
                echo json_encode(false);
            }
        }
    } else {
        header((createHeaderLink() . '6'), true, 301);
        echo json_encode(false);
    }
}
mysqli_close($connect);
