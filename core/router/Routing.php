<?php
class Routing {

    private $url;
    private $urlArray;
    private $routingListUrlArray;
    private $collection;
    private $controller;
    private $method;
    private $paramsType = array();
    private $defaultParams = array();
    private $paramsArray = array();
    private $className;
    private $catalogName;
    private $controllerObject;
    private $errors = array();

    public function __construct() {
        $this->url = $_GET['url'];
        $this->collection = include DIR_CORE.'routing_list.php';
        $this->match();
        $this->className = explode('/', $this->controller);
        $this->catalogName = $this->className[0];
        $this->className = ucfirst($this->className[1]);
//        echo "Controller: " . $this->controller . "<br>";
//        echo "Method: " . $this->method . "<br>";
//        echo "Params: "; print_r($this->paramsArray); echo '<br>';
//        echo "Default params: "; print_r($this->defaultParams); echo "<br>";
        $this->route();
    }

    private function match() {
        $this->urlArray = explode('/', $this->url);
        if($this->url == null) {
            $this->controller = 'home/homeController';
            $this->method = 'index';
        } else {
            if(count($this->urlArray)>1) {
                foreach($this->collection as $router) {
                    $this->routingListUrlArray = explode('/', $router->getUrl());
                    if($this->routingListUrlArray[0] == $this->urlArray[0] &&
                       $this->routingListUrlArray[1] == $this->urlArray[1]) { 
                        $this->controller = $router->getController();
                        $this->method = $router->getMethod();
                        $this->paramsType = $router->getParamsType();
                        $this->defaultParams = $router->getDefaultParams();
                        if(count($this->urlArray)-2 == count($this->paramsType)) {
                            for($i=2; $i<count($this->urlArray); $i++) {
                                switch(true) {
                                    case is_numeric($this->urlArray[$i]) :
                                       if($this->paramsType[$i-2] == 'integer') {
                                           $this->paramsArray[$i-2] = $this->urlArray[$i];
                                       } else {
                                           array_push($this->errors, 'Param: ' . $this->urlArray[$i] . ', schould be a string');
                                       }
                                       break;
                                    case is_string($this->urlArray[$i]) : 
                                        if($this->paramsType[$i-2] == 'string') {
                                            $this->paramsArray[$i-2] = $this->urlArray[$i];
                                        } else {
                                            array_push($this->errors, 'Param: ' . $this->urlArray[$i] . ', schould be an integer');
                                        }
                                        break;
                                }
                            }
                        } else {
                            array_push($this->errors, 'Params does not match to the pattern');
                        }
                    }
                }
            } else {
                foreach($this->collection as $router) {
                    $routerUrl = $router->getUrl();
                    $routerUrlArray = explode('/', $routerUrl);
                    if($routerUrlArray[0] == $this->urlArray[0]) {
                        $this->controller = $router->getController();
                        $this->method = 'index';
                    }
                }
            }
        }
       
    }

    private function route() {
        if(file_exists(DIR_CONTROLLERS . $this->controller . '.php')) {
            require_once DIR_CONTROLLERS . $this->controller . '.php';
            $this->controllerObject = new $this->className();
            if(method_exists($this->controllerObject, $this->method)) {
                if(count($this->errors) == null) {
                    call_user_func(array($this->controllerObject, $this->method), extract($this->paramsArray));
                } else {
                    foreach($this->errors as $error) {
                        echo $error . '<br>';
                    }
                }
            } else {
                echo "Method: " . $this->method . " does not exists";
            }
        } else {
            echo 'controller: '. $this->controller . ' does not exists';
        }
    }
}
