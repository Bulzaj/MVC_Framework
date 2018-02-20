<?php

namespace MVC\Core\Controller;

use MVC\Core\View\View;
use MVC\Core\Model\Model;
use PDO;

abstract class Controller {
    
    protected $view;
    protected $model;
    
    protected function redirect($url) {
        header('location: ' . $url);
    }
    
    public function setView($template, $data=null) {
        $this->view = new View($template, $data);
    }
    
    protected function setModel() {
        $this->model = Model::getInstance();
    }
    
    protected function renderHtml() {
        $this->view->renderHtml();
    }

    protected function query($sql) {
        $this->model->query($sql, array());
    }

    protected function fetchData($fetchStyle = PDO::FETCH_OBJ) {
        $this->model->fetchData($fetchStyle);
    }

    protected function getModelData() {
        return $this->model->getResults();
    }

    protected  function getModelCount() {
        return $this->model->getCount();
    }
    
    public static function addHtmlElement($element) {
        $path = DIR_HTML_ELEMENTS . $element . '.html.php';
        if(file_exists($path)) {
            require_once $path;
        } else {
            throw new HtmlElementException('Html Element: ' . $element . ' not Found');
        }
    }
    
    public static function setCss($css) {
        $path = DIR_CSS . $css . '.css';
        if(file_exists($path)) {
            require_once $path;
        } else {
            throw new CssException('Css file: ' . $css . ' not found');
        }
    }
    
    public static function setJs($js) {
        $path = DIR_JS . $js . '.js';
        if(file_exists($path)) {
            require_once $path;
        } else {
            throw new JSException('JS file: ' . $js . ' not found');
        }
    }
    
    public static function setImg($img) {
        $path = DIR_IMG . $img;
        if(file_exists($path)) {
            require_once $path;
        } else {
            throw new IMGException('Image: ' . $img . ' not found');
        }
    }
}
