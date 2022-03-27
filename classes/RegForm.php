<?php

require_once 'User.php';
require_once 'Session.php';

class RegForm extends Form
{
    private $login;
    private $password;
    private $password_confirm;
    private $email;
    private $name;
    private $error_fields;

    public function __construct($login, $password, $password_confirm, $email, $name)
    {
        $this->login = trim(stripslashes(htmlspecialchars($login)));
        $this->password = trim(stripslashes(htmlspecialchars($password)));
        $this->password_confirm = trim(stripslashes(htmlspecialchars($password_confirm)));
        $this->email = trim(stripslashes(htmlspecialchars($email)));
        $this->name = trim(stripslashes(htmlspecialchars($name)));
    }

    public function validation()
    {
        $this->checkUserLogin($this->login);
        $this->checkUserPassword($this->password);
        $this->checkUserPasswordConfirm($this->password_confirm);
        $this->checkUserEmail($this->email);
        $this->checkUserName($this->name);


        if (empty($this->getErrorField()["error_login"])) {
            $account = $this->getUserLogin();
            if (isset($account)) {
                $this->error_fields["error_login"] = "Логин с таким пользователем уже существует";
            }
        }

        if (empty($this->getErrorField()["error_email"])) {
            $account = $this->getUserEmail();
            if (isset($account)) {
                $this->error_fields["error_email"] = "Пользователь с такой почтой уже зарегистрирован";
            }
        }

        if(empty($this->getErrorField())) {
            $new_user = new User();

            $salt = $this->generateSalt();
            $hash = md5($salt . $this->password);

            $register_data = [
                "login" => $this->login,
                "password" => $hash,
                "email" => $this->email,
                "name" => $this->name,
                "salt" => $salt,
            ];

            $new_user->insertNewUser($register_data);
            $this->error_fields["status"] = true;

            $session = new Session();
            $session->start($register_data);
        } else {
            $this->error_fields["status"] = false;
        }
    }

    private function checkUserLogin($user_login)
    {
        if ($user_login === '') {
            $error_login = "Укажите логин";
            $this->error_fields["error_login"] = $error_login;
        } else {
            if (!preg_match("/^[a-zA-Z0-9]+$/", $user_login) || strlen(($user_login)) < 6) {
                $error_login = "Длина логина должна составлять не менее 6 символов";
                $this->error_fields["error_login"] = $error_login;
            }
        }
    }

    private function checkUserPassword($user_password)
    {
        if ($user_password === '') {
            $error_password = "Укажите пароль";
            $this->error_fields["error_password"] = $error_password;
        } else {
            if (!preg_match("/^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$/", $user_password) || strlen($user_password) < 6) {
                $error_password = "Пароль обязательно должен состоять из букв и цифр длинной не менее 6 символов";
                $this->error_fields["error_password"] = $error_password;
            }
        }
    }

    private function checkUserPasswordConfirm($user_password_confirm)
    {
        if ($user_password_confirm === '') {
            $error_password_confirm = "Укажите пароль повторно";
            $this->error_fields["error_password_confirm"] = $error_password_confirm;
        }  else if($this->password != $user_password_confirm) {
            $error_password_confirm = "Пароль не совпадает";
            $this->error_fields["error_password_confirm"] = $error_password_confirm;
        }
    }

    private function checkUserEmail($user_email)
    {
        if ($user_email === '') {
            $error_email = "Укажите email";
            $this->error_fields["error_email"] = $error_email;
        } else {
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $error_email = "Не корректно";
                $this->error_fields["error_email"] = $error_email;
            }
        }
    }

    private function checkUserName($user_name)
    {
        if ($user_name === '') {
            $error_name = "Укажите имя";
            $this->error_fields["error_name"] =  $error_name;
        } else {
            if (!preg_match("/^[a-zA-Z]{2}$/", $user_name)) {
                $error_name = "Имя должно состоять только из букв длинной 2 символа";
                $this->error_fields["error_name"] = $error_name;
            }
        }
    }

    private function getUserLogin()
    {
        $user = new User();

        foreach ($accounts = $user->getUsers() as $account) {
            if ($account['login'] === $this->login) {
                return $account;
            }
        }
        return null;
    }

    private function getUserEmail()
    {
        $user = new User();

        foreach ($accounts = $user->getUsers() as $account) {
            if ($account['email'] === $this->email) {
                return $account;
            }
        }
        return null;
    }

    private function generateSalt() {
        $salt = null;
        $length = 10;

        for($i = 0; $i < $length; $i++) {
            $salt .= chr(mt_rand(80,100));
        }

        return $salt;
    }

    public function getErrorField()
    {
        return $this->error_fields;
    }
}