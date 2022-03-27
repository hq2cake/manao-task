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
    <title>Authorization</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <form>
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <span id="error_login"></span>
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <span id="error_password"></span>
        <button type="submit" class="login-btn">Войти</button>
        <p>
            У вас нет аккаунта? - <a href="/register.php">зарегистрируйтесь</a>!
        </p>
    </form>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script>
        const error_login = document.querySelector('#error_login');
        const error_password = document.querySelector('#error_password');

        function printData(data) {
            error_login.innerHTML = "";
            error_password.innerHTML = "";

            if('error_login' in data){
                error_login.textContent = data['error_login'];
            }
            if('error_password' in data){
                error_password.textContent = data['error_password'];
            }
        }
    </script>

    <script src="assets/js/main.js"></script>
</body>
</html>
