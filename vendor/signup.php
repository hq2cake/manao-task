<?php

require_once '../classes/User.php';
require_once '../classes/Form.php';
require_once '../classes/RegForm.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {


    $new_user = new RegForm($_POST['login'], $_POST['password'], $_POST['confirm_password'], $_POST['email'], $_POST['name']);
    $new_user->validation();

    echo json_encode($new_user->getErrorField());

}
