<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public $Vtnhccfabdro = null;
  public $Vtcujs51ixgw = null;
  public $Vpg2lony4irw = null;
  public $Vb1sy1i33vt4 = 0;
  public $Vepmtmozxdzf = 0;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('session') );
    $this->is_loggedin();
    $this->load->helper( array('url') );
    $this->load->model( 'parameter_model', 'parameter' );
    $this->load->model( 'grading_model', 'grading' );
    $this->load->model( 'priority_model', 'priority' );
    $this->load->model( 'role_access_model', 'role_access' );
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
  }
  
  public function view( $Vambozbl1bie = 'home' )
  {
    if ( ! file_exists(APPPATH.'views/home/'.$Vambozbl1bie.'.php') )
    {
      show_404();
    }
    $this->_get_target_value();
    $V3xenore5brc = array(
      'title' => ucfirst($Vambozbl1bie),
      'description' => '',
      'js_files' => array(
        base_url() . 'assets/js/custom/vs.access.js',
        base_url() . 'assets/js/custom/vs.changepass.js'
      ),
      'allowed_menu' => $this->allowed_menu,
      'daily_target' => $this->daily_target,
      'monthly_target' => $this->monthly_target
    );
    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'home/'.$Vambozbl1bie, $V3xenore5brc );
    $this->load->view( 'modal/change_modal_form', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'templates/footer' );
  }
  
  private function _get_target_value()
  {
    if ( $this->session->userdata('mill_code') )
    {
      $V4pqr5uxebur = $this->session->userdata('mill_code');
      $Vyua0brn0noy = date('Y-m-d');
      $Vydf0yv4kugy = date('n');
      $Vajlzfpin2ij = $this->parameter->get_param_value( $V4pqr5uxebur, 'num_of_grading_each_day' );
      $Vv3l0nw0k4rj = $this->grading->count_actual_grading( $V4pqr5uxebur, $Vyua0brn0noy );
      if ( !empty($Vajlzfpin2ij) && !empty($Vv3l0nw0k4rj) ) 
      $this->daily_target = round ( ($Vv3l0nw0k4rj / $Vajlzfpin2ij) * 100, 2 );    
      
      $Vjfbnz3orcfq = $this->priority->count_sampling_priority( $V4pqr5uxebur, $Vydf0yv4kugy );
      if ( !empty($Vjfbnz3orcfq['total_curr_day']) && !empty($Vjfbnz3orcfq['total_last_month']) )
      $this->monthly_target = round( ($Vjfbnz3orcfq['total_curr_day'] / $Vjfbnz3orcfq['total_last_month']) * 100, 2 );
    }
  }
  
}