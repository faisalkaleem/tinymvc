<?php

/**
 * Description of DB
 *
 * @author Faisal
 */
class DB {
  public function insert($table_name, $data) {
    global $connection, $salt;
    // ugly fix
    if(isset($data['password'])) {
      $data['password'] = md5($salt.$data['password']);
    }
    $fields = "`".implode("`,`", array_keys($data))."`";
    $values = "'".implode("','",$data)."'";
    $sql = "INSERT INTO $table_name ($fields) "
      . "VALUES ($values)";
    
    return mysqli_query($connection, $sql);
  }
  
  public function update($table_name, $data, $id) {
    $sql = "UPDATE user SET first_name=$firstname WHERE id=$id";
  }
  
  public static function getConnection() {
//    global $connection;
    global $db_host, $db_user, $db_password, $db_name;
    $connection = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
    return $connection;
  }
}
