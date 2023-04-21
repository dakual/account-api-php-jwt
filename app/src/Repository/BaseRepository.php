<?php
namespace App\Repository;

use \PDO;

abstract class BaseRepository
{
  private $host   = '192.168.1.100';
  private $user   = 'root';
  private $pass   = 'root';
  private $dbname = 'test';

  public function __construct()
  {
    $connection_str = "mysql:host={$this->host};dbname={$this->dbname}";
    $this->database = new PDO($connection_str, $this->user, $this->pass);
    $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  protected function getDb(): PDO
  {
      return $this->database;
  }
}