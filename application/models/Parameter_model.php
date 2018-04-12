<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Parameter_model extends CI_Model {
    
  var $V0gzvn5tl2xh = array(
      'no_alias' => 'grading_params'
  );

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  
  public function get_param_value( $Vjgjok5a4gci = null, $V5mwq11nenf4 = 'all' )
  {
    if ( empty($Vjgjok5a4gci) && $V5mwq11nenf4 != 'all' ) return false;
    $this->db->select( 'mill_code, daily_sampling_percent, monthly_sampling_percent, num_of_grading_each_day, num_of_team, TIME_FORMAT(start_work_hour, "%H:%i") AS start_work_hour, TIME_FORMAT(end_work_hour, "%H:%i") AS end_work_hour,'
                     . 'time_interval_for_next_grading, break_time, max_sampling_each_day, num_of_grading_sequence, num_of_step_sequence, limit_day_to_activate_emergency_grading, waiting_list,'
                     . 'modify_user, modify_date' );
    $this->db->from( $this->parameter_table['no_alias'] );
    if ( !empty($Vjgjok5a4gci) ) $this->db->where( 'mill_code', $Vjgjok5a4gci );    
    if ( empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'all' ) return $this->db->get()->result();
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'all' ) return $this->db->get()->row();
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'daily_sampling_percent' ) return $this->db->get()->row()->daily_sampling_percent;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'monthly_sampling_percent' ) return $this->db->get()->row()->monthly_sampling_percent;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'num_of_grading_each_day' ) return $this->db->get()->row()->num_of_grading_each_day;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'num_of_team' ) return $this->db->get()->row()->num_of_team;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'start_work_hour' ) return $this->db->get()->row()->start_work_hour;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'end_work_hour' ) return $this->db->get()->row()->end_work_hour;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'time_interval_for_next_grading' ) return $this->db->get()->row()->time_interval_for_next_grading;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'break_time' ) return $this->db->get()->row()->break_time;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'max_sampling_each_day' ) return $this->db->get()->row()->max_sampling_each_day;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'num_of_grading_sequence' ) return $this->db->get()->row()->num_of_grading_sequence;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'num_of_step_sequence' ) return $this->db->get()->row()->num_of_step_sequence;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'limit_day_to_activate_emergency_grading' ) return $this->db->get()->row()->limit_day_to_activate_emergency_grading;
    if ( !empty($Vjgjok5a4gci) && $V5mwq11nenf4 == 'waiting_list' ) return $this->db->get()->row()->waiting_list;    
    return false;
  }

  public function update( $Vmpvm0zjypu0, $Vycukm2g435s )
  {
    $this->db->update( $this->parameter_table['no_alias'], $Vycukm2g435s, $Vmpvm0zjypu0 );
    return $this->db->affected_rows();
  }

  public function save( $Vycukm2g435s )
  {   
    $this->db->insert( $this->parameter_table['no_alias'], $Vycukm2g435s );
    return $this->db->insert_id();
  }
}
