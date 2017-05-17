<?php
require_once('database.php');

class DBObject {

  protected static $table_name;
  protected static $db_fields;

  public static function find_by_sql($sql="") {
    global $db;
    $result_set = $db->select($sql);
    $object_array = array();
    foreach ($result_set as $record) {

      $object_array[] = static::instantiate($record);
    }
    return $object_array;
  }

  public static function count_all() {
    global $db;
    $sql = "SELECT COUNT(*) FROM " .static::$table_name;
    $row = $db->select($sql);
    return array_shift($row[0]);
  }

  public static function find_all() {
    $objects = static::find_by_sql("SELECT * FROM " . static::$table_name);
    return $objects;
  }

  public static function find_by_id($id=0) {
    $result_set = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
    return !empty($result_set) ? array_shift($result_set) : false;
  }

  private static function instantiate($record) {
    $class = get_called_class();
    $object = new $class();
    foreach($record as $attr=>$val) {

      if ($object->has_attribute($attr)) {
        $object->$attr = $val;
      }
    }
    return $object;
  }

  private function has_attribute($attribute) {
    $object_vars = get_object_vars($this);
    return array_key_exists($attribute, $object_vars);
  }

  protected function attributes() {
    $attributes = array();
    foreach(static::$db_fields as $field) {
      if(property_exists($this, $field)) {
        $attributes[$field] = $this->$field;
      }
    }
    return $attributes;
  }

  protected function sanitized_attributes() {
    global $db;
    $clean_attributes = array();

    foreach ($this->attributes() as $key => $value) {
      if ($key != 'id') {
        $clean_attributes[$key] = $db->scrub_value($value);
      }
    }
    return $clean_attributes;
  }

  public function save() {
    return isset($this->id) ? $this->update() : $this->create();
  }

  public function create() {
    global $db;
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .=  join(", ", array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    if ($db->query($sql)) {
      $this->id = $db->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function update() {
    global $db;

    $attributes = $this->sanitized_attributes();
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE id=" . $this->id;
    $db->query($sql);
    return ($db->affected_rows() == 1) ? true : false;

  }

  public function delete() {
    global $db;
    $sql = "DELETE From " . static::$table_name . " ";
    $sql .= "WHERE id=" . $db->quote($this->id) . " ";
    $sql .= "LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() == 1) ? true : false;

  }
}
?>
