<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Extreme_template_model extends CI_Model {

    var $extreme_template_table = array(
      'no_alias' => 'email_template_for_extreme',
      'alias' => 'email_template_for_extreme etfe',
      'column_display' => 'esm.estate_short_name, esm.estate_name, dim.division_code, dim.division_name, etfe.template_id, etfe.email_to, etfe.email_reply_to, etfe.email_cc, etfe.email_bcc, etfe.email_subject, etfe.email_body',
      'column_search' => array('esm.estate_short_name', 'esm.estate_name', 'dim.division_name', 'etfe.email_to', 'etfe.email_reply_to', 'etfe.email_cc', 'etfe.email_bcc', 'etfe.email_subject')
    );
    var $column_order = array('esm.estate_short_name', 'esm.estate_name', 'dim.division_name', 'etfe.email_to', 'etfe.email_reply_to', 'etfe.email_cc', 'etfe.email_bcc', 'etfe.email_subject');
    var $order = array('esm.estate_short_name' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $order, $search )
    {
      $this->db->select( $this->extreme_template_table['column_display'] );
      $this->db->from( $this->extreme_template_table['alias'] );
      $this->db->join( 'division_mst dim', 'etfe.division_code = dim.division_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      if ( isset($search['value']) && $search['value'] != '' )
      {
        $i = 0;
        foreach ( $this->extreme_template_table['column_search'] as $item )
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
          if ( count($this->extreme_template_table['column_search']) - 1 == $i )
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
      $query = $this->db->get( $this->extreme_template_table['no_alias'] );
      return $query->result();
    }
    
    public function count_all()
    {
      $this->db->from( $this->extreme_template_table['no_alias'] );
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
      $this->db->select( $this->extreme_template_table['column_display'] );
      $this->db->from( $this->extreme_template_table['alias'] );
      $this->db->join( 'division_mst dim', 'etfe.division_code = dim.division_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      $this->db->where( 'etfe.template_id', $id );
      $query = $this->db->get();

      return $query->row();
    }
 
    public function save( $data )
    {
      $this->db->insert( $this->extreme_template_table['no_alias'], $data );
      return $this->db->insert_id();
    }
 
    public function update( $where, $data )
    {
      $this->db->update( $this->extreme_template_table['no_alias'], $data, $where );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $id )
    {
      $this->db->where( 'template_id', $id );
      $this->db->delete( $this->extreme_template_table['no_alias'] );
    }
}

