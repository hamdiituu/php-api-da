<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $pdo;

    /**
     * Get the PDO instance.
     *
     * @return PDO The PDO instance.
     */
    public static function connect()
    {
        if (self::$pdo === null) {
            // Veritabanı bağlantısı ayarları
            $dsn = 'mysql:host=127.0.0.1;dbname=todo_app;charset=utf8';
            $username = 'root';
            $password = 'myrootpassword';

            try {
                self::$pdo = new PDO($dsn, $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}