<?php
session_start();
if ($_SESSION['login']) {
    header('Location: profile.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<!-- Форма регистрации -->

<form>
    <label>Логин</label>
    <input type="text" name="login" placeholder="Введите свой логин" required>
    <span id="error_login"></span>
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Введите пароль" required>
    <span id="error_password"></span>
    <label>Подтверждение пароля</label>
    <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
    <span id="error_password_confirm"></span>
    <label>Почта</label>
    <input type="email" name="email" placeholder="Введите адрес своей почты" required>
    <span id="error_email"></span>
    <label>Имя</label>
    <input type="text" name="name" placeholder="Введите свое имя" required>
    <span id="error_name"></span>
    <button type="submit" class="register-btn">Зарегистрироваться</button>
    <p>
        У вас уже есть аккаунт? - <a href="/">авторизируйтесь</a>!
    </p>
</form>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script>
        const error_login = document.querySelector('#error_login');
        const error_password = document.querySelector('#error_password');
        const error_password_confirm = document.querySelector('#error_password_confirm');
        const error_email = document.querySelector('#error_email');
        const error_name = document.querySelector('#error_name');

        function printData(data) {
            error_login.innerHTML = "";
            error_password.innerHTML = "";
            error_password_confirm.innerHTML = "";
            error_email.innerHTML = "";
            error_name.innerHTML = "";

            if('error_login' in data){
                error_login.textContent = data['error_login'];
            }
            if('error_password' in data){
                error_password.textContent = data['error_password'];
            }
            if('error_password_confirm' in data){
                error_password_confirm.textContent = data['error_password_confirm'];
            }
            if('error_email' in data){
                error_email.textContent = data['error_email'];
            }
            if('error_name' in data){
                error_name.textContent = data['error_name'];
            }
        }
    </script>


<script src="assets/js/main.js"></script>
</body>
</html>
