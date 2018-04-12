<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Spb_model extends CI_Model {

    var $V45lmeiquhmz = array(
      'no_alias' => 'spb',
      'alias' => 'spb spb',
      'column_display' => 'spb.spb_num, DATE_FORMAT(spb.create_date, \'%d-%m-%Y %H:%i:%s\') as create_date, spb.truck_num, spb.driver_name, spb.reason, spb.is_grading, grm.group_code, grm.group_name, rem.region_code, rem.region_name, esm.estate_code, esm.estate_short_name, esm.estate_name, dim.division_code, dim.division_name',
      'column_search' => array('spb.spb_num', 'spb.create_date', 'spb.truck_num', 'spb.driver_name', 'spb.reason', 'grm.group_name', 'rem.region_name', 'esm.estate_name', 'dim.division_name')
    );
    var $V0ub4ttdoq3w = array('spb.spb_num', 'spb.create_date', 'spb.truck_num', 'spb.driver_name', 'grm.group_name', 'rem.region_name', 'esm.estate_name', 'dim.division_name', 'spb.is_grading', 'spb.reason');
    var $V20nc4ajz5we = array('spb.create_date' => 'desc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->db->select( $this->spb_table['column_display'] );
      $this->db->from( $this->spb_table['alias'] );
      $this->db->join( 'group_parent_mst grpm', 'spb.group_parent_code = grpm.group_parent_code' );
      $this->db->join( 'group_mst grm', 'spb.group_code = grm.group_code' );
      $this->db->join( 'region_mst rem', 'spb.region_code = rem.region_code' );
      $this->db->join( 'estate_mst esm', 'spb.estate_code = esm.estate_code' );
      $this->db->join( 'division_mst dim', 'spb.division_code = dim.division_code' );
      $this->db->join( 'mill_mst mim', 'spb.mill_code = mim.mill_code' );
      $this->db->where( 'spb.mill_code', $this->session->userdata('mill_code') );
      
      if ( isset($Vv20acflwotv['parent_code']) && $Vv20acflwotv['parent_code'] != '' )
      {
        $this->db->where( 'spb.spb_num', $Vv20acflwotv['parent_code'] );
      }
      
      if ( isset($Vv20acflwotv['start_date']) && $Vv20acflwotv['start_date'] != '' && $Vv20acflwotv['end_date'] == '' )
      {
        $V10njmdb4dmu = $Vv20acflwotv['start_date'];
        
        $this->db->where( 'spb.spb_date', date('Y-m-d', strtotime($V10njmdb4dmu)));
      }
      
      if ( isset($Vv20acflwotv['start_date']) && $Vv20acflwotv['start_date'] != '' && isset($Vv20acflwotv['end_date']) && $Vv20acflwotv['end_date'] != '' )
      {
          $V10njmdb4dmu = $Vv20acflwotv['start_date'];
          $Vgicmduxd4r5 = $Vv20acflwotv['end_date'];
          
          $this->db->where('spb.spb_date BETWEEN "'. date('Y-m-d', strtotime($V10njmdb4dmu)). '" and "'. date('Y-m-d', strtotime($Vgicmduxd4r5)).'"');
        
        $V10njmdb4dmu = '';
        $Vgicmduxd4r5 = '';
      }

      if ( isset($Vv20acflwotv['value']) && $Vv20acflwotv['value'] != '' )
      {
        $Vg1zw3ulxabx = 0;
        foreach ( $this->spb_table['column_search'] as $Vg1zw3ulxabxtem )
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
          if ( count($this->spb_table['column_search']) - 1 == $Vg1zw3ulxabx )
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
    
    public function count_all()
    {
      $this->db->select( $this->spb_table['column_display'] );
      $this->db->from( $this->spb_table['alias'] );
      $this->db->join( 'group_parent_mst grpm', 'spb.group_parent_code = grpm.group_parent_code' );
      $this->db->join( 'group_mst grm', 'spb.group_code = grm.group_code' );
      $this->db->join( 'region_mst rem', 'spb.region_code = rem.region_code' );
      $this->db->join( 'estate_mst esm', 'spb.estate_code = esm.estate_code' );
      $this->db->join( 'division_mst dim', 'spb.division_code = dim.division_code' );
      $this->db->join( 'mill_mst mim', 'spb.mill_code = mim.mill_code' );
      return $this->db->count_all_results();
    }
    
    public function count_filtered( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->num_rows();
    }
    
    public function get_detail_by_spbnum( $Vg3l32ogla4u, $Vkiezwdh21pw )
    {
      $Vukjf0c5hzu0 = array('esm.estate_short_name' => $Vg3l32ogla4u, 'dim.division_name' => $Vkiezwdh21pw);
      $this->db->select( 'grpm.group_parent_code, grpm.group_parent_name, grm.group_code, grm.group_name, rem.region_code, rem.region_name, esm.estate_code, esm.estate_short_name, esm.estate_name, dim.division_code, dim.division_name, mim.mill_code, mim.mill_name' );
      $this->db->from( 'estate_mst esm' );
      $this->db->join( 'division_mst dim', 'esm.estate_code = dim.estate_code' );
      $this->db->join( 'mill_mst mim', 'dim.mill_code = mim.mill_code' );
      $this->db->join( 'region_mst rem', 'esm.region_code = rem.region_code' );
      $this->db->join( 'group_mst grm', 'rem.group_code = grm.group_code' );
      $this->db->join( 'group_parent_mst grpm', 'grm.group_parent_code = grpm.group_parent_code' );
      $this->db->where( $Vukjf0c5hzu0 );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row_array();
    }
 
    public function save( $Vycukm2g435s )
    {
      $this->db->insert( $this->spb_table['no_alias'], $Vycukm2g435s );
      if ( $this->db->affected_rows() > 0 )
      {
        return TRUE;
      } 
      else 
      {
        return FALSE;
      }
    }
    
    public function call_grading_logic( $Vg0nsq02in0n, $V4mm1plmtxfy, $Vsyh5mexgj13 )
    {
      $Vonbvky11c1w = $this->db->query( 'SELECT `fn_grading_logic`("'.$Vg0nsq02in0n.'","'.$V4mm1plmtxfy.'","'.$Vsyh5mexgj13.'") AS `is_grading`' );
      return $Vonbvky11c1w->row_array();
    }
 
    public function get_by_id( $Vg0nsq02in0n )
    {
      $this->db->from( $this->spb_table['no_alias'] );
      $this->db->where( 'spb_num', $Vg0nsq02in0n );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row();
    }
    
    public function update( $Vmpvm0zjypu0, $Vycukm2g435s )
    {
      $this->db->update( $this->spb_table['no_alias'], $Vycukm2g435s, $Vmpvm0zjypu0 );
      return $this->db->affected_rows();
    }
 
    public function delete_by_id( $Vg1zw3ulxabxd )
    {
      $this->db->where( 'group_code', $Vg1zw3ulxabxd );
      $this->db->delete( $this->spb_table['no_alias'] );
    }
}

