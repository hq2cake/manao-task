<?php
session_start();
if (!$_SESSION['login']) {
    header('Location: /');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<form>
    <h1>Страница 1</h1>
    <h2><?= 'Привет, ' . $_COOKIE['name'] ?></h2>
    <a href="vendor/logout.php" class="logout">Выход</a>
</form>
</body>
</html>


