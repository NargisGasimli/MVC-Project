<?php

namespace app\core\form;

use app\core\form\Field;
use app\core\Model;

class Form{
    public static function begin($url, $method){
        echo sprintf('<form action = "%s" method = "%s">', $url, $method);
        return new Form();
    }

    public static function end(){
        echo '</form>';
    }

    public static function field(Model $model, $attribute){
        return new InputField($model, $attribute);
    }
}