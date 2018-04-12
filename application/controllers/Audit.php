<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller {

  public $hidden_menu = null;
  public $sub_menu_access = null;
  public $access = null;
  public $allowed_menu = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->is_loggedin();
    $this->load->helper( array('html', 'url', 'form', 'security') );
    $this->load->model( 'audit_model', 'audit' );
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
    $disallowed_sub_menu = array();
    $allowed_sub_menu = array();
    if ( !empty($this->sub_menu_access) )
    {
      foreach ( $this->sub_menu_access as $sub_menu ) 
      {
        if ( $sub_menu->view_permission == '0' ) {
          $disallowed_sub_menu[] = $sub_menu->menu_name;
        } else if ( $sub_menu->view_permission == '1' ) {
          $allowed_sub_menu[] = $sub_menu->menu_name;
        }
      }
    }
    $this->hidden_menu = $this->role_access->get_menu_access( $disallowed_sub_menu );
    $this->allowed_menu = array_merge( $allowed_sub_menu, $this->hidden_menu );
    $this->access = $this->role_access->get_crud_access( 'Audit Log', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('index');
    }
  }
  
  public function index()
  {
    $data = array(
      'title' => 'Audit Log',
      'description' => '',
      'css_files' => array( 
          'assets/css/select/bootstrap-select.min.css' 
      ),
      'js_files' => array( 
          base_url() . 'assets/js/select/bootstrap-select.min.js', 
          base_url() . 'assets/js/custom/vs.log.js'
      ),
      'allowed_menu' => $this->allowed_menu
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'log/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'templates/footer' );
  }

  public function log_list( $type = 'vsp' )
  {
    if ( $type == 'vsp' || $type == 'vsc' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      
      $data = array();
      $list = $this->audit->get_datatables( $start, $length, $order, $search );
      foreach ( $list as $log ) 
      {
        $start++;
        $row = array();
        $row[] = $log->id;
        $row[] = $log->module;        
        $row[] = $log->action;        
        $row[] = $log->info;
        $row[] = $log->create_user;
        $row[] = $log->create_date;
        $data[] = $row;
      }
      
      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->audit->count_all(),
        "recordsFiltered" => $this->audit->count_filtered( $order, $search ),
        "data" => $data,
      );

      echo json_encode( $output );
      exit();
    }
    else
    {
      show_404();
    }
  }
    
  public function log_edit( $id )
  {
    $data = $this->audit->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }
}