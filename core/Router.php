<?php

namespace app\core;
use app\core\exception\NotFoundException;

class Router{

    protected array $routes = [];
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback){
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback){
        $this->routes['post'][$path] = $callback;
    }
    
    public function resolve(){
        $params = [];
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            throw new NotFoundException();

        }
        if(is_string($callback)){
            return $this->renderView($callback, $params);
        }
  
        if (is_array($callback)) {
            /**
             * @var \app\core\Controller $controller
             */


            $controller = new $callback[0];
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->middlewares as $middleware) {
                $middleware->execute();
            }
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);

    }

    public function renderView($view, $params){
        $leyoutContent = $this->layoutContent();
        $renderOnlyView = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $renderOnlyView, $leyoutContent);
        include_once Application::$ROOT_DIR."/views/$view.php";
    }
    
    public function layoutContent(){
        $layout = Application::$app->layout;
        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }
    public function renderOnlyView($view, $params){
        foreach($params as $key =>$value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

}