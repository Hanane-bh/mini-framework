<?php

class Kernel{

    private $viewData = [];

    public function loadClass($class){

        if(substr($class,-10)=='Controller')
        {
            $fileName='app/controllers/'.$class.'.php';
        }
        elseif(substr($class,-5)=="Model")
        {
            $fileName="app/models/".$class.'.php';
        }
        else
        {
            $fileName="app/class/".$class.'.php';
        }

        if(file_exists($fileName))
        {
            include $fileName;
        }
        else
        {
            die('impossible de charger la classe');
        }
    }

    public function bootstrap()
    {
        spl_autoload_register([$this,"loadClass"]);
    }


    public function run(){

        if(isset($_SERVER['PATH_INFO'])){
            $requestPath=$_SERVER['PATH_INFO'];
        }
        else{
            $requestPath='/';
        }
        
        $router= new Router();
        $this->viewData["router"]=$router;
        $requestRoute=$router->getRoute($requestPath);

        $controllerName=$requestRoute["controller"]."Controller";
        $methodName=$requestRoute["method"];

        $controller= new $controllerName($router);

        if(method_exists($controller, $methodName)){
            $this->viewData = array_merge(  
                                            $this->viewData,
                                            (array)$controller->$methodName()   
                                        );
            $this->renderResponse();
        }
        else {
            die("method".$methodName."inconnue");
        }
        
    }

    public function renderResponse(){
        extract($this->viewData, EXTR_OVERWRITE);

        if(isset($template)){
            $flashbag=new Flashbag();

            $templatePath ='www/views';
            $templatePath.='/'.$template['folder'];
            $templatePath.='/'.$template['file'];
            $templatePath.='View.phtml';
 
            include "www/views/layout.phtml";
        }
        elseif(isset($redirect))
        {
            header('Location:'.$router->generateUrl($redirect));
            exit();
        }

    }
    
}