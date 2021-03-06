<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends CI_Controller {

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
    $this->load->model( 'region_model', 'region' );
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
    $this->access = $this->role_access->get_crud_access( 'Master Region', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && ($this->uri->segment(3) != 'vsc' && $this->uri->segment(3) != 'vscr') )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $data = array(
      'title' => 'Master Region',
      'description' => '',
      'js_files' => array( 
          base_url().'assets/js/custom/vs.region.js' 
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'region/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'modal/region_modal_form', $data );
    $this->load->view( 'modal/group_parent_modal', $data );
    $this->load->view( 'modal/group_modal', $data );
    $this->load->view( 'templates/footer');
  }

  public function region_list( $type = 'vsp', $id = '' )
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
        if ( $this->session->userdata('level') == 'REGION' )
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
      $list = $this->region->get_datatables( $start, $length, $order, $search );
      
      if ( $type == 'vscr' && !empty($id) )
      {
        $output = $list; 
      }
      else
      {
        foreach ( $list as $region ) 
        {
          $start++;
          $action = '';
          $row = array();
          $row[] = $region->region_code;
          $row[] = $region->region_name;
          $row[] = nl2br($region->description);
          $row[] = $region->group_name;
          $row[] = $region->group_parent_name;

          if ( $type == 'vsp' )
          {
            if ( $this->access->edit_permission == '1' )
            {
              $action .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Region" onclick="send_action('."'edit','".$region->region_code."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
            } 
            if ( $this->access->delete_permission == '1' )
            {
              $action .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Region" onclick="send_action('."'delete','".$region->region_code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
            }
          }
          $row[] = $action;
          $data[] = $row;
        }
        
        $output = array(
          'draw' => $draw,
          'recordsTotal' => $this->region->count_all(),
          'recordsFiltered' => $this->region->count_filtered( $order, $search ),
          'data' => $data,
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
 
  public function region_edit( $id )
  {
    $data = $this->region->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }

  public function region_add()
  {
    $this->_form_validation( 'insert' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'region_name' => strtoupper($this->input->post('region_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'group_code' => $this->input->post('group_code'),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $now
    );
    $this->region->save( $data );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function region_update()
  {
    $this->_form_validation( 'update' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'region_name' => strtoupper($this->input->post('region_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'group_code' => $this->input->post('group_code'),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $now
    );
    $this->region->update(array(
        'region_code' => $this->input->post('region_code')
    ), $data);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function region_delete( $id )
  {
    $this->region->delete_by_id( $id );
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
      $this->form_validation->set_rules('region_name', 'Region Name', 'trim|required|min_length[3]|max_length[50]|xss_clean|is_unique[region_mst.region_name]',
                                          array(
                                            'is_unique' => 'This %s already exists.'
                                          ));
    }
    $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
    $this->form_validation->set_rules('group_parent', 'Group Parent', 'trim|required|xss_clean');
    $this->form_validation->set_rules('group', 'Group', 'trim|required|xss_clean');

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