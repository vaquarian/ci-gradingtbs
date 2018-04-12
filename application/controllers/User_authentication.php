<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_authentication extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->load->helper( array('html', 'url', 'form', 'security') );
    $this->load->model( 'user_model', 'user' );
  }

  public function index()
  {
    $this->_destroy_session();
    $V3xenore5brc = array(
      'title' => 'Login Page',
      'css_files' => array( 
          'assets/css/custom/checkbox-radio-bootstrap.css' 
      ),
      'js_files' => array( 
          base_url().'assets/js/custom/vs.access.js', 
          base_url().'assets/js/custom/vs.login.js' 
      )
    );
    if ( $this->uri->segment(1) == 'clear' ) 
      $this->load->view( 'login/clear', $V3xenore5brc );
    else 
      $this->load->view( 'login/index', $V3xenore5brc );
    $this->load->view( 'modal/forgot_modal_form', $V3xenore5brc );
  }

  public function send_userid()
  {     
    $this->_form_validation( 'forgot' );

    $V3ko0mnvzs5e = $this->input->post('user_name_forgot');
    $V3xenore5brc = $this->user->get_user( $this->input->post('user_name_forgot') );

    if ( !empty($V3xenore5brc) && $V3xenore5brc->email != '' ) {
        
        $V1bf2d5w14tm = "http://10.90.2.67/grading_api/sendMailforPassword.php?user_name=$V3ko0mnvzs5e";
        
        $Varasbslyfu2 = curl_init();
        
        curl_setopt($Varasbslyfu2, CURLOPT_URL, $V1bf2d5w14tm);
        
        $Vpzhbgxxoryb = curl_exec($Varasbslyfu2);
        
        curl_close($Varasbslyfu2);
        
        exit();

    } else {
      
        $V3xenore5brc = array(
            'status' => 0,
            'msg' => 'Email doesn\'t exist',
        );
        echo json_encode( $V3xenore5brc );
        exit();
        
    }
  }

  public function login_process() 
  {
    $this->_form_validation( 'login' );
    $V3ko0mnvzs5e = $this->input->post('user_name');
    $Vvjsqbpymziz = $this->input->post('password');
    if ( $this->user->get_active_status( $V3ko0mnvzs5e ) ) 
    {
      if ( $this->user->resolve_user_login( $V3ko0mnvzs5e, $Vvjsqbpymziz ) ) 
      {
	if ( $this->_is_currently_loggedin( $V3ko0mnvzs5e ) )
        {
          $Vkz3ogn14u5r['errors'] = array( 'userpass' => 'User can\'t login in another device.' );
          $Vkz3ogn14u5r['status'] = FALSE;
          echo json_encode( $Vkz3ogn14u5r );
          exit();
        }
        $this->user->update( array(
          'user_name' => $V3ko0mnvzs5e
        ), array('web_session' => session_id()) );
        $Vvo1jvopov2q = $this->user->get_user( $V3ko0mnvzs5e );
        $V3xenore5brc = array(
          'user_name'      => $Vvo1jvopov2q->user_name,
          'full_name'      => $Vvo1jvopov2q->full_name,
          'active'         => $Vvo1jvopov2q->active,
          'mill_code'      => $Vvo1jvopov2q->mill_code,
          'role_id'        => $Vvo1jvopov2q->role_id,
          'level'          => $Vvo1jvopov2q->level,
          'hierarchy_code' => $Vvo1jvopov2q->hierarchy_code,
          'logged_in'      => TRUE
        );
        $this->session->set_userdata( $V3xenore5brc );
        echo json_encode( array('status' => TRUE) );
        exit();
      } 
      else 
      {      
        $Vkz3ogn14u5r['errors'] = array( 'userpass' => 'Wrong username or password.' );
        $Vkz3ogn14u5r['status'] = FALSE;
        echo json_encode( $Vkz3ogn14u5r );
        exit();
      }
    }
    else 
    {      
      $Vkz3ogn14u5r['errors'] = array( 'userpass' => 'User is not active.' );
      $Vkz3ogn14u5r['status'] = FALSE;
      echo json_encode( $Vkz3ogn14u5r );
      exit();
    }
  }
  
  public function logout()
  {
    $this->_destroy_session();
    redirect('login');
  }

  private function _is_currently_loggedin( $V3ko0mnvzs5e )
  {
    $Vvo1jvopov2q = $this->user->get_user( $V3ko0mnvzs5e );
    if ( isset($Vvo1jvopov2q) && !empty($Vvo1jvopov2q->web_session) )
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  private function _destroy_session()
  {
    if ( $this->session->userdata('logged_in') === true ) 
    {
      $this->user->update(array(
        'user_name' => $this->session->userdata('user_name')
      ), array('web_session' => NULL));

      $Vsxdihsekerh = array('user_name', 'full_name', 'active', 'mill_code', 'role_id', 'level', 'hierarchy_code', 'logged_in');
      $this->session->unset_userdata( $Vsxdihsekerh );
      $this->session->sess_destroy();
    }
  }
  
  private function _form_validation( $Vvlp2zayn0ey = 'login' )
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $Vvlp2zayn0ey == 'forgot' )
    {
      $this->form_validation->set_rules('user_name_forgot', 'User ID', 'trim|required|xss_clean');
    } 
    else if ( $Vvlp2zayn0ey == 'clear' )
    {
      $this->form_validation->set_rules('user_name_clear', 'User ID', 'trim|required|xss_clean');
    } 
    else 
    {						
      $this->form_validation->set_rules('user_name', 'User ID', 'trim|required|xss_clean');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
    }
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
  
  public function unsess( $Vdlc15w335ke )
  {
    $this->_form_validation( 'clear' );
    $Vvo1jvopov2q = $this->user->get_user( $this->input->post('user_name_clear') );
    if ( isset($Vvo1jvopov2q) && !empty($Vvo1jvopov2q->user_name) )
    {
      if ( $Vdlc15w335ke == 'websession' )
      {
        $this->user->update(array(
          'user_name' => $Vvo1jvopov2q->user_name
        ), array('web_session' => NULL));
      } 
      else if ( $Vdlc15w335ke == 'mobsession' )
      {
        $this->user->update(array(
          'user_name' => $Vvo1jvopov2q->user_name
        ), array('mobile_login' => 0));
      }
      echo json_encode( array("status" => TRUE) );
      exit();
    }
    else 
    {      
      $Vkz3ogn14u5r['errors'] = array( 'userpass_clear' => 'User doesn\'t exist.' );
      $Vkz3ogn14u5r['status'] = FALSE;
      echo json_encode( $Vkz3ogn14u5r );
      exit();
    }
  }
    
}