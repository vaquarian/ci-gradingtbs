<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model {

    var $group_table = array(
      'no_alias' => 'group_mst',
      'alias' => 'group_mst grm',
      'column_display' => 'grm.group_code, grm.group_name, grm.description, grpm.group_parent_code, grpm.group_parent_name',
      'column_search' => array('grm.group_code', 'grm.group_name', 'grm.description', 'grpm.group_parent_name')
    );
    var $column_order = array('grm.group_code', 'grm.group_name', 'grm.description', 'grpm.group_parent_name');
    var $order = array('grm.group_name' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->group_table['column_display'] );
      $this->db->from( $this->group_table['alias'] );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );      
      if ( isset($search['hierarchy_code']) && !empty($search['hierarchy_code']) )
      {
        $this->db->where( 'grm.group_code', $search['hierarchy_code'] );
      }
      if ( isset($search['parent_code']) && !empty($search['parent_code']) )
      {
        $this->db->where( 'grm.group_parent_code', $search['parent_code'] );
      }
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->group_table['column_search'] as $item )
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
          if ( count($this->group_table['column_search']) - 1 == $i )
            $this->db->group_end();
          $i++;
        }
      }
      if ( !empty($order) )
      {
        $col = 0;
        $dir = '';
        foreach( $order as $o ) 
        {
          $col = $o['column'];
          $dir = $o['dir'];
        }
        if ( $dir != 'asc' && $dir != 'desc' ) $dir = 'asc';
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
    
    public function count_all()
    {
      $this->db->select( $this->group_table['column_display'] );
      $this->db->from( $this->group_table['alias'] );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
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
      $this->db->select( $this->group_table['column_display'] );
      $this->db->from( $this->group_table['alias'] );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
      $this->db->where( 'grm.group_code', $id );
      $query = $this->db->get();
      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( $this->group_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->group_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'group_code', $id );
      $this->db->delete( $this->group_table['no_alias'] );
    }
}

