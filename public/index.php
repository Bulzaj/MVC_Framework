<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once '../core/init.php';
$app = new App;
