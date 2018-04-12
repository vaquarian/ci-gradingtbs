<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_parent extends CI_Controller {

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
    $this->load->model( 'group_parent_model', 'group_parent' );
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
    $this->access = $this->role_access->get_crud_access( 'Master Group Parent', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }

  public function index()
  {
    $data = array(
      'title' => 'Master Group Parent',
      'description' => '',
      'js_files' => array( 
          base_url().'assets/js/custom/vs.group.parent.js' 
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'group_parent/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'modal/group_parent_modal_form', $data );
    $this->load->view( 'templates/footer');
  }

  public function group_parent_list( $type = 'vsp' )
  {
    if ( $type == 'vsp' || $type == 'vsc' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      if ( $type == 'vsc' && (!empty($this->session->userdata('level')) && !empty($this->session->userdata('hierarchy_code'))) ) 
      {
        if ( $this->session->userdata('level') == 'GROUP PARENT' )
        {
          $search['hierarchy_code'] = $this->session->userdata('hierarchy_code');
        }
      }
      $data = array();
      $list = $this->group_parent->get_datatables( $start, $length, $order, $search );
      foreach ( $list as $group_parent ) 
      {
        $start++;
        $action = '';
        $row = array();
        $row[] = $group_parent->group_parent_code;
        $row[] = $group_parent->group_parent_name;
        $row[] = nl2br($group_parent->description);

        if ( $type == 'vsp' )
        {
          if ( $this->access->edit_permission == '1' ) 
          {
            $action .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Group Parent" onclick="send_action('."'edit','".$group_parent->group_parent_code."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
          }
          if ( $this->access->delete_permission == '1' ) 
          {
            $action .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Group Parent" onclick="send_action('."'delete','".$group_parent->group_parent_code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
          }
        }
        $row[] = $action;
        $data[] = $row;
      }

      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->group_parent->count_all(),
        "recordsFiltered" => $this->group_parent->count_filtered( $order, $search ),
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
    
  public function group_parent_edit( $id )
  {
    $data = $this->group_parent->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }

  public function group_parent_add()
  {
    $this->_form_validation( 'insert' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'group_parent_name' => strtoupper($this->input->post('group_parent_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $now
    );
    $this->group_parent->save( $data );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function group_parent_update()
  {
    $this->_form_validation( 'update' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'group_parent_name' => strtoupper($this->input->post('group_parent_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $now
    );
    $this->group_parent->update(array(
        'group_parent_code' => $this->input->post('group_parent_code')
    ), $data);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function group_parent_delete( $id )
  {
    $this->group_parent->delete_by_id( $id );
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
    if ( $type == 'insert' ) {
      $this->form_validation->set_rules('group_parent_name', 'Group Parent Name', 'trim|required|min_length[3]|max_length[50]|xss_clean|is_unique[group_parent_mst.group_parent_name]',
                  array(
                      'is_unique' => 'This %s already exists.'
                  ));
    }
    $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');

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