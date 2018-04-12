<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_template extends CI_Controller {
    
  public $Vtnhccfabdro = null;
  public $Vtcujs51ixgw = null;
  public $Vodifebfj2pm = null;
  public $Vpg2lony4irw = null; 
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->is_loggedin();
    $this->load->helper( array('html', 'url', 'form', 'security', 'email') );
    $this->load->model( 'report_template_model', 'report_template' );
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
    $this->access = $this->role_access->get_crud_access( 'Report Email Template', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'Report Email Template',
      'description' => '',
      'js_files' => array(
        base_url() . 'assets/js/tinymce/tinymce.js',
        base_url() . 'assets/js/tinymce/plugins/table/plugin.js',
        base_url() . 'assets/js/tinymce/plugins/paste/plugin.js',
        base_url() . 'assets/js/tinymce/plugins/spellchecker/plugin.js',
        base_url() . 'assets/js/custom/vs.template.report.js'
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'report_template/index', $V3xenore5brc );
    $this->load->view( 'modal/report_template_modal_form', $V3xenore5brc );
    $this->load->view( 'modal/estate_modal', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'templates/footer');
  }
    
  public function template_list( $Vvlp2zayn0ey = 'vsp' )
  {
    if ( $Vvlp2zayn0ey == 'vsp' || $Vvlp2zayn0ey == 'vsc' )
    {
      $V1vl4f3wf3ia = intval( $this->input->post('draw') );
      $Vxj1oacjn402 = intval( $this->input->post('start') );
      $V0fomgg0qq33 = intval( $this->input->post('length') );
      $V2tpzhezkaxa = $this->input->post('order');
      $Vpcmffkcdohy = $this->input->post('search');
      
      $V3xenore5brc = array();
      $Vknd1marzr2z = $this->report_template->get_datatables( $Vxj1oacjn402, $V0fomgg0qq33, $V2tpzhezkaxa, $Vpcmffkcdohy );
      foreach ( $Vknd1marzr2z as $Vodzcrtex3uw ) 
      {
        $Vxj1oacjn402++;
        $Vvjscda24cms = '';
        $Vcyrw50em1ux = array();
        $Vcyrw50em1ux[] = $Vodzcrtex3uw->estate_short_name;
        $Vcyrw50em1ux[] = $Vodzcrtex3uw->estate_name;
        $Vcyrw50em1ux[] = $Vodzcrtex3uw->email_to;
        $Vcyrw50em1ux[] = $Vodzcrtex3uw->email_reply_to;
        $Vcyrw50em1ux[] = $Vodzcrtex3uw->email_cc;
        $Vcyrw50em1ux[] = $Vodzcrtex3uw->email_bcc;
        $Vcyrw50em1ux[] = $Vodzcrtex3uw->email_subject;
        if ( $Vvlp2zayn0ey == 'vsp' )
        {
          if ( $this->access->edit_permission == '1' ) 
          {
            $Vvjscda24cms .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Template" onclick="send_action('."'edit','".$Vodzcrtex3uw->template_id."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
          }
          if ( $this->access->delete_permission == '1' ) 
          {
            $Vvjscda24cms .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Template" onclick="send_action('."'delete','".$Vodzcrtex3uw->template_id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
          }
        }
        $Vcyrw50em1ux[] = $Vvjscda24cms;
        $V3xenore5brc[] = $Vcyrw50em1ux;
      }

      $Vn3nfj5vah4x = array(
        "draw" => $V1vl4f3wf3ia,
        "recordsTotal" => $this->report_template->count_all(),
        "recordsFiltered" => $this->report_template->count_filtered( $V2tpzhezkaxa, $Vpcmffkcdohy ),
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
    
  public function template_add()
  {
    $this->_form_validation( 'insert' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'estate_code' => $this->input->post('estate_code'),
      'email_to' => $this->input->post('email_to'),
      'email_reply_to' => $this->input->post('email_reply_to'),
      'email_cc' => $this->input->post('email_cc'),
      'email_bcc' => $this->input->post('email_bcc'),
      'email_subject' => $this->input->post('email_subject'),
      'email_body' => $this->input->post('email_body'),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $Vouvwcb4kxmm
    );
    $this->report_template->save( $V3xenore5brc );
    echo json_encode( array("status" => TRUE) );
    exit();
  }
    
  public function template_edit( $V0onjqf41sze )
  {
    $V3xenore5brc = $this->report_template->get_by_id( $V0onjqf41sze );
    echo json_encode( $V3xenore5brc );
    exit();
  }
    
  public function template_update()
  {
    $this->_form_validation( 'update' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'estate_code' => $this->input->post('estate_code'),
      'email_to' => $this->input->post('email_to'),
      'email_reply_to' => $this->input->post('email_reply_to'),
      'email_cc' => $this->input->post('email_cc'),
      'email_bcc' => $this->input->post('email_bcc'),
      'email_subject' => $this->input->post('email_subject'),
      'email_body' => $this->input->post('email_body'),  
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $Vouvwcb4kxmm
    );
    $this->report_template->update(array(
        'template_id' => $this->input->post('template_id')
    ), $V3xenore5brc);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function template_delete( $V0onjqf41sze )
  {
    $this->report_template->delete_by_id( $V0onjqf41sze );
    echo json_encode( array("status" => TRUE) );
    exit();
  }
    
  private function _form_validation( $Vvlp2zayn0ey = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('estate', 'Estate', 'trim|required|xss_clean');
    $this->form_validation->set_rules('email_to', 'Email To', 'trim|required|xss_clean');
    $this->form_validation->set_rules('email_reply_to', 'Email Reply-To', 'trim|xss_clean');
    $this->form_validation->set_rules('email_cc', 'Email CC', 'trim|xss_clean');
    $this->form_validation->set_rules('email_bcc', 'Email BCC', 'trim|xss_clean');
    $this->form_validation->set_rules('email_subject', 'Email Subject', 'trim|required|xss_clean');
    $this->form_validation->set_rules('email_body', 'Email Body', 'trim|required|xss_clean');
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
