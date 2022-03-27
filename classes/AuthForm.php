<?php

require_once 'User.php';
require_once 'Session.php';

class AuthForm extends Form
{
    private $login;
    private $password;
    private $error_fields;

    public function __construct($login, $password)
    {
        $this->login = trim(stripslashes(htmlspecialchars($login)));
        $this->password = trim(stripslashes(htmlspecialchars($password)));
    }

    public function validation()
    {
        $this->checkUserLogin($this->login);
        $this->checkUserPassword($this->password);

        $data_user = $this->getUserByLogin($this->login);
        if(empty($this->getErrorField())) {
            if( $data_user != null) {
                $salt = $data_user['salt'];
                $password = md5($salt .$this->password);

                if($data_user['password'] == $password) {
                    $this->error_fields["status"] = true;
                    $session = new Session();
                    $session->start($data_user);
                } else {
                    $this->error_fields["error_password"] = "Пароль не верный";
                    $this->error_fields["status"] = false;
                }

            } else {
                $this->error_fields["error_login"] = "Аккаунта с таким логином не существует";
                $this->error_fields["status"] = false;
            }

        }

    }

    private function getUserByLogin($user_login)
    {
        $user = new User();

        foreach ($accounts = $user->getUsers() as $account){
            if($account['login'] == $user_login) {
                return $account;
            }
        }
        return null;
    }

    private function checkUserLogin($user_login)
    {
        if ($user_login === '') {
            $error_login = "Укажите логин";
            $this->error_fields["error_login"] = $error_login;
        }
    }

    private function checkUserPassword($user_password)
    {
        if ($user_password === '') {
            $error_password = "Укажите пароль";
            $this->error_fields["error_password"] = $error_password;
        }
    }

    public function getErrorField()
    {
        return $this->error_fields;
    }
}