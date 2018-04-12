<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {

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
    $this->load->model( 'holiday_model', 'holiday' );
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
    $this->access = $this->role_access->get_crud_access( 'Master Holiday', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $data = array(
      'title' => 'Master Holiday',
      'description' => '',
      'css_files' => array( 
          'assets/css/datepicker/bootstrap-datepicker.min.css',
          'assets/css/custom/checkbox-radio-bootstrap.css'
      ),
      'js_files' => array( 
          base_url().'assets/js/datepicker/bootstrap-datepicker.min.js', 
          base_url().'assets/js/custom/vs.holiday.js'
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'holiday/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'modal/holiday_modal_form' );
    $this->load->view( 'modal/mill_modal' );
    $this->load->view( 'templates/footer' );
  }

  public function holiday_list( $type = 'vsp' )
  {
    if ( $type == 'vsp' || $type == 'vsc' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      
      $data = array();
      $list = $this->holiday->get_datatables( $start, $length, $order, $search );
      foreach ( $list as $holiday ) 
      {
        $start++;
        $action = '';
        $row = array();
        $row[] = $holiday->holiday_id;
        $row[] = $holiday->holiday_date;
        $row[] = $holiday->description;
        $row[] = $holiday->mill_name;
        if ( $type == 'vsp' )
        {
          if ( $this->access->edit_permission == '1' )
          {
            $action .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Holiday" onclick="send_action('."'edit','".$holiday->holiday_id."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
          }
          if ( $this->access->delete_permission == '1' )
          {
            $action .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Holiday" onclick="send_action('."'delete','".$holiday->holiday_id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
          }
        }
        $row[] = $action;
        $data[] = $row;
      }
      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->holiday->count_distinct(),
        "recordsFiltered" => $this->holiday->count_filtered( $order, $search ),
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
  
  public function holiday_edit( $id )
  {
    $data = $this->holiday->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }

  public function holiday_add()
  {
    $this->_form_validation( 'insert' );
    $now = date('Y-m-d H:i:s');
    $date = DateTime::createFromFormat("d-m-Y", $this->input->post('holiday_date'));
    
    if ( $this->input->post('mill_option') == 'ALL' )
    {
      $data = array(
        'holiday_date' => $date->format('Y-m-d'),
        'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
        'mill_option' => $this->input->post('mill_option'),
        'mill_code' => null,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $now
      );
      $this->holiday->save( $data );
    }
    else if ( $this->input->post('mill_option') == 'SPECIFIC' ) 
    {
      $data = array(
        'holiday_date' => $date->format('Y-m-d'),
        'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
        'mill_option' => $this->input->post('mill_option'),
        'mill_code' => $this->input->post('mill_code'),
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $now
      );
      $this->holiday->save( $data );
    }    
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function holiday_update()
  {
    $this->_form_validation( 'update' );
    $now = date('Y-m-d H:i:s');
    $date = DateTime::createFromFormat("d-m-Y", $this->input->post('holiday_date'));
    
    if ( $this->input->post('mill_option') == 'ALL' )
    {
      $data = array(
        'holiday_date' => $date->format('Y-m-d'),
        'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
        'mill_option' => $this->input->post('mill_option'),
        'mill_code' => null,
        'modify_user' => 'VSYSTEM',
        'modify_date' => $now
      );
      $this->holiday->update(array(
          'holiday_id' => $this->input->post('holiday_id')
      ), $data);
    }
    else if ( $this->input->post('mill_option') == 'SPECIFIC' ) 
    {
      $data = array(
        'holiday_date' => $date->format('Y-m-d'),
        'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
        'mill_option' => $this->input->post('mill_option'),
        'mill_code' => $this->input->post('mill_code'),
        'modify_user' => 'VSYSTEM',
        'modify_date' => $now
      );
      $this->holiday->update(array(
          'holiday_id' => $this->input->post('holiday_id')
      ), $data);
    }  
    echo json_encode( array("status" => TRUE) );
    exit();
  }


  
  public function holiday_delete( $id )
  {
    // check date
    $data = $this->holiday->get_by_id( $id );
    $old_date = strtotime($data->holiday_date);
    $today = strtotime("now");
    
    $message = array();
    if($old_date < $today ){
        echo json_encode( array("status" => FALSE) );
        exit();
    }else{
        $this->holiday->delete_by_id( $id );
        echo json_encode( array("status" => TRUE) );
        exit();
    }
  }
  
  function check_validate( $string )
  {
    if ( isset($string) && $string == 'none' )
    {
      $this->form_validation->set_message('check_validate', 'The %s field is required.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }
  
  function holiday_format( $date )
  {
    if ( !empty($date) )
    {
      $date_format = strtotime( $date );
      $db_format = date( 'd-m-Y', $date_format );
      if ( $date != $db_format ) 
      {
        $this->form_validation->set_message('holiday_format', 'Wrong date format. Allowed date format : dd-mm-yyyy.');
        return FALSE;
      }
    }
    return TRUE;
  }
  
  function unique_holiday( $date )
  {
    $mill_code = ( empty($this->input->post('mill_code')) ) ? null : $this->input->post('mill_code');
    $new_date = date('Y-m-d', strtotime($date));

    $data = $this->holiday->get_detail( $new_date, $mill_code );
    if ( !empty($data) ) 
    {      
      $old_date = $data->holiday_date;
      if ( $new_date == $old_date ) 
      {
        $this->form_validation->set_message('unique_holiday', 'This %s already exists.');
        return FALSE;
      }
      return TRUE;
    } 
    else 
    {
      $data = $this->holiday->get_detail( $new_date, null );
      if ( !empty($data) )
      {
        $old_date = $data->holiday_date;
        $old_mill_option = $data->mill_option;
        if ( ($new_date == $old_date) && ($old_mill_option == 'ALL') ) 
        {
          $this->form_validation->set_message('unique_holiday', 'This %s already exists.');
          return FALSE;
        }
      }
      return TRUE;
    }
  }
  
  private function _form_validation( $type = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $type == 'insert' ) {
      $this->form_validation->set_rules('holiday_date', 'Holiday Date', 'trim|required|xss_clean|callback_holiday_format|callback_unique_holiday');
    }
    $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
    if ( $this->input->post('mill_option') == 'SPECIFIC' ) {
      $this->form_validation->set_rules('mill', 'Mill Name', 'trim|required|xss_clean');
    }
    $response = array();
    $response['status'] = TRUE;
    if ( $this->form_validation->run() == FALSE )
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