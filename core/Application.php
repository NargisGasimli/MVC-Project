<?php

namespace app\core;

class Application{

    public static string $ROOT_DIR;
    public Request $request;
    public Router $router;
    public Response $response;
    public static $app;
    public Controller $controller;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request;
        $this->response = new Response;
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