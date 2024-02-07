<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    public string $firstname = '';
    public string $lastname = '';
    public $status = self::STATUS_INACTIVE;
    public string $email = '';
    public string $password = '';
    public string $confirm_password = '';

    public static function tableName():string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules():array
    {
        return[
            'firstname' => [self::RULES_REQUIRED],
            'lastname' => [self::RULES_REQUIRED],
            'email' => [self::RULES_REQUIRED, self::RULES_EMAIL,[
                self::RULES_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULES_REQUIRED, [self::RULES_MAX, 'max' => 8],[self::RULES_MIN, 'min' => 4]],
            'confirm_password' => [self::RULES_REQUIRED, [self::RULES_MATCH, 'match' => 'password']],
        ];
    }

    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function getAttributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password', 'status'];
    }

    public function label(): array
    {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
        ];
    }

    public function getDisplayName(): string{
        return $this->firstname .' '. $this->lastname;
    }
}