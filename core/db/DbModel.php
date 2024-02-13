<?php

namespace app\core\db;
use app\core\Model;
use app\core\Application;


abstract class DbModel extends Model{

    abstract public static function tableName(): string;
    abstract public function getAttributes(): array;
    abstract public static function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->getAttributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);


        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                VALUES (".implode(',', $params).")");

        foreach($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function findOne($where){ // ['email' => 'nargis1.gasimli@gmail.com', 'firstname' => 'Nargiz']
        $tableName = static::tableName();
        $attributes = array_keys($where);
        //SELECT * FROM $tableName WHERE email = :email AND firstname = :firstname
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach($where as $key => $value){
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}