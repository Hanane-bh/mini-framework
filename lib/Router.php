<?php

class Router{
    private $rootUrl;
    private $wwwPath;
    private $localhostPath;
    private $allUrls=[];

    private $allRoutes=  /** Define your routes for your website. Examples below **/
     [
        "/" => 
        [   "controller"=>"Home", 
            "method"=>"main", 
            "name"=>"website_home_main"
        ],

        // DISH -----------------------------------------------
        "/plats/ajouter" => 
        [   "controller"=>"Dish", 
            "method"=>"create", 
            "name"=>"website_dish_create"
        ],
        "/plats" => 
        [   "controller"=>"Dish", 
            "method"=>"showAll", 
            "name"=>"website_dish_showall"
        ],


        // USERS -----------------------------------------------
        "/user/signup"=>
        [   "controller"=>"User",
            "method"=>"create",
            "name"=>"resto_user_sign_up"
        ],

        "/user/login"=>
        [   "controller"=>"User",
            "method"=>"login",
            "name"=>"resto_user_login"
         ],

        "/user/logout"=>
        [   "controller"=>"User",
            "method"=>"logout",
            "name"=>"resto_user_logout"
         ],
        
    ];


    public function __construct(){
        $this->rootUrl=$_SERVER['SCRIPT_NAME'];
        $this->wwwPath=dirname($this->rootUrl).'/www';
        $this->localhostPath=$_SERVER['DOCUMENT_ROOT'];

        foreach ($this->allRoutes as $url => $route) {
            $this->allUrls[$route['name']]=$url;
        }
    }


    public function generateUrl($routeName){
        if(isset($this->allUrls[$routeName]))
        {
            return $this->rootUrl.$this->allUrls[$routeName];
        }
        else
        {
            throw new ErrorException("nom de la route inconnu:".$routeName);
        }
    }


    public function getRoute($requestPath){
         if(isset($this->allRoutes[$requestPath]))
         {
             return $this->allRoutes[$requestPath];
         }
         else{
             die("URL inconnue");
         }
    }


    public function getWwwPath($absolute=false){   
        if($absolute)
        {
            return $this->localhostPath.$this->wwwPath;
        }
        else
        {
            return $this->wwwPath;
        }
    }
}