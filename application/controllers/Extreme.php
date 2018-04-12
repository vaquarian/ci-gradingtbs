<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Extreme extends CI_Controller {

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
    $this->load->model( 'extreme_model', 'extreme' );
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
    $this->access = $this->role_access->get_crud_access( 'Extreme Condition and Target', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $data = array(
      'title' => 'Extreme Condition and Target',
      'description' => '',
      'css_files' => array( 
          'assets/css/custom/checkbox-radio-bootstrap.css',
          'assets/css/select/bootstrap-select.min.css'
      ),
      'js_files' => array( 
          base_url() . 'assets/js/select/bootstrap-select.min.js', 
          base_url() . 'assets/js/custom/vs.extreme.js' 
      ),
      'allowed_menu' => $this->allowed_menu
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'extreme/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'modal/extreme_modal_form', $data );
    $this->load->view( 'templates/footer');
  }

  public function extreme_list( $type = 'vsp', $id = '' )
  {
    if ( $type == 'vsp' || $type == 'vsc' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      if ( $id != '' ) {
        $search['parent_code'] = $id;
      }
      
      $data = array();
      $list = $this->extreme->get_datatables( $start, $length, $order, $search );
      foreach ( $list as $extreme ) 
      {
        $start++;
        $action = '';
        $row = array();
        $row[] = $extreme->criteria_code;
        $row[] = $extreme->criteria_name;
        $row[] = $extreme->prefix;
        $row[] = $extreme->target;
        if ( $extreme->is_extreme == '1' ) {
          $row[] = '<img src="'.base_url().'assets/img/checked.png" alt="YES">';
        } else {
          $row[] = '<img src="'.base_url().'assets/img/unchecked.png" alt="NO">';
        }
        $row[] = $extreme->extreme_value;
        
        if ( $type == 'vsp' && $this->access->edit_permission == '1' ) 
        {
            $action .= '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Edit Extreme Condition" onclick="send_action('."'edit','".$extreme->criteria_code."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
        }
        $row[] = $action;
        $data[] = $row;
      }
      
      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->extreme->count_all(),
        "recordsFiltered" => $this->extreme->count_filtered( $order, $search ),
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
    
  public function extreme_edit( $id )
  {
    $data = $this->extreme->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }
  
  public function extreme_update()
  {
    $this->_form_validation( 'update' );
    $now = date('Y-m-d H:i:s');
    $detail = $this->extreme->get_detail( $this->input->post('criteria_code') );
    if ( !empty($detail) )
    {
      $data = array(
        'prefix' => ( (empty($this->input->post('prefix'))) ? null : $this->input->post('prefix') ),
        'target' => $this->input->post('target'),
        'is_extreme' => ( ($this->input->post('is_extreme') != 'on') ? null : 1 ),
        'extreme_value' => ( ($this->input->post('is_extreme') != 'on') ? null : $this->input->post('extreme_value') ),
        'modify_user' => $this->session->userdata('user_name'),
        'modify_date' => $now
      );
      $this->extreme->update(array(
        'criteria_code' => $this->input->post('criteria_code')
      ), $data);
    }
    else 
    {
      $data = array(
        'criteria_code' => $this->input->post('criteria_code'),
        'prefix' => ( (empty($this->input->post('prefix'))) ? null : $this->input->post('prefix') ),
        'target' => $this->input->post('target'),
        'is_extreme' => ( ($this->input->post('is_extreme') != 'on') ? null : 1 ),
        'extreme_value' => ( ($this->input->post('is_extreme') != 'on') ? null : $this->input->post('extreme_value') ),
        'modify_user' => $this->session->userdata('user_name'),
        'modify_date' => $now
      );
      $this->extreme->save( $data );
    }
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  function alpha_space_only( $string )
  {
    if ( !preg_match("/^[a-zA-Z ]+$/", $string) )
    {
      $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  private function _form_validation( $type = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('prefix', 'Prefix', 'trim|max_length[10]|alpha|xss_clean');
    $this->form_validation->set_rules('target', 'Target', 'trim|required|numeric|xss_clean');
    if ( $this->input->post('is_extreme') == 'on' ) {
      $this->form_validation->set_rules('extreme_value', 'Extreme Value', 'trim|required|numeric|xss_clean');
    }
    $response = array();
    $response['status'] = TRUE;
    if ( $this->form_validation->run() === FALSE )
    {
      $errors = array();
      foreach ($this->input->post() as $key => $value)
      {
        $errors[$key] = form_error($key);
      }
      $response['errors'] = array_filter($errors);
      $response['status'] = FALSE;

      echo json_encode( $response );
      exit();
    }
  }
}