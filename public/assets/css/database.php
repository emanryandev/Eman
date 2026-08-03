<?php
namespace App\Config;

use MongoDB\Client;

class Database {
    private static $db = null;

    public static function getConnection() {
        if (self::$db === null) {
            $uri = $_ENV['MONGODB_URI'] ?? 'mongodb://127.0.0.1:27017';
            $dbName = $_ENV['DB_NAME'] ?? 'cloud_portfolio';
            
            $client = new Client($uri);
            self::$db = $client->$dbName;
        }
        return self::$db;
    }
}