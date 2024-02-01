<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller{

    public function handleContact(Request $request){
        $body = $request->getBody();
        return 'handling submitted data!';
    }

    public function contact(){
        $params = [];
        return $this->render('contact', $params);
    }

    public function home(){
        $params = [
            'name' => 'Nargiz'
        ];
        return $this->render('home', $params);
    }
}