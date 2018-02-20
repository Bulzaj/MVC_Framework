<?php

class Router {
    
    private $url;
    private $controller;
    private $method;
    private $paramsType = array();
    private $defaultParams = array();
    
    public function __construct(String $url, String $controller, String $method, Array $paramsType = null, Array $defaultParams = null) {
        $this->url = $url;
        $this->controller = $controller;
        $this->method = $method;
        $this->paramsType = $paramsType;
        $this->defaultParams = $defaultParams;
    }
    
    public function getUrl() {
        return $this->url;
    }
        
    public function getController() {
        return $this->controller;
    }
    
    public function getMethod() {
        return $this->method;
    }
    
    public function getParamsType() {
        return $this->paramsType;
    }
    
    public function  getDefaultParams() {
        return $this->defaultParams;
    }
}