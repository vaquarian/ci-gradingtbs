<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Parameter extends CI_Controller {
  
  public $Vtnhccfabdro = null;
  public $Vtcujs51ixgw = null;
  public $Vodifebfj2pm = null;
  public $Vpg2lony4irw = null;  
  public $Vjzqizbe5wg0 = null;
  
  public function __construct() 
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->is_loggedin();
    $this->load->helper( array('html', 'url', 'form', 'security') );
    $this->load->model( 'parameter_model', 'parameter' );
    $this->load->model( 'mill_model', 'mill' );
    $this->load->model( 'role_access_model', 'role_access');
    $this->is_allowed();
  }
  
  private function is_loggedin()
  {
    if ( ! $this->session->userdata('logged_in') )
    {
      redirect('login');
    }
  }
  
  private function is_allowed()
  {
    $this->sub_menu_access = $this->role_access->get_sub_menu_access( $this->session->userdata['role_id'] );
    $Vjr5yu52q4yu = array();
    $Vt0kvhbinhm4 = array();
    if ( !empty($this->sub_menu_access) )
    {
      foreach ( $this->sub_menu_access as $Vvrvinbrz4c5 ) 
      {
        if ( $Vvrvinbrz4c5->view_permission == '0' ) {
          $Vjr5yu52q4yu[] = $Vvrvinbrz4c5->menu_name;
        } else if ( $Vvrvinbrz4c5->view_permission == '1' ) {
          $Vt0kvhbinhm4[] = $Vvrvinbrz4c5->menu_name;
        }
      }
    }
    $this->hidden_menu = $this->role_access->get_menu_access( $Vjr5yu52q4yu );
    $this->allowed_menu = array_merge( $Vt0kvhbinhm4, $this->hidden_menu );
    $this->access = $this->role_access->get_crud_access( 'Grading Parameter', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  private function _get_mill_list()
  {
    if ( $this->session->userdata('user_name') != 'admin' )
    {
      if ( $this->session->userdata('mill_code') )
      {
        $this->mill_list = $this->mill->get_by_id( $this->session->userdata('mill_code') );
      } 
      else 
      {
        $this->mill_list = $this->mill->get_all();
      }
    }
    else
    {
      $this->mill_list = $this->mill->get_all();
    }
  }
  
  public function index()
  {
    $this->_get_mill_list();
    $V3xenore5brc = array(
      'title' => 'Grading Parameter',
      'description' => '',
      'css_files' => array( 
        'assets/css/timepicker/bootstrap-timepicker.min.css'
      ),
      'js_files' => array( 
        base_url().'assets/js/timepicker/bootstrap-timepicker.min.js', 
        base_url().'assets/js/custom/vs.parameter.js'
      ),
      'mill_list' => $this->mill_list,
      'allowed_menu' => $this->allowed_menu,
      'edit_permission' => $this->access->edit_permission
    );

    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'parameter/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'templates/footer');
  }
    
  public function parameter_edit( $V4pqr5uxebur )
  {
    $V3xenore5brc = $this->parameter->get_param_value( $V4pqr5uxebur );
    echo json_encode( $V3xenore5brc);
    exit();
  }
  
  public function parameter_update()
  {
    $this->_form_validation();
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'daily_sampling_percent' => $this->input->post('daily_sampling_percent'),
      'monthly_sampling_percent' => $this->input->post('monthly_sampling_percent'),
      'num_of_grading_each_day' => $this->input->post('num_of_grading_each_day'),
      'num_of_team' => $this->input->post('num_of_team'),
      'start_work_hour' => $this->input->post('start_work_hour'),
      'end_work_hour' => $this->input->post('end_work_hour'),
      'time_interval_for_next_grading' => $this->input->post('time_interval_for_next_grading'),
      'break_time' => $this->input->post('break_time'),
      'max_sampling_each_day' => $this->input->post('max_sampling_each_day'),
      'num_of_grading_sequence' => $this->input->post('num_of_grading_sequence'),
      'num_of_step_sequence' => $this->input->post('num_of_step_sequence'),
      'limit_day_to_activate_emergency_grading' => $this->input->post('limit_day_to_activate_emergency_grading'),
      'waiting_list' => $this->input->post('waiting_list'),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $Vouvwcb4kxmm
    );
    $this->parameter->update(array(
          'mill_code' => $this->input->post('mill_code')
      ), $V3xenore5brc);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  function check_start_hour( $Vskr0w21uhht )
  {
    if ( $Vskr0w21uhht >= $this->input->post('end_work_hour') )
    {
      $this->form_validation->set_message('check_start_hour', 'The %s field must be less than the End Work Hour field.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }
  
  function check_end_hour( $V1tbjbgemzjn )
  {
    if ( $V1tbjbgemzjn <= $this->input->post('start_work_hour') )
    {
      $this->form_validation->set_message('check_end_hour', 'The %s field must be greater than the Start Work Hour field.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }
  
  private function _form_validation( )
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('daily_sampling_percent', '% Daily Sampling', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('monthly_sampling_percent', '% Monthly Sampling', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('num_of_grading_each_day', 'Num of Grading Each Day', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('num_of_team', 'Num of Team', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('waiting_list', 'Waiting List', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('start_work_hour', 'Start Work Hour', 'trim|required|xss_clean|callback_check_start_hour');
    $this->form_validation->set_rules('end_work_hour', 'End Work Hour', 'trim|required|xss_clean|callback_check_end_hour');
    $this->form_validation->set_rules('time_interval_for_next_grading', 'Time Interval for Next Grading', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('break_time', 'Break Time', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('max_sampling_each_day', 'Max Sampling Each Day', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('num_of_grading_sequence', 'Num of Grading Sequence', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('num_of_step_sequence', 'Num of Step Sequence', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('limit_day_to_activate_emergency_grading', 'Limit Day to Activate Emerency Grading', 'trim|required|numeric|xss_clean');
    $Vkz3ogn14u5r = array();
    $Vkz3ogn14u5r['status'] = TRUE;
    if ( $this->form_validation->run() === FALSE )
    {
      $Vc1vco1iu5gh = array();
      foreach ($this->input->post() as $Valj2nkivdzo => $V34cplgiqc3d)
      {
        $Vc1vco1iu5gh[$Valj2nkivdzo] = form_error($Valj2nkivdzo);
      }
      $Vkz3ogn14u5r['errors'] = array_filter($Vc1vco1iu5gh);
      $Vkz3ogn14u5r['status'] = FALSE;
      echo json_encode( $Vkz3ogn14u5r );
      exit();
    }
  }
}
