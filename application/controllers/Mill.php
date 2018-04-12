<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Mill extends CI_Controller {

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
    $this->access = $this->role_access->get_crud_access( 'Master Mill', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && ($this->uri->segment(3) != 'vsc' && $this->uri->segment(3) != 'vscr') )
    {
      redirect('home');
    }
  }
  
  public function index()
  { 
    $data = array(
      'title' => 'Master Mill',
      'description' => '',      
      'js_files' => array( 
          base_url().'assets/js/custom/vs.mill.js' 
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );
    $this->load->view( 'templates/header', $data );
    $this->load->view( 'mill/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'modal/mill_modal_form', $data );
    $this->load->view( 'templates/footer' );
  }

  public function mill_list( $type = 'vsp' )
  {
    if ( $type == 'vsp' || $type == 'vsc' || $type == 'vscr' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      
      $data = array();
      $start = 0;
      $list = $this->mill->get_datatables( $start, $length, $order, $search );
      foreach ( $list as $mill ) 
      {
        $action = '';
        $row = array();
        $row[] = $mill->mill_code;
        $row[] = $mill->mill_name;
        $row[] = nl2br($mill->description);
        if ( $type == 'vsp' )
        {
          if ( $this->access->edit_permission == '1' ) 
          {
            $action .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Mill" onclick="send_action('."'edit','".$mill->mill_code."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
          }
          if ( $this->access->delete_permission == '1' )
          {
            $action .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Mill" onclick="send_action('."'delete','".$mill->mill_code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
          }
        }
        $row[] = $action;
        $data[] = $row;
        $start++;
      }
      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->mill->count_all(),
        "recordsFiltered" => $this->mill->count_filtered( $order, $search ),
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
    
  public function mill_edit( $id )
  {
    $data = $this->mill->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }

  public function mill_add()
  {
    $this->_form_validation( 'insert' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'mill_name' => strtoupper($this->input->post('mill_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $now
    );
    $this->mill->save( $data );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function mill_update()
  {
    $this->_form_validation( 'update' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'mill_name' => strtoupper($this->input->post('mill_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $now
    );
    $this->mill->update(array(
                'mill_code' => $this->input->post('mill_code')
            ), $data);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function mill_delete( $id )
  {
    $this->mill->delete_by_id( $id );
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
      $this->form_validation->set_rules('mill_name', 'Mill Name', 'trim|required|max_length[50]|xss_clean|is_unique[mill_mst.mill_name]', 
                                        array(
                                          'is_unique' => 'This %s already exists.'
                                        ));
    } else {
      $this->form_validation->set_rules('mill_name', 'Mill Name', 'trim|required|max_length[50]|xss_clean');
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