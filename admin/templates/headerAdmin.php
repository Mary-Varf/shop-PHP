
<?include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/menu.php';?>
<header class="page-header">
  <a class="page-header__logo" style="display:block"  href="/admin/">
    <img src="/img/logo.svg" alt="Fashion">
  </a>

  <nav class='page-header__menu'>
    
    <?=createMenu($menuAdmin, 'header')?>

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
  const enterIcon = document.querySelector('.enter-icon');
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