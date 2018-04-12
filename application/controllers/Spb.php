<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Spb extends CI_Controller {

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
    $this->load->model( 'spb_model', 'spb' );
    $this->load->model( 'user_model', 'user' );
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
    $this->access = $this->role_access->get_crud_access( 'SPB', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'Input SPB',
      'description' => '',
      'css_files' => array(
            'assets/css/datepicker/bootstrap-datepicker.min.css'
      ),
      'js_files' => array(
	  base_url().'assets/js/datepicker/bootstrap-datepicker.min.js',
          base_url().'assets/js/scanner/jquery.scannerdetection.js',
          base_url().'assets/js/scanner/jquery.scannerdetection.compatibility.js',
          base_url().'assets/js/custom/vs.spb.js',
          base_url().'assets/js/custom/vs.access.js'
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'spb/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );    
    $this->load->view( 'modal/spb_modal_form', $V3xenore5brc );
    $this->load->view( 'modal/approval_modal_form', $V3xenore5brc );
    $this->load->view( 'templates/footer');
  }

  public function spb_list( $Vvlp2zayn0ey = 'vsp', $V0onjqf41sze = '' )
  {
    if ( $Vvlp2zayn0ey == 'vsp' || $Vvlp2zayn0ey == 'vsc' )
    {
      $V1vl4f3wf3ia = intval( $this->input->post('draw') );
      $Vxj1oacjn402 = intval( $this->input->post('start') );
      $V0fomgg0qq33 = intval( $this->input->post('length') );
      $V2tpzhezkaxa = $this->input->post('order');
      $Vpcmffkcdohy = $this->input->post('search');

      $Vxj1oacjn402_date = $this->input->post('start_date');
      $Vt4shbdrwyrv = $this->input->post('end_date');
      if ( !empty($V0onjqf41sze) ) {
        $Vpcmffkcdohy['parent_code'] = $V0onjqf41sze;
      }
      if( !empty($Vxj1oacjn402_date) ) {
          $Vpcmffkcdohy['start_date'] = $Vxj1oacjn402_date;
      }
      if( !empty($Vt4shbdrwyrv) ) {
          $Vpcmffkcdohy['end_date'] = $Vt4shbdrwyrv;
      }
      $V3xenore5brc = array();
      $Vknd1marzr2z = $this->spb->get_datatables( $Vxj1oacjn402, $V0fomgg0qq33, $V2tpzhezkaxa, $Vpcmffkcdohy );
      foreach ( $Vknd1marzr2z as $Vjqrgzfdaoia ) 
      {
        $Vxj1oacjn402++;
        $Vcyrw50em1ux = array();
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->spb_num;
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->create_date;
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->truck_num;
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->driver_name;
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->group_name;
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->region_name;
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->estate_name . ' (' . $Vjqrgzfdaoia->estate_short_name . ')';
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->division_name;
        $Vcyrw50em1ux[] = ( $Vjqrgzfdaoia->is_grading == '1' ) ? 'YES' : 'NO';
        $Vcyrw50em1ux[] = $Vjqrgzfdaoia->reason;
        $V3xenore5brc[] = $Vcyrw50em1ux;
      }

      $Vn3nfj5vah4x = array(
        "draw" => $V1vl4f3wf3ia,
        "recordsTotal" => $this->spb->count_all(),
        "recordsFiltered" => $this->spb->count_filtered( $V2tpzhezkaxa, $Vpcmffkcdohy ),
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
  
  
  public function spb_detail()
  {
    $V3xenore5brc = array();
    $Vjqrgzfdaoia_num = trim($this->input->post('spb_num'));
    if ( (!empty($Vjqrgzfdaoia_num)) && (strlen($Vjqrgzfdaoia_num) == 13) )
    {
      $Vvigdadaekjn = substr($Vjqrgzfdaoia_num, 0, 4);
      $Vhpza10hzyhq = substr($Vjqrgzfdaoia_num, 7, 2);
      if ( !empty($Vvigdadaekjn) && !empty($Vhpza10hzyhq) ) 
      {
        $V3xenore5brc = $this->spb->get_detail_by_spbnum( $Vvigdadaekjn, $Vhpza10hzyhq );
        if ( !empty($V3xenore5brc) ) 
        {
          $V3xenore5brc['spb_date'] = date('Y-m-d');
          echo json_encode( array('item' => $V3xenore5brc, 'status' => TRUE) );
          exit();
        }
      }
    }
    $V3xenore5brc['spb_date'] = date('Y-m-d');
    echo json_encode( array('item' => $V3xenore5brc, 'status' => FALSE) );
    exit();
  }
  
  public function spb_add()
  {
    $this->_form_validation( 'insert' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $Vohvlsuo3u5a = date("y");
    $Vydf0yv4kugy = date("m");
    $V0iiq1zs4tns = substr(strtoupper($this->input->post('spb_num')), 0, -4);
    $Vtq1d1c5bmvh = substr(strtoupper($this->input->post('spb_num')), -4);
    $Vjqrgzfdaoia_num = $V0iiq1zs4tns . $Vohvlsuo3u5a . $Vydf0yv4kugy . $Vtq1d1c5bmvh;
    $V3xenore5brc = array(
      'spb_num' => $Vjqrgzfdaoia_num,
      'spb_date' => $this->input->post('spb_date'),
      'group_parent_code' => $this->input->post('group_parent_code'), 
      'group_code' => $this->input->post('group_code'),
      'region_code' => $this->input->post('region_code'),
      'estate_code' => $this->input->post('estate_code'),
      'division_code' => $this->input->post('division_code'),
      'mill_code' => $this->input->post('mill_code'),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $Vouvwcb4kxmm
    );
    $Vgpquinituir = $this->spb->save( $V3xenore5brc );
    if ( $Vgpquinituir ) 
    {
      $Vmhzgefgkvbm = $this->input->post('local_time');
      $V5syncrae4y4 = $this->session->userdata('mill_code');
      $Vpzhbgxxoryb = $this->spb->call_grading_logic( $Vjqrgzfdaoia_num, $Vmhzgefgkvbm, $V5syncrae4y4 );
      echo json_encode( array('item' => $Vpzhbgxxoryb, 'status' => TRUE) );
      exit();
    } 
    else 
    {
      echo json_encode( array('status' => FALSE) );
      exit();
    }
  }
  
  public function spb_approval( )
  { 
    $V3ko0mnvzs5e = $this->input->post('user_name');
    $Vvjsqbpymziz = $this->input->post('password');
    
    if ( $V3ko0mnvzs5e == '' || $Vvjsqbpymziz == '' )
    {
        $Vkz3ogn14u5r['message'] = 'Wrong username or password.';
        $Vkz3ogn14u5r['status'] = FALSE;
        echo json_encode( $Vkz3ogn14u5r );
        exit();
    }
	
    if ( $this->user->get_active_status($V3ko0mnvzs5e) )
    {   
        $V55eztxsvkqp = $this->user->resolve_user_login($V3ko0mnvzs5e, $Vvjsqbpymziz);
        $Vvbr3u1e2r5b = $this->user->validate_by_mill( $V3ko0mnvzs5e);
        $Vfmiunbgth4s = $this->user->validate_by_position( $V3ko0mnvzs5e);
		
        if( !$V55eztxsvkqp )
        {
            $Vkz3ogn14u5r['message'] = 'Wrong username or password.';
            $Vkz3ogn14u5r['status'] = FALSE;
            echo json_encode( $Vkz3ogn14u5r );
            exit();
        }
        else if( !$Vvbr3u1e2r5b )
        {
            $Vkz3ogn14u5r['message'] = 'Wrong Mill Code.';
            $Vkz3ogn14u5r['status'] = FALSE;
            echo json_encode( $Vkz3ogn14u5r );
            exit();
        }
        else if( !$Vfmiunbgth4s )
        {
            $Vkz3ogn14u5r['message'] = 'Wrong Position.';
            $Vkz3ogn14u5r['status'] = FALSE;
            echo json_encode( $Vkz3ogn14u5r );
            exit();
        }
        else
        {
            $Vkz3ogn14u5r['status'] = TRUE;
            echo json_encode( $Vkz3ogn14u5r );
            exit();
        }
    }
    else
    {
        $Vkz3ogn14u5r['message'] = 'User is not active.';
        $Vkz3ogn14u5r['status'] = FALSE;
        echo json_encode( $Vkz3ogn14u5r );
        exit();
    }
      
  }
  
  public function spb_delete( $V0onjqf41sze )
  {
    $this->spb->delete_by_id( $V0onjqf41sze );
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

  public function unique_spb( $Vjqrgzfdaoia_num )
  { 
    if ( !empty($Vjqrgzfdaoia_num) ) 
    { 
      $Vohvlsuo3u5a = date("y");
      $Vydf0yv4kugy = date("m");
      $V0iiq1zs4tns = substr(strtoupper($Vjqrgzfdaoia_num), 0, -4);
      $Vtq1d1c5bmvh = substr(strtoupper($Vjqrgzfdaoia_num), -4);
      $Vgui0v5dwakj = $V0iiq1zs4tns . $Vohvlsuo3u5a . $Vydf0yv4kugy . $Vtq1d1c5bmvh;
      $V3xenore5brc = $this->spb->get_by_id( $Vgui0v5dwakj );
      if ( !empty($V3xenore5brc) )
      {
        if ( $Vgui0v5dwakj == $V3xenore5brc->spb_num )
        {
          $this->form_validation->set_message('unique_spb', 'This {field} already exists.');
          return FALSE;
        }
      }
    }
    return TRUE;
  }
  
  private function _form_validation( $Vvlp2zayn0ey = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('spb_num', 'SPB No', 'trim|required|xss_clean|callback_unique_spb');
    $this->form_validation->set_rules('spb_date', 'SPB Date', 'trim|required|xss_clean');
    $this->form_validation->set_rules('group', 'Group', 'trim|required|xss_clean');
    $this->form_validation->set_rules('region', 'Region', 'trim|required|xss_clean');
    $this->form_validation->set_rules('estate', 'Estate', 'trim|required|xss_clean');
    $this->form_validation->set_rules('division', 'Division', 'trim|required|xss_clean');
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