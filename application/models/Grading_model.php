<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Grading_model extends CI_Model {

    var $Vzcclvos4u1f = array(
      'no_alias' => 'grading_master',
      'alias' => 'grading_master gma',
      'column_display' => 'gma.spb_num, gma.brondolan_on_spb, gma.actual_brondolan_on_pks, gma.num_of_janjang, gma.foreman, gma.witness, gma.assistant, TIME_FORMAT(gma.time_start, \'%H:%i\') AS time_start, TIME_FORMAT(gma.time_end, \'%H:%i\') AS time_end, DATE_FORMAT(gma.create_date, \'%d-%m-%Y %H:%i:%s\') as create_date, DATE_FORMAT(gma.modify_date, \'%d-%m-%Y %H:%i:%s\') as modify_date, gma.modify_user, gma.approve_date, DATE_FORMAT(spb.spb_date, \'%d-%m-%Y\') as spb_date, spb.truck_num, '
                        . 'grm.group_code, grm.group_name, rem.region_code, rem.region_name, esm.estate_code, esm.estate_short_name, esm.estate_name, dim.division_code, dim.division_name, mim.mill_code, mim.mill_name, '
                        . 'frm.full_name as foreman_name, wts.full_name as witness_name, ast.full_name as assistant_name ',
      'column_search' => array('gma.spb_num', 'gma.foreman', 'gma.witness', 'gma.assistant', 'spb.truck_num', 'grm.group_name', 'rem.region_name', 'esm.estate_name', 'dim.division_name', 'mim.mill_name', 'frm.full_name', 'wts.full_name', 'ast.full_name')
    );
    var $V0ub4ttdoq3w = array('gma.spb_num', 'grm.group_name', 'rem.region_name', 'esm.estate_name', 'dim.division_name', 'spb.truck_num', 'gma.foreman', 'gma.witness', 'gma.assistant', 'gma.modify_date', 'gma.approve_date');
    var $V20nc4ajz5we = array('gma.create_date' => 'desc');
        
    var $Vcsabnrmogas = array(
      'no_alias' => 'grading_detail',
      'alias' => 'grading_detail gde',
      'column_display' => 'gcr.criteria_code, gcr.criteria_name, gcr.index_num, gde.spb_num, gde.is_extreme, gde.value, gde.percent, gcr.type',
      'column_search' => array('gcr.criteria_code', 'gcr.criteria_name')
    );
    var $V3pyoqx4rdi3 = array('gcr.criteria_name', 'gde.value', 'gde.percent');
    var $Vf5mcr0kcg1i = array('gcr.index_num' => 'asc');
    
    var $Vtt4y43dgo2d = array(
      'no_alias' => 'grading_criteria',
      'alias' => 'grading_criteria gcr',
      'column_display' => 'gcr.criteria_code, gcr.criteria_name',
      'column_search' => array('gcr.criteria_code', 'gcr.criteria_name')
    );
    
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->db->select( $this->grading_table['column_display'] );
      $this->db->from( $this->grading_table['alias'] );
      $this->db->join( 'spb spb', 'gma.spb_num = spb.spb_num' );
      $this->db->join( 'group_mst grm', 'spb.group_code = grm.group_code' );
      $this->db->join( 'region_mst rem', 'spb.region_code = rem.region_code' );
      $this->db->join( 'estate_mst esm', 'spb.estate_code = esm.estate_code' );
      $this->db->join( 'division_mst dim', 'spb.division_code = dim.division_code' );
      $this->db->join( 'mill_mst mim', 'spb.mill_code = mim.mill_code' );
      $this->db->join( 'user_mst frm', 'gma.foreman = frm.user_name', 'left' );
      $this->db->join( 'user_mst wts', 'gma.witness = wts.user_name', 'left' );
      $this->db->join( 'user_mst ast', 'gma.assistant = ast.user_name', 'left' );

      $this->db->where ( 'mim.mill_code', $this->session->userdata('mill_code'));
      
      if ( isset($Vv20acflwotv['start_date']) && $Vv20acflwotv['start_date'] != '' && $Vv20acflwotv['end_date'] == '' )
      {
        $V10njmdb4dmu = $Vv20acflwotv['start_date'];
        
        $this->db->like( "gma.create_date", date('Y-m-d', strtotime($V10njmdb4dmu)), 'after');
      }
      
      if ( isset($Vv20acflwotv['start_date']) && $Vv20acflwotv['start_date'] != '' && isset($Vv20acflwotv['end_date']) && $Vv20acflwotv['end_date'] != '' )
      {
          $V10njmdb4dmu = date('Y-m-d', strtotime($Vv20acflwotv['start_date']));
          $Vgicmduxd4r5 = date('Y-m-d', strtotime($Vv20acflwotv['end_date']));
          
          $this->db->where('gma.create_date BETWEEN "'. $V10njmdb4dmu . ' 00:00:00' . '" and "'. $Vgicmduxd4r5 . ' 23:59:59'.'"');
        
        $V10njmdb4dmu = '';
        $Vgicmduxd4r5 = '';
      }
      
      if ( isset($Vv20acflwotv['value']) && !empty($Vv20acflwotv['value']) )
      {
        $Vg1zw3ulxabx = 0;
        foreach ( $this->grading_table['column_search'] as $Vg1zw3ulxabxtem )
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
          if ( count($this->grading_table['column_search']) - 1 == $Vg1zw3ulxabx )
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
    
    private function get_detail_datatables_query( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->db->select( $this->grading_detail_table['column_display'] );
      $this->db->from( $this->grading_detail_table['alias'] );
      $this->db->join( 'grading_criteria gcr', 'gde.criteria_code = gcr.criteria_code' );
      
      if ( isset($Vv20acflwotv['spb_num']) && $Vv20acflwotv['spb_num'] != '' )
      {
        $this->db->where( 'gde.spb_num', $Vv20acflwotv['spb_num'] );
      }
      
      if ( isset($Vv20acflwotv['value']) && $Vv20acflwotv['value'] != '' )
      {
        $Vg1zw3ulxabx = 0;
        foreach ( $this->grading_detail_table['column_search'] as $Vg1zw3ulxabxtem )
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
          if ( count($this->grading_detail_table['column_search']) - 1 == $Vg1zw3ulxabx )
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
        if ( !isset($this->column_detail_order[$Vnnzijkwufvj]) )
        {
          $this->db->order_by( key($this->detail_order), $this->detail_order[key($this->detail_order)] );
        } 
        else 
        {
          $this->db->order_by( $this->column_detail_order[$Vnnzijkwufvj], $Vhvz4l23hppb );
        }
      }
      else if ( !empty($this->detail_order) ) 
      {
        $this->db->order_by( key($this->detail_order), $this->detail_order[key($this->detail_order)] );
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
    
    public function get_detail_datatables( $Vwcobbwlvjxr, $Vx1jay24nklq, $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->get_detail_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
      if ( $Vx1jay24nklq != -1 ) {
          $this->db->limit( $Vx1jay24nklq, $Vwcobbwlvjxr );
      }
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->result();
    }
    
    public function count_all()
    {
      $this->db->from( $this->grading_table['no_alias'] );
      return $this->db->count_all_results();
    }
    
    public function count_all_detail( $Vv20acflwotv )
    {
      $this->db->select( $this->grading_detail_table['column_display'] );
      $this->db->from( $this->grading_detail_table['alias'] );
      $this->db->join( 'grading_criteria gcr', 'gde.criteria_code = gcr.criteria_code' );      
      if ( isset($Vv20acflwotv['spb_num']) && $Vv20acflwotv['spb_num'] != '' )
      {
        $this->db->where( 'gde.spb_num', $Vv20acflwotv['spb_num'] );
      }
      return $this->db->count_all_results();
    }
    
    public function count_filtered( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->num_rows();
    }
    
    public function count_filtered_detail( $V20nc4ajz5we, $Vv20acflwotv )
    {
      $this->get_detail_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->num_rows();
    }
    
    public function get_by_spbnum( $Vg0nsq02in0n )
    {
      $this->db->select( $this->grading_table['column_display'] );
      $this->db->from( $this->grading_table['alias'] );
      $this->db->join( 'spb spb', 'gma.spb_num = spb.spb_num' );
      $this->db->join( 'group_mst grm', 'spb.group_code = grm.group_code' );
      $this->db->join( 'region_mst rem', 'spb.region_code = rem.region_code' );
      $this->db->join( 'estate_mst esm', 'spb.estate_code = esm.estate_code' );
      $this->db->join( 'division_mst dim', 'spb.division_code = dim.division_code' );
      $this->db->join( 'mill_mst mim', 'spb.mill_code = mim.mill_code' );
      $this->db->join( 'user_mst frm', 'gma.foreman = frm.user_name', 'left' );
      $this->db->join( 'user_mst wts', 'gma.witness = wts.user_name', 'left' );
      $this->db->join( 'user_mst ast', 'gma.assistant = ast.user_name', 'left' );
      $this->db->where( 'gma.spb_num', $Vg0nsq02in0n );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row();
    }
    
    public function get_detail( $Vg0nsq02in0n=null, $Vxai1ymevbjc=null )
    {
      $this->db->select( $this->grading_detail_table['column_display'] );
      $this->db->from( $this->grading_detail_table['alias'] );
      $this->db->join( 'grading_criteria gcr', 'gde.criteria_code = gcr.criteria_code' );
      if ( !empty($Vg0nsq02in0n) ) {
        $this->db->where( 'gde.spb_num', $Vg0nsq02in0n );
      }
      if ( !empty($Vxai1ymevbjc) ) {
        $this->db->where( 'gcr.criteria_code', $Vxai1ymevbjc );
      }
      $this->db->order_by( 'gcr.index_num ASC' );
      $Vonbvky11c1w = $this->db->get();
      if ( !empty($Vg0nsq02in0n) && !empty($Vxai1ymevbjc) ) {
        return $Vonbvky11c1w->row();
      } else {
        return $Vonbvky11c1w->result();
      }
    }
    
    public function get_criteria( $Vxai1ymevbjc )
    {
      $this->db->select( $this->grading_criteria_table['column_display'] );
      $this->db->from( $this->grading_criteria_table['alias'] );
      $this->db->where( 'gcr.criteria_code', $Vxai1ymevbjc );
      $this->db->order_by( 'gcr.index_num ASC' );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row();
    }
    
    private function _get_total_value( $Vg0nsq02in0n )
    {
      $this->db->select_sum( 'value', 'value_total' );
      $this->db->from( $this->grading_detail_table['alias'] );
      $this->db->join( 'grading_criteria gcr', 'gcr.criteria_code = gde.criteria_code');
      $this->db->where( 'gde.spb_num', $Vg0nsq02in0n );
      $this->db->where( 'gcr.type', 'INTERNAL');
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row();
    }

    
    private function _update_percent( $Vmpvm0zjypu0, $Vycukm2g435s )
    {
      $this->db->update( $this->grading_detail_table['no_alias'], $Vycukm2g435s, $Vmpvm0zjypu0 );
      return $this->db->affected_rows();
    }
    
    public function calculate_percent( $Vg0nsq02in0n, $Vxai1ymevbjc )
    {
      $Vukjf0c5hzu0 = $this->_get_total_value( $Vg0nsq02in0n );
      $Vqud41polbea = $this->get_detail( $Vg0nsq02in0n );
      $Vqud41polbea = array_filter( $Vqud41polbea );
      if ( !empty($Vqud41polbea) ) 
      {
        foreach ( $Vqud41polbea as $V4uykm0bgyjc )
        {
	  if($V4uykm0bgyjc->type == 'INTERNAL'){
          	$Vndnvpp5pwk5 = ($V4uykm0bgyjc->value / $Vukjf0c5hzu0->value_total) * 100;
	  }else{
		$Vndnvpp5pwk5 = 0;	
	  }
          $Vycukm2g435s = array(
            'percent' => $Vndnvpp5pwk5
          );
          $this->_update_percent( array(
            'spb_num' => $V4uykm0bgyjc->spb_num,
            'criteria_code' => $V4uykm0bgyjc->criteria_code
          ), $Vycukm2g435s );
        }
        return array( 'value_total' => $Vukjf0c5hzu0->value_total, 'status' => TRUE );
      }
      return array( 'status' => FALSE );
    }
    
    public function update( $Vmpvm0zjypu0, $Vycukm2g435s )
    {
      $this->db->update( $this->grading_table['no_alias'], $Vycukm2g435s, $Vmpvm0zjypu0 );
      return $this->db->affected_rows();
    }

    public function update_spb( $Vmpvm0zjypu0, $Vycukm2g435s )
    {
      $this->db->update( 'spb', $Vycukm2g435s, $Vmpvm0zjypu0 );
      return $this->db->affected_rows();
    }
    
    public function update_detail( $Vmpvm0zjypu0, $Vycukm2g435s )
    {
      $this->db->update( $this->grading_detail_table['no_alias'], $Vycukm2g435s, $Vmpvm0zjypu0 );
      return $this->db->affected_rows();
    }
    
    public function save_detail( $Vycukm2g435s )
    {
      $this->db->insert( $this->grading_detail_table['no_alias'], $Vycukm2g435s );
      return $this->db->insert_id();
    }
    
    public function count_actual_grading( $Vjgjok5a4gci, $Vebtv3yovyq3 )
    {
      $this->db->select( 'COUNT(*) as num_actual_grading' );
      $this->db->from( $this->grading_table['alias'] );
      $this->db->join( 'spb spb', 'gma.spb_num = spb.spb_num' );
      $this->db->where( 'spb.mill_code', $Vjgjok5a4gci );
      $this->db->where( 'spb.spb_date', $Vebtv3yovyq3 );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row()->num_actual_grading;
    }
}