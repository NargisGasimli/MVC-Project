<?php

namespace app\controllers;

use Nirya\PhpMvcCore\Application;
use Nirya\PhpMvcCore\exception\ForbiddenException;
use Nirya\PhpMvcCore\middlewares\BaseMiddleWare;

class AuthMiddleWare extends BaseMiddleWare{

    public array $actions = [];

    public function __construct(array $actions = []){
        $this->actions = $actions;
    }
    public function execute()
    {
        if(Application::isGuest()){
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)){
                throw new ForbiddenException();
            }
        }
    }
}