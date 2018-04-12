<?php
/* 
 * @author  Vincent
 * @version CI3
 */
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

defined('BASEPATH') OR exit('No direct script access allowed');

class Priority extends CI_Controller {

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
    $this->load->model( 'priority_model', 'priority' );    
    $this->load->model( 'role_access_model', 'role_access');
    $this->is_allowed();
    $this->exec_sp();
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
    $this->access = $this->role_access->get_crud_access( 'Grading Priority', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  private function exec_sp()
  {
    $V4pqr5uxebur = $this->session->userdata('mill_code');
    $V3ko0mnvzs5e = $this->session->userdata('user_name');
    $V3xenore5brc = $this->priority->call_grading_priority( $V4pqr5uxebur, $V3ko0mnvzs5e );
    if ( !empty($V3xenore5brc) ) 
    {
      if ( $V4pqr5uxebur == $V3xenore5brc->mill_code ) 
      {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    return FALSE;
  }

  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'Grading Priority',
      'description' => '',
      'js_files' => array(
          base_url().'assets/js/custom/vs.priority.js' 
      ),
      'allowed_menu' => $this->allowed_menu
    );
    
    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'priority/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'templates/footer');
  }

  public function priority_list( $Vvlp2zayn0ey = 'vsp' )
  {
    if ( $Vvlp2zayn0ey == 'vsp' )
    {
      $V1vl4f3wf3ia = intval( $this->input->post('draw') );
      $Vxj1oacjn402 = intval( $this->input->post('start') );
      $V0fomgg0qq33 = intval( $this->input->post('length') );
      $V2tpzhezkaxa = $this->input->post('order');
      $Vpcmffkcdohy = $this->input->post('search');
      
      $V3xenore5brc = array();
      $Vknd1marzr2z = $this->priority->get_datatables( $Vxj1oacjn402, $V0fomgg0qq33, $V2tpzhezkaxa, $Vpcmffkcdohy );
      foreach ( $Vknd1marzr2z as $Voe4k4yq3qli ) 
      {
        $Vxj1oacjn402++;
        $Vcyrw50em1ux = array();
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->estate_short_name;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->division_name;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->num_of_truck_last_month;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->actual_num_of_truck_coming;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->estimate_sampling;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->on_days;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->estimate_num_of_sampling;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->actual_num_of_sampling;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->gap;
        $Vcyrw50em1ux[] = $Voe4k4yq3qli->percent_gap;
        $V3xenore5brc[] = $Vcyrw50em1ux;
      }
      
      $Vn3nfj5vah4x = array(
        "draw" => $V1vl4f3wf3ia,
        "recordsTotal" => $this->priority->count_all(),
        "recordsFiltered" => $this->priority->count_filtered( $V2tpzhezkaxa, $Vpcmffkcdohy ),
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
  
  private function _get_priority_data()
  {
    $V3xenore5brc = array();
    $Vknd1marzr2z = $this->priority->get_all();
    if ( !empty($Vknd1marzr2z) )
    {
      foreach ( $Vknd1marzr2z as $Voe4k4yq3qli ) 
      {
        $Vxj1oacjn402++;
        $Vcyrw50em1ux = array();
        $Vcyrw50em1ux['estate_code'] = $Voe4k4yq3qli->estate_short_name;
        $Vcyrw50em1ux['division_name'] = $Voe4k4yq3qli->division_name;
        $Vcyrw50em1ux['last_month_num_truck'] = $Voe4k4yq3qli->num_of_truck_last_month;
        $Vcyrw50em1ux['actual_num_truck'] = $Voe4k4yq3qli->actual_num_of_truck_coming;
        $Vcyrw50em1ux['last_month_sampling'] = $Voe4k4yq3qli->estimate_sampling;
        $Vcyrw50em1ux['on_days'] = $Voe4k4yq3qli->on_days;
        $Vcyrw50em1ux['estimate_sampling'] = $Voe4k4yq3qli->estimate_num_of_sampling;
        $Vcyrw50em1ux['actual_sampling'] = $Voe4k4yq3qli->actual_num_of_sampling;
        $Vcyrw50em1ux['gap'] = $Voe4k4yq3qli->gap;
        $Vcyrw50em1ux['percent_gap'] = $Voe4k4yq3qli->percent_gap;
        $V3xenore5brc[] = $Vcyrw50em1ux;
      }
      return $V3xenore5brc;
    }
    return false;
  }
  
  public function priority_export( $Vvlp2zayn0ey = 'xls' )
  {
    if ( $Vvlp2zayn0ey == 'xls' )
    {
      $Vsakcbvhwygc = new Spreadsheet();
      $Vsakcbvhwygc->getProperties()->setCreator( $this->session->userdata('user_name') )
                                   ->setLastModifiedBy( $this->session->userdata('user_name') )
                                   ->setTitle( 'Grading Priority' )
                                   ->setSubject( 'Grading Priority' )
                                   ->setDescription( 'Grading Priority' );
      $V3xenore5brc = $this->_get_priority_data();      
      $Vsakcbvhwygc->setActiveSheetIndex(0);
      $Vlofblbjztea = $Vsakcbvhwygc->getActiveSheet();      
      $Vlofblbjztea->setCellValue( 'A1', 'GRADING PRIORITY' )->getStyle('A1')->getFont()->applyFromArray(
        array( 'name' => 'Calibri', 'bold' => TRUE, 'color' => array( 'rgb' => '808080' ), 'size' => 16 )
      );      
      $Vlofblbjztea->mergeCells('A1:K1')->getStyle('A1:K1')->getAlignment()->applyFromArray(
        array( 'horizontal' => Alignment::HORIZONTAL_CENTER )
      );
      $Vlofblbjztea->setCellValue( 'A3', '#')
                  ->setCellValue( 'B3', 'Estate' )
                  ->setCellValue( 'C3', 'Division' )
                  ->setCellValue( 'D3', '# Last Month Truck' )
                  ->setCellValue( 'E3', '# Actual Truck' )
                  ->setCellValue( 'F3', '# Last Month Sampling' )
                  ->setCellValue( 'G3', 'On Days' )
                  ->setCellValue( 'H3', '# Current Day Estimate Sampling' )
                  ->setCellValue( 'I3', '# Current Day Actual Sampling' )
                  ->setCellValue( 'J3', 'Gap' )
                  ->setCellValue( 'K3', '% Gap' );
      
      $Vkk3dcyvccoy = 5;
      foreach ( $V3xenore5brc as $Vx5rdmjfk1az => $V3xenore5brcRow ) 
      {
        $Vcyrw50em1ux = $Vkk3dcyvccoy + $Vx5rdmjfk1az;
        $Vlofblbjztea->insertNewRowBefore( $Vcyrw50em1ux, 1 );
        $Vlofblbjztea->setCellValue( 'A' . $Vcyrw50em1ux, $Vx5rdmjfk1az + 1 )
                    ->setCellValue( 'B' . $Vcyrw50em1ux, $V3xenore5brcRow['estate_code'] )
                    ->setCellValue( 'C' . $Vcyrw50em1ux, $V3xenore5brcRow['division_name'] )
                    ->setCellValue( 'D' . $Vcyrw50em1ux, $V3xenore5brcRow['last_month_num_truck'] )
                    ->setCellValue( 'E' . $Vcyrw50em1ux, $V3xenore5brcRow['actual_num_truck'] )
                    ->setCellValue( 'F' . $Vcyrw50em1ux, $V3xenore5brcRow['last_month_sampling'] )
                    ->setCellValue( 'G' . $Vcyrw50em1ux, $V3xenore5brcRow['on_days'] )
                    ->setCellValue( 'H' . $Vcyrw50em1ux, $V3xenore5brcRow['estimate_sampling'] )
                    ->setCellValue( 'I' . $Vcyrw50em1ux, $V3xenore5brcRow['actual_sampling'] )
                    ->setCellValue( 'J' . $Vcyrw50em1ux, $V3xenore5brcRow['gap'] )
                    ->setCellValue( 'K' . $Vcyrw50em1ux, $V3xenore5brcRow['percent_gap'] );
      }
      $Vlofblbjztea->removeRow( $Vkk3dcyvccoy - 1, 1 );
      
      foreach( range('A','K') as $Vkyeixogwgor ) 
      {
        $Vlofblbjztea->getColumnDimension($Vkyeixogwgor)
                    ->setAutoSize(true);
      }
      
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Grading Priority.xls"');
      header('Cache-Control: max-age=0');
      ob_end_clean();
      
      $Vakedt33sqck = new Xls( $Vsakcbvhwygc );
      $Vakedt33sqck->save('php://output');
      exit();
    }
  }
}