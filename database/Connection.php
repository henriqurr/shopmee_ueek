<?php

abstract class Connection {
    
    #Database connection
    protected function connect() {
        try {
            $database = new PDO("mysql:host=localhost; dbname=shopmee", "root", "");
            return $database;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}

?>