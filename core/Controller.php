<?php

namespace app\core;

use app\core\middlewares\BaseMiddleWare;

Class Controller{
/**
 * @var \app\core\middlewares\BaseMiddleWares[]
 */
    public array $middlewares = [];
    public $layout = 'main';
    public string $action = '';

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function render($view, $params = []){
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleWare(BaseMiddleWare $middleWare){
        $this->middlewares[] = $middleWare;
    }
}