<?php

namespace app\core;

abstract class Model{

    public const RULES_REQUIRED = 'required';
    public const RULES_EMAIL = 'email';
    public const RULES_MIN = 'min';
    public const RULES_MAX = 'max';
    public const RULES_MATCH = 'match';
    public const RULES_UNIQUE = 'unique';

    public function loadData($data){
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules();

    public array $errors = [];

    public function label(): array
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->label()[$attribute] ?? $attribute;
    }

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
                    $this->addErrorForRule($attribute, self::RULES_REQUIRED);
                }
                if($ruleName === self::RULES_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute, self::RULES_EMAIL);
                }
                if($ruleName === self::RULES_MIN && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute, self::RULES_MIN, $rule);
                }
                if($ruleName === self::RULES_MAX && strlen($value) > $rule['max']){
                    $this->addErrorForRule($attribute, self::RULES_MAX, $rule);
                }
                if($ruleName === self::RULES_MATCH && $value != $this->{$rule['match']}){
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULES_MATCH, $rule);
                }
                if($ruleName === self::RULES_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Database::prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue("attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record){
                        $this->addErrorForRule($attribute, self::RULES_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }   
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = []){
        $messages = $this->errorMessage()[$rule] ?? '';
        foreach($params as $key => $value){
            $messages = str_replace("{{$key}}", $value, $messages);
        }
        $this->errors[$attribute][] = $messages;
    }

    public function addError(string $attribute, string $message){
        $this->errors[$attribute][] = $message;
    }

    public function errorMessage(){
        return [
            self::RULES_REQUIRED => 'This field is required',
            self::RULES_EMAIL => 'Email should be valid email',
            self::RULES_MAX => 'Min length of field must be {max}',
            self::RULES_MIN => 'Min length of field must be {min}',
            self::RULES_MATCH => 'This field must be the same as {match}',
            self::RULES_UNIQUE => 'Record for this {field} already exist'
        ];
    }

    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }
    public function firstErrorMessage($attribute){
        return $this->errors[$attribute][0] ?? false;
    }
}