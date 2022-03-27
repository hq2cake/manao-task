<?php

require_once "User.php";

class Session
{
    function __construct() {
        session_start();

    }

    function start($user){
        setcookie("name", $user['name'], time()+3600, '/');
        $_SESSION['login'] = $user['login'];
    }
    function destroy(){
        session_destroy();

        header('Location: ../index.php');
    }
}