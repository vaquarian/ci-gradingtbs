<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

  public $Vtnhccfabdro = null;
  public $Vtcujs51ixgw = null;
  public $Vodifebfj2pm = null;
  public $Vpg2lony4irw = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->is_loggedin();
    $this->load->helper( array('html', 'url', 'form', 'security') );
    $this->load->model( 'role_model', 'role' );
    $this->load->model( 'web_access_model', 'web_access' );
    $this->load->model( 'mobile_access_model', 'mobile_access' );
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
    $this->access = $this->role_access->get_crud_access( 'Application Role', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'Application Role',
      'description' => '',
      'css_files' => array( 
        'assets/css/custom/checkbox-radio-bootstrap.css' 
      ),
      'js_files' => array( 
        base_url().'assets/js/custom/vs.role.js'
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'role/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'modal/role_modal_form', $V3xenore5brc );
    $this->load->view( 'modal/web_access_modal_form', $V3xenore5brc );
    $this->load->view( 'modal/mobile_access_modal_form', $V3xenore5brc );
    $this->load->view( 'templates/footer' );
  }

  public function role_list( $Vvlp2zayn0ey = 'vsp' )
  {
    if ( $Vvlp2zayn0ey == 'vsp' || $Vvlp2zayn0ey == 'vsc' )
    {
      $V1vl4f3wf3ia = intval( $this->input->post('draw') );
      $Vxj1oacjn402 = intval( $this->input->post('start') );
      $V0fomgg0qq33 = intval( $this->input->post('length') );
      $V2tpzhezkaxa = $this->input->post('order');
      $Vpcmffkcdohy = $this->input->post('search');
      
      $V3xenore5brc = array();
      $Vknd1marzr2z = $this->role->get_datatables( $Vxj1oacjn402, $V0fomgg0qq33, $V2tpzhezkaxa, $Vpcmffkcdohy );
      foreach ( $Vknd1marzr2z as $Vl1y313cfz4x ) 
      {
        $Vxj1oacjn402++;
        $Vvjscda24cms = '';
        $Vcyrw50em1ux = array();
        $Vcyrw50em1ux[] = $Vl1y313cfz4x->role_id;
        $Vcyrw50em1ux[] = $Vl1y313cfz4x->role_name;
        $Vcyrw50em1ux[] = nl2br($Vl1y313cfz4x->description);
        if ( $Vvlp2zayn0ey == 'vsp' )
        {
          if ( $this->access->edit_permission == '1' ) 
          {
            $Vvjscda24cms .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Role" onclick="send_action('."'edit','".$Vl1y313cfz4x->role_id."'".')"><i class="glyphicon glyphicon-pencil"></i></a> '
                     . '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Manage Web Access" onclick="send_action('."'web_access','".$Vl1y313cfz4x->role_id."'".')"><i class="glyphicon glyphicon-globe"></i></a> '
                     . '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Manage Mobile Access" onclick="send_action('."'mobile_access','".$Vl1y313cfz4x->role_id."'".')"><i class="glyphicon glyphicon-phone"></i></a> ';
          }
          if ( $this->access->delete_permission == '1' ) 
          {
            $Vvjscda24cms .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Role" onclick="send_action('."'delete','".$Vl1y313cfz4x->role_id."'".')"><i class="glyphicon glyphicon-trash"></i></a> ';
          }
        }
        $Vcyrw50em1ux[] = $Vvjscda24cms;
        $V3xenore5brc[] = $Vcyrw50em1ux;
      }
      
      $Vn3nfj5vah4x = array(
        "draw" => $V1vl4f3wf3ia,
        "recordsTotal" => $this->role->count_all(),
        "recordsFiltered" => $this->role->count_filtered( $V2tpzhezkaxa, $Vpcmffkcdohy ),
        "data" => $V3xenore5brc,
      );
      echo json_encode( $Vn3nfj5vah4x );
      exit();
    }
    else
    {
      show_404();
    }
  }
    
  public function role_edit( $V0onjqf41sze )
  {
    $V3xenore5brc = $this->role->get_by_id( $V0onjqf41sze );
    echo json_encode( $V3xenore5brc );
    exit();
  }

  public function role_add()
  {
    $this->_form_validation( 'insert' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'role_name' => strtoupper($this->input->post('role_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $Vouvwcb4kxmm
    );
    $this->role->save( $V3xenore5brc );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function role_update()
  {
    $this->_form_validation( 'update' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'role_name' => strtoupper($this->input->post('role_name')),
      'description' => ( empty($this->input->post('description')) ) ? null : strtoupper($this->input->post('description')),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $Vouvwcb4kxmm
    );
    $this->role->update(array(
                'role_id' => $this->input->post('role_id')
            ), $V3xenore5brc);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function role_delete( $V0onjqf41sze )
  {
    $this->role->delete_by_id( $V0onjqf41sze );
    $this->web_access->delete_by_id( $V0onjqf41sze );
    $this->mobile_access->delete_by_id( $V0onjqf41sze );
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function web_access_edit( $V0onjqf41sze )
  {
    $V3xenore5brc = $this->web_access->get_by_id( $V0onjqf41sze);
    echo json_encode( $V3xenore5brc );
    exit();
  }
  
  public function web_access_add()
  {
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'User Management',
        'view_permission' => $this->input->post('view_user_management'),
        'add_permission' => $this->input->post('add_user_management'),
        'edit_permission' => $this->input->post('edit_user_management'),
        'delete_permission' => $this->input->post('delete_user_management'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Application Role',
        'view_permission' => $this->input->post('view_role_management'),
        'add_permission' => $this->input->post('add_role_management'),
        'edit_permission' => $this->input->post('edit_role_management'),
        'delete_permission' => $this->input->post('delete_role_management'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Change Password',
        'view_permission' => $this->input->post('view_change_password'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Mill',
        'view_permission' => $this->input->post('view_mst_mill'),
        'add_permission' => $this->input->post('add_mst_mill'),
        'edit_permission' => $this->input->post('edit_mst_mill'),
        'delete_permission' => $this->input->post('delete_mst_mill'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Group Parent',
        'view_permission' => $this->input->post('view_mst_group_parent'),
        'add_permission' => $this->input->post('add_mst_group_parent'),
        'edit_permission' => $this->input->post('edit_mst_group_parent'),
        'delete_permission' => $this->input->post('delete_mst_group_parent'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Group',
        'view_permission' => $this->input->post('view_mst_group'),
        'add_permission' => $this->input->post('add_mst_group'),
        'edit_permission' => $this->input->post('edit_mst_group'),
        'delete_permission' => $this->input->post('delete_mst_group'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Region',
        'view_permission' => $this->input->post('view_mst_region'),
        'add_permission' => $this->input->post('add_mst_region'),
        'edit_permission' => $this->input->post('edit_mst_region'),
        'delete_permission' => $this->input->post('delete_mst_region'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Estate',
        'view_permission' => $this->input->post('view_mst_estate'),
        'add_permission' => $this->input->post('add_mst_estate'),
        'edit_permission' => $this->input->post('edit_mst_estate'),
        'delete_permission' => $this->input->post('delete_mst_estate'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Division',
        'view_permission' => $this->input->post('view_mst_division'),
        'add_permission' => $this->input->post('add_mst_division'),
        'edit_permission' => $this->input->post('edit_mst_division'),
        'delete_permission' => $this->input->post('delete_mst_division'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Holiday',
        'view_permission' => $this->input->post('view_mst_holiday'),
        'add_permission' => $this->input->post('add_mst_holiday'),
        'edit_permission' => $this->input->post('edit_mst_holiday'),
        'delete_permission' => $this->input->post('delete_mst_holiday'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Grading Criteria',
        'view_permission' => $this->input->post('view_mst_grading_criteria'),
        'add_permission' => $this->input->post('add_mst_grading_criteria'),
        'edit_permission' => $this->input->post('edit_mst_grading_criteria'),
        'delete_permission' => $this->input->post('delete_mst_grading_criteria'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Master Position',
        'view_permission' => $this->input->post('view_mst_position'),
        'add_permission' => $this->input->post('add_mst_position'),
        'edit_permission' => $this->input->post('edit_mst_position'),
        'delete_permission' => $this->input->post('delete_mst_position'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'SPB',
        'view_permission' => $this->input->post('view_spb'),
        'add_permission' => $this->input->post('add_spb'),
        'edit_permission' => 0,
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Grading',
        'view_permission' => $this->input->post('view_grading'),
        'add_permission' => 0,
        'edit_permission' => $this->input->post('edit_grading'),
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Grading Priority',
        'view_permission' => $this->input->post('view_grading_priority'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Grading Report',
        'view_permission' => $this->input->post('view_grading_report'), 
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Achievement Target Report',
        'view_permission' => $this->input->post('view_achievement_target_report'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Grading Parameter',
        'view_permission' => $this->input->post('view_grading_parameter'),
        'add_permission' => 0,
        'edit_permission' => $this->input->post('edit_grading_parameter'),
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Extreme Condition and Target',
        'view_permission' => $this->input->post('view_extreme_condition'),
        'add_permission' => 0,
        'edit_permission' => $this->input->post('edit_extreme_condition'),  
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Daily Report',
        'view_permission' => $this->input->post('view_daily_report'),
        'add_permission' => 0,
        'edit_permission' => 0,  
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Extreme Email Template',
        'view_permission' => $this->input->post('view_email_condition'),
        'add_permission' => $this->input->post('add_email_condition'),
        'edit_permission' => $this->input->post('edit_email_condition'),
        'delete_permission' => $this->input->post('delete_email_condition'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Report Email Template',
        'view_permission' => $this->input->post('view_email_report'),
        'add_permission' => $this->input->post('add_email_report'),
        'edit_permission' => $this->input->post('edit_email_report'),
        'delete_permission' => $this->input->post('delete_email_report'),  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Audit Log',
        'view_permission' => $this->input->post('view_audit_log'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'W'
      )
    );
    
    $this->web_access->delete_by_id( $this->input->post('role_id') );
    
    $this->web_access->save( $V3xenore5brc );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function mobile_access_edit( $V0onjqf41sze )
  {
    $V3xenore5brc = $this->mobile_access->get_by_id( $V0onjqf41sze);
    echo json_encode( $V3xenore5brc );
    exit();
  }
  
   public function mobile_access_add()
  {
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Daftar User',
        'view_permission' => $this->input->post('view_register_user'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'M'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Register Finger Print',
        'view_permission' => $this->input->post('view_register_finger_print'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'M'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Grading Mobile',
        'view_permission' => $this->input->post('view_grading_mobile'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'M'
      ),
      array(
        'role_id' => $this->input->post('role_id'),
        'menu_name' => 'Emergency Grading',
        'view_permission' => $this->input->post('view_emergency_grading'),
        'add_permission' => 0,
        'edit_permission' => 0,
        'delete_permission' => 0,  
        'create_user' => $this->session->userdata('user_name'),
        'create_date' => $Vouvwcb4kxmm,
        'app_type' => 'M'
      )
    );
    
    $this->mobile_access->delete_by_id( $this->input->post('role_id') );
    
    $this->mobile_access->save( $V3xenore5brc );
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

  private function _form_validation( $Vvlp2zayn0ey = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $Vvlp2zayn0ey == 'insert' ) {
      $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|max_length[50]|xss_clean|is_unique[role_mst.role_name]', 
                                        array(
                                          'is_unique' => 'This %s already exists.'
                                        ));
    } else {
      $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|max_length[50]|xss_clean');
    }
    $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
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