<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public $Vtnhccfabdro = null;
  public $Vtcujs51ixgw = null;
  public $Vodifebfj2pm = null;
  public $Vpg2lony4irw = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->is_loggedin();
    $this->load->helper( array('html', 'url', 'email', 'form', 'security') );
    $this->load->model( 'user_model', 'user' );
    $this->load->model( 'access_model', 'pass' );
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
    $this->access = $this->role_access->get_crud_access( 'User Management', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(2) != 'user_session' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'User Management',
      'description' => '',
      'css_files' => array( 
          'assets/css/custom/checkbox-radio-bootstrap.css' 
      ),
      'js_files' => array(
          base_url().'assets/js/custom/vs.access.js', 
          base_url().'assets/js/custom/vs.user.js' 
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );
    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'user/index', $V3xenore5brc ); 
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'modal/user_modal_form' );
    $this->load->view( 'modal/reset_modal_form' );
    $this->load->view( 'modal/position_modal' );
    $this->load->view( 'modal/mill_modal' );
    $this->load->view( 'modal/level_modal' );
    $this->load->view( 'modal/group_parent_modal' );
    $this->load->view( 'modal/group_modal' );
    $this->load->view( 'modal/region_modal' );
    $this->load->view( 'modal/estate_modal' );
    $this->load->view( 'modal/role_modal' );
    $this->load->view( 'templates/footer' );
  }

  public function user_list( $Vvlp2zayn0ey = 'vsp' )
  {
    if ( $Vvlp2zayn0ey == 'vsp' || $Vvlp2zayn0ey == 'vsc' )
    {
      $V1vl4f3wf3ia = intval( $this->input->post('draw') );
      $Vxj1oacjn402 = intval( $this->input->post('start') );
      $V0fomgg0qq33 = intval( $this->input->post('length') );
      $V2tpzhezkaxa = $this->input->post('order');
      $Vpcmffkcdohy = $this->input->post('search');
      if ( $this->session->userdata('user_name') != 'admin' )
        $Vpcmffkcdohy['xpe'] = 'admin';
      $V3xenore5brc = array();
      $Vknd1marzr2z = $this->user->get_datatables( $Vxj1oacjn402, $V0fomgg0qq33, $V2tpzhezkaxa, $Vpcmffkcdohy );
      foreach ( $Vknd1marzr2z as $Vvo1jvopov2q ) 
      {
        $Vxj1oacjn402++;
        $Vvjscda24cms = '';
        $Vcyrw50em1ux = array();
        $Vcyrw50em1ux[] = strtoupper($Vvo1jvopov2q->user_name);
        $Vcyrw50em1ux[] = strtoupper($Vvo1jvopov2q->email);
        $Vcyrw50em1ux[] = $Vvo1jvopov2q->position_name;
        $Vcyrw50em1ux[] = $Vvo1jvopov2q->mill_name;
        $Vcyrw50em1ux[] = $Vvo1jvopov2q->role_name;
        $Vcyrw50em1ux[] = $Vvo1jvopov2q->level;
        $Vcyrw50em1ux[] = $Vvo1jvopov2q->hierarchy_name;
        if ( $Vvo1jvopov2q->active == '1' ) {
          $Vcyrw50em1ux[] = '<img src="'.base_url().'assets/img/checked.png" alt="YES">';
        } else {
          $Vcyrw50em1ux[] = '<img src="'.base_url().'assets/img/unchecked.png" alt="NO">';
        }
        if ( $Vvlp2zayn0ey == 'vsp' )
        {
          if ( $this->access->edit_permission == '1' ) 
          {
            $Vvjscda24cms .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit User" onclick="send_action('."'edit','".$Vvo1jvopov2q->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a> '
                     . '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Reset Password" onclick="send_action('."'reset','".$Vvo1jvopov2q->id."'".')"><i class="glyphicon glyphicon-lock"></i></a> ';
          }        
          if ( $this->access->delete_permission == '1' )
          {
            $Vvjscda24cms .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete User" onclick="send_action('."'delete','".$Vvo1jvopov2q->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';                     
          }
        }
        $Vcyrw50em1ux[] = $Vvjscda24cms;
        $V3xenore5brc[] = $Vcyrw50em1ux;
      }
      
      $Vn3nfj5vah4x = array(
        "draw" => $V1vl4f3wf3ia,
        "recordsTotal" => $this->user->count_all(),
        "recordsFiltered" => $this->user->count_filtered( $Vpcmffkcdohy ),
        "data" => $V3xenore5brc
      );
      echo json_encode( $Vn3nfj5vah4x );
      exit();
    }
    else
    {
      show_404();
    }
  }

  public function user_session()
  {
    if ( $this->session->userdata('user_name') ) 
    {
      $V3xenore5brc = $this->user->get_session_data( $this->session->userdata('user_name') );
      echo json_encode( $V3xenore5brc );
      exit();
    }
  }
  
  public function user_edit( $V0onjqf41sze )
  {
    $V3xenore5brc = $this->user->get_by_id( $V0onjqf41sze );
    echo json_encode( $V3xenore5brc );
    exit();
  }

  public function user_add()
  {
    $this->_form_validation( 'insert' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'user_name' => strtolower($this->input->post('user_name')),
      'password' => $this->pass->get_default_password(),
      'full_name' => ( empty($this->input->post('full_name')) ? null : strtoupper($this->input->post('full_name')) ),
      'email' => ( empty($this->input->post('email')) ? null : $this->input->post('email') ),
      'imei' => ( empty($this->input->post('imei')) ? null : $this->input->post('imei') ),
      'position_id' => $this->input->post('position_id'),
      'mill_code' => $this->input->post('mill_code'),
      'role_id' => $this->input->post('role_id'),
      'level' => ( empty($this->input->post('level')) ? null : $this->input->post('level') ),
      'hierarchy_code' => ( empty($this->input->post('hierarchy_code')) ? null : $this->input->post('hierarchy_code') ),
      'active' => ( ($this->input->post('active') != 'on') ? 0 : 1 ),
      'change_pass_date' => null,
      'should_change_pass' => 1,
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $Vouvwcb4kxmm
    );
    $this->user->save( $V3xenore5brc );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function user_update()
  {
    $this->_form_validation( 'update' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'user_name' => strtolower($this->input->post('user_name')),
      'full_name' => ( empty($this->input->post('full_name')) ? null : strtoupper($this->input->post('full_name')) ),
      'email' => ( empty($this->input->post('email')) ? null : $this->input->post('email') ),
      'imei' => ( empty($this->input->post('imei')) ? null : $this->input->post('imei') ),
      'position_id' => $this->input->post('position_id'),
      'mill_code' => $this->input->post('mill_code'),
      'role_id' => $this->input->post('role_id'),
      'level' => ( empty($this->input->post('level')) ? null : $this->input->post('level') ),
      'hierarchy_code' => ( empty($this->input->post('hierarchy_code')) ? null : $this->input->post('hierarchy_code') ),
      'active' => ( ($this->input->post('active') != 'on') ? 0 : 1 ),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $Vouvwcb4kxmm
    );
    $this->user->update(array(
        'id' => $this->input->post('id')    
    ), $V3xenore5brc);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function user_delete( $V0onjqf41sze )
  {
    $this->user->delete_by_id( $V0onjqf41sze );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  function alpha_space_only( $Vkhlpybea3vk )
  {
    if ( !preg_match("/^[a-zA-Z ]+$/", $Vkhlpybea3vk) )
    {
      $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }
  
  function username_combination( $Vkhlpybea3vk )
  {
    if ( !preg_match("/^[a-zA-Z0-9_.]*$/", $Vkhlpybea3vk) )
    {
      $this->form_validation->set_message('username_combination', 'The %s field must contain only alphabets, numerics, point and underscore.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  private function _form_validation( $Vvlp2zayn0ey = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $Vvlp2zayn0ey == 'insert' ) {
      $this->form_validation->set_rules('user_name', 'User ID', 'trim|required|min_length[5]|max_length[50]|xss_clean|callback_username_combination|is_unique[user_mst.user_name]', 
                                        array(
                                          'is_unique' => 'This %s already exists.'
                                        ));
      $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean|is_unique[user_mst.email]', 
                                        array(
                                          'is_unique' => 'This %s already exists.'
                                        ));
    } else if ( $Vvlp2zayn0ey == 'update' ) {
      $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[5]|max_length[50]|xss_clean|callback_username_combination');
      $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
    }
    $this->form_validation->set_rules('imei', 'IMEI', 'trim|numeric|exact_length[15]|xss_clean');
    $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[50]|xss_clean|callback_alpha_space_only');
    $this->form_validation->set_rules('position', 'Position Title', 'trim|required|xss_clean');
    $this->form_validation->set_rules('mill', 'Mill', 'trim|required|xss_clean');
    $this->form_validation->set_rules('level', 'Level', 'trim|xss_clean');
    $this->form_validation->set_rules('hierarchy', 'Hierarchy', 'trim|xss_clean');
    $this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
    $Vkz3ogn14u5r = array();
    $Vkz3ogn14u5r['status'] = TRUE;
    if ( $this->form_validation->run() === FALSE )
    {
      $Vc1vco1iu5gh = array();
      foreach ( $this->input->post() as $Valj2nkivdzo => $V34cplgiqc3d )
      {
        $Vc1vco1iu5gh[$Valj2nkivdzo] = form_error($Valj2nkivdzo);
      }
      $Vkz3ogn14u5r['errors'] = array_filter( $Vc1vco1iu5gh );
      $Vkz3ogn14u5r['status'] = FALSE;
      echo json_encode( $Vkz3ogn14u5r );
      exit();
    }
  }
    
}