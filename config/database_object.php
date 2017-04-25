<?php
class DatabaseObject {
  // when calling this function and specifying $ord and $dir, you must also specify $x and $y as empty strings
  // if nothing is specified, function returns all records by default order
  // if specifying any variable passed to this function, it must be all or none
  public function table_attributes() {
    return static::find_by_sql("SHOW COLUMNS FROM ".static::$table_name);
  }
  
  //many
  public static function find_all($ord="id", $dir="ASC") {
    return static::find_by_sql("SELECT * FROM ".static::$table_name." ORDER BY ".$ord." ".$dir);
  }
  
  public static function find_all_visible($ord="id", $dir="DESC") {
    $query = "SELECT * FROM ".static::$table_name." WHERE is_disp = 1 ORDER BY ".$ord." ".$dir;
    return static::find_by_sql($query);
  }

  //many
  public static function find_all_l($ord="id", $dir="ASC", $l=1) {
    return static::find_by_sql("SELECT * FROM ".static::$table_name." ORDER BY ".$ord." ".$dir." LIMIT ".$l);
  }
  
  //many
  public static function find($wh="id", $eq="1", $ord="id", $dir="ASC") {
    return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ".$wh." = ".$eq." ORDER BY ".$ord." ".$dir);
  }
  
  //many
  public static function find_all_producers() {
    return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE category_id = 2 ORDER BY name ASC");
  }
  
  //many
  public static function find_and($wh="id", $eq="1", $and="name", $aeq="1", $ord="id", $dir="ASC") {
    return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ".$wh." = ".$eq." AND ".$and." = ".$aeq." ORDER BY ".$ord." ".$dir);
  }
  
  //score sorted by main_value
  public static function find_all_mv($wh, $eq) {
    return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ".$wh." = ".$eq." ORDER BY cast(main_value as SIGNED) DESC");
  }


  //many with limit (default 1)
  public static function find_l($wh="id", $eq=1, $lim=1) {
    return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ".$wh." = '".$eq."' LIMIT ".$lim);
  }
  
  //one
  public static function find_by_id($id=1) {
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id=".$id." LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function find_admin_user_by_id($id=1) {
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE type_id=1 AND id=".$id." LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  //one
  public static function find_by_other($wh="id", $id=1) {
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ".$wh."=".$id." LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  //one
  public static function find_by_other_and($wh="id", $eq=1, $and="id", $aeq=1) {
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE ".$wh."=".$eq." AND ".$and." = ".$aeq." LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
  
  // used for pagination
  public static function count_all() {
    global $database;
    $sql  = "SELECT COUNT(*) FROM ".static::$table_name;
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    return array_shift($row);
  }
  
  private static function instantiate($record) {
    // Could check that $record exists and is an array
    $class_name = get_called_class();
    $object = new $class_name;
    foreach($record as $attribute=>$value) {
      if($object->has_attribute($attribute)) {
        $object->$attribute = $value;
      }
    }
    return $object;
  }
  
  private function has_attribute($attribute) {
    // We don't care about the value, we just want to know if the key exists
    // Will return true or false
    return array_key_exists($attribute, $this->attributes());
  }
  
  protected function attributes() {
    // return an array of attribute names and their values
    $attributes = array();
    foreach(static::$db_fields as $field) {
      if(property_exists($this, $field)) {
        $attributes[$field] = $this->$field;
      }
    }
    return $attributes;
  }
  
  protected function sanitized_attributes() {
    global $database;
    $clean_attributes = array();
    // sanitize the values before submitting
    // Note: does not alter the actual value of each attribute
    foreach($this->attributes() as $key => $value) {
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }
  
  public function save() {
    // A new record won't have an id yet.
    return isset($this->id) ? $this->update() : $this->create();
  }
  
  public function create() {
    global $database;
    // Don't forget your SQL syntax and good habits:
    // - INSERT INTO table (key, key) VALUES ('value', 'value')
    // - single-quotes around all values
    // - escape all values to prevent SQL injection
    $attributes = $this->sanitized_attributes();
    $sql  = "INSERT INTO ".static::$table_name." (";
    $sql .= join(", ", array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    if($database->query($sql)) {
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function list_fields() {
    global $database;
    $attribute = array();
    foreach($this->attributes() as $key => $value) {
      $attributes[$key] = $value;
    }
    return $attributes;
  }
  
  //resets all changelog is_current to 0
  public function update_changelog_current() {
    global $database;
    $sql  = "UPDATE changelog SET is_current = 0 WHERE is_current = 1";
    $database->query($sql);
  }

  //changed a single record in the user's profile to set it as 'active' to prevent multiple activation attempts and if a user tries to login before activating. Other future uses
  public function activate_user() {
    global $database;
    $sql  = "UPDATE user SET is_active = 1 WHERE id = ";
    $sql .= $database->escape_value($this->id);
    $database->query($sql);
  }

  public function update() {
    global $database;
    // Don't forget your SQL syntax and good habits
    // - UPDATE table SET key='value', Key='value' WHERE condition
    // - single-quotes around all values
    // - escape all values to prevent SQL injection
    $attributes = $this->sanitized_attributes();
    $attribute_pairs = array();
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }
    $sql  = "UPDATE ".static::$table_name." SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE id=".$database->escape_value($this->id);
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
    $session->message = "Updated Successfully";
    return $session->message;
  }
  
  public function delete() {
    global $database;
    // Don't forget your SQL syntax and good habits
    // DELTE FROM talbe WHERE condition LIMIT 1
    // escape all values to prevent SQL injection
    // use LIMIT 1
    $sql  = "DELETE FROM ".static::$table_name;
    $sql .= " WHERE id=".$database->escape_value($this->id);
    $sql .= " LIMIT 1";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

}
?>