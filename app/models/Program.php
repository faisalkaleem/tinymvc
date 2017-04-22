<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Faisal
 */
class Program extends Model {
  
  public $id;
  public $title;
  
  public $table_name = 'program';
  
  public function getTableAttributes() {
    return array(
      'id',
      'title',
    );
  }
  
}
