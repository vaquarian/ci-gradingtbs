<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  
  var $Vancxevcbvmc = array(
    'no_alias' => 'user_mst',
    'alias' => 'user_mst usm',
    'column_display' => 'usm.id, usm.user_name, usm.full_name, usm.email, usm.imei, usm.position_id, pom.position_name, '
          . 'usm.mill_code, mim.mill_name, usm.role_id, rom.role_name, usm.level, usm.hierarchy_code, him.hierarchy_name, usm.active, usm.should_change_pass, usm.create_date',
    'column_search' => array('usm.user_name', 'usm.full_name', 'usm.email', 'usm.imei', 'pom.position_name', 'mim.mill_name', 'rom.role_name', 'usm.level', 'him.hierarchy_name')
  );
  
  var $Vngc1h5brf0b = array(
    'group_parent_mst' => array(
      'alias' => 'group_parent_mst grpm', 
      'column_display' => '\'GROUP PARENT\' as hierarchy_level, grpm.group_parent_code as hierarchy_code, grpm.group_parent_name as hierarchy_name'
    ),
    'group_mst' => array(
      'alias' => 'group_mst grm', 
      'column_display' => '\'GROUP\' as hierarchy_level, grm.group_code as hierarchy_code, grm.group_name as hierarchy_name'
    ),
    'region_mst' => array(
      'alias' => 'region_mst rem', 
      'column_display' => '\'REGION\' as hierarchy_level, rem.region_code as hierarchy_code, rem.region_name as hierarchy_name'
    ),
    'estate_mst' => array(
      'alias' => 'estate_mst esm', 
      'column_display' => '\'ESTATE\' as hierarchy_level, esm.estate_code as hierarchy_code, esm.estate_name as hierarchy_name'
    )
  );
  var $Vdh50khvdfxz = 'usm.id';
  var $V0ub4ttdoq3w = array('usm.user_name', 'usm.email', 'pom.position_name', 'mim.mill_name', 'rom.role_name', 'usm.level', 'him.hierarchy_name', 'usm.active', null);
  var $V20nc4ajz5we = array('usm.create_date' => 'desc'); 

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  private function _get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv )
  {
    $Vngc1h5brf0b = '';
    $Vngc1h5brf0b_alias = '';
    $Vy2ykzlo454b = array();
    
    if ( isset($this->hierarchy_table) ) 
    {
      foreach ( $this->hierarchy_table as $Vaxglmo4rwds ) 
      {
        $this->db->select( $Vaxglmo4rwds['column_display'] );
        $this->db->from( $Vaxglmo4rwds['alias'] );
        $Vy2ykzlo454b[] = $this->db->get_compiled_select();
      }
      $Vngc1h5brf0b = implode(' UNION ', $Vy2ykzlo454b);
      $Vngc1h5brf0b_alias = '(' . $Vngc1h5brf0b . ') him';
    }
    
    $this->db->select( $this->user_mst_table['column_display'] );
    $this->db->from( $this->user_mst_table['alias'] );
    $this->db->join( 'position_mst pom', 'usm.position_id = pom.position_id' );        
    $this->db->join( 'mill_mst mim', 'usm.mill_code = mim.mill_code' );
    $this->db->join( 'role_mst rom', 'usm.role_id = rom.role_id' );
    $this->db->join( $Vngc1h5brf0b_alias, 'usm.level = him.hierarchy_level AND usm.hierarchy_code = him.hierarchy_code', 'left' );
      
    if ( isset($Vv20acflwotv['xpe']) && !empty($Vv20acflwotv['xpe']) )
      $this->db->where( 'user_name !=', $Vv20acflwotv['xpe'] );
    if ( is_array($Vv20acflwotv) )
    {
      if ( isset($Vv20acflwotv['value']) && !empty($Vv20acflwotv['value']) )
      {
        $Vg1zw3ulxabx = 0;
        foreach ( $this->user_mst_table['column_search'] as $Vg1zw3ulxabxtem )
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
          if ( count($this->user_mst_table['column_search']) - 1 == $Vg1zw3ulxabx )
            $this->db->group_end();
          $Vg1zw3ulxabx++;
        }
      }
    }
    else 
    {
      $this->db->where( $this->column_primary, $Vv20acflwotv );
      $this->db->or_where( 'usm.user_name', $Vv20acflwotv );
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
    $this->_get_datatables_query( $V20nc4ajz5we, $Vv20acflwotv );
    if ( $Vx1jay24nklq != -1 ) {
      $this->db->limit( $Vx1jay24nklq, $Vwcobbwlvjxr );
    }
    $Vonbvky11c1w = $this->db->get();
    return $Vonbvky11c1w->result();
  }
    
  public function count_all()
  {
    $this->db->from( $this->user_mst_table['no_alias'] );
    return $this->db->count_all_results();
  }

  public function count_filtered( $Vv20acflwotv )
  {
    $this->_get_datatables_query( null, $Vv20acflwotv );
    $Vonbvky11c1w = $this->db->get();
    return $Vonbvky11c1w->num_rows();
  }

  public function get_session_data( $V5jdburgy42k )
  {
    $this->_get_datatables_query( null, $V5jdburgy42k );
    $Vonbvky11c1w = $this->db->get();
    return $Vonbvky11c1w->row();
  }
  
  public function get_by_id( $Vg1zw3ulxabxd )
  {
    $this->_get_datatables_query( null, $Vg1zw3ulxabxd );
    $Vonbvky11c1w = $this->db->get();
    return $Vonbvky11c1w->row();
  }

  public function save( $Vycukm2g435s )
  {
    $this->db->insert( $this->user_mst_table['no_alias'], $Vycukm2g435s );
    return $this->db->insert_id();
  }

  public function update( $Vmpvm0zjypu0, $Vycukm2g435s )
  {
    $this->db->update( $this->user_mst_table['no_alias'], $Vycukm2g435s, $Vmpvm0zjypu0 );
    return $this->db->affected_rows();
  }

  public function delete_by_id( $Vg1zw3ulxabxd )
  {
    $this->db->where( 'id', $Vg1zw3ulxabxd );
    $this->db->delete( $this->user_mst_table['no_alias'] );
  }
  
  public function get_active_status( $V5jdburgy42k )
  {
    $this->db->select( 'active' );
    $this->db->from( $this->user_mst_table['no_alias'] );
    $this->db->where( 'user_name', $V5jdburgy42k );
    $Vduzw2rusy0u = $this->db->get()->row( 'active' );
    return ( $Vduzw2rusy0u == 1 ) ? TRUE : FALSE;
  }
  
  public function resolve_user_login( $V5jdburgy42k, $Vffjurpbcc3a )
  {
    $this->db->select( 'password' );
    $this->db->from( $this->user_mst_table['no_alias'] );
    $this->db->where( 'user_name', $V5jdburgy42k );
    $Vthghrbzz5yh = $this->db->get()->row( 'password' );
    return $this->_verify_password_hash( $Vffjurpbcc3a, $Vthghrbzz5yh );
  }
  
  private function _verify_password_hash( $Vffjurpbcc3a, $Vthghrbzz5yh ) 
  {
    if ( md5($Vffjurpbcc3a) == $Vthghrbzz5yh )
    { 
      return TRUE;
    } 
    else if ( md5($Vffjurpbcc3a) != $Vthghrbzz5yh )
    {
      return FALSE;
    }
  }
 
  public function validate_by_mill( $V5jdburgy42k )
  {
    $this->db->select( 'usm.user_name' );
    $this->db->from( $this->user_mst_table['alias'] );
    $this->db->where( 'usm.user_name', $V5jdburgy42k );
    $this->db->where( 'usm.mill_code', $this->session->userdata('mill_code') );
    $Vrxc5c45brd0  = $this->db->get()->row( 'user_name' );
    return ( $Vrxc5c45brd0 != '' ) ? TRUE : FALSE;
  }
  
  public function validate_by_position( $V5jdburgy42k )
  {
    $this->db->select( 'usm.user_name' );
    $this->db->from( $this->user_mst_table['alias'] );
    $this->db->join( 'position_mst pos', 'pos.position_id = usm.position_id' );
    $this->db->where( 'usm.user_name', $V5jdburgy42k );
    $this->db->where( 'pos.position_id', 1 );
    $Vrxc5c45brd0 = $this->db->get()->row( 'user_name' );
    return ( $Vrxc5c45brd0 != '' ) ? TRUE : FALSE;
  }
  
  public function get_user( $V5jdburgy42k ) 
  {
    $this->db->from( $this->user_mst_table['no_alias'] );
    $this->db->where( 'user_name', $V5jdburgy42k );
    return $this->db->get()->row();
  }
  
}