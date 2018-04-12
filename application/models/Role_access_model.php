<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_access_model extends CI_Model {
    
    var $Vda3kprwf241 = array(
      'alias' => 'role_access roa',
      'no_alias' => 'role_access',    
      'column_display' => 'roa.view_permission, roa.add_permission, roa.edit_permission, roa.delete_permission',
      'menu_display' => 'roa.menu_name, roa.view_permission'    
    );
    
    var $Vx0ql00mgc1m = array(
      'main_menu1' => array(
        'menu' => 'User Profile',
        'sub_menu' => array(
          'User Management', 'Application Role', 'Change Password'
        )
      ), 
      'main_menu2' => array(
        'menu' => 'Master',
        'sub_menu' => array(
          'Master Mill', 'Master Group Parent', 'Master Group', 'Master Region', 'Master Estate', 'Master Division', 'Master Holiday', 'Master Grading Criteria', 'Master Position'
        )
      ), 
      'main_menu3' => array(
        'menu' => 'Monitoring',
        'sub_menu' => array(
          'SPB', 'Grading', 'Grading Priority' 
        )
      ), 
      'main_menu4' => array(
        'menu' => 'Report',
        'sub_menu' => array(
          'Grading Report', 'Achievement Target Report'
        )
      ), 
      'main_menu5' => array(
        'menu' => 'Setting',
        'sub_menu' => array(
          'Grading Parameter', 'Extreme Condition and Target', 'Extreme Email Template', 'Report Email Template'
        )
      ),
      'main_menu6' => array(
        'menu' => 'Audit Log',
        'sub_menu' => array()
      )
    );
    
    public function __construct() 
    {
      parent::__construct();
      $this->load->database();
    }
    
    public function get_crud_access( $Vrv0eitfwv3a, $Vk4qcnkyboxw )
    {
      $this->db->select( $this->role_access['column_display'] );
      $this->db->from( $this->role_access['alias'] );
      $this->db->where( 'roa.app_type', 'W' );
      $this->db->where( 'roa.role_id', $Vk4qcnkyboxw );
      $this->db->where( 'roa.menu_name', $Vrv0eitfwv3a );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row(); 
    }
    
    public function get_sub_menu_access( $Vk4qcnkyboxw )
    {
      $this->db->select( $this->role_access['menu_display'] );
      $this->db->from( $this->role_access['alias'] );
      $this->db->where( 'roa.app_type', 'W' );
      $this->db->where( 'roa.role_id', $Vk4qcnkyboxw );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->result();
    }
    
    public function get_menu_access( $Vwm1r25ypous )
    { 
      $Vfpdzbg01avp = array();
      $Vpin0gy2335l = array();
      if ( !empty($this->main_menu) ) {
        foreach ( $this->main_menu as $Vguwrnvxrgh3 ) {
          if ( count(array_intersect($Vwm1r25ypous, $Vguwrnvxrgh3['sub_menu'])) == count($Vguwrnvxrgh3['sub_menu']) ) {
            $Vfpdzbg01avp[] = $Vguwrnvxrgh3['menu'];
          } else {
            $Vpin0gy2335l[] = $Vguwrnvxrgh3['menu'];
          }
        }
      }
      return $Vpin0gy2335l;
    }
    
}
