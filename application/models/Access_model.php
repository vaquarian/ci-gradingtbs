<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_model extends CI_Model {

  var $access_table = 'sys_setting';
  var $column_display = 'default_password';
  
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
    
  public function get_default_password()
  {
    $query = $this->db->select( $this->column_display )->get( $this->access_table );
    $row = $query->row();
    return $row->default_password;
  }
  
  public function get_random_password( $id )
  {
    $hash_user = md5( $id );
    $hash_pass = $this->get_default_password();
    $substr_user = substr( $hash_user, 0, 5 );
    $substr_pass = substr( $hash_pass, 0, 32 );
    $final_pass = $substr_user . $substr_pass;
    return $final_pass;
  }
  
}

