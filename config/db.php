<?php
class DB {
  private $port = 3306;
  private $serverName = "localhost";
  private $dbUsername = 'root';
  private $dbPassword = '';
  private $dbName = "quizzy";

  protected function connect(){
      $mysql = "mysql:host=$this->serverName;port=$this->port;dbname=$this->dbName";

      $pdo = new PDO($mysql, $this->dbUsername, $this->dbPassword);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      return $pdo;
  }

}