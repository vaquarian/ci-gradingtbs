<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_access_model extends CI_Model {
    
    var $access_table = array(
      'alias' => 'role_access roa',
      'no_alias' => 'role_access',
      'column_display' => 'rom.role_id, rom.role_name, rom.description, roa.menu_name, roa.view_permission, roa.add_permission, roa.edit_permission, roa.delete_permission'
    );
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    public function get_by_id( $id )
    {
      $this->db->select( $this->access_table['column_display'] );
      $this->db->from( $this->access_table['alias'] );
      $this->db->join( 'role_mst rom', 'roa.role_id = rom.role_id' );
      $this->db->where( 'roa.app_type', 'W' );
      $this->db->where( 'rom.role_id', $id );
      $query = $this->db->get();
      return $query->result();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->access_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
    
    public function save( $data )
    {
      $this->db->insert_batch( $this->access_table['no_alias'], $data); 
      return $this->db->insert_id();
    }
    
    public function delete_by_id( $id )
    {
      $this->db->where( 'app_type', 'W' );
      $this->db->where( 'role_id', $id );
      $this->db->delete( $this->access_table['no_alias'] );
    }
}

