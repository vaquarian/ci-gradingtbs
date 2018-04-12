<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Division_model extends CI_Model {

    var $division_table = array(
      'no_alias' => 'division_mst',
      'alias' => 'division_mst dim',
      'column_display' => 'dim.division_code, dim.division_name, dim.description, grpm.group_parent_code, grpm.group_parent_name, grm.group_code, grm.group_name, rem.region_code, rem.region_name, dim.estate_code, esm.estate_short_name, esm.estate_name, dim.mill_code, mim.mill_name',
      'column_search' => array('dim.division_code', 'dim.division_name', 'dim.description', 'grpm.group_parent_name', 'grm.group_name', 'rem.region_name', 'esm.estate_short_name', 'esm.estate_name', 'mim.mill_name')
    );
    var $column_order = array('dim.division_code', 'dim.division_name', 'dim.description', 'grpm.group_parent_name', 'grm.group_name', 'rem.region_name', 'esm.estate_short_name', 'esm.estate_name', 'mim.mill_name');
    var $order = array('dim.division_name' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->division_table['column_display'] );
      $this->db->from( $this->division_table['alias'] );
      $this->db->join( 'mill_mst mim', 'dim.mill_code = mim.mill_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      $this->db->join( 'region_mst rem', 'esm.region_code = rem.region_code' );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' ); 
      if ( isset($search['vstype']) && $search['vstype'] != 'report' ) 
      {
        $this->db->where( 'dim.mill_code', $this->session->userdata('mill_code') );
      }
      if ( isset($search['hierarchy_code']) && !empty($search['hierarchy_code']) )
      {
        $this->db->where( 'dim.division_code', $search['hierarchy_code'] );
      }
      if ( isset($search['parent_code']) && !empty($search['parent_code']) )
      {
        $this->db->where( 'dim.estate_code', $search['parent_code'] );
      }
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->division_table['column_search'] as $item )
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
          if ( count($this->division_table['column_search']) - 1 == $i )
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
      $this->db->select( $this->division_table['column_display'] );
      $this->db->from( $this->division_table['alias'] );
      $this->db->join( 'mill_mst mim', 'dim.mill_code = mim.mill_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      $this->db->join( 'region_mst rem', 'esm.region_code = rem.region_code' );
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
      $this->db->select( $this->division_table['column_display'] );
      $this->db->from( $this->division_table['alias'] );
      $this->db->join( 'mill_mst mim', 'dim.mill_code = mim.mill_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      $this->db->join( 'region_mst rem', 'esm.region_code = rem.region_code' );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
      $this->db->where( 'dim.division_code', $id );
      $query = $this->db->get();
      return $query->row();
    }
 
    public function get_detail( $division_name, $estate_code )
    {
      $this->db->from( $this->division_table['no_alias'] );
      $this->db->where( 'division_name', $division_name );
      $this->db->where( 'estate_code', $estate_code );
      $query = $this->db->get();
      return $query->row();
    }
    
    public function save( $data )
    {
      $this->db->insert( $this->division_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->division_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'division_code', $id );
      $this->db->delete( $this->division_table['no_alias'] );
    }
    
    public function get_by_mill_estate( $mill_code, $estate_code )
    {
      $this->db->from( $this->division_table['no_alias'] );
      $this->db->where( 'estate_code', $estate_code );
      $this->db->where( 'mill_code', $mill_code ); 
      $this->db->order_by( 'division_name', 'ASC' ); 
      $query = $this->db->get();
      return $query->result();
    }
}

