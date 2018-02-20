<?php

namespace MVC\Core\Model;
use PDO;

 class Model {
   
    private static $instance = null;
    private $pdo;
    private $results;
    private $count = 0;
    private $dsn;
    private $user;
    private $password;
    
    private function __construct() {
        $this->dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;
        $this->user = DB_USERNAME;
        $this->password = DB_PASSWORD;
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new Model();
        }
        return self::$instance;
    }
    
    public function getResults() {
        return $this->results;
    }

    public function getCount() {
        return $this->count;
    }
    
    public function query($sql, $params) {
        $this->query = $this->pdo->prepare($sql);
        $this->query->execute($params);
        $this->count = $this->query->rowCount();
        return $this;
    }

    public function fetchData($fetchStyle = PDO::FETCH_KEY_PAIR) {
        $this->results = $this->query->fetchAll($fetchStyle);
    }
}
