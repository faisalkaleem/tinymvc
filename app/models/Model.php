<?php
/**
 * Description of Model
 *
 * @author Faisal
 */
abstract class Model {
  
  public $id;
  public $connection;
  public $date_modified;
  public $date_created;
  
  public $has_timestamps = true;
  public $date_created_field = 'date_created';
  public $date_modified_field = 'date_modified';
  
  public $sql_condition = array();
  
  public $sort = array();
  

  public function __construct() {
    $this->connection = DB::getConnection();
  }
  
  public function __wakeup() {
    $this->connection = DB::getConnection();
  }
  
  public function find($id) {
    $sql = "SELECT * FROM {$this->table_name} WHERE id=$id LIMIT 1";
    $result_set = mysqli_query($this->connection, $sql);
    $record = mysqli_fetch_assoc($result_set);
    $attributes  = $this->getTableAttributes();
    $class_name = get_class($this);
    
    $row = new $class_name;
    foreach($attributes as $attribute) {
      $row->{$attribute} = $record[$attribute];
    }
    return $row;
  }
  
  public function findByAttributes($attributes, $index=null) {
    foreach($attributes as $attribute => $value) {
      $condition[] = $attribute.'='.$value;
    }
    $condition = implode(' AND ', $condition);
    $sql = "SELECT * FROM {$this->table_name} WHERE {$condition}";
    
    $attributes  = $this->getTableAttributes();
    $result_set = mysqli_query($this->connection, $sql);
    if(!$result_set) {
      echo mysqli_error($this->connection);
      exit;
    }
    $class_name = get_class($this);
    $records = array();
    
    while(($record = mysqli_fetch_assoc($result_set))) {
      $row = new $class_name;
      foreach($attributes as $attribute) {
        $row->{$attribute} = $record[$attribute];
      }
      if($index) {
        $records[$row->{$index}] = $row;
      } else {
        $records[] = $row;
      }
    }
      
    return $records;
  }
  
  /**
   * Returns all the table records
   * @return array Array of records. Empty array if nothing found.
   */
  public function findAll($limit="") {
    if($limit!=null) {
      $limit = " LIMIT ".$limit;
    }
    $sql = "SELECT * FROM {$this->table_name}";
    $condition = $this->getConditions();
    
    if($condition!='') {
      $sql .= " WHERE ".$condition;
    }
    $sql .= $this->getSort();
    $sql = $sql . $limit;
    $result_set = mysqli_query($this->connection, $sql);
    $records = array();
    $attributes  = $this->getTableAttributes();
    while(($record=  mysqli_fetch_assoc($result_set))) {
      $class_name = get_class($this);
      $row = new $class_name;
      foreach($attributes as $attribute) {
        $row->{$attribute} = $record[$attribute];
      }
      $records[] = $row;
    }
    return $records;
  }
  
  public function getSort() {
    $sort = '';
    if($this->sort!==array()) {
      $sort_fields = array();
      foreach($this->sort as $key => $order) {
        $sort_fields[] = $key. ' '.$order;
      }
      $sort = ' ORDER BY '.implode(', ', $sort_fields);
    }
    return $sort;
  }
  
  public function insert() {
    $attributes = $this->getTableAttributes();
    unset($attributes['id']);
    $set_attributes = array();
    if($this->has_timestamps) {
      $datetime = date('Y-m-d H:i:s');
      $set_attributes[] = $this->date_modified_field."='".$datetime."'";
      $set_attributes[] = $this->date_created_field."='".$datetime."'";
    }
    $fields = array();
    $field_values = array();
    foreach($attributes as $attribute) {
      $fields[] = $attribute;
      $field_values[] = $this->{$attribute};
    }
    $fields = "`".implode("`,`", $fields)."`";
    $values = "'".implode("','",$field_values)."'";
    $sql = "INSERT INTO {$this->table_name} ($fields) "
      . "VALUES ($values)";
    return mysqli_query($this->connection, $sql);
  }
  
  public function update() {
    $attributes = $this->getTableAttributes();
    $set_attributes = array();
    foreach($attributes as $attribute) {
      $set_attributes[] = $attribute."='".$this->{$attribute}."'";
    }
    if($this->has_timestamps) {
      $set_attributes[] = $this->date_modified_field."='".date('Y-m-d H:i:s')."'";
    }
    
    
    $update_sql = "UPDATE {$this->table_name} SET ".
      implode(',', $set_attributes)
    . "WHERE id=" . $this->id;
    return mysqli_query($this->connection, $update_sql);
  }
  
  public function setAttributes() {
    $attributes  = $this->getTableAttributes();
    foreach($attributes as $attribute) {
      $this->{$attribute}  = isset($_POST[$attribute])?$_POST[$attribute]:null;
    }
  }
  
  public function count($count_field = 'id') {
    $sql = "SELECT COUNT(".$count_field.") as rows FROM {$this->table_name}";
    if($this->sql_condition!=array()) {
      $sql .= ' WHERE '.$this->getConditions();
    }
    $result = mysqli_query($this->connection, $sql);
    $count = mysqli_fetch_assoc($result);
    return $count['rows'];
  }
  
  public function deleteByAttributes($attributes) {
    $condition = array();
    foreach($attributes as $attribute => $value) {
      $condition[] = $attribute.'='.$value;
    }
    $condition = implode(' AND ', $condition);
    $sql = "DELETE FROM {$this->table_name} WHERE {$condition}";
    return mysqli_query($this->connection, $sql);
  }
  
  public function getConditions() {
    $condition = array();
    $condition_string = '';
    if(!empty($this->sql_condition)) {
      foreach($this->sql_condition as $attribute => $value) {
        $value = trim($value);
        if($value!="") {
          $condition[] = "`".$attribute.'` LIKE "%'.mysqli_real_escape_string($this->connection, $value).'%"';
        }
      }
    }
      
    if(!empty($condition)) {
      $condition_string = implode(' AND ', $condition);
    }
    return $condition_string;
  }
  
  public function queryAll($sql) {
    $result_set = mysqli_query($this->connection, $sql);
    $records = array();
    while(($record=  mysqli_fetch_assoc($result_set))) {
      $records[] = $record;
    }
    return $records;
  }
  
  abstract public function getTableAttributes();
  
}
