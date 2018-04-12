<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Extreme_model extends CI_Model {

    var $extreme_table = array(
      'no_alias' => 'grading_criteria',
      'alias' => 'grading_criteria gcr',
      'column_display' => 'gcr.criteria_code, gcr.criteria_name, gcr.index_num, gcr.type, gcr.state, gta.target, gta.is_extreme, gta.prefix, gta.extreme_value, gta.modify_user, gta.modify_date',
      'column_search' => array('gcr.criteria_code', 'gcr.criteria_name', 'gcr.type', 'gcr.state', 'gta.prefix')
    );
    var $column_order = array('gcr.criteria_code', 'gcr.criteria_name', 'gta.prefix', 'gta.target', 'gta.is_extreme', 'gta.extreme_value');
    var $order = array('gcr.index_num' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->extreme_table['column_display'] );
      $this->db->from( $this->extreme_table['alias'] );
      $this->db->join( 'grading_target gta', 'gcr.criteria_code = gta.criteria_code', 'left' );
      
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->extreme_table['column_search'] as $item )
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
          if ( count($this->extreme_table['column_search']) - 1 == $i )
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
      $this->db->select( $this->extreme_table['column_display'] );
      $this->db->from( $this->extreme_table['alias'] );
      $this->db->join( 'grading_target gta', 'gcr.criteria_code = gta.criteria_code', 'left' );
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
      $this->db->select( $this->extreme_table['column_display'] );
      $this->db->from( $this->extreme_table['alias'] );
      $this->db->join( 'grading_target gta', 'gcr.criteria_code = gta.criteria_code', 'left' );
      $this->db->where( 'gcr.criteria_code', $id );
      $query = $this->db->get();
      return $query->row();
    }
    
    public function get_detail( $id )
    {
      $this->db->from( 'grading_target' );
      $this->db->where( 'criteria_code', $id );
      $query = $this->db->get();
      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( 'grading_target', $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( 'grading_target', $data, $where );
      return $this->db->affected_rows();
    }
}

