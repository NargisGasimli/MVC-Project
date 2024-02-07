<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model{

    public string $email = '';
    public string $password = '';

    public function rules():array
    {
        return[
            'email' => [self::RULES_REQUIRED, self::RULES_EMAIL],
            'password' => [self::RULES_REQUIRED],
        ];
    }

    public function login(){

        $user = User::findOne(['email' => $this->email]);

        if(!$user){
            $this->addError('email', 'User does not exist with this email');
            return false;
        }

        if(!password_verify($this->password, $user->password)){
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        Application::$app->login($user);
    }

    public function label(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}