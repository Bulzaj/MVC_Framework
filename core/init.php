<?php

require_once 'App.php';
require_once 'Model.php';
require_once 'View.php';
require_once 'Controller.php';
require_once 'router/Routing.php';
require_once 'router/Router.php';
require_once 'routing_list.php';
require_once 'Controller.php';
require_once 'Model.php';
require_once 'View.php';
require_once 'config.php';

spl_autoload_register(function ($className) {
    $path = DIR_LIBS . $className . '.php';
    require_once $path;
});