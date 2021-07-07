<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/order/msg.php';

/**
 * функция отправляет данные о заказе в бд
 * @param массив с вариантами сообщений
 * @return сообщение о результате отправки заказа в бд
 */

function orderProduct($msg)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
    $message = '';
    if (isset($_POST['surname']) && isset($_GET['productID'])) {
        $connect = connectSQL();
        if (mysqli_connect_errno()) {
            $message = createMsg($msg[4]);
        } else {
            if (!isset($_POST['surname']) || !isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['email']) || $_POST['surname'] == '' || $_POST['name'] == '' || $_POST['phone'] == '' || $_POST['email'] == '') {
                $message = createMsg($msg[2]);
            } else {        
                $delivery = $connect->real_escape_string($_POST['delivery']);
                $city = $connect->real_escape_string($_POST['cityD']);
                $street = $connect->real_escape_string($_REQUEST["streetD"]);
                $home = $connect->real_escape_string($_REQUEST["homeD"]);
                $aprt = $connect->real_escape_string($_POST['aprtD']);
                $pay = $connect->real_escape_string($_POST['pay']);
                $comment = $connect->real_escape_string($_POST['comment']);
                
                ($delivery == 'dev-no') ? ($delivery = '0') : ($delivery = '1');
                ($pay == 'cash') ? ($pay = '0') : ($pay = '1');
                $login = $connect->real_escape_string($_COOKIE['login']);
                (isset($_SESSION['password'])) ? ($password = $_SESSION['password']) : ($password = '');
        
                if ($delivery == '1' && ($city == '' || $home == '' || $aprt == '' || $street == ''))  {
                    $message = createMsg($msg[3]);
                } else {
                    $resultAuth = mysqli_query($connect, "SELECT login, users.id FROM users
                    where login='$login' and password='$password';");
                    if ($resultAuth && $resultAuth->num_rows > 0) {
                        $data = $resultAuth->fetch_array();
                        if (is_array($data)) {
                            $prodId = $connect->real_escape_string(intval(substr($_GET['productID'], 14)));
                            $resultPrice = mysqli_query($connect, "SELECT price FROM `goods` WHERE id=$prodId;");
                            while ($row = mysqli_fetch_assoc($resultPrice)) {
                                $price = $row['price'];
                            }
                            if ($delivery == '1' && $price < FREE_DEL_PRICE) {
                                $price = $price + AD_DEL_PRICE;
                            }
                            $usersId = $data['id'];

                            $resultOrder = mysqli_query($connect, "INSERT INTO `orders` (`users_id`, `total_price`) VALUES ('$usersId', '$price');");
                            $insert_id = $connect->insert_id;

                            $resultGoodOrder = mysqli_query($connect, "INSERT INTO `good_order` (`orders_id`, `goods_id`) VALUES ('$insert_id', '$prodId');");

                            $resultInfo = mysqli_query($connect, "INSERT INTO `info` (`orders_id`, `delivery`, `payment`, `comment`) VALUES ('$insert_id', '$delivery', '$pay', '$comment');");
                            if ($delivery == '1') {
                                $resultAddress = mysqli_query($connect, "INSERT INTO `address` (`info_orders_id`, `city`, `street`, `building`, `flat`) 
                                VALUES ('$insert_id', '$city', '$street', '$home', '$aprt');");
                            }
                            if (!$resultOrder && !$resultGoodOrder && !$resultInfo || ($delivery == '1' && !$resultAddress)) {
                                $message = createMsg($msg[3]);
                            } else {
                                $message = createMsg($msg[1]);
                            }
                        }
                    } else {
                        $message = createMsg($msg[0]);
                    }
                }            
            }
        }
        mysqli_close($connect);
    }
    return $message;
} 

/**
 * функция возвращает массив с данными юзера с логином и паролем как из сессии
 */
 
function getUsersInfo ()
{
    include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
    
    $login = (isset($_COOKIE['login']) ? $_COOKIE['login'] : '');
    $password = (isset($_SESSION['password']) ? $_SESSION['password'] : '');

    $data = [];
    $connect = connectSQL();

    if (mysqli_connect_errno()) {
        return false;
    } else { 
        $result = mysqli_query($connect, "SELECT * FROM users WHERE login = '$login'");
        if ($result -> num_rows > 0) {
            $data = $result->fetch_array();
        } else {
            mysqli_close($connect);
            return false;
        }
        if ($data['password'] == $password) {
            mysqli_close($connect);
            return $data;
        }
    }
}
