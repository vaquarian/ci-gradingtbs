<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Mill_model extends CI_Model {

    var $mill_table = array(
      'no_alias' => 'mill_mst',
      'alias' => 'mill_mst mim',
      'column_display' => 'mim.mill_code, mim.mill_name, mim.description',
      'column_search' => array('mim.mill_code', 'mim.mill_name', 'mim.description')
    );
    var $column_order = array('mim.mill_code', 'mim.mill_name', 'mim.description');
    var $order = array('mim.mill_name' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->mill_table['column_display'] );
      $this->db->from( $this->mill_table['alias'] );
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->mill_table['column_search'] as $item )
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
          if ( count($this->mill_table['column_search']) - 1 == $i )
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
      $this->db->from( $this->mill_table['alias'] );
      $this->db->order_by( key($this->order), $this->order[key($this->order)] );
      $query = $this->db->get();
      return $query->result();
    }
    
    public function count_all()
    {
      $this->db->from( $this->mill_table['no_alias'] );
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
      $this->db->from( $this->mill_table['alias'] );
      $this->db->where( 'mim.mill_code', $id );
      $query = $this->db->get();

      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( $this->mill_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->mill_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'mill_code', $id );
      $this->db->delete( $this->mill_table['no_alias'] );
    }
}

