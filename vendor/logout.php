<?php
session_start();

unset($_SESSION['login']);
unset($_COOKIE['name']);
setcookie('name', null, -1, '/');
header('Location: ../index.php');
