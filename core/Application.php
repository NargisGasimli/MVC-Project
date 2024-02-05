<?php

namespace app\core;

use app\core\Session;

class Application{

    public static string $ROOT_DIR;
    public Request $request;
    public Router $router;
    public Response $response;
    public Session $session;
    public Database $db;
    public static $app;
    public Controller $controller;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request;
        $this->session = new Session;
        $this->response = new Response;
        $this->db = new Database($config['db']);
        $this->router = new Router($this->request, $this->response);
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
}