<?php
class App {
    private $routing;
    
    public function __construct() {
        $this->collection = include 'routing_list.php';
        $this->routing = new Routing;
    }
}
