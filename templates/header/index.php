
<?
  include $_SERVER['DOCUMENT_ROOT'] . '/templates/menu/createLi.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fashion</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="/img/intro/coats-2018.jpg" as="image">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script defer src="/js/scripts3.js"></script>

</head>
<body class='body'>
    
<header class="page-header">
<a class="page-header__logo" style="display:block"  href="/">
  <img src="/img/logo.svg" alt="Fashion">
</a>

<nav class='page-header__menu'>
  
  <?createMenu($menu);?>

</nav>
  <?
    if (isset($_COOKIE['name']) && isset($_SESSION['password'])) {
      echo '
      <button onclick="exit()" class="auth-user" id="auth-user">User: ' . $_COOKIE['name'] . '</button>';
    } else {
      echo '
      <a href="/authorization/" class="auth-user" id="auth-go">Авторизация</a>';
    }
    ?>
</header>
<script>
  const enterBlock = document.querySelector('#auth-user');
  const authBtn = document.querySelector('#auth-go');
  const header = document.querySelector('.page-header');

  const enterIcon = document.querySelector('.enter-icon');
  const exit = () => {
    fetch('/php/exit.php', {
          method: 'POST',
          body: JSON.stringify(''),
      }).then(response => response.json())
      .then((data) => {
          console.log(data);
        if (data) {
          enterBlock.remove();
          const emptyChild = document.createElement('div');
          header.appendChild(emptyChild);
          window.location.href = "/"; 
        }
        else {
          enterBlock.innerHTML = 'Ошибка';
        }
        
      })
    
  }
  if (enterBlock) {
    const inner = enterBlock.innerHTML;
    enterBlock.addEventListener('mouseover', () => {
    enterBlock.innerHTML = 'Выйти';
    
    enterBlock.classList.add('show-exit');
  })

  enterBlock.addEventListener('mouseout', () => {
    enterBlock.innerHTML = inner;
    enterBlock.classList.remove('show-exit');
  })

  
  }

</script>
