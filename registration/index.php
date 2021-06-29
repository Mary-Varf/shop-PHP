<?
  include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';
  if (isset($_COOKIE['login'])) {
    unset($_COOKIE['login']);  
    setcookie('login', '', time() - 1, '/');
  }
  if (isset($_COOKIE['name'])) {
    unset($_COOKIE['name']);  
    setcookie('name', '', time() - 1, '/');
  }
  cookieHandler\deleteSession();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Регистрация</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.css">
  <script defer src="/js/jquery-3.5.1.min.js"></script>
</head>
<body>
<?include $_SERVER['DOCUMENT_ROOT'] . '/templates/header/index.php';?>

<main class="page-authorization" id='login-form'>
  <h1 class="h h--1">Регистрация</h1>
  
  <form class="custom-form" id='reg_form' action="" method="post">
    
    <input id="surname" class="custom-form__input" type="text"  required="" name="surname" value="<?=htmlspecialchars($data['surname'] ?? '') ?>" placeholder='Фамилия*'>

    <input id="usersname" class="custom-form__input" type="text"  required="" name="usersname" value="<?=htmlspecialchars($data['usersname'] ?? '') ?>"  placeholder='Имя*'> 
  
    <input id="thirdName" class="custom-form__input" type="text"name="thirdName" value="<?=htmlspecialchars($data['patronymic'] ?? '') ?>" placeholder='Отчество'>
  
    <input id="phone" class="custom-form__input" type="tel" name="phone" required="" value="<?=htmlspecialchars($data['phone'] ?? '') ?>" placeholder='Телефон*'>
  
    <input id="email" class="custom-form__input" type="email" name="email" required="" value="<?=htmlspecialchars($data['login'] ?? '') ?>" placeholder='Почта*'>
  
    <input class="custom-form__input" required="" id="password" required  size="30" name="password" type="password" minlength="3" placeholder='Ваш пароль:'>

    <input class="custom-form__input" required="" id="passwordVer" required  size="30" name="passwordVer" type="password" minlength="3" placeholder='Повторите пароль:'>

    <div class="error" style='color:red; margin: 20px 0;'></div>

    <button class="button" name='send' id='reg-enter' type="submit">Регистрация</button>
    
    <input type="text" hidden name="productID" id="productID" value='<?=(isset($_GET['productID']) ? $_GET['productID'] : '')?>'>
    
  </form>
</main>
<?include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer/index.php';?>
</body>
</html>

<script>
  
const passwordVer = document.querySelector('#passwordVer');
const emailId = document.querySelector('#email_id');
const password = document.querySelector('#password');

if (passwordVer.value == password.value) {
  const errorBlock = document.querySelector('.error');
  const regBtn = document.querySelector('#reg-enter');

  regBtn.addEventListener('click', (e)=>{
      e.preventDefault();
      const url = '../registration/registrationHandler.php';
      fetch(url, {
              method: 'POST',
              body: JSON.stringify({
                surname: surname.value, 
                usersname: usersname.value, 
                thirdname: thirdName.value, 
                phone: phone.value, 
                email: email.value, 
                password: password.value,
                passwordVer: passwordVer.value,
              }),
          }).then(response => response.json())
          .then((data) => {
            console.log(data);

            if (data == true) {
                window.location.href = "/"; 
            } else {
            const error = document.createElement('div');
            error.classList.add('red'); 
            error.innerText = data;
            errorBlock.appendChild(error);
            setTimeout(() => {
              error.remove();
            }, 2000)
            }
            
          })
        })
} else {
  const error = document.createElement('div');
  error.classList.add('red'); 
  error.innerText = 'Пароли не совпадают';
  errorBlock.appendChild(error);
  setTimeout(() => {
    error.remove();
  }, 2000)
}

 
</script>
</html>
