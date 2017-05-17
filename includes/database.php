<?php
require_once("config.php");

class MySQLDatabase {

  protected static $connection;
  public $last_query;

  function __constuct() {
    $this -> connect();
  }

  public function connect() {
    if(!isset(self::$connection)) {
      self::$connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    }

    if(self::$connection === false) {
      // Handle Error Here
      return false;
    }

    return self::$connection;
  }

  public function query($query) {
    $this->last_query = $query;
    $connection = $this -> connect();
    $result = $connection -> query($query);
    return $result;
  }

  public function select($query) {
    $rows = array();
    $result = $this -> query($query);
    if($result === false) {
      return false;
    }
    while ($row = $result -> fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }

  public function num_rows($result_set) {
    return mysqli_num_rows($result_set);
  }

  public function insert_id() {
    $connection = $this->connect();
    return $connection -> insert_id;
  }

  public function affected_rows() {
    $connection = $this->connect();
    return $connection -> affected_rows;
  }

  public function error() {
    $connection = $this->connect();
    return $connection -> error();
  }

  public function quote($value) {
    return "'" . $this->scrub_value($value) . "'";
  }

  public function scrub_value($value) {
    $connection = $this -> connect();
    $value = strip_tags($value);
    return $connection -> real_escape_string($value);
  }

  public function close() {
    if (isset(self::$connection)) {
      mysqli_close(self::$connection);
      unset(self::$connection);
    }
  }

 }

$db = new MySQLDatabase();

?>
