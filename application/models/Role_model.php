<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

    var $role_table = array(
      'no_alias' => 'role_mst',
      'alias' => 'role_mst rom',
      'column_display' => 'rom.role_id, rom.role_name, rom.description',
      'column_search' => array('rom.role_name', 'rom.description')
    );
    var $column_order = array('rom.role_id', 'rom.role_name', 'rom.description');
    var $order = array('rom.role_name' => 'asc');
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->role_table['column_display'] );
      $this->db->from( $this->role_table['alias'] );

      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->role_table['column_search'] as $item )
        { 
          if ( $i === 0 )
          {
            $this->db->group_start();
            $this->db->like( $item, $search['value'] );
          } 
          else 
          {
            $this->db->or_like( $item, $search['value'] );
          }
          if ( count($this->role_table['column_search']) - 1 == $i )
            $this->db->group_end();
          $i++;
        }
      }
      if ( !empty($order) )
      {
        $col = 0;
        $dir = '';
        foreach( $order as $o ) {
          $col = $o['column'];
          $dir = $o['dir'];
        }
        if ( $dir != 'asc' && $dir != 'desc' ) 
          $dir = 'asc';
        if ( !isset($this->column_order[$col]) )
        {
          $this->db->order_by( key($this->order), $this->order[key($this->order)] );
        } 
        else 
        {
          $this->db->order_by( $this->column_order[$col], $dir );
        }
      }
      else if ( !empty($this->order) ) 
      {
        $this->db->order_by( key($this->order), $this->order[key($this->order)] );
      }
    }
    
    public function get_datatables( $start, $length, $order, $search )
    {
      $this->get_datatables_query( $order, $search );
      if ( $length != -1 ) {
          $this->db->limit( $length, $start );
      }
      $query = $this->db->get();
      return $query->result();
    }
    
    public function get_all()
    {
      $query = $this->db->get( $this->role_table['no_alias'] );
      return $query->result();
    }
    
    public function count_all()
    {
      $this->db->from( $this->role_table['no_alias'] );
      return $this->db->count_all_results();
    }
    
    public function count_filtered( $order, $search )
    {
      $this->get_datatables_query( $order, $search );
      $query = $this->db->get();
      return $query->num_rows();
    }
 
    public function get_by_id( $id )
    {
      $this->db->from( $this->role_table['alias'] );
      $this->db->where( 'rom.role_id', $id );
      $query = $this->db->get();

      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( $this->role_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->role_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'role_id', $id );
      $this->db->delete( $this->role_table['no_alias'] );
    }
    
    public function save_access( $data )
    {
      $this->db->insert_batch( 'role_access', $data ); 
      return $this->db->insert_id();
    }
}

