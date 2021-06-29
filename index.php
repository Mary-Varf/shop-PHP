<?php
include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/categoryHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/categoriesHandler.php';

$page = 1;
if (isset($_GET) && array_key_exists('page', $_GET)) {
  $page = $_GET['page'];
} 
$price = countPrices(createGoodsArray());
// if (isset($_GET['useFilter'])) {
//   header('Location: /', true, 301);
// }
?>
<?include $_SERVER['DOCUMENT_ROOT'] . '/templates/header/index.php';?>


<main class="shop-page">
  <header class="intro">
    <div class="intro__wrapper">
      <h1 class=" intro__title">COATS</h1>
      <p class="intro__info">Collection 2018</p>
    </div>
  </header>
  <section class="shop container">
    <section class="shop__filter filter">
      <form>
      <div class="filter__wrapper">
        <b class="filter__title">Категории</b>
        <ul class="filter__list">
          <?createCategoriesList($categories)?>
        </ul>
      </div>
        <div class="filter__wrapper">
          <b class="filter__title">Фильтры</b>
          <div class="filter__range range">
            <span class="range__info">Цена</span>
            <div class="range__line" aria-label="Range Line"></div>
            <div class="range__res">
              <div>
                <span class="range__res-item min-price"><?=(isset($price[0]['minPrice']) ? ($price[0]['minPrice']) : '0')?></span><span class="range__res-item"> руб.</span>
              </div>
              <div>
              <span class="range__res-item range__res-item-clear max-price"><?=(isset($price[0]['maxPrice']) ? $price[0]['maxPrice'] : '0');?></span><span class="range__res-item  range__res-item-clear"> руб.</span>
              </div>
            </div>
          </div>
        </div>

        <fieldset class="custom-form__group">
          
        <?
            if (isset($_GET['cat']) || isset($_GET['category'])) {
              
              foreach(array_unique($_GET) as $key => $val) {
                if ($key == 'cat' || $key == 'category') {
                  echo "<input type='hidden' name=" . $key . " value=" . $val . ">";
                }
              }
            }
          ?>
          <input type="hidden" id='minprice' name="minprice"/>
          <input type="hidden" id='maxprice' name="maxprice"/>
          <input type="checkbox" name="new" id="new" value=<?=((isset($_GET['new']) && $_GET['new'] == '1') ? ('"1" checked') : ('"1"'))?> class="custom-form__checkbox">

          <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
          <input type="checkbox" name="sale" id="sale"  value=<?=((isset($_GET['sale']) && $_GET['sale'] == '1') ? ('"1" checked') : ('"1"'))?> class="custom-form__checkbox">

          <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
        </fieldset>
        <button class="btn" type="submit" name='useFilter' style="width: 100%">Применить</button>
      </form>
    </section>

    <div class="shop__wrapper">
      <section class="shop__sorting">
        <form id="sort_form_1" class="shop__sorting" action="">
          <div class="shop__sorting-item custom-form__select-wrapper">
          <?
            if (isset($_GET)) {
              foreach(($_GET) as $key => $val) {
                if ($key == 'order' || $key == 'sort') {
                } else {
                  echo "<input type='hidden' name=" . $key . " value=" . $val . ">";
                }
              }
            }
          ?>
            <select class="custom-form__select sort" name="sort">
              <option hidden="">Сортировка</option>
              <option value="price" <?=((isset($_GET['sort']) && array_unique($_GET)['sort'] == 'price') ? ' selected ' : '')?>>По цене</option>
              <option value="name" <?=((isset($_GET['sort']) && array_unique($_GET)['sort'] == 'name') ? ' selected ' : '')?>>По названию</option>
            </select>
          </div>
          <div class="shop__sorting-item custom-form__select-wrapper">


            <select class="custom-form__select order" name="order" onchange="this.form.submit()">
              <option hidden="">Порядок</option>
              <option value="asc" <?=((isset($_GET['order']) && array_unique($_GET)['order'] == 'asc') ? ' selected ' : '')?>>По возрастанию</option>
              <option value="desc" <?=((isset($_GET['order']) && array_unique($_GET)['order'] == 'desc') ? ' selected ' : '')?>>По убыванию</option>
            </select>
          </div>
          <p class="shop__sorting-res"><?=countModels(createGoodsArray())?></p>
        </form>
      </section>
      <section class="shop__list">
        <?createGoodsDivs($page, manageOrder(createGoodsArray(), (isset($_GET['order']) ? (array_unique($_GET)['order']) : ''), (isset($_GET['sort']) ? (array_unique($_GET)['sort']) : '')));?> 
      </section>
      <ul class="shop__paginator paginator" style='align-items:center'>
        <?createPagination(createGoodsArray(), $page);?>
        </li>
      </ul>
  </section>

</main>

<?include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer/index.php';?>

</html>
<script>
if (document.querySelector('.shop-page')) {

  let minPricePhp = parseInt(document.querySelector('.min-price').innerText);
  let maxPricePhp = parseInt(document.querySelector('.max-price').innerText);
$('.range__line').slider({
  min: minPricePhp,
  max: maxPricePhp,
  values: [minPricePhp, maxPricePhp],
  range: true,
  stop: function(event, ui) {

    $('.min-price').text($('.range__line').slider('values', 0) + ' ');
    $('.max-price').text($('.range__line').slider('values', 1) + ' ');
    document.querySelector('#minprice').setAttribute('value', $('.range__line').slider('values', 0));

  },
  slide: function(event, ui) {

    $('.min-price').text($('.range__line').slider('values', 0) + ' ');
    $('.max-price').text($('.range__line').slider('values', 1) + ' ');
    document.querySelector('#maxprice').setAttribute('value', $('.range__line').slider('values', 1));

  }
});

}


</script>