<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {

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
    $this->load->model( 'user_model', 'user' );
    $this->load->model( 'access_model', 'access' );
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
    $this->access = $this->role_access->get_crud_access( 'Change Password', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && ($this->uri->segment(2) != 'change' || $this->uri->segment(2) != 'reset') )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'Change Password',
      'description' => '',
      'js_files' => array(
          base_url() . 'assets/js/custom/vs.md5.js', 
          base_url() . 'assets/js/custom/vs.access.js', 
          base_url() . 'assets/js/custom/vs.changepass.js'
      ),
      'allowed_menu' => $this->allowed_menu
    );
    
    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'access/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'templates/footer' );
  }
    
  public function generate_password( $Vvlp2zayn0ey = 'sys', $Vhb3qisraijo = '' ) 
  {
    if ( $Vvlp2zayn0ey == 'sys' )
    {
      $Vvjsqbpymziz = $this->access->get_default_password();
      return $Vvjsqbpymziz;
    }
    $Vvjsqbpymziz = $this->access->get_random_password( $Vhb3qisraijo );
    return $Vvjsqbpymziz;
  }
  
  public function update_password( $Vvlp2zayn0ey = 'reset' )
  {
    if ( $Vvlp2zayn0ey == 'reset' || $Vvlp2zayn0ey == 'change' ) 
    { 
      $this->_form_validation( $Vvlp2zayn0ey );
      $V3ko0mnvzs5e = ($Vvlp2zayn0ey == 'change') ? $this->session->userdata('user_name') : $this->input->post('user_name_reset');
      $Vouvwcb4kxmm = date('Y-m-d H:i:s');
      $V3xenore5brc = array(
        'password' => md5( $this->input->post('new_password') ),
        'should_change_pass' => '0',
        'change_pass_date' => $Vouvwcb4kxmm, 
        'modify_user' => $this->session->userdata('user_name'),
        'modify_date' => $Vouvwcb4kxmm,
        'info' => $this->input->post('new_password'),
      );
      $this->user->update(array(
          'user_name' => $V3ko0mnvzs5e
      ), $V3xenore5brc);
      echo json_encode( array("status" => TRUE) );
      exit();
    }
    else
    {
      show_404();
    }
  }
        
  public function valid_password( $Vvjsqbpymziz = '' )
  {
    $Vvjsqbpymziz = trim( $Vvjsqbpymziz );
    $Vynppnnecxqf = '/[a-z]/';
    $Vyp2eookgz5t = '/[A-Z]/';
    $Vyon2b3o22sz = '/[0-9]/';
    $V5c4hmgmcogt = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
    
    if ( empty($Vvjsqbpymziz) )
    {
      $this->form_validation->set_message('valid_password', 'The {field} field is required.');
      return FALSE;
    }
    if ( preg_match_all($Vynppnnecxqf, $Vvjsqbpymziz) < 1 )
    {
      $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
      return FALSE;
    }
    if ( preg_match_all($Vyp2eookgz5t, $Vvjsqbpymziz) < 1 )
    {
      $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
      return FALSE;
    }
    if ( preg_match_all($Vyon2b3o22sz, $Vvjsqbpymziz) < 1 )
    {
      $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
      return FALSE;
    }
    if ( strlen($Vvjsqbpymziz) < 8 )
    {
      $this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
      return FALSE;
    }
    if ( strlen($Vvjsqbpymziz) > 50 )
    {
      $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 50 characters in length.');
      return FALSE;
    }
    return TRUE;
  }
  
  public function matches_old_password( $Vvjsqbpymziz = '' )
  { 
    if ( !empty($Vvjsqbpymziz) ) 
    { 
      $V3ko0mnvzs5e = $this->session->userdata('user_name');
      $Vlozmhhdsar1 = md5( $Vvjsqbpymziz );
      $Vvo1jvopov2q = $this->user->get_user( $V3ko0mnvzs5e );
      if ( !empty($Vvo1jvopov2q) && $Vlozmhhdsar1 != $Vvo1jvopov2q->password )
      {
        $this->form_validation->set_message('matches_old_password', 'The {field} field does not match the password inside the database.');
        return FALSE;
      }
      return TRUE;
    }
    return TRUE;
  }
  
  private function _form_validation( $Vvlp2zayn0ey = 'reset' ) 
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $Vvlp2zayn0ey == 'change' ) {
      $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|callback_matches_old_password');
    }
    $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|callback_valid_password');
    $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'trim|required|xss_clean|matches[new_password]');
    $Vkz3ogn14u5r = array();
    $Vkz3ogn14u5r['status'] = TRUE;
    if ( $this->form_validation->run() == FALSE )
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