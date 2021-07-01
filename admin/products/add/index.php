<?php

include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
include  $_SERVER['DOCUMENT_ROOT'] . "/php/serverCred.php";
include  $_SERVER['DOCUMENT_ROOT'] . "/admin/products/add/addCangeHandler.php";

if (!(isset($_COOKIE['login']) && isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == '1')) {

  include $_SERVER['DOCUMENT_ROOT'] . '/templates/header/index.php';
  echo 
  '<main class="page-add">
    <h3 style="color:red;">Ошибка прав доступа</h3>
  </main>';
  exit;
}

if (isset($_GET['change_id'])) {
  $id = $_GET['change_id']; 
  $message = '';
  $line = "SELECT goods.id as ID, goods.name as name, price, goods.img, new,cat.ru_name as cat_name, sale, cg.categories_id FROM goods 
  left join category_good as cg on goods.id = cg.goods_id
  left join categories as cat on cat.id = cg.categories_id
  where goods.id = '$id'";
  
  $connect = new mysqli($host, $user, $passwordSql, $dbname);
  mysqli_set_charset($connect,'utf8'); 

  if(mysqli_connect_errno()) {

    $message =  'Возникла ошибка, повторите попытку позже';

  } else {
    
    $result = mysqli_query($connect, $line);
    $data = [];
    while($row = mysqli_fetch_assoc($result)) {
        array_push($data, $row);
    }; 
    
  } 
  mysqli_close($connect);

}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Добавление товара</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>
<body>

<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/headerAdmin.php';?>

<main class="page-add">

  <form class="custom-form" id="good_info_form" action="/admin/products/add/save_product.php" method="post">
  <h1 class="h h--1">
  <?=(!isset($data[0]) ? 'Добавление товара' : 'Измение товара');?>  

  </h1>
    <fieldset class="page-add__group custom-form__group">
      <?=$message?>
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <?
        if (isset($data[0])) {
          echo '<input type="text" name="change" id="change" value="1" hidden>
          <input type="text" id="id" name="id" value="' . $id . '" hidden>';
        }
      ?>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="productName" id="productName" placeholder='Название товара*' required value="<?=htmlspecialchars($data[0]['name'] ?? '') ?>">
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="productPrice" id="productPrice" placeholder='Цена товара*' required  value="<?=htmlspecialchars($data[0]['price'] ?? '') ?>">
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара*</legend>
      <ul class="add-list">

        <?
          if (isset($data[0]['img']) && $data[0]['img'] != '') {
            echo '<li class="add-list__item add-list__item--add" hidden>
            <input id="productPhoto" type="file" name="file[]" hidden multiple accept=".jpg,.jpeg,.png,.gif">
            <label for="productPhoto">Добавить фотографию</label>
          </li>
          <li class="add-list__item add-list__item--active">
            <img src=' . $data[0]['img'] . ' alt=' . $data[0]['name'] . '>
          </li>
          </ul>
          <div class="new-item" style="display:none;">
            <div class="img-item">
              <img src=' . $data[0]['img'] . '>
              <a herf="#" onclick="remove_img(this); return false;"></a>
              <input type="hidden" name="images[]" value=' . mb_strcut($data[0]['img'], 14) . '>
            </div>
          </div>
          <input hidden type="text" name="oldImg" value="' . $data[0]['img'] . '">
          ';
          } else {
            echo 
            '<li class="add-list__item add-list__item--add">
              <input id="productPhoto" type="file" name="file[]" hidden multiple accept=".jpg,.jpeg,.png,.gif">
              <label for="productPhoto">Добавить фотографию</label>
            </li>
            </ul>
            <div class="new-item" style="display:none;"></div>
            ';
          }
        ?>

        
      

    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" id='category' class="custom-form__select" multiple="multiple" required>          
          <option hidden="">Название раздела</option>
          <?createCategoriesOptions((isset($data[0]['categories_id']) ? $data : []))?>
        </select>
      </div>
      <input type="checkbox" name="newProd" id="newProd" value='new' class="custom-form__checkbox"  <?if(isset($data[0])) {echo (($data[0]['new'] == '0') ? '' : 'checked');} ?>>
      <label for="newProd" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" value='sale' class="custom-form__checkbox" <?if(isset($data[0])) {echo (($data[0]['sale'] == '0') ? '' : 'checked');}?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <div class="errorBlock"></div>
    <button class="button" name='addProduct' id="add-product" type="submit">
      <?
        if (!isset($data[0])) {
          echo 'Добавить товар';
        } else {
          echo 'Изменить товар';
        }
      ?>
      </button>
      * - поля обязательные для заполнения
  </form>
  <?
  $getLine = '';
  if (isset($_GET)) {
    $getLine = '?';
    foreach($_GET as $key => $val) {
      if ($key != 'error') {
        $getLine = $getLine . $key . '=' . $val . '&';
      }
    }
  }
    if (isset($_GET['error'])) {
      $color = 'red';
      $visability = '';
      if (isset($_GET['error'])) {
        if ($_GET['error'] == '1') {
          $msg = 'Ошибка подключения, повторите попытку позже';
        } elseif ($_GET['error'] == '2') {
          $msg = 'Необходимо заполнить все поля помеченные звездочкой';
        } elseif ($_GET['error'] == '3') {
          $msg = 'Возникла ошибка, повторите попытку позже';
        } elseif ($_GET['error'] == '4') {
          $msg = 'Изменения не сохранены, повторите попытку позже';
        } elseif ($_GET['error'] == '5') {
          $msg = 'Необходимо загрузить фотографию товара';
        } else {
          $msg = 'Ошибка, повторите попытку позже';
        } 
      }  

      echo '
      <section class="shop-page__popup-end page-add__popup-end">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
          <h2 class="h h--2 shop-page__end-title ' . $color . '">' . $msg . '</h2>
          <a href="/admin/products/add/index.php'. $getLine . '"  class="button error-block__link">Вернуться</a>
        </div>
        </section>
      ';
    }
    if (isset($_COOKIE['add/change'])) {
      echo '
      <section class="shop-page__popup-end page-add__popup-end">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
          <h2 class="h h--2 h--icon shop-page__end-title "> Товар успешно ' . $_COOKIE['add/change'] . '</h2>
          <a href="/admin/products/"  class="button error-block__link">Вернуться</a>
        </div>
        </section>
      ';     
    }

  ?>




</main>
<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/footerAdmin.php'?>

</body>
<script src="/js/jquery-3.5.1.min.js"></script>
<script>
   'use strict';

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

      const status = evt.target.previousElementSibling;

      if (status.classList && status.classList.contains('order-item__info--no')) {
        status.textContent = 'Выполнено';
      } else {
        status.textContent = 'Не выполнено';
      }

      status.classList.toggle('order-item__info--no');
      status.classList.toggle('order-item__info--yes');

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#productPhoto');

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      $('.new-item').children().remove();
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

}






$("#productPhoto").change(function(){
	if (window.FormData === undefined) {
		alert('В вашем браузере загрузка файлов не поддерживается');
	} else {
		var formData = new FormData();
		$.each($("#productPhoto")[0].files, function(key, input){
			formData.append('file[]', input);
		});
		$.ajax({
			type: 'POST',
			url: '/admin/products/add/upload_image.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			dataType : 'json',
			success: function(msg){
				msg.forEach(function(row) {
					if (row.error != '') {
						alert(row.error);
					} 
          if (row.error == '') {
						$('.new-item').append(row.data);
					}
				});
				$("#productPhoto").val(''); 
			}
		});
	}
});
 const delImg = document.querySelector('.img-item');
 const delImgActive = document.querySelector('.add-list__item--active');
 const delImgAdd = document.querySelector('.add-list__item--add');
 if (delImg) {
    delImg.addEventListener('click', (e) => {
      e.preventDefault();
    })
    delImgActive.addEventListener('click', (e) => {
      e.preventDefault();
      delImg.remove();
      delImgActive.remove();
      delImgAdd.hidden = false;
    })

 }



</script>
</html>
