<?php
require_once('database.php');

class User extends DBObject{

  protected static $table_name = "users";
  protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name');
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;

  public function __toString() {
    $name = $this->full_name();
    $string = "User Id: " . $this->id . " Named: " . $name;
    return $string;
  }

  public function full_name() {
    if (isset($this->first_name) && isset($this->last_name)) {
      return $this->first_name . " " . $this->last_name;
    } else {
      return "";
    }
  }

  public static function authenticate($username="", $password="") {
    global $db;
    $username = $db -> quote($username);
    $password = $db -> quote($password);


    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username = {$username} ";
    $sql .= "AND password = {$password} ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function authenticate_with_hash($username="", $email="", $password="") {
    global $db;
    $username = $db -> quote($username);
    $email = $db->quote($email);

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username = {$username} ";
    $sql .= "AND email = {$email} ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
    if (!empty($result_array)) {
      $user = array_shift($result_array);
      if (password_verify($password, $user['password'])) {
        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }


  public static function create_user($username="", $password="", $first_name="", $last_name="") {
    if (isset($username) && isset($password) && isset($first_name) && isset($last_name)) {
      global $db;
      $pass_hash = password_hash($password);
      $first_name = $db->quote($first_name);
      $last_name = $db->quote($last_name);

      $sql = "INSERT INTO " . self::$table_name . " ";
      $sql .= "(username, password, first_name, last_name) VALUES ";
      $sql .= "({$db->quote($username)}, '{$pass_hash}', {$first_name}, {$last_name})";

      $result = $db->query($sql);

      if ($result) {
        return self::authenticate_with_hash($username, $pass_hash);

      } else {
        return false;
      }

    } else {
      return false;
    }

  }




}

?>
