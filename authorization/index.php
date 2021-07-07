<?php include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">
    <meta name="theme-color" content="#393939">
    <link rel="icon" href="/img/favicon.png">
    <link rel="stylesheet" href="/css/style.min.css">
    <script defer src="/js/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header/index.php'; ?>
<main class="page-authorization" id='login-form'>
    <h1 class="h h--1">Авторизация</h1>
    <form class="custom-form" action="" method="post">
        <input type="email" class="custom-form__input" required=""  id="email_id" name="email" minlength="3" placeholder="Ваш email:" value="<?php echo htmlspecialchars(isset($_COOKIE['login']) ? $_COOKIE['login'] : ''); ?>">
        <input class="custom-form__input" required="" id="password"  size="30" name="password" type="password" minlength="3" placeholder='Ваш пароль:'>
        <div class="error" style='color:red; margin: 20px 0;'></div>
        <button class="button" name='send' id='login-enter' type="submit">Войти в личный кабинет</button>
        <h3><a href='/registration/' class='dark-grey'>Регистрация</a></h3>
        <input type="text" hidden name="productID" id="productID" value='<?php echo (isset($_GET['productID']) ? $_GET['productID'] : ''); ?>'>
    </form>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer/index.php'; ?>
</body>
</html>

<script>
const emailId = document.querySelector('#email_id');
const password = document.querySelector('#password');
const errorBlock = document.querySelector('.error');
const loginBtn = document.querySelector('#login-enter');

loginBtn.addEventListener('click', (e)=>{
    e.preventDefault();
    const post = [email_id.value, password.value, productID.value];
    const url = '../authorization/login.php';
    fetch(url, {
            method: 'POST',
            body: JSON.stringify({email: email_id.value, password: password.value, productID: productID.value}),
        })
    .then(response => response.json())
    .then((data) => {
        console.log(data);
        if (typeof(data) != 'string') {
            if (data.roles_id == '1') {
                window.location.href = "/admin/"; 
            } else if (data.roles_id == '2') {
                window.location.href = "/admin/orders/"; 
            } else if (data.roles_id == '3' && data.productID || data.roles_id == null) {
                window.location.href = "/order/" + window.location.search; 
            } else {
                window.location.href = "/";
            }
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
</script>
</html>
