<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Grading extends CI_Controller {

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
    $this->load->model( 'grading_model', 'grading' );
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
    $this->access = $this->role_access->get_crud_access( 'Grading', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'Grading',
      'description' => '',
      'css_files' => array(
            'assets/css/datepicker/bootstrap-datepicker.min.css'
      ),  
      'js_files' => array(
          base_url().'assets/js/datepicker/bootstrap-datepicker.min.js',
          base_url().'assets/js/custom/vs.grading.js' 
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'grading/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'modal/grading_modal_form' );
    $this->load->view( 'modal/grading_detail_modal_form' );
    $this->load->view( 'templates/footer');
  }

  public function grading_list( $Vvlp2zayn0ey = 'vsp' )
  {
    if ( $Vvlp2zayn0ey == 'vsp' )
    {
      $V1vl4f3wf3ia = intval( $this->input->post('draw') );
      $Vxj1oacjn402 = intval( $this->input->post('start') );
      $V0fomgg0qq33 = intval( $this->input->post('length') );
      $V2tpzhezkaxa = $this->input->post('order');
      $Vpcmffkcdohy = $this->input->post('search');
      
      $Vxj1oacjn402_date = $this->input->post('start_date');
      $Vt4shbdrwyrv = $this->input->post('end_date');
      
      if ( $Vxj1oacjn402_date != '' ) {
          $Vpcmffkcdohy['start_date'] = $Vxj1oacjn402_date;
      }
      
      if ( $Vt4shbdrwyrv != '' ) {
          $Vpcmffkcdohy['end_date'] = $Vt4shbdrwyrv;
      }
      
      $V3xenore5brc = array();
      $Vknd1marzr2z = $this->grading->get_datatables( $Vxj1oacjn402, $V0fomgg0qq33, $V2tpzhezkaxa, $Vpcmffkcdohy );
      foreach ( $Vknd1marzr2z as $V42rkcu4nxzx ) 
      {
        $Vxj1oacjn402++;
        $Vvjscda24cms = '';
        $Vcyrw50em1ux = array();
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->spb_num;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->group_name;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->region_name;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->estate_name . ' (' . $V42rkcu4nxzx->estate_short_name . ')';
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->division_name;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->create_date;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->time_start;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->time_end;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->truck_num;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->foreman_name;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->witness_name;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->assistant_name;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->modify_user;
        $Vcyrw50em1ux[] = $V42rkcu4nxzx->modify_date;
        
        if ( $Vvlp2zayn0ey == 'vsp' && $this->access->edit_permission == '1' )
        {
          $Vvjscda24cms .= '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Edit SPB" onclick="send_action('."'edit','".$V42rkcu4nxzx->spb_num."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
        }
        $Vcyrw50em1ux[] = $Vvjscda24cms;
        $V3xenore5brc[] = $Vcyrw50em1ux;
      }
      
      $Vn3nfj5vah4x = array(
        "draw" => $V1vl4f3wf3ia,
        "recordsTotal" => $this->grading->count_all(),
        "recordsFiltered" => $this->grading->count_filtered( $V2tpzhezkaxa, $Vpcmffkcdohy ),
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
  
  public function grading_edit()
  {
    $Vx02fcin305m = $this->input->post('spb_num');
    $V3xenore5brc = $this->grading->get_by_spbnum( $Vx02fcin305m );
    echo json_encode( $V3xenore5brc );
    exit();
  }
  
  public function grading_detail()
  {
    $V1vl4f3wf3ia = intval( $this->input->post('draw') );
    $Vxj1oacjn402 = intval( $this->input->post('start') );
    $V0fomgg0qq33 = intval( $this->input->post('length') );
    $V2tpzhezkaxa = $this->input->post('order');
    $Vpcmffkcdohy = $this->input->post('search');
    $Vx02fcin305m = $this->input->post('spb_num');
    if ( $Vx02fcin305m != '' ) {
      $Vpcmffkcdohy['spb_num'] = $Vx02fcin305m;
    }
    
    $V3xenore5brc = array();
    $Vknd1marzr2z = $this->grading->get_detail_datatables( $Vxj1oacjn402, $V0fomgg0qq33, $V2tpzhezkaxa, $Vpcmffkcdohy );
    foreach ( $Vknd1marzr2z as $Vqlilbta3llt ) 
    {
      $Vxj1oacjn402++; 
      $Vcyrw50em1ux = array();
      $Vcyrw50em1ux[] = $Vqlilbta3llt->criteria_name;
      $Vcyrw50em1ux[] = ( $Vqlilbta3llt->is_extreme == '1' ) ? 'YES' : 'NO';
      $Vcyrw50em1ux[] = $Vqlilbta3llt->value;
      if($Vqlilbta3llt->type == 'INTERNAL'){
      	$Vcyrw50em1ux[] = $Vqlilbta3llt->percent;
      }else{
	$Vcyrw50em1ux[] = '';
      }
      $Vcyrw50em1ux[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Edit Detail" onclick="send_action('."'edit_detail','".$Vx02fcin305m."','".$Vqlilbta3llt->criteria_code."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';
      $V3xenore5brc[] = $Vcyrw50em1ux;
    }

    $Vn3nfj5vah4x = array(
      "draw" => $V1vl4f3wf3ia,
      "recordsTotal" => $this->grading->count_all_detail( $Vpcmffkcdohy ),
      "recordsFiltered" => $this->grading->count_filtered_detail( $V2tpzhezkaxa, $Vpcmffkcdohy ),
      "data" => $V3xenore5brc,
    );

    echo json_encode( $Vn3nfj5vah4x );
    exit();
  }
  
  public function grading_detail_edit()
  {
    $Vx02fcin305m = $this->input->post('spb_num');
    $Vfj2ulo3mgft = $this->input->post('criteria_code');
    $V3xenore5brc = $this->grading->get_detail( $Vx02fcin305m, $Vfj2ulo3mgft );
    if ( empty($V3xenore5brc) ) {
      $V3xenore5brc = $this->grading->get_criteria( $Vfj2ulo3mgft );
    }
    echo json_encode( $V3xenore5brc );
    exit();
  }
  
  public function grading_update()
  {
    $this->_form_validation( 'update' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $V3xenore5brc = array(
      'brondolan_on_spb' => $this->input->post('brondolan_on_spb'),
      'actual_brondolan_on_pks' => $this->input->post('actual_brondolan_on_pks'),
      'num_of_janjang' => $this->input->post('num_of_janjang'),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $Vouvwcb4kxmm
    );
    $this->grading->update(array(
        'spb_num' => $this->input->post('spb_num')
    ), $V3xenore5brc);
    
    
    $V3xenore5brc1 = array(     
      'truck_num' => $this->input->post('truck_num'),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $Vouvwcb4kxmm
    );
    $this->grading->update_spb(array(
        'spb_num' => $this->input->post('spb_num')
    ), $V3xenore5brc1);
    
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function grading_detail_update()
  {
    $this->_form_validation( 'update_detail' );
    $Vouvwcb4kxmm = date('Y-m-d H:i:s');
    $Vqlilbta3llt = $this->grading->get_detail( $this->input->post('spb_num_master'), $this->input->post('criteria_code') );
    if ( !empty($Vqlilbta3llt) )
    {
      $V3xenore5brc = array(
        'value' => $this->input->post('value')
      );
      $this->grading->update_detail(array(
        'spb_num' => strtoupper($this->input->post('spb_num_master')),
        'criteria_code' => strtoupper($this->input->post('criteria_code'))
      ), $V3xenore5brc);
    }
    else 
    {
      $V3xenore5brc = array(
        'spb_num' => strtoupper($this->input->post('spb_num_master')),
        'criteria_code' => strtoupper($this->input->post('criteria_code')),
        'value' => $this->input->post('value')
      );
      $this->grading->save_detail( $V3xenore5brc );
    }
    $Vqlilbta3llt = $this->grading->calculate_percent( $this->input->post('spb_num_master'), $this->input->post('criteria_code') );
    $V3xenore5brc = array(
      'num_of_janjang' => $Vqlilbta3llt['value_total'],
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $Vouvwcb4kxmm
    );
    $this->grading->update(array(
        'spb_num' => $this->input->post('spb_num_master')
    ), $V3xenore5brc);
    echo json_encode( array( 'value_total' => $Vqlilbta3llt['value_total'], 'status' => TRUE) );
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

  private function _form_validation( $Vvlp2zayn0ey = 'update' )
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $Vvlp2zayn0ey == 'update' )
    {
      $this->form_validation->set_rules('truck_num', 'Truck Plate No', 'trim|xss_clean');  
      $this->form_validation->set_rules('brondolan_on_spb', 'Brondolan on SPB', 'trim|required|numeric|xss_clean');
      $this->form_validation->set_rules('actual_brondolan_on_pks', 'Actual Brondolan on PKS', 'trim|required|numeric|xss_clean');
    } 
    else if ( $Vvlp2zayn0ey == 'update_detail' )
    {
      $this->form_validation->set_rules('value', 'Value', 'trim|required|numeric|xss_clean');
    }
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