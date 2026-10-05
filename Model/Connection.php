<?php

namespace Model;

use PDO;
use PDOException;

require_once __DIR__ . "/../Config/Configuration.php";

class Conncetion {
    private static $stmt;

    public static function getInstance(): PDO 
    {
        if (empty(self::$stmt)) {
            try {
                self::$stmt = new PDO('mysql :holst='. DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . '' , DB_USER, DB_PASSWORD, [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERROMODE_EXCEPTION,
                    
                ]);
            }
        }
    }
}