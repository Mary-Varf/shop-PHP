<?php

/**
 * функция  возвращает массив с товарами
 */
function createGoodsArray ()
{
  include $_SERVER['DOCUMENT_ROOT'] . '/php/serverCred.php';
   
    $arr = [];
    $line = '';
    $add = '';
    
    if (isset($_GET)) {

      if (!isset($_GET['cat'])) {
        $clearGet = $_GET;
      }   else {
      ($_GET['cat'] == '') ? ($clearGet = array_diff($_GET, array(''))) : ($clearGet = $_GET); 
      }
      
      foreach($clearGet as $key => $val) {
          if (($key == 'cat' || $key == 'category') && $val != '') {
            $add = 'ct.name = "' . $val . '"';
          } elseif ($key == 'new') {
            $add = 'goods.new = "' . $val . '"';
          } elseif ($key == 'sale') {
            $add = 'goods.sale = "' . $val . '"';
          } elseif ($key == 'minprice' && $val != '') {
            $add = 'goods.price >= "' . $val . '"';
          } elseif ($key == 'maxprice' && $val != '') {
            $add = 'goods.price <= "' . $val . '"';
          } else {
            continue;
          }

          array_push($arr, $add);
        
      }
      
      $lineConcat = implode(' and ', $arr);
      $lineConcat = (strlen($lineConcat) > 0) ? ($line = ' where ' . $lineConcat) : '';
      
      (strlen($line) > 0) ? ($line = 'SELECT distinct goods.id, goods.name, price, img FROM goods 
      left join category_good as cg on goods.id = cg.goods_id
      left join categories as ct on cg.categories_id = ct.id ' . $lineConcat) : ($line = 'SELECT distinct goods.id, goods.name, price, img FROM goods');
      
    } else {
      $line = 'SELECT distinct goods.id, goods.name, price, img FROM goods';
    }
    $connect = new mysqli($host, $user, $passwordSql, $dbname);
    mysqli_set_charset($connect,'utf8'); 

    if(mysqli_connect_errno()) {
   
      return  $goodsList = [];;

    } else {
      
      $result = mysqli_query($connect, $line);
      $goodsList = [];

      while($row = mysqli_fetch_assoc($result)) {
          array_push($goodsList, $row);
      }; 
      return $goodsList;
    } 

    mysqli_close($connect);
}

/**
* Функция возврвщает строку с количеством моделей
* @param массив
* @return строку с количеством моделей
*/

function countModels($array = []) : string
{
  $modelsNumber = count($array);
  $text = 'Найдено ';
  $lastNumber = substr($modelsNumber, -1, 1);
  
  if ($modelsNumber > 99) {
      $twoLastNumbers = substr($modelsNumber, -2, 2);
  } else {
      $twoLastNumbers = $modelsNumber;
  }
  
  switch (true) {
      case ($modelsNumber == 0):
          return 'Не найдено ни одной модели';
          break;
      case ($twoLastNumbers != 11 && $lastNumber == 1):
          return $text . $modelsNumber . ' модель';
          break;
      case ($twoLastNumbers != 12 && $twoLastNumbers != 13 && $twoLastNumbers != 14 && $lastNumber >= 2 && $lastNumber <= 4):
          return $text . $modelsNumber . ' модели';
          break;
      default:
        return $text . $modelsNumber . ' моделей';
  }

}

/**
* Функция возврвщает новый массив с отсортированными значениями
* @param массив
* @param строка сортировка
* @return тип массив с упорядоченными значениями(сортировка по ключу)
*/

function manageOrder(array $array, string $order = 'noSort', string $sort = 'noSort') : array
{
  $sortedArray = [];
  
  function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
  }

  if ($order == 'noSort' || $sort == 'noSort') {
    $sortedArray = $array;
  } else {
    if ($sort == 'price') {
      if ($order == 'asc') {
        usort($array, build_sorter($sort));
      } elseif ($order =='desc') {
        usort($array, build_sorter($sort));
        krsort($array);
      };
    } elseif ($sort == 'name') {
      if ($order == 'asc') {
        function cmp($a, $b)
        {
            return strcmp($a["name"], $b["name"]);
        }
        usort($array, "cmp");
      } elseif ($order == 'desc') {
        function cmp($a, $b)
        {
            return strcmp($b["name"], $a["name"]);
        }
        usort($array, "cmp");
      }
    }

    
    foreach ($array as $item) {
        array_push($sortedArray, $item);
    } 
  }
  return $sortedArray;
};

/**
 * функция  выводит список товаров
 * @param строку с номером страницы
 * @param массив с товарами
 */
function createGoodsDivs ($page,$array)
{
  if (!isset($array) || (isset($array) && count($array) == 0)) {
    echo 'Товары отсутствуют, попробуйте выбрать другую категорию';
  } else {
    foreach($array as $key => $val) {
      if ($key >= ($page * 9 - 9) && $key < $page * 9) {
        echo  "<article class='shop__item product' id='goods_list_id_" . $val['id'] . "' tabindex='0'>
        
        <div class='product__image'>
          <img src='" . $val['img'] . "' alt='" . $val['name'] . "'>
        </div>
        <h4 class='product__name'>" . $val['name'] . "</h4>
        <span class='product__price'>" . number_format($val['price'],0,'',' ') . " руб.</span>
        
      </article>";
    }
    }
  }
} 

/**
 * функция  выводит лишки с номерами страниц (5 до, 5 после и активную)
 * @param массив с товарами
 * @param строку с номером страницы
 */
function createPagination ($array, $page) 
{
  $pagesNumber = ceil(count($array) / 9);
  if (isset($_GET) && !empty($_GET)) {
    $href = '/?';
    $get = '';
    foreach($_GET as $key => $val) {
      if ($key != 'page') {
        $get = $get . $key . '=' . $val . '&'; 
      }
    }
    $href = $href . $get . 'page=';
  } else {
    $href = '/?page=';
  }
  for ($i = 1; $i <= $pagesNumber; $i++) {

    if ($i == $page) {
      echo '
        <li>
          <a class="paginator__item " style="background-color:#E45446; color:#fff" href="' . $href . $i . '">' . $i .'</a>
        </li>
      ';
    } elseif (($i <= $page + 5) && ($i >= $page - 5) ) {
      echo '
        <li>
          <a class="paginator__item" href="' . $href . $i . '">' . $i .'</a>
        </li>
      ';
    } 

  }
}

/**
 * функция возвращает массив с макс и мин ценами

 */

function countPrices()
{
 $maximum = 100000;
 $minimum = 0;
  $arr = [];
  $line = '';
  $add = '';
  
  if (isset($_GET)) {

    if (!isset($_GET['cat'])) {
      $clearGet = $_GET;
    }   else {
    ($_GET['cat'] == '') ? ($clearGet = array_diff($_GET, array(''))) : ($clearGet = $_GET); 
    }
    
    foreach($clearGet as $key => $val) {
        if (($key == 'cat' || $key == 'category') && $val != '') {
          $add = 'ct.name = "' . $val . '"';
        } elseif ($key == 'new') {
          $add = 'goods.new = "' . $val . '"';
        } elseif ($key == 'sale') {
          $add = 'goods.sale = "' . $val . '"';
        } elseif ($key == 'minprice' && $val != '') {
          $add = 'goods.price >= "' . $minimum . '"';
        } elseif ($key == 'maxprice' && $val != '') {
          $add = 'goods.price <= "' . $maximum  . '"';
        } else {
          continue;
        }

        array_push($arr, $add);
      
    }
    
    $lineConcat = implode(' and ', $arr);
    $lineConcat = (strlen($lineConcat) > 0) ? ($line = ' where ' . $lineConcat) : '';
    
    (strlen($line) > 0) ? ($line = 'SELECT  MAX(price) AS maxPrice, MIN(price) AS minPrice FROM goods  
    left join category_good as cg on goods.id = cg.goods_id
    left join categories as ct on cg.categories_id = ct.id ' . $lineConcat) : ($line = 'SELECT  MAX(price) AS maxPrice, MIN(price) AS minPrice FROM goods ');
    
  } else {
    $line = 'SELECT  MAX(price) AS maxPrice, MIN(price) AS minPrice FROM goods ';
  }
  include $_SERVER['DOCUMENT_ROOT'] . '/php/serverCred.php';
  $connect = new mysqli($host, $user, $passwordSql, $dbname);
  
  mysqli_set_charset($connect,'utf8'); 
  if(mysqli_connect_errno()) {
 
    return  $prices =  ["maxPrice"=> $maximum, "minPrice"=> $minimum ];

  } else {
    
    $result = mysqli_query($connect, $line);
    $prices = [];

    while($row = mysqli_fetch_assoc($result)) {
        array_push($prices, $row);
    }; 
    return $prices;
  } 

  mysqli_close($connect);
  
}