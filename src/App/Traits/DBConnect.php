<?php

namespace App\Traits;

use PDO;
use PDOException;
use Exception;

trait DBConnect {
  protected static $db;

  /**
   * Initialize the PDO connection.
   *
   * @return void
   * @throws \Exception if the connection fails.
   */
  static function connect(): void {
    $dsn = 'mysql:host=localhost;dbname=notes';
    $username = 'nishat';
    $password = '1234';

    try {
      self::$db = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
    } catch (PDOException $e) {
      throw new Exception("Database connection failed: " . $e->getMessage());
    }
  }

  /**
   * Get the PDO instance.
   *
   * @return PDO The PDO instance.
   */
  protected static function getDb(): PDO {
    return self::$db;
  }
}
