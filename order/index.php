<?php
/**
 * @var array $msg
 */
include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/order/msg.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/order/orderProductHandler.php';
    $data = getUsersInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.min.css">
    <script defer src="/js/jquery-3.5.1.min.js"></script>
    <title>Оформление заказа</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header/index.php'; ?>
<section class="shop-page__order">
    <div class="shop-page__wrapper">
        <h2 class="h h--1">Оформление заказа</h2>
        <?php
            if (!isset($_COOKIE['login']) || !isset($_SESSION['password']) || !isset($_GET['productID'])) {
                if (isset($_GET)) {
                    $href = '';
                    foreach($_GET as $key => $val) {
                        $href = $href . '&' . $key . '=' . $val;
                    }
                    $href = substr($href, 1);
                }
                echo 
                '<h3 class="red">Для совершения покупки Вам необходимо авторизоваться</h3>
                <br><a href="/authorization/?' . $href .'" class="button">Авторизоваться</a><br><br>
                <form action="" method="post" class="custom-form js-order" id="order_good_form" hidden>
                ';
            } else {
                echo '<form action="" method="post" class="custom-form js-order" id="order_good_form">';
            }
        ?>
        <fieldset class="custom-form__group">
            <legend class="custom-form__title">Укажите свои личные данные</legend>
            <p class="custom-form__info">
                <span class="req">*</span> поля обязательные для заполнения
            </p>
            <div class="custom-form__column">
                <label class="custom-form__input-wrapper" for="surname">
                <input id="surname" class="custom-form__input" type="text" name="surname" value="<?php echo htmlspecialchars($data['surname'] ?? '') ?>" placeholder='Фамилия*'>
                </label>
                <label class="custom-form__input-wrapper" for="name">
                <input id="name" class="custom-form__input" type="text" name="name" value="<?php echo htmlspecialchars($data['name'] ?? '') ?>"  placeholder='Имя*'> 
                </label>
                <label class="custom-form__input-wrapper" for="thirdName">
                <input id="thirdName" class="custom-form__input" type="text" name="thirdName" value="<?php echo htmlspecialchars($data['patronymic'] ?? '') ?>" placeholder='Отчество'>
                </label>
                <label class="custom-form__input-wrapper" for="phone">
                <input id="phone" class="custom-form__input" type="tel" name="phone" required="" value="<?php echo htmlspecialchars($data['phone'] ?? '') ?>" placeholder='Телефон*'>
                </label>
                <label class="custom-form__input-wrapper" for="email">
                <input id="email" class="custom-form__input" type="email" name="email" required="" value="<?php echo htmlspecialchars($data['login'] ?? '') ?>" placeholder='Почта*'>
                </label>
            </div>
        </fieldset>
        <fieldset class="custom-form__group js-radio">
            <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
            <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="dev-no" checked="">
            <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
            <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="dev-yes">
            <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
        </fieldset>
        <div class="shop-page__delivery shop-page__delivery--no">
            <table class="custom-table">
                <caption class="custom-table__title">Пункт самовывоза</caption>
                <tr>
                    <td class="custom-table__head">Адрес:</td>
                    <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
                </tr>
                <tr>
                    <td class="custom-table__head">Время работы:</td>
                    <td>пн-вс 09:00-22:00</td>
                </tr>
                <tr>
                    <td class="custom-table__head">Оплата:</td>
                    <td>Наличными или банковской картой</td>
                </tr>
                <tr>
                    <td class="custom-table__head">Срок доставки: </td>
                    <td class="date">13 декабря—15 декабря</td>
                </tr>
            </table>
        </div>
        <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
            <fieldset class="custom-form__group">
                <legend class="custom-form__title">Адрес</legend>
                <p class="custom-form__info">
                    <span class="req">*</span> поля обязательные для заполнения
                </p>
                <div class="custom-form__row">
                    <label class="custom-form__input-wrapper" for="city">
                        <input id="city" class="custom-form__input" type="text" name="cityD" value="<?php echo htmlspecialchars($_POST['city'] ?? '') ?>" placeholder="Город*"> 
                    </label>
                    <label class="custom-form__input-wrapper" for="street">
                        <input id="street" class="custom-form__input" type="text" name="streetD" value="<?php echo htmlspecialchars($_POST['street'] ?? '') ?>" placeholder="Улица*">
                    </label>
                    <label class="custom-form__input-wrapper" for="home">
                        <input id="home" class="custom-form__input custom-form__input--small" type="text" name="homeD" value="<?php echo htmlspecialchars($_POST['home'] ?? '') ?>" placeholder="Дом*">
                    </label>
                    <label class="custom-form__input-wrapper" for="aprt">
                        <input id="aprt" class="custom-form__input custom-form__input--small" type="text" name="aprtD" value="<?php echo htmlspecialchars($_POST['aprt'] ?? '') ?>" placeholder="Квартира*">
                    </label>
                </div>
            </fieldset>
        </div>
        <fieldset class="custom-form__group shop-page__pay">
            <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
            <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
            <label for="cash" class="custom-form__radio-label">Наличные</label>
            <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
            <label for="card" class="custom-form__radio-label">Банковской картой</label>
        </fieldset>
        <fieldset class="custom-form__group shop-page__comment">
            <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
            <textarea class="custom-form__textarea" name="comment" value="<?php echo htmlspecialchars($_POST['comment'] ?? '') ?>"></textarea>
        </fieldset>
        <button class="button" type="submit" id='send_order'>Отправить заказ</button>
        <a href="<?php
            $line = '/';
            if (isset($_GET) && !empty($_GET)) {
                $line = '/?';
                foreach($_GET as $key => $val) {
                    if ($key != 'productID') {
                        $line = $line . $key . '=' . $val . '&';
                    }
                }
            }
            echo $line;
        ?>" class="button" >Вернуться</a>
      </form>
    </div>
  </section>
  <?php
    if (isset($_GET['productID']) && isset($_COOKIE['login']) && isset($_SESSION)) {
        echo orderProduct($msg);
    }
  ?>
</form>

</body>
<script>
  const popup = document.querySelector('.shop-page__popup-end');
  if (popup) {
    document.querySelector('.shop-page__order').hidden =true;
  }
  const devYes = document.querySelector('#dev-yes');
  devYes.addEventListener('checked', (e) => {
    e.preventDefault();
  })
  var elem = document.getElementsByName("delivery");
  // elem.foreach((el) => {
  //   console.log(el.value);
  // })
  for(let i=0; i < elem.length; i++) {
    elem[i].onchange = () => {
    if (elem[i].value == 'dev-yes') {
      document.querySelector('.shop-page__delivery--yes').hidden = false;
      document.querySelector('.shop-page__delivery--no').hidden = true;
      document.querySelector('#city').setAttribute('required', true);
      // document.querySelector('#street').setAttribute('required', true);
      document.querySelector('#home').setAttribute('required', true);
      document.querySelector('#aprt').setAttribute('required', true);
    } else {
      document.querySelector('.shop-page__delivery--yes').hidden = true;
      document.querySelector('.shop-page__delivery--no').hidden = false;
      document.querySelector('#city').removeAttribute('required');
      document.querySelector('#street').removeAttribute('required');
      document.querySelector('#home').removeAttribute('required');
      document.querySelector('#aprt').removeAttribute('required');
    }
  }
}
</script>
</html>