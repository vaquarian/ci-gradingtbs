<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Division extends CI_Controller {

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
    $this->load->model( 'division_model', 'division' );
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
    $this->access = $this->role_access->get_crud_access( 'Master Division', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && ($this->uri->segment(3) != 'vsc' && $this->uri->segment(3) != 'vscr') )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $data = array(
      'title' => 'Master Division',
      'description' => '',
      'js_files' => array(
          base_url().'assets/js/custom/vs.division.js'
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'division/index', $data );
    $this->load->view( 'modal/division_modal_form', $data );
    $this->load->view( 'modal/group_parent_modal', $data );
    $this->load->view( 'modal/group_modal', $data );
    $this->load->view( 'modal/region_modal', $data );
    $this->load->view( 'modal/estate_modal', $data );
    $this->load->view( 'modal/mill_modal', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'templates/footer' );
  }

  public function division_list( $type = 'vsp', $id = '' )
  {
    if ( $type == 'vsp' || $type == 'vsc' || $type == 'vscr' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      if ( $type != 'vscr' && !empty($id) ) 
      {
        $search['parent_code'] = $id;
      }
      if ( $type == 'vscr' && (!empty($this->session->userdata('level')) && !empty($this->session->userdata('hierarchy_code'))) ) 
      {
        $search['vstype'] = 'report';
        if ( $this->session->userdata('level') == 'DIVISION' )
        {
          $search['hierarchy_code'] = $this->session->userdata('hierarchy_code');
        }
        else
        {
          if ( !empty($id) )
          {
            $search['parent_code'] = $id;
          }
          else 
          {
            $search['parent_code'] = $this->session->userdata('hierarchy_code');
          }
        }
      }
      $data = array();
      $list = $this->division->get_datatables( $start, $length, $order, $search );
      if ( $type == 'vscr' && !empty($id) )
      {
        $output = $list; 
      }
      else
      {
        foreach ( $list as $division ) 
        {
          $start++;
          $action = '';
          $row = array();
          $row[] = $division->division_code;
          $row[] = $division->division_name;
          $row[] = nl2br($division->description);
          $row[] = $division->mill_name;
          $row[] = $division->estate_short_name;
          $row[] = $division->estate_name;
          $row[] = $division->region_name;
          $row[] = $division->group_name;
          $row[] = $division->group_parent_name;

          if ( $type == 'vsp' )
          {
            if ( $this->access->edit_permission == '1' ) 
            {
              $action .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Division" onclick="send_action('."'edit','".$division->division_code."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
            }
            if ( $this->access->delete_permission == '1' ) 
            {
              $action .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Division" onclick="send_action('."'delete','".$division->division_code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
            }
          }
          $row[] = $action;
          $data[] = $row;
        }

        $output = array(
          "draw" => $draw,
          "recordsTotal" => $this->division->count_all(),
          "recordsFiltered" => $this->division->count_filtered( $order, $search ),
          "data" => $data,
        );
      }
      echo json_encode( $output );
      exit();
    }
    else
    {
      show_404();
    }
  }
    
  public function division_edit( $id )
  {
    $data = $this->division->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }

  public function division_add()
  {
    $this->_form_validation( 'insert' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'division_name' => strtoupper($this->input->post('division_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'estate_code' => $this->input->post('estate_code'),
      'mill_code' => $this->input->post('mill_code'),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $now
    );
    $this->division->save( $data );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function division_update()
  {
    $this->_form_validation( 'update' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'division_name' => strtoupper($this->input->post('division_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'estate_code' => $this->input->post('estate_code'),
      'mill_code' => $this->input->post('mill_code'),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $now
    );
    $this->division->update(array(
        'division_code' => $this->input->post('division_code')
    ), $data);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function division_delete( $id )
  {
    $this->division->delete_by_id( $id );
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
  
  function unique_division( $division_name )
  {
    $estate_code = $this->input->post('estate_code');
    $new_division = $division_name . $estate_code;
    if ( !empty($estate_code) )
    {
      $data = $this->division->get_detail( $division_name, $estate_code );
      if ( !empty($data) ) 
      {
        $old_division = $data->division_name . $data->estate_code;
        if ( $new_division == $old_division ) 
        {
          $this->form_validation->set_message('unique_division', 'This %s already exists.');
          return FALSE;
        }
      }
    }
    return TRUE;
  }

  private function _form_validation( $type = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $type == 'insert' ) {
      $this->form_validation->set_rules('division_name', 'Division Name', 'trim|required|exact_length[2]|xss_clean|callback_unique_division');
    }
    $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
    $this->form_validation->set_rules('group_parent', 'Group Parent', 'trim|required|xss_clean');
    $this->form_validation->set_rules('group', 'Group', 'trim|required|xss_clean');
    $this->form_validation->set_rules('region', 'Region', 'trim|required|xss_clean');
    $this->form_validation->set_rules('estate', 'Estate', 'trim|required|xss_clean');
    $this->form_validation->set_rules('mill', 'Mill', 'trim|required|xss_clean');
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