<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model {

    var $log_table = array(
      'no_alias' => 'audit_log',
      'alias' => 'audit_log aul',
      'column_display' => "aul.id, aul.module, aul.action, aul.info, aul.create_user, DATE_FORMAT(aul.create_date, '%d-%m-%Y %H:%i:%s') as create_date",
      'column_search' => array('aul.module', 'aul.action', 'aul.info', 'aul.create_user', 'aul.create_date')
    );
    var $column_order = array('aul.id', 'aul.module', 'aul.action', 'aul.info', 'aul.create_user', 'aul.create_date');
    var $order = array('aul.id' => 'desc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->log_table['column_display'] );
      $this->db->from( $this->log_table['alias'] );
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->log_table['column_search'] as $item )
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
          if ( count($this->log_table['column_search']) - 1 == $i )
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
      $this->db->from( $this->log_table['no_alias'] );
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
      $this->db->from( $this->log_table['alias'] );
      $this->db->where( 'id', $id );
      $query = $this->db->get();

      return $query->row();
    }
}

