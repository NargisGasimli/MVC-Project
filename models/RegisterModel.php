<?php

namespace app\models;
use app\core\Model;

class RegisterModel extends Model{
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $confirm_password;

    public function rules()
    {
        return[
            'firstname' => [self::RULES_REQUIRED],
            'lastname' => [self::RULES_REQUIRED],
            'email' => [self::RULES_REQUIRED, self::RULES_EMAIL],
            'password' => [self::RULES_REQUIRED, [self::RULES_MAX, 'max' => 8],[self::RULES_MIN, 'min' => 4]],
            'confirm_password' => [self::RULES_REQUIRED, [self::RULES_MATCH, 'match' => 'password']],
        ];
    }

    public function register(){
        echo 'Creating new user';
    }
}