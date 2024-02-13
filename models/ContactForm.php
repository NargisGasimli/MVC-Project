<?php

namespace app\models;

use app\core\Model;

class ContactForm extends Model{

    public string $subject = '';
    public string $email = '';
    public string $body = '';
    public function rules(): array
    {
        return [
            'subject' => [self::RULES_REQUIRED],
            'email' => [self::RULES_REQUIRED],
            'body' => [self::RULES_REQUIRED],
        ];
    }

    public function label(): array
    {
        return [
            'subject'=> 'Enter your subject',
            'email'=> 'Enter Your email',
            'body'=> 'Body',
        ];
    }

    public function send()
    {
        return true;
    }
}