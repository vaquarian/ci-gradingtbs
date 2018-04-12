<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_template_model extends CI_Model {

    var $report_template_table = array(
      'no_alias' => 'email_template_for_report',
      'alias' => 'email_template_for_report etfr',
      'column_display' => 'esm.estate_short_name, esm.estate_name, etfr.estate_code, etfr.template_id, etfr.email_to, etfr.email_reply_to, etfr.email_cc, etfr.email_bcc, etfr.email_subject, etfr.email_body',
      'column_search' => array('esm.estate_short_name', 'esm.estate_name', 'etfr.email_to', 'etfr.email_reply_to', 'etfr.email_cc', 'etfr.email_bcc', 'etfr.email_subject')
    );
    var $column_order = array('esm.estate_short_name', 'esm.estate_name', 'etfr.email_to', 'etfr.email_reply_to', 'etfr.email_cc', 'etfr.email_bcc', 'etfr.email_subject');
    var $order = array('esm.estate_short_name' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->report_template_table['column_display'] );
      $this->db->from( $this->report_template_table['alias'] );
      $this->db->join( 'estate_mst esm', 'etfr.estate_code = esm.estate_code' );
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->report_template_table['column_search'] as $item )
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
          if ( count($this->report_template_table['column_search']) - 1 == $i )
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
      $query = $this->db->get( $this->report_template_table['no_alias'] );
      return $query->result();
    }
    
    public function count_all()
    {
      $this->db->from( $this->report_template_table['no_alias'] );
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
      $this->db->select( $this->report_template_table['column_display'] );
      $this->db->from( $this->report_template_table['alias'] );
      $this->db->join( 'estate_mst esm', 'etfr.estate_code = esm.estate_code' );
      $this->db->where( 'etfr.template_id', $id );
      $query = $this->db->get();

      return $query->row();
    }
    
    public function get_by_estate( $code )
    {
      $this->db->select( $this->report_template_table['column_display'] );
      $this->db->from( $this->report_template_table['alias'] );
      $this->db->join( 'estate_mst esm', 'etfr.estate_code = esm.estate_code' );
      $this->db->where( 'etfr.estate_code', $code );
      $query = $this->db->get();

      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( $this->report_template_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->report_template_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'template_id', $id );
      $this->db->delete( $this->report_template_table['no_alias'] );
    }
}

