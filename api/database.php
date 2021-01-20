<?php
class Database
{
    // database credentials
    private $host = "localhost";
    private $db_name = "cwone";
    private $username = "root";
    private $password = "";
    public $conx;
  
    // get the database connection
    public function getConnection()
    {
        $this->conx = null;
  
        try {
            $this->conx = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conx->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conx;
    }
}
