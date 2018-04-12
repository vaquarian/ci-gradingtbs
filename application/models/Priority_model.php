<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Priority_model extends CI_Model {

    var $Vowy3c2cwaim = array(
      'no_alias' => 'grading_priority',
      'alias' => 'grading_priority gpr',
      'column_display' => 'esm.estate_short_name, dim.division_name, gpr.num_of_truck_last_month, gpr.actual_num_of_truck_coming, '
                        . 'gpr.estimate_sampling, gpr.on_days, gpr.estimate_num_of_sampling, gpr.actual_num_of_sampling, gpr.gap, gpr.percent_gap',
      'column_search' => array('esm.estate_short_name',  'dim.division_name')
    );
    var $V0ub4ttdoq3w = array('esm.estate_short_name', 'dim.division_name', 'gpr.num_of_truck_last_month', 'gpr.actual_num_of_truck_coming', 'gpr.estimate_sampling', 'gpr.on_days', 'gpr.estimate_num_of_sampling', 'gpr.actual_num_of_sampling', 'gpr.gap', 'gpr.percent_gap');
    var $V20nc4ajz5we = array('gpr.percent_gap' => 'asc', 'gpr.num_of_truck_last_month' => 'asc');
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->db->select( $this->priority_table['column_display'] );
      $this->db->from( $this->priority_table['alias'] );
      $this->db->join( 'division_mst dim', 'gpr.division_code = dim.division_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      $this->db->where( 'dim.mill_code', $this->session->userdata('mill_code') );
      if ( isset($Vv20acflwotv['value']) && $Vv20acflwotv['value'] != '' )
      {
        $Vg1zw3ulxabx = 0;
        foreach ( $this->priority_table['column_search'] as $Vg1zw3ulxabxtem )
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
          if ( count($this->priority_table['column_search']) - 1 == $Vg1zw3ulxabx )
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
        foreach ( $this->order as $Vnqx2cwz4eag => $V1k4cznieu4a )
        {
          $this->db->order_by( $Vnqx2cwz4eag, $V1k4cznieu4a );
        }
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
      $this->db->select( $this->priority_table['column_display'] );
      $this->db->from( $this->priority_table['alias'] );
      $this->db->join( 'division_mst dim', 'gpr.division_code = dim.division_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      $this->db->where( 'dim.mill_code', $this->session->userdata('mill_code') );
      $this->db->order_by( 'gpr.percent_gap', 'asc' );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->result();
    }
    
    public function count_all()
    {
      $this->db->select( $this->priority_table['column_display'] );
      $this->db->from( $this->priority_table['alias'] );
      $this->db->join( 'division_mst dim', 'gpr.division_code = dim.division_code' );
      $this->db->join( 'estate_mst esm', 'dim.estate_code = esm.estate_code' );
      return $this->db->count_all_results();
    }
    
    public function count_filtered( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->num_rows();
    }
    
    public function call_grading_priority( $Vjgjok5a4gci, $V5jdburgy42k )
    {
      $this->db->query( 'CALL `sp_grading_priority`("'.$Vjgjok5a4gci.'", "'.$V5jdburgy42k.'")' );
      
      $this->db->from( 'division_mst' );
      $this->db->where( 'mill_code', $Vjgjok5a4gci );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row();
    }
    
    public function count_sampling_priority( $Vjgjok5a4gci, $Vsoyuznqhiek )
    {
      $V5jdburgy42k = $this->session->userdata('user_name');
      $this->call_grading_priority( $Vjgjok5a4gci, $V5jdburgy42k );
      
      $Vfgwdxutgzve = $this->_get_division( $Vjgjok5a4gci );
      $this->db->select( 'gpr.estimate_sampling, gpr.actual_num_of_sampling' );
      $this->db->from( $this->priority_table['alias'] );
      $this->db->join( 'spb spb', 'gpr.division_code = spb.division_code' );
      $this->db->where( 'MONTH(spb.spb_date)', $Vsoyuznqhiek );
      $this->db->where_in( 'gpr.division_code', $Vfgwdxutgzve );
      $Vonbvky11c1w = $this->db->get();
      if ( $Vonbvky11c1w->num_rows() > 0 ) {
        $Visuezxnlpp0 = 0;
        $Vpblbl10lxpk = 0;
        foreach ( $Vonbvky11c1w->result() as $Vziedijv1boh ) {
          $Vejj1hhtlzz3 = $Vziedijv1boh->estimate_sampling;
          $Vcwdohjz53kt = $Vziedijv1boh->actual_num_of_sampling;
          $Vxxav2nztcnh = ( ($Vejj1hhtlzz3 - $Vcwdohjz53kt) < 0 ) ? $Vejj1hhtlzz3 : $Vcwdohjz53kt;
          $Visuezxnlpp0 = $Visuezxnlpp0 + $Vxxav2nztcnh;
          $Vpblbl10lxpk = $Vpblbl10lxpk + $Vejj1hhtlzz3;
        }
        $Vycukm2g435s = array(
          'total_curr_day' => $Visuezxnlpp0,
          'total_last_month' => $Vpblbl10lxpk
        );
        return $Vycukm2g435s;
      }
      return false;
    }
    
    private function _get_division( $Vjgjok5a4gci )
    {
      $Vt344rf3amdw = array();
      $this->db->from( 'division_mst' );
      $this->db->where( 'mill_code', $Vjgjok5a4gci );      
      $Vonbvky11c1w = $this->db->get();
      foreach ( $Vonbvky11c1w->result() as $Vbem5iumao5p ) {        
        $Vt344rf3amdw[] = $Vbem5iumao5p->division_code;
      }
      return $Vt344rf3amdw;
    }
}

