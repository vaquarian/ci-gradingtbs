<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Estate_model extends CI_Model {

    var $estate_table = array(
      'no_alias' => 'estate_mst',
      'alias' => 'estate_mst esm',
      'column_display' => 'esm.estate_code, esm.estate_short_name, esm.estate_name, esm.description, esm.type, grpm.group_parent_code, grpm.group_parent_name, grm.group_code, grm.group_name, esm.region_code, rem.region_name',
      'column_search' => array('esm.estate_short_name', 'esm.estate_name', 'esm.description', 'esm.type', 'grpm.group_parent_name', 'grm.group_name', 'rem.region_name')
    );
    var $column_order = array('esm.estate_code', 'esm.estate_short_name', 'esm.estate_name', 'esm.description', 'esm.type', 'grpm.group_parent_name', 'grm.group_name', 'rem.region_name');
    var $order = array('esm.estate_short_name' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $estate_code = $this->_get_estate();
      $this->db->select( $this->estate_table['column_display'] );
      $this->db->from( $this->estate_table['alias'] );
      $this->db->join( 'region_mst rem', 'esm.region_code = rem.region_code' );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
      if ( isset($search['vstype']) && $search['vstype'] != 'report' ) 
      {
        $this->db->where_in( 'esm.estate_code', $estate_code );
      }
      if ( isset($search['hierarchy_code']) && !empty($search['hierarchy_code']) )
      {
        $this->db->where( 'esm.estate_code', $search['hierarchy_code'] );
      }
      if ( isset($search['parent_code']) && !empty($search['parent_code']) )
      {
        $this->db->where( 'esm.region_code', $search['parent_code'] );
      }
      if ( isset($search['value']) && !empty($search['value']) )
      {
        $i = 0;
        foreach ( $this->estate_table['column_search'] as $item )
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
          if ( count($this->estate_table['column_search']) - 1 == $i )
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
      $estate_code = $this->_get_estate();
	
      $this->db->select( $this->estate_table['column_display'] );
      $this->db->from( $this->estate_table['alias'] );
      $this->db->join( 'region_mst rem', 'esm.region_code = rem.region_code' );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
      $this->db->where_in( 'esm.estate_code', $estate_code );
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
      $this->db->select( $this->estate_table['column_display'] );
      $this->db->from( $this->estate_table['alias'] );
      $this->db->join( 'region_mst rem', 'esm.region_code = rem.region_code' );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
      $this->db->where( 'esm.estate_code', $id );
      $query = $this->db->get();
      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( $this->estate_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->estate_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'estate_code', $id );
      $this->db->delete( $this->estate_table['no_alias'] );
    }

    private function _get_estate()
    {
      $codes = array();
      $this->db->select( 'dim.estate_code' );
      $this->db->from( 'division_mst dim' );
      $this->db->where( 'dim.mill_code', $this->session->userdata('mill_code') );
      $query = $this->db->get();
      foreach ( $query->result() as $division ) {        
        $codes[] = $division->estate_code;
      }
      return $codes;
    }	
}

