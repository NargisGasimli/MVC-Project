<?php

namespace app\core;

abstract class Model{

    public const RULES_REQUIRED = 'required';
    public const RULES_EMAIL = 'email';
    public const RULES_MIN = 'min';
    public const RULES_MAX = 'max';
    public const RULES_MATCH = 'match';

    public function loadData($data){
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules();

    public array $errors = [];

    public function validate(){
        foreach($this->rules() as $attribute => $rules){
            // [
            //     'firstname' => [self::RULES_REQUIRED],
            //     'lastname' => [self::RULES_REQUIRED],
            //     'email' => [self::RULES_REQUIRED, self::RULES_EMAIL],
            //     'password' => [self::RULES_REQUIRED, [self::RULES_MAX, 'max' => 8],[self::RULES_MIN, 'min' => 4]],
            //     'firstname' => [self::RULES_REQUIRED, [self::RULES_MATCH, 'match' => 'password']],
            // ];
            $value = $this->{$attribute};
            foreach($rules as $rule){
                $ruleName = $rule;
                if(is_array($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULES_REQUIRED && !$value){
                    $this->addError($attribute, self::RULES_REQUIRED);
                }
                if($ruleName === self::RULES_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addError($attribute, self::RULES_EMAIL);
                }
                if($ruleName === self::RULES_MIN && strlen($value) < $rule['min']){
                    $this->addError($attribute, self::RULES_MIN, $rule);
                }
                if($ruleName === self::RULES_MAX && strlen($value) > $rule['max']){
                    $this->addError($attribute, self::RULES_MAX, $rule);
                }
                if($ruleName === self::RULES_MATCH && $value != $this->{$rule['match']}){
                    $this->addError($attribute, self::RULES_MATCH, $rule);
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, $params = []){
        $messages = $this->errorMessage()[$rule] ?? '';
        foreach($params as $key => $value){
            $messages = str_replace("{{$key}}", $value, $messages);
        }
        $this->errors[$attribute][] = $messages;
    }

    public function errorMessage(){
        return [
            self::RULES_REQUIRED => 'This field is required',
            self::RULES_EMAIL => 'Email should be valid email',
            self::RULES_MAX => 'Min length of field must be {max}',
            self::RULES_MIN => 'Min length of field must be {min}',
            self::RULES_MATCH => 'This field must be the same as {match}'
        ];
    }
}