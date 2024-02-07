<?php

namespace app\core;

use app\core\Session;

class Application{
    public string $userClass;
    public static string $ROOT_DIR;
    public Request $request;
    public Router $router;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?DbModel $user;
    public static $app;
    public Controller $controller;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request;
        $this->session = new Session;
        $this->response = new Response;
        $this->db = new Database($config['db']);
        $this->router = new Router($this->request, $this->response);

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }else{
            $this->user = Null;
        }
    }

    public function run(){
        echo $this->router->resolve();
    }

    public function getController(){
        return $this->controller;
    }

    public function setController($controller):void{
        $this->controller = $controller;
    }

    public function login(DbModel $user){
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout(){
        $this->user = Null;
        $this->session->remove('user');
    }

    public static function isGuest(){
        return !self::$app->user;
    }
}