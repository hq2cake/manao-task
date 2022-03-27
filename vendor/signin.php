<?php

require_once '../classes/User.php';
require_once '../classes/Form.php';
require_once '../classes/AuthForm.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {


    $user = new AuthForm($_POST['login'], $_POST['password']);
    $user->validation();

    echo json_encode($user->getErrorField());
}





