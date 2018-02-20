<?php

namespace MVC\Core\View;

class View {
    
    private $template;
    private static $staticContent = array();
    private $data = array();

    public function __construct($template, $data=null) {
        try {
            $this->setHeader();
            $this->setTemplate($template);
            $this->setStaticContent();
            $this->setFooter();
            $this->data = $data;
        } catch (Exception $ex) {
            $ex->errorMessage();
        }
    }
    
    public function setStaticContent() {
        $this->staticContent = require_once DIR_TEMPLATES . 'static_content.php';
    }
    
    public function setTemplate($template) {
        $path = DIR_TEMPLATES . $template . '.html.php';
        if(file_exists($path)) {
            $this->template = $path;
        } else {
            throw new TemplateException('Template: ' . $template . ' not found');
        }
    }

    public function renderHtml() {
        if($this->data != null) {
            extract($this->data);
        }
        require_once $this->template;
    }
            
    private function setHeader() {
        require_once DIR_TEMPLATES . 'header.html.php';
    }
    
    private function setFooter() {
         require_once DIR_TEMPLATES . 'footer.html.php';
    }
}
