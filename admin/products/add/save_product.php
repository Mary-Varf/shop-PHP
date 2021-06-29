<?php


include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';

$tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/img/tmp/';

$path = $_SERVER['DOCUMENT_ROOT'] . '/img/products/';
 
include $_SERVER['DOCUMENT_ROOT'] . '/php/serverCred.php';

$connect = new mysqli($host, $user, $passwordSql, $dbname);
mysqli_set_charset($connect,'utf8'); 

$ref = $_SERVER['HTTP_REFERER'];
$headerLink = '';
if (strpos($ref, 'php?')) {
    $headerLink = 'Location: ' . $ref . '&error=';
} else {
    $headerLink = 'Location: ' . $ref . '?error=';
}
if(mysqli_connect_errno()) {
    header(($headerLink . '1'), true, 301);
    echo json_encode(false);
} else {
    if (isset($_POST['addProduct'])) {
        if (!isset($_POST['productName']) || $_POST['productName'] == '' || !isset($_POST['productPrice']) || $_POST['productPrice'] == '')  {
            header(($headerLink . '2'), true, 301);
            echo json_encode(false);
        } else {
            if (isset($_POST['id'])) {
                $id = $connect->real_escape_string($_POST['id']);
            }
    
            $name = $connect->real_escape_string($_POST['productName']);
            $price = $connect->real_escape_string($_POST['productPrice']);
            if (isset($_POST['newProd']) && $_POST['newProd'] == 'new') {
                $new = '1';
            } else {
                $new='0';
            }
            if (isset($_POST['sale']) && $_POST['sale'] == 'sale') {
                $sale = '1';
            } else {$sale='0';}
            
            
            $oldImg = (isset($_POST['oldImg']) ? $connect->real_escape_string($_POST['oldImg']) : '0');

            
            $category = (isset($_POST['category']) ? $_POST['category'] : []);
                if (!empty($_POST['images']) && $_POST['images'][0] != '' && !isset($_POST['change'])) {
                        $filename = preg_replace("/[^a-z0-9\.-]/i", '', $_POST['images'][0]);
                        if (!empty($filename)) {
    
                            $line = "INSERT INTO `goods` (`name`, `price`, `new`, `sale`, `img`) VALUES ('$name', '$price', '$new', '$sale', '/img/products/$filename');";
                            $result = mysqli_query($connect, $line);
    
                            $insert_id = $connect->insert_id;
                            if (count($category) > 0) {
                                foreach($category as $key => $val) {
                                    $line2 = "INSERT INTO `category_good` (`goods_id`, `categories_id`) VALUES ('$insert_id', '$val');";
                                    $resultCat = mysqli_query($connect, $line2);
                                }
                            } else {
                                $resultCat = true;
                            }
                            if($result && $resultCat) {
                                if (!empty($filename) && is_file($tmp_path . $filename)) {
                                    
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
                                header(($headerLink . '3'), true, 301);
                                echo json_encode(false);
                            }
                        }
                    
                    
                } elseif (isset($_POST['change'])  && !empty($_POST['images']) && $_POST['images'] != '') {
                    $filename = preg_replace("/[^a-z0-9\.-]/i", '', $_POST['images'][0]);
                    $line = "UPDATE `goods` SET `name` = '$name', `price` = '$price', `new` = '$new', `sale`='$sale', `img` = '/img/products/$filename' WHERE (`id` = '$id');";
                    $result = mysqli_query($connect, $line);
    
                    $resultDelCat = mysqli_query($connect, "DELETE FROM `category_good` WHERE (`goods_id` = '$id');");
    
                    if (count($category) > 0) {
                        foreach($category as $key => $val) {
                            $resultCat = mysqli_query($connect, "INSERT INTO `category_good` (`goods_id`, `categories_id`) VALUES ('$id', '$val');");
                        }
                    } else {
                        $resultCat = true;
                    }
    
                    if($result && $resultCat && $resultDelCat) {
                        if (("/img/products/" . $_POST['images'][0]) != $oldImg) {
                            $dir = $_SERVER['DOCUMENT_ROOT']  . strval($oldImg);
                            unlink($dir);
                            if (!empty($filename) && is_file($tmp_path . $filename)) {
                    
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
                    }  else {
                        header(($headerLink . '4'), true, 301);
                        echo json_encode(false);
                    }

                } else {
                    header(($headerLink . '5'), true, 301);
                    echo json_encode(false);
                }
        }
        
       
    } else {
        header(($headerLink . '6'), true, 301);
        echo json_encode(false);
    }
}
mysqli_close($connect);