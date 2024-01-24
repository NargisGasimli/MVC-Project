<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;

class AuthController extends Controller{

    public function login(Request $request){
        $this->setLayout('auth');
        return $this->render('login', $params = []);
    }

    public function register(Request $request){
        if($request -> isPost()){
            // var_dump("<pre>");
            // var_dump($_POST);
            // exit;
            return 'Handling submitted data';
        }
        $this->setLayout('auth');
        return $this->render('register', $params = []);
    }
}