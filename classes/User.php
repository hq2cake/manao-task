<?php

class User
{
    private $stored_data;
    private $number_of_records;
    private $ids = [];
    private $logins = [];
    private $json_file = '../database/users.json';

    function __construct()
    {
        $this->stored_data = json_decode(file_get_contents($this->json_file), true);
        $this->number_of_records = count($this->stored_data);

        if ($this->number_of_records != 0){
            foreach ($this->stored_data as $user){
                array_push($this->ids, $user['id']);
                array_push($this->logins, $user['login']);
            }
        }
    }

    private function setUserID($user)
    {
        if ($this->number_of_records == 0){
            $user['id'] = 1;
        } else {
            $user['id'] = max($this->ids) + 1;
        }

        return $user;
    }

    private function storeData()
    {
        file_put_contents(
            $this->json_file,
            json_encode($this->stored_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
    }

    public function insertNewUser($new_user)
    {
        $user_with_id_field = $this->setUserID($new_user);
        array_push($this->stored_data, $user_with_id_field);

        if ($this->number_of_records == 0) {
            $this->storeData();
        }else {
            if(!in_array($new_user['login'], $this->logins)){
                $this->storeData();
            }
        }
    }

    public function updateUser($user_id, $field, $value)
    {
        foreach ($this->stored_data as $key => $stored_user){
            if($stored_user['id'] == $user_id){
                $this->stored_data[$key][$field] = $value;
            }
        }
        $this->storeData();
    }

    public function deleteUser($user_id)
    {
        foreach ($this->stored_data as $key => $stored_user){
            if($stored_user['id'] == $user_id){
                unset($this->stored_data[$key]);
            }
        }
        $this->storeData();
    }

//    public function checkUserData($user_login, $user_password)
//    {
//        foreach ($this->stored_data as $key => $stored_user){
//            if($stored_user['login'] == $user_login) {
//                $salt = $this->stored_data[$key]["salt"];
//                $hash = md5($salt .$user_password);
//
//                if ($this->stored_data[$key]["password"] == $hash) {
//                    return 1;
//                } else {
//                    return 2;
//                }
//            }
//        }
//
//        return 3;
//    }

    public function getUsers()
    {
        return $this->stored_data;
    }
}