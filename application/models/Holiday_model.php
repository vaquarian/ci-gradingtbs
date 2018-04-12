<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_model extends CI_Model {

    var $Vwd2yxuzgkje = array(
      'no_alias' => 'holiday_mst',
      'alias' => 'holiday_mst hom',
      'column_edit' => 'hom.holiday_id, DATE_FORMAT(hom.holiday_date, \'%d-%m-%Y\') as holiday_date, hom.description, hom.mill_option, hom.mill_code, mim.mill_name',
      'column_display' => 'hom.holiday_id, DATE_FORMAT(hom.holiday_date, \'%d-%m-%Y\') as holiday_date, hom.description, hom.mill_option, (CASE hom.mill_option WHEN "ALL" THEN "ALL MILL" WHEN "SPECIFIC" THEN mim.mill_name ELSE NULL END) AS mill_name',
      'column_search' => array('holiday_date', 'hom.description', 'mill_name')
    );
    var $V0ub4ttdoq3w = array('hom.holiday_id', 'holiday_date', 'hom.description', 'mill_name');
    var $V20nc4ajz5we = array('holiday_date' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->db->distinct();
      $this->db->select( $this->holiday_table['column_display'] );
      $this->db->from( $this->holiday_table['alias'] );
      $this->db->join( 'mill_mst mim', 'hom.mill_code = mim.mill_code', 'left' );
      if ( isset($Vv20acflwotv['value']) && $Vv20acflwotv['value'] != '' )
      {
        $Vg1zw3ulxabx = 0;
        foreach ( $this->holiday_table['column_search'] as $Vg1zw3ulxabxtem )
        { 
          if ( $Vg1zw3ulxabx === 0 )
          {
            $this->db->group_start();
            $this->db->like( $Vg1zw3ulxabxtem, $Vv20acflwotv['value'] );
          } 
          else 
          {
            $this->db->or_like( $Vg1zw3ulxabxtem, $Vv20acflwotv['value'] );
          }
          if ( count($this->holiday_table['column_search']) - 1 == $Vg1zw3ulxabx )
            $this->db->group_end();
          $Vg1zw3ulxabx++;
        }
      }
      if ( !empty($V20nc4ajz5we) )
      {
        $Vnnzijkwufvj = 0;
        $Vhvz4l23hppb = '';
        foreach( $V20nc4ajz5we as $Vmx0katkkzkv ) {
          $Vnnzijkwufvj = $Vmx0katkkzkv['column'];
          $Vhvz4l23hppb = $Vmx0katkkzkv['dir'];
        }
        if ( $Vhvz4l23hppb != 'asc' && $Vhvz4l23hppb != 'desc' ) 
          $Vhvz4l23hppb = 'asc';
        if ( !isset($this->column_order[$Vnnzijkwufvj]) )
        {
          $this->db->order_by( key($this->order), $this->order[key($this->order)] );
        } 
        else 
        {
          $this->db->order_by( $this->column_order[$Vnnzijkwufvj], $Vhvz4l23hppb );
        }
      }
      else if ( !empty($this->order) ) 
      {
        $this->db->order_by( key($this->order), $this->order[key($this->order)] );
      }
    }
    
    public function get_datatables( $Vwcobbwlvjxr, $Vx1jay24nklq, $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
      if ( $Vx1jay24nklq != -1 ) {
          $this->db->limit( $Vx1jay24nklq, $Vwcobbwlvjxr );
      }
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->result();
    }
    
    public function get_all()
    {
      $Vonbvky11c1w = $this->db->get( $this->holiday_table['no_alias'] );
      return $Vonbvky11c1w->result();
    }
    
    public function count_all()
    {
      $this->db->from( $this->holiday_table['no_alias'] );
      return $this->db->count_all_results();
    }
    
    public function count_distinct()
    {
      $this->db->distinct();
      $this->db->select( $this->holiday_table['column_display'] );
      $this->db->from( $this->holiday_table['alias'] );
      $this->db->join( 'mill_mst mim', 'hom.mill_code = mim.mill_code', 'left' );
      return $this->db->count_all_results();
    }
    
    public function count_filtered( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->num_rows();
    }
 
    public function get_by_id( $Vg1zw3ulxabxd )
    {
      $this->db->select( $this->holiday_table['column_edit'] );
      $this->db->from( $this->holiday_table['alias'] );
      $this->db->join( 'mill_mst mim', 'hom.mill_code = mim.mill_code', 'left' );
      $this->db->where( 'hom.holiday_id', $Vg1zw3ulxabxd );
      $Vonbvky11c1w = $this->db->get();

      return $Vonbvky11c1w->row();
    }
    
    public function get_by_date( $Vveh05ps2lyr )
    {
      $this->db->select( $this->holiday_table['column_edit'] );
      $this->db->from( $this->holiday_table['alias'] );
      $this->db->join( 'mill_mst mim', 'hom.mill_code = mim.mill_code', 'left' );
      $this->db->where( 'holiday_date', $Vveh05ps2lyr );
      $Vonbvky11c1w = $this->db->get();

      return $Vonbvky11c1w->row();
    }
    
    public function get_detail( $Vveh05ps2lyr, $Vjgjok5a4gci )
    {
      $this->db->from( $this->holiday_table['no_alias'] );
      $this->db->where( 'holiday_date', $Vveh05ps2lyr );
      if ( !empty($Vjgjok5a4gci) ) {
        $this->db->where( 'mill_code', $Vjgjok5a4gci );
      }
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row();
    }
 
    public function save_batch( $Vycukm2g435s )
    {
      $this->db->insert_batch( $this->holiday_table['no_alias'], $Vycukm2g435s );
      return $this->db->insert_id();
    }
    
    public function save( $Vycukm2g435s )
    {
      $this->db->insert( $this->holiday_table['no_alias'], $Vycukm2g435s );
      return $this->db->insert_id();
    }
 
    public function update( $Vmpvm0zjypu0, $Vycukm2g435s )
    {
      $this->db->update( $this->holiday_table['no_alias'], $Vycukm2g435s, $Vmpvm0zjypu0 );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $Vg1zw3ulxabxd )
    {
      $this->db->where( 'holiday_id', $Vg1zw3ulxabxd );
      $this->db->delete( $this->holiday_table['no_alias'] );
    }
    
    public function delete_batch( $Vveh05ps2lyr )
    {
      $this->db->where( 'holiday_date', $Vveh05ps2lyr );
      $this->db->delete( $this->holiday_table['no_alias'] );
    }
}

