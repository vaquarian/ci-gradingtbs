<?php
/* 
 * @author  Vincent
 * @version CI3
 */
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Helper\Html as HtmlHelper;

defined('BASEPATH') OR exit('No direct script access allowed');

class Target_report extends CI_Controller {

  public $Vtnhccfabdro = null;
  public $Vtcujs51ixgw = null;
  public $Vodifebfj2pm = null;
  public $Vpg2lony4irw = null;
  public $Vcpgpwcq1hms = null;
  public $Vvs2rpnzubbs = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->is_loggedin();
    $this->load->helper( array('html', 'url', 'file', 'form', 'security') );
    $this->load->model( 'report_model', 'report' );
    $this->load->model( 'division_model', 'division');
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
        if ( $Vvrvinbrz4c5->view_permission == '0' )
        {
          $Vjr5yu52q4yu[] = $Vvrvinbrz4c5->menu_name;
        } else if ( $Vvrvinbrz4c5->view_permission == '1' ) {
          $Vt0kvhbinhm4[] = $Vvrvinbrz4c5->menu_name;
        }
      }
    }
    $this->hidden_menu = $this->role_access->get_menu_access( $Vjr5yu52q4yu );
    $this->allowed_menu = array_merge( $Vt0kvhbinhm4, $this->hidden_menu );
    $this->access = $this->role_access->get_crud_access( 'Achievement Target Report', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' )
    {
      redirect('index');
    }
  }
  
  public function index()
  {
    $V3xenore5brc = array(
      'title' => 'Achievement Target Report',
      'description' => '',
      'css_files' => array(
          'assets/css/datepicker/bootstrap-datepicker.min.css',
          'assets/css/custom/checklist.css' 
      ),
      'js_files' => array(
          base_url() . 'assets/js/datepicker/bootstrap-datepicker.min.js',
          base_url() . 'assets/js/custom/vs.report.target.js'
      ),
      'allowed_menu' => $this->allowed_menu
    );
    
    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'target_report/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'modal/mill_modal' );
    $this->load->view( 'modal/estate_modal' );
    $this->load->view( 'templates/footer' );
  }

  private function _get_post_data()
  {
    $V30jqm4jxzl1 = array();
    $V3rc3czeytdt = $this->division->get_by_mill_estate( $this->input->post('mill_code'), $this->input->post('hierarchy_code') );
    foreach ( $V3rc3czeytdt as $Vnmygk32oc1h => $Venvdzibqf0f ) 
    {
      $Vcyrw50em1ux = array();
      $Vcyrw50em1ux['child_code'] = $Venvdzibqf0f->division_code;
      $Vcyrw50em1ux['child_name'] = $Venvdzibqf0f->division_name;
      $V30jqm4jxzl1[] = $Vcyrw50em1ux;
    }
    $this->post_data = array(
        'start_date' => empty($this->input->post('start_spb_date_rpt')) ? date('Y-m-d') : date( 'Y-m-d', strtotime($this->input->post('start_spb_date_rpt')) ),
        'end_date' => empty($this->input->post('start_spb_date_rpt')) ? date('Y-m-d') : date( 'Y-m-d', strtotime($this->input->post('start_spb_date_rpt')) ),
        'mill_code' => $this->input->post('mill_code'),
        'mill_desc' => $this->input->post('mill_desc'),
        'level' => 'ESTATE',
        'hierarchy' => $this->input->post('hierarchy_code'),
        'hierarchy_name' => $this->input->post('hierarchy'),
        'hierarchy_desc' => $this->input->post('hierarchy_desc'),
        'child_level' => $this->input->post('hierarchy_child'),
        'list_child' => $V30jqm4jxzl1
    );
  }
  
  public function report_filter( $Vdlc15w335ke = 'view' )
  {
    $this->_form_validation();
    $this->_get_post_data(); 
    $Vhgertdralco = $this->report->filter_data( $this->post_data, 'target' );
    $this->_get_report_structure( $Vhgertdralco );
    $Vnipetssibos = $this->load->view( 'templates/report/target', $this->structure, TRUE );
    if ( $Vdlc15w335ke == 'view' )
    {
      echo json_encode( array('response' => $Vnipetssibos, 'status' => TRUE) ); 
      exit();
    }
  }
  
  private function _form_validation()
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('start_spb_date_rpt', 'Date', 'trim|required|xss_clean');
    $this->form_validation->set_rules('mill', 'Mill', 'trim|required|xss_clean');
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
  
  public function report_export( $Vhiwhnmylswq = 'xls' )
  {
    if ( $Vhiwhnmylswq == 'xls' )
    {
      $this->report_filter( 'export' );
      $Vimnek0pstxi = 'Achievement Target Report.xls';
      $V3xenore5brc = array('filename' => $Vimnek0pstxi);
      $Vnipetssibos_data = array_merge( $this->structure, $V3xenore5brc );
      $Vq2kqr40v0mg = $this->load->view( 'templates/report/target_excel', $Vnipetssibos_data, TRUE );
      echo json_encode( array('response' => 'data:application/vnd.ms-excel;base64,'.base64_encode( $Vq2kqr40v0mg ), 'filename' => $Vimnek0pstxi, 'status' => TRUE) ); 
      exit();
    }
  }
  
  private function _get_report_structure( $Vv13gg3rpmae ) 
  {
    $V5omacd5cjnz      = ( count($this->post_data['list_child']) == 0 ) ? 1 : count($this->post_data['list_child']);
    $V355lynlo0yl        = 9;
    $V355lynlo0yl_level  = $V5omacd5cjnz;
    $Vvrylbqc0nla    = ceil( 40 / $V355lynlo0yl_level );
    
    $V4ief4qnrbyi            = $this->post_data['level'];
    $Vt4mdlluf4ug      = $this->post_data['child_level'];
    $V4ief4qnrbyi_desc       = ($V4ief4qnrbyi == 'ESTATE') ? ($this->post_data['hierarchy_desc'] . ' (' . $this->post_data['hierarchy_name'] . ')') : $this->post_data['hierarchy_name'];
    $Vt4mdlluf4ug_desc = $this->post_data['list_child'];
    $V4ief4qnrbyi_filtered   = $this->post_data['mill_desc'];
    $Vcd4eyagzvkr       = strtoupper( date('d F Y', strtotime($this->post_data['start_date'])) );
    $Vt4shbdrwyrv         = strtoupper( date('d F Y', strtotime($this->post_data['end_date'])) );
    $Vk5j4yg315dp     = 'DAFTAR % PENCAPAIAN PER ESTATE PER DIVISI';
    $Vcsfxvngcddn      = 'PER TANGGAL '.$Vcd4eyagzvkr;
    $Vfwm2mdvn3zw       = $this->session->userdata('full_name');
    $Vy1r3qh4c3uo       = date('d F Y H:i:s');
    
    $Vpq30p5zxafj = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'" style="font-size:18px;font-weight:bold;text-align:center;">'.$Vk5j4yg315dp.'</td>
      </tr>
      <tr>
        <td colspan="'.$V355lynlo0yl.'" style="font-size:18px;font-weight:bold;text-align:center;">'.$Vcsfxvngcddn.'</td>
      </tr>';
    
    $Venyy5j1hcj2 = '
      <tr><td colspan="'.$V355lynlo0yl.'">&nbsp;</td></tr>
      <tr>
        <td rowspan="2" colspan="5" style="font-weight:bold;text-align:left;">'.$V4ief4qnrbyi_filtered.'</td>
        <td>Dicetak oleh</td>
        <td colspan="3">: '.$Vfwm2mdvn3zw.'</td>
      </tr>
      <tr>            
        <td>Tanggal Cetak</td>
        <td colspan="3">: '.$Vy1r3qh4c3uo.'</td>
      </tr>';    
    
    $Vfwdhm11magb = '
      <tr>
        <td style="width:10%;text-align:center;">Kebun</td>
        <td style="width:10%;text-align:center;">Divisi</td>
        <td style="width:10%;text-align:center;">Jml Truk Bulan Lalu</td>
        <td style="width:10%;text-align:center;">Aktual Jumlah Truk</td>
        <td style="width:10%;text-align:center;">Estimasi 10% Sampling Sebulan</td>
        <td style="width:10%;text-align:center;">Hari ke N</td>
        <td style="width:10%;text-align:center;">Estimasi Jumlah Sampling Hari ke N</td>
        <td style="width:10%;text-align:center;">Aktual Jml Sampling s.d Hari Ini Real Time</td>
        <td style="width:10%;text-align:center;">% Pencapaian</td>
      </tr>';
    
    $Ve1nublssobl = '';
    foreach( $Vv13gg3rpmae as $Vvhalnnjsldh => $V2my5s2ykfx2 )
    {
      $V3tscm4mhzx1 = '';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['estate_short_name'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['division_name'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['num_of_truck_last_month'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['actual_num_of_truck_coming'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['estimate_sampling'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['on_days'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['estimate_num_of_sampling'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['actual_num_of_sampling'].'</td>';
      $V3tscm4mhzx1 .= '<td>'.$V2my5s2ykfx2['achievement'].'</td>';
      $Ve1nublssobl .= '<tr>' . $V3tscm4mhzx1 . '</tr>';
    }
    
    $this->structure = array(
      'tr_title'                => $Vpq30p5zxafj,
      'tr_level_filtered'       => $Venyy5j1hcj2,
      'tr_column_title'         => $Vfwdhm11magb,
      'tr_column_value'         => $Ve1nublssobl,
    );
  }
  
}