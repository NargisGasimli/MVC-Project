<?php

namespace app\core;
class View{

    public string $title = '';
    public function renderView($view, $params){
        $renderOnlyView = $this->renderOnlyView($view, $params);
        $leyoutContent = $this->layoutContent();
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