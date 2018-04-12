<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_model extends CI_Model {

    var $region_table = array(
      'no_alias' => 'region_mst',
      'alias' => 'region_mst rem',
      'column_display' => 'rem.region_code, rem.region_name, rem.description, grpm.group_parent_code, grpm.group_parent_name, rem.group_code, grm.group_name',
      'column_search' => array('rem.region_code', 'rem.region_name', 'rem.description', 'grpm.group_parent_name', 'grm.group_name')
    );
    var $column_order = array('rem.region_code', 'rem.region_name', 'rem.description', 'grpm.group_parent_name', 'grm.group_name');
    var $order = array('rem.region_name' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->region_table['column_display'] );
      $this->db->from( $this->region_table['alias'] );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );      
      if ( isset($search['hierarchy_code']) && !empty($search['hierarchy_code']) )
      {
        $this->db->where( 'rem.region_code', $search['hierarchy_code'] );
      }
      if ( isset($search['parent_code']) && !empty($search['parent_code']) )
      {
        $this->db->where( 'rem.group_code', $search['parent_code'] );
      }
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->region_table['column_search'] as $item )
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
          if ( count($this->region_table['column_search']) - 1 == $i )
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
    
    public function count_all()
    {
      $this->db->select( $this->region_table['column_display'] );
      $this->db->from( $this->region_table['alias'] );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
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
      $this->db->select( $this->region_table['column_display'] );
      $this->db->from( $this->region_table['alias'] );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
      $this->db->where( 'rem.region_code', $id );
      $query = $this->db->get();

      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( $this->region_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->region_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'region_code', $id );
      $this->db->delete( $this->region_table['no_alias'] );
    }
}

