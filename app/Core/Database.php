<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    /**
     * Get database connection instance (Singleton)
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = Config::get('DB_HOST', 'localhost');
            $port = Config::get('DB_PORT', '5432');
            $database = Config::get('DB_DATABASE', 'coachpro');
            $username = Config::get('DB_USERNAME', 'postgres');
            $password = Config::get('DB_PASSWORD', '');

            try {
                $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
                
                self::$instance = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Prevent unserialization
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
