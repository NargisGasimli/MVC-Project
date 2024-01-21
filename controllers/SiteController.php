<?php

namespace app\controllers;

use app\core\Application;

class SiteController{

    public function handleContact(){
        return 'handling submitted data!';
    }

    public function contact(){
        $params = [];
        return Application::$app->router->renderView('contact', $params);
    }

    public function home(){
        $params = [
            'name' => 'Nargiz'
        ];
        return Application::$app->router->renderView('home',$params);
    }
}