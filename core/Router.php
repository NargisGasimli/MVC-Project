<?php

namespace app\core;

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
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            $this->response->ResponseCode(404);
            $params = [];
            return $this->renderView('_404', $params);

        }
        if(is_string($callback)){
            $params = [];
            return $this->renderView($callback, $params);
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }
        return call_user_func($callback);
        // return call_user_func($callback);
        // var_dump("<pre>");
        // var_dump($callback);
        // exit;

    }

    public function renderView($view, $params){
     
        $leyoutContent = $this->layoutContent();
        $renderOnlyView = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $renderOnlyView, $leyoutContent);
        include_once Application::$ROOT_DIR."/views/$view.php";
    }
    
    public function layoutContent(){
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
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