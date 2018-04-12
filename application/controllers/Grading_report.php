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

class Grading_report extends CI_Controller {

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
    $this->access = $this->role_access->get_crud_access( 'Grading Report', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' )
    {
      redirect('index');
    }
  }
  
  public function index()
  {
    if ( $this->uri->segment(2) == 'json' ) 
      $Vvlp2zayn0ey = 'json';
    else 
      $Vvlp2zayn0ey = 'load';
    $V3xenore5brc = array(
      'title' => 'Grading Report',
      'description' => '',
      'type' => $Vvlp2zayn0ey,
      'css_files' => array(
          'assets/css/datepicker/bootstrap-datepicker.min.css',
          'assets/css/custom/checklist.css' 
      ),
      'js_files' => array(
          base_url() . 'assets/js/datepicker/bootstrap-datepicker.min.js',
          base_url() . 'assets/js/custom/vs.report.grading.js'
      ),
      'allowed_menu' => $this->allowed_menu
    );
    $this->load->view( 'templates/header', $V3xenore5brc );
    $this->load->view( 'grading_report/index', $V3xenore5brc );
    $this->load->view( 'templates/footer_js', $V3xenore5brc );
    $this->load->view( 'modal/mill_modal' );
    $this->load->view( 'modal/level_modal' );
    $this->load->view( 'modal/group_parent_modal' );
    $this->load->view( 'modal/group_modal' );
    $this->load->view( 'modal/region_modal' );
    $this->load->view( 'modal/estate_modal' );
    $this->load->view( 'templates/footer' );
  }

  private function _get_post_data()
  {
    $V30jqm4jxzl1 = array();
    if ( !empty($this->input->post('hierarchy_child_code[]')) )
    {
      foreach ( $this->input->post('hierarchy_child_code[]') as $Vnmygk32oc1h => $Venvdzibqf0f ) 
      {
        $Vcyrw50em1ux = array();
        $Vuppbq1dpo3g = explode( '::', $Venvdzibqf0f );
        $Vcyrw50em1ux['child_code'] = $Vuppbq1dpo3g[0];
        $Vcyrw50em1ux['child_name'] = $Vuppbq1dpo3g[1];
        $V30jqm4jxzl1[] = $Vcyrw50em1ux;
      }
    }
    $this->post_data = array(
        'start_date' => empty($this->input->post('start_spb_date_rpt')) ? date('Y-m-d') : date( 'Y-m-d', strtotime($this->input->post('start_spb_date_rpt')) ),
        'end_date' => empty($this->input->post('end_spb_date_rpt')) ? date('Y-m-d') : date( 'Y-m-d', strtotime($this->input->post('end_spb_date_rpt')) ),
        'mill_code' => empty($this->input->post('mill_code')) ? 'All' : $this->input->post('mill_code'),
        'level' => empty($this->input->post('level')) ? null : $this->input->post('level'),
        'hierarchy' => empty($this->input->post('hierarchy_code')) ? null : $this->input->post('hierarchy_code'),
        'hierarchy_name' => empty($this->input->post('hierarchy')) ? null : $this->input->post('hierarchy'),
        'hierarchy_desc' => empty($this->input->post('hierarchy_desc')) ? null : $this->input->post('hierarchy_desc'),
        'child_level' => empty($this->input->post('hierarchy_child')) ? null : $this->input->post('hierarchy_child'),
        'list_child' => $V30jqm4jxzl1
    );
  }
  
  public function report_filter( $Vdlc15w335ke = 'view' )
  {
    $this->_form_validation();
    $this->_get_post_data(); 
    $Vz54maodzzvo = json_encode( $this->post_data );
    $Vhgertdralco = $this->report->filter_data( $Vz54maodzzvo );
    $this->_get_report_structure( $Vhgertdralco );
    $Vnipetssibos = $this->load->view( 'templates/report/grading', $this->structure, TRUE );
    if ( $Vdlc15w335ke == 'view' )
    {
      echo json_encode( array('response' => $Vnipetssibos, 'status' => TRUE) ); 
      exit();
    }
  }
  
  private function _form_validation()
  {
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('start_spb_date_rpt', 'Start Date', 'trim|required|xss_clean');
    $this->form_validation->set_rules('end_spb_date_rpt', 'End Date', 'trim|required|xss_clean');
    $this->form_validation->set_rules('level', 'Level', 'trim|required|xss_clean');
    $this->form_validation->set_rules('hierarchy', 'Hierarchy', 'trim|required|xss_clean');
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
      $Vimnek0pstxi = 'Grading Report.xls';
      $V3xenore5brc = array('filename' => $Vimnek0pstxi);
      $Vnipetssibos_data = array_merge( $this->structure, $V3xenore5brc );
      $Vq2kqr40v0mg = $this->load->view( 'templates/report/grading_excel', $Vnipetssibos_data, TRUE );
      echo json_encode( array('response' => 'data:application/vnd.ms-excel;base64,'.base64_encode( $Vq2kqr40v0mg ), 'filename' => $Vimnek0pstxi, 'status' => TRUE) ); 
      exit();
    }
  }
  
  public function report_json()
  {
    $this->_form_validation();
    $this->_get_post_data(); 
    $Vz54maodzzvo = json_encode( $this->post_data );
    echo json_encode( array('response' => $Vz54maodzzvo, 'status' => TRUE) ); 
    exit();
  }
  
  private function _get_report_structure( $Vv13gg3rpmae ) 
  {
    $Vuppbq1dpo3g_num      = ( count($this->post_data['list_child']) == 0 ) ? 1 : count($this->post_data['list_child']);
    $V355lynlo0yl        = 3 + $Vuppbq1dpo3g_num;
    $V355lynlo0yl_level  = $Vuppbq1dpo3g_num;
    $Vuppbq1dpo3g_width    = ceil( 40 / $V355lynlo0yl_level );
    
    $V4ief4qnrbyi            = $this->post_data['level'];
    $Vuppbq1dpo3g_level      = $this->post_data['child_level'];
    $V4ief4qnrbyi_desc       = ($V4ief4qnrbyi == 'ESTATE') ? ($this->post_data['hierarchy_desc'] . ' (' . $this->post_data['hierarchy_name'] . ')') : $this->post_data['hierarchy_name'];
    $Vuppbq1dpo3g_level_desc = $this->post_data['list_child'];

    $V4ief4qnrbyi_filtered   = $this->post_data['hierarchy_desc'];
    $Vcd4eyagzvkr       = strtoupper( date('d F Y', strtotime($this->post_data['start_date'])) );
    $Vt4shbdrwyrv         = strtoupper( date('d F Y', strtotime($this->post_data['end_date'])) );
    $Vk5j4yg315dp     = 'RINGKASAN LAPORAN GRADING '.$V4ief4qnrbyi.' PER '.$Vuppbq1dpo3g_level;
    $Vcsfxvngcddn      = 'TANGGAL '.$Vcd4eyagzvkr.' S/D TANGGAL '.$Vt4shbdrwyrv;
    
    $Venyy5j1hcj2 = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'" style="font-weight:bold;font-size:18px;">'.$V4ief4qnrbyi_filtered.'</td>
      </tr>';
    
    $Vpq30p5zxafj = '
      <tr><td colspan="'.$V355lynlo0yl.'">&nbsp;</td></tr>
      <tr>
        <td colspan="'.$V355lynlo0yl.'" style="font-size:18px;font-weight:bold;text-align:center;">'.$Vk5j4yg315dp.'</td>
      </tr>
      <tr>
        <td colspan="'.$V355lynlo0yl.'" style="font-size:18px;font-weight:bold;text-align:center;">'.$Vcsfxvngcddn.'</td>
      </tr>';
    
    $Vc33mglos5jy = '
      <tr><td colspan="'.$V355lynlo0yl.'">&nbsp;</td></tr>
      <tr>
        <td colspan="'.$V355lynlo0yl.'" style="font-weight:bold;">A. Kematangan & % Berondolan Lepas</td>
      </tr>';
    
    $Vcan5bci0vdz = '
      <tr>
        <td style="font-weight:bold;">'.$V4ief4qnrbyi.'</td>
        <td colspan="'.$V355lynlo0yl_level.'" style="font-weight:bold;text-align:center;">'.$V4ief4qnrbyi_desc.'</td>
        <td rowspan="2" style="width:10%;font-weight:bold;text-align:center;">TOTAL</td>
        <td rowspan="2" style="width:10%;font-weight:bold;text-align:center;">TARGET</td>
      </tr>';
    
    $Vulesd4oa4ky = '';
    foreach( $Vuppbq1dpo3g_level_desc as $Vvhalnnjsldh => $V2my5s2ykfx2 )
    {
      $Vulesd4oa4ky .= '<td style="width:'.$Vuppbq1dpo3g_width.'%;font-weight:bold;text-align:center;">'.$V2my5s2ykfx2['child_name'].'</td>';
    }
    
    $Vkgb04iujdvi = '
      <tr>
        <td style="width:40%;font-weight:bold;">'.$Vuppbq1dpo3g_level.'</td>
        '.$Vulesd4oa4ky.'
      </tr>';
    
    if ( !empty($Vv13gg3rpmae) ) 
    { 
      $Vyy0bnejnikb = array('JUMLAH SAMPLE', 'Total Normal', 'Total Abnormal', 'Grand Total');
      if ( !empty($Vv13gg3rpmae['data_one']) ) 
      {
        $Vvdgfa3pgtce = '';
        foreach( $Vv13gg3rpmae['data_one'] as $Vvhalnnjsldh1 => $V3xenore5brc_one )
        {
          $Vygyvmtx1yqc = $Vv13gg3rpmae['data_one'][$Vvhalnnjsldh1];
          if ( !empty($V3xenore5brc_one) )
          { 
            $Vpkhn1luipsp = '';
            $Vro2vlv0ntd5 = '';
            foreach( $V3xenore5brc_one as $Valj2nkivdzo1 => $V2my5s2ykfx21 )
            {
              $V34cplgiqc3d = ( !empty($V2my5s2ykfx21) ) ? $V2my5s2ykfx21 : '-';
              
              
              if ( $Valj2nkivdzo1 == 'criteria_name' && in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'criteria_name' && !in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td>'.$V34cplgiqc3d.'</td>';
              
              
              foreach( $Vuppbq1dpo3g_level_desc as $Vvhalnnjsldh_child => $V2my5s2ykfx2_child )
              {
                $Vmz0qnpiu3ip = 'text-align:right;';
                if ( $Valj2nkivdzo1 == $V2my5s2ykfx2_child['child_name'] )
                {
                  if ( strpos(strtolower($Vygyvmtx1yqc['criteria_name']), 'mentah') !== false )
                    $Vvq2uqslzgha['buah_mentah'] = floatval($Vygyvmtx1yqc['Total']);
                  else if ( strpos(strtolower($Vygyvmtx1yqc['criteria_name']), 'kosong') !== false )
                    $Vvq2uqslzgha['janjangan_kosong'] = floatval($Vygyvmtx1yqc['Total']);
                  else if ( strpos(strtolower($Vygyvmtx1yqc['criteria_name']), 'parthenocarpic') !== false )
                    $Vvq2uqslzgha['parthenocarpic'] = floatval($Vygyvmtx1yqc['Total']);
                  
                  if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                    $Vmz0qnpiu3ip = 'text-align:right;font-weight:bold;color:#000000;';
                  else if ( $Vygyvmtx1yqc['target2'] != '' )
                  {
                    switch ( $Vygyvmtx1yqc['prefix'] ) 
                    {
                      case 'MAX' : 
                        if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      case 'MIN' :
                        if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      default : 
                        $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                        if ( $Vno13xurehdh > 0 )
                        {
                          $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                          if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        } 
                        else if ( $Vno13xurehdh == 0 ) 
                        {
                          if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        }
                        break;
                    }
                  }
                  $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
                }
              }
              
              
              if ( $Valj2nkivdzo1 == 'Total' )
              {
                $Vmz0qnpiu3ip = 'text-align:center;';
                if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                  $Vmz0qnpiu3ip = 'text-align:center;font-weight:bold;color:#000000;';
                else if ( $Vygyvmtx1yqc['target2'] != '' )
                {
                  switch ( $Vygyvmtx1yqc['prefix'] ) 
                  {
                    case 'MAX' : 
                      if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    case 'MIN' :
                      if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    default : 
                      $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                      if ( $Vno13xurehdh > 0 )
                      {
                        $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                        if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      } 
                      else if ( $Vno13xurehdh == 0 ) 
                      {
                        if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      }
                      break;
                  }
                }
                $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
              }
              
                            
              if ( $Valj2nkivdzo1 == 'target' && in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="text-align:center;font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'target' && !in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) )
                $Vro2vlv0ntd5 .= '<td style="text-align:center;background-color:#77dd77">'.$V34cplgiqc3d.'</td>';
            }
            $Vpkhn1luipsp = '<tr>' . $Vro2vlv0ntd5 . '</tr>';
          }
          $Vvdgfa3pgtce .= $Vpkhn1luipsp;
        }
      }
      if ( !empty($Vv13gg3rpmae['data_two']) ) 
      {
        $Vpkhn1luipsp_sample_two = '';
        foreach( $Vv13gg3rpmae['data_two'] as $Vvhalnnjsldh1 => $V3xenore5brc_two )
        {
          $Vygyvmtx1yqc = $Vv13gg3rpmae['data_two'][$Vvhalnnjsldh1];
          if ( !empty($V3xenore5brc_two) )
          { 
            $Vpkhn1luipsp = '';
            $Vro2vlv0ntd5 = '';
            foreach( $V3xenore5brc_two as $Valj2nkivdzo1 => $V2my5s2ykfx21 )
            {
              $V34cplgiqc3d = ( !empty($V2my5s2ykfx21) ) ? $V2my5s2ykfx21 : '-';
              
              
              if ( $Valj2nkivdzo1 == 'criteria_name' && in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'criteria_name' && !in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td>'.$V34cplgiqc3d.'</td>';
              
              
              foreach( $Vuppbq1dpo3g_level_desc as $Vvhalnnjsldh_child => $V2my5s2ykfx2_child )
              {
                $Vmz0qnpiu3ip = 'text-align:right;';
                if ( $Valj2nkivdzo1 == $V2my5s2ykfx2_child['child_name'] )
                {
                  if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                    $Vmz0qnpiu3ip = 'text-align:right;font-weight:bold;color:#000000;';
                  else if ( $Vygyvmtx1yqc['target2'] != '' )
                  {
                    switch ( $Vygyvmtx1yqc['prefix'] ) 
                    {
                      case 'MAX' : 
                        if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      case 'MIN' :
                        if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      default : 
                        $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                        if ( $Vno13xurehdh > 0 )
                        {
                          $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                          if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        } 
                        else if ( $Vno13xurehdh == 0 ) 
                        {
                          if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        }
                        break;
                    }
                  }
                  $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
                }
              }
              
              
              if ( $Valj2nkivdzo1 == 'Total' )
              {
                $Vmz0qnpiu3ip = 'text-align:center;';
                if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                  $Vmz0qnpiu3ip = 'text-align:center;font-weight:bold;color:#000000;';
                else if ( $Vygyvmtx1yqc['target2'] != '' )
                {
                  switch ( $Vygyvmtx1yqc['prefix'] ) 
                  {
                    case 'MAX' : 
                      if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    case 'MIN' :
                      if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    default : 
                      $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                      if ( $Vno13xurehdh > 0 )
                      {
                        $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                        if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      } 
                      else if ( $Vno13xurehdh == 0 ) 
                      {
                        if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      }
                      break;
                  }
                }
                $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
              }
              
                            
              if ( $Valj2nkivdzo1 == 'target' && in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="text-align:center;font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'target' && !in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) )
                $Vro2vlv0ntd5 .= '<td style="text-align:center;background-color:#77dd77">'.$V34cplgiqc3d.'</td>';          
            }
            $Vpkhn1luipsp = '<tr>' . $Vro2vlv0ntd5 . '</tr>';
          }
          $Vpkhn1luipsp_sample_two .= $Vpkhn1luipsp;
        }
      }
      if ( !empty($Vv13gg3rpmae['data_three']) ) 
      {
        $Vpkhn1luipsp_sample_three = '';
        foreach( $Vv13gg3rpmae['data_three'] as $Vvhalnnjsldh1 => $V3xenore5brc_three )
        {
          $Vygyvmtx1yqc = $Vv13gg3rpmae['data_three'][$Vvhalnnjsldh1];
          if ( !empty($V3xenore5brc_three) )
          { 
            $Vpkhn1luipsp = '';
            $Vro2vlv0ntd5 = '';
            foreach( $V3xenore5brc_three as $Valj2nkivdzo1 => $V2my5s2ykfx21 )
            {
              $V34cplgiqc3d = ( !empty($V2my5s2ykfx21) ) ? $V2my5s2ykfx21 : '-';
              
              if ( $Valj2nkivdzo1 == 'criteria_name' && in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'criteria_name' && !in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td>'.$V34cplgiqc3d.'</td>';
              
              
              foreach( $Vuppbq1dpo3g_level_desc as $Vvhalnnjsldh_child => $V2my5s2ykfx2_child )
              {
                $Vmz0qnpiu3ip = 'text-align:right;';
                if ( $Valj2nkivdzo1 == $V2my5s2ykfx2_child['child_name'] )
                {
                  if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                    $Vmz0qnpiu3ip = 'text-align:right;font-weight:bold;color:#000000;';
                  else if ( $Vygyvmtx1yqc['target2'] != '' )
                  {
                    switch ( $Vygyvmtx1yqc['prefix'] ) 
                    {
                      case 'MAX' : 
                        if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      case 'MIN' :
                        if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      default : 
                        $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                        if ( $Vno13xurehdh > 0 )
                        {
                          $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                          if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        } 
                        else if ( $Vno13xurehdh == 0 ) 
                        {
                          if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        }
                        break;
                    }
                  }
                  $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
                }
              }
              
              
              if ( $Valj2nkivdzo1 == 'Total' )
              {
                $Vmz0qnpiu3ip = 'text-align:center;';
                if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                  $Vmz0qnpiu3ip = 'text-align:center;font-weight:bold;color:#000000;';
                else if ( $Vygyvmtx1yqc['target2'] != '' )
                {
                  switch ( $Vygyvmtx1yqc['prefix'] ) 
                  {
                    case 'MAX' : 
                      if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    case 'MIN' :
                      if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    default : 
                      $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                      if ( $Vno13xurehdh > 0 )
                      {
                        $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                        if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      } 
                      else if ( $Vno13xurehdh == 0 ) 
                      {
                        if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      }
                      break;
                  }
                }
                $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
              }
              
                            
              if ( $Valj2nkivdzo1 == 'target' && in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="text-align:center;font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'target' && !in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) )
                $Vro2vlv0ntd5 .= '<td style="text-align:center;">'.$V34cplgiqc3d.'</td>';           
            }
            $Vpkhn1luipsp = '<tr>' . $Vro2vlv0ntd5 . '</tr>';
          }
          $Vpkhn1luipsp_sample_three .= $Vpkhn1luipsp;
        }
      }
      if ( !empty($Vv13gg3rpmae['data_four']) ) 
      {
        $Vpkhn1luipsp_sample_four = '';
        foreach( $Vv13gg3rpmae['data_four'] as $Vvhalnnjsldh1 => $V3xenore5brc_four )
        {
          $Vygyvmtx1yqc = $Vv13gg3rpmae['data_four'][$Vvhalnnjsldh1];
          if ( !empty($V3xenore5brc_four) )
          { 
            $Vpkhn1luipsp = '';
            $Vro2vlv0ntd5 = '';
            foreach( $V3xenore5brc_four as $Valj2nkivdzo1 => $V2my5s2ykfx21 )
            {
              $V34cplgiqc3d = ( !empty($V2my5s2ykfx21) ) ? $V2my5s2ykfx21 : '-';
              
              if ( $Valj2nkivdzo1 == 'criteria_name' && in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'criteria_name' && !in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td>'.$V34cplgiqc3d.'</td>';
              
              
              foreach( $Vuppbq1dpo3g_level_desc as $Vvhalnnjsldh_child => $V2my5s2ykfx2_child )
              {
                $Vmz0qnpiu3ip = 'text-align:right;';
                if ( $Valj2nkivdzo1 == $V2my5s2ykfx2_child['child_name'] )
                {
                  if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                    $Vmz0qnpiu3ip = 'text-align:right;font-weight:bold;color:#000000;';
                  else if ( $Vygyvmtx1yqc['target2'] != '' )
                  {
                    switch ( $Vygyvmtx1yqc['prefix'] ) 
                    {
                      case 'MAX' : 
                        if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      case 'MIN' :
                        if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      default : 
                        $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                        if ( $Vno13xurehdh > 0 )
                        {
                          $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                          if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        } 
                        else if ( $Vno13xurehdh == 0 ) 
                        {
                          if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        }
                        break;
                    }
                  }
                  $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
                }
              }
              
              
              if ( $Valj2nkivdzo1 == 'Total' )
              {
                $Vmz0qnpiu3ip = 'text-align:center;';
                if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                  $Vmz0qnpiu3ip = 'text-align:center;font-weight:bold;color:#000000;';
                else if ( $Vygyvmtx1yqc['target2'] != '' )
                {
                  switch ( $Vygyvmtx1yqc['prefix'] ) 
                  {
                    case 'MAX' : 
                      if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    case 'MIN' :
                      if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    default : 
                      $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                      if ( $Vno13xurehdh > 0 )
                      {
                        $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                        if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      } 
                      else if ( $Vno13xurehdh == 0 ) 
                      {
                        if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      }
                      break;
                  }
                }
                $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
              }
              
                            
              if ( $Valj2nkivdzo1 == 'target' && in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="text-align:center;font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'target' && !in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) )
                $Vro2vlv0ntd5 .= '<td style="text-align:center;">'.$V34cplgiqc3d.'</td>';      
            }
            $Vpkhn1luipsp = '<tr>' . $Vro2vlv0ntd5 . '</tr>';
          }
          $Vpkhn1luipsp_sample_four .= $Vpkhn1luipsp;
        }        
      }
      if ( !empty($Vv13gg3rpmae['data_five']) ) 
      {
        $Vpkhn1luipsp_sample_five = '';
        foreach( $Vv13gg3rpmae['data_five'] as $Vvhalnnjsldh1 => $V3xenore5brc_five )
        {
          $Vygyvmtx1yqc = $Vv13gg3rpmae['data_five'][$Vvhalnnjsldh1];
          if ( !empty($V3xenore5brc_five) )
          { 
            $Vpkhn1luipsp = '';
            $Vro2vlv0ntd5 = '';
            foreach( $V3xenore5brc_five as $Valj2nkivdzo1 => $V2my5s2ykfx21 )
            {
              $V34cplgiqc3d = ( !empty($V2my5s2ykfx21) ) ? $V2my5s2ykfx21 : '-';
              
              if ( $Valj2nkivdzo1 == 'criteria_name' && in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'criteria_name' && !in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td>'.$V34cplgiqc3d.'</td>';
              
              
              foreach( $Vuppbq1dpo3g_level_desc as $Vvhalnnjsldh_child => $V2my5s2ykfx2_child )
              {
                $Vmz0qnpiu3ip = 'text-align:right;';
                if ( $Valj2nkivdzo1 == $V2my5s2ykfx2_child['child_name'] )
                {
                  if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                    $Vmz0qnpiu3ip = 'text-align:right;font-weight:bold;color:#000000;';
                  else if ( $Vygyvmtx1yqc['target2'] != '' )
                  {
                    switch ( $Vygyvmtx1yqc['prefix'] ) 
                    {
                      case 'MAX' : 
                        if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      case 'MIN' :
                        if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      default : 
                        $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                        if ( $Vno13xurehdh > 0 )
                        {
                          $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                          if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        } 
                        else if ( $Vno13xurehdh == 0 ) 
                        {
                          if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        }
                        break;
                    }
                  }
                  $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
                }
              }
              
              
              if ( $Valj2nkivdzo1 == 'Total' )
              {
                $Vmz0qnpiu3ip = 'text-align:center;';
                if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                  $Vmz0qnpiu3ip = 'text-align:center;font-weight:bold;color:#000000;';
                else if ( $Vygyvmtx1yqc['target2'] != '' )
                {
                  switch ( $Vygyvmtx1yqc['prefix'] ) 
                  {
                    case 'MAX' : 
                      if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    case 'MIN' :
                      if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    default : 
                      $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                      if ( $Vno13xurehdh > 0 )
                      {
                        $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                        if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      } 
                      else if ( $Vno13xurehdh == 0 ) 
                      {
                        if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      }
                      break;
                  }
                }
                $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
              }
              
                            
              if ( $Valj2nkivdzo1 == 'target' && in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="text-align:center;font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'target' && !in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) )
                $Vro2vlv0ntd5 .= '<td style="text-align:center;background-color:#77dd77">'.$V34cplgiqc3d.'</td>';            
            }
            $Vpkhn1luipsp = '<tr>' . $Vro2vlv0ntd5 . '</tr>';
          }
          $Vpkhn1luipsp_sample_five .= $Vpkhn1luipsp;
        }        
      }
      if ( !empty($Vv13gg3rpmae['data_six']) ) 
      {
        $Vpkhn1luipsp_sample_six = '';
        foreach( $Vv13gg3rpmae['data_six'] as $Vvhalnnjsldh1 => $V3xenore5brc_six )
        {
          $Vygyvmtx1yqc = $Vv13gg3rpmae['data_six'][$Vvhalnnjsldh1];
          if ( !empty($V3xenore5brc_six) )
          { 
            $Vpkhn1luipsp = '';
            $Vro2vlv0ntd5 = '';
            foreach( $V3xenore5brc_six as $Valj2nkivdzo1 => $V2my5s2ykfx21 )
            {
              $V34cplgiqc3d = ( !empty($V2my5s2ykfx21) ) ? $V2my5s2ykfx21 : '-';
              
              if ( $Valj2nkivdzo1 == 'criteria_name' && in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'criteria_name' && !in_array($V2my5s2ykfx21, $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td>'.$V34cplgiqc3d.'</td>';
              
              
              foreach( $Vuppbq1dpo3g_level_desc as $Vvhalnnjsldh_child => $V2my5s2ykfx2_child )
              {
                $Vmz0qnpiu3ip = 'text-align:right;';
                if ( $Valj2nkivdzo1 == $V2my5s2ykfx2_child['child_name'] )
                {
                  if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                    $Vmz0qnpiu3ip = 'text-align:right;font-weight:bold;color:#000000;';
                  else if ( $Vygyvmtx1yqc['target2'] != '' )
                  {
                    switch ( $Vygyvmtx1yqc['prefix'] ) 
                    {
                      case 'MAX' : 
                        if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      case 'MIN' :
                        if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        break;
                      default : 
                        $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                        if ( $Vno13xurehdh > 0 )
                        {
                          $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                          if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        } 
                        else if ( $Vno13xurehdh == 0 ) 
                        {
                          if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:right;color:#FF0000;';
                          else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:right;color:#000000;';
                        }
                        break;
                    }
                  }
                  $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
                }
              }
              
              
              if ( $Valj2nkivdzo1 == 'Total' )
              {
                $Vmz0qnpiu3ip = 'text-align:center;';
                if ( $Vygyvmtx1yqc['target2'] == '' || ($Vygyvmtx1yqc['target'] == '100%') )
                  $Vmz0qnpiu3ip = 'text-align:center;font-weight:bold;color:#000000;';
                else if ( $Vygyvmtx1yqc['target2'] != '' )
                {
                  switch ( $Vygyvmtx1yqc['prefix'] ) 
                  {
                    case 'MAX' : 
                      if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    case 'MIN' :
                      if ( $V2my5s2ykfx21 < $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                      else if ( $V2my5s2ykfx21 > $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      break;
                    default : 
                      $Vno13xurehdh = substr_count ( $Vygyvmtx1yqc['target2'], ' - ' );
                      if ( $Vno13xurehdh > 0 )
                      {
                        $Vgwutpi1afan = explode( ' - ', $Vygyvmtx1yqc['target2'] );
                        if ( $V2my5s2ykfx21 < $Vgwutpi1afan[0] && $V2my5s2ykfx21 > $Vgwutpi1afan[1] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 > $Vgwutpi1afan[0] && $V2my5s2ykfx21 < $Vgwutpi1afan[1] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      } 
                      else if ( $Vno13xurehdh == 0 ) 
                      {
                        if ( $V2my5s2ykfx21 != $Vygyvmtx1yqc['target2'] )      $Vmz0qnpiu3ip = 'text-align:center;color:#FF0000;';
                        else if ( $V2my5s2ykfx21 == $Vygyvmtx1yqc['target2'] ) $Vmz0qnpiu3ip = 'text-align:center;color:#000000;';
                      }
                      break;
                  }
                }
                $Vro2vlv0ntd5 .= '<td style="'.$Vmz0qnpiu3ip.'">'.$V34cplgiqc3d.'</td>';
              }
              
                            
              if ( $Valj2nkivdzo1 == 'target' && in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) ) 
                $Vro2vlv0ntd5 .= '<td style="text-align:center;font-weight:bold;">'.$V34cplgiqc3d.'</td>';
              else if ( $Valj2nkivdzo1 == 'target' && !in_array($Vygyvmtx1yqc['criteria_name'], $Vyy0bnejnikb) )
                $Vro2vlv0ntd5 .= '<td style="text-align:center;">'.$V34cplgiqc3d.'</td>';          
            }
            $Vpkhn1luipsp = '<tr>' . $Vro2vlv0ntd5 . '</tr>';
          }
          $Vpkhn1luipsp_sample_six .= $Vpkhn1luipsp;
        }        
      }
    }

    $Vpkhn1luipsp_formula = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'" style="color:blue;font-style:italic;font-weight:bold;margin-bottom:15px;">
          Total % Berondolan Lepas = % Berondolan Lepas (sampling) + % Berondolan Lepas (khusus)
        </td>
      </tr>';
      
    $Vpkhn1luipsp_section_two_title = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="'.$V355lynlo0yl.'" style="font-weight:bold;">B. Jumlah Janjangan</td>
      </tr>';
    
    $Vpkhn1luipsp_section_three_title = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="'.$V355lynlo0yl.'" style="font-weight:bold;">C. Berat Berondolan Lepas (Kg)</td>
      </tr>';
    
    $Vpkhn1luipsp_section_four_title = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="'.$V355lynlo0yl.'" style="font-weight:bold;">D. Kerusakan Akibat Digigit Tikus</td>
      </tr>';
    
    $Vpkhn1luipsp_section_five_title = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="'.$V355lynlo0yl.'" style="font-weight:bold;">E. Sampah</td>
      </tr>';
    
    $Vpkhn1luipsp_comment_title = '
      <tr>
        <td colspan="'.$V355lynlo0yl.'">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="'.$V355lynlo0yl.'" style="font-weight:bold;">Komentar :</td>
      </tr>';
    
    $Vpkhn1luipsp_comment = '
      <tr>
        <td>- BUAH MENTAH</td>
        <td>:&nbsp;&nbsp;'.$Vvq2uqslzgha['buah_mentah'].'</td>
        <td colspan="'.(1+$Vuppbq1dpo3g_num).'"> % di atas standard</td>
      </tr>
      <tr>
        <td>- BUAH PARTHENOCARPIC</td>
        <td>:&nbsp;&nbsp;'.$Vvq2uqslzgha['parthenocarpic'].'</td>
        <td colspan="'.(1+$Vuppbq1dpo3g_num).'"> % di atas standard</td>
      </tr>
      <tr>
        <td>- JANJANGAN KOSONG</td>
        <td>:&nbsp;&nbsp;'.$Vvq2uqslzgha['janjangan_kosong'].'</td>
        <td colspan="'.(1+$Vuppbq1dpo3g_num).'"> % di atas standard</td>
      </tr>
      ';
    
      $this->structure = array(
        'tr_level_filtered'       => $Venyy5j1hcj2,
        'tr_title'                => $Vpq30p5zxafj,
        'tr_section_one_title'    => $Vc33mglos5jy,
        'tr_parent_level'         => $Vcan5bci0vdz,
        'tr_child_level'          => $Vkgb04iujdvi,
        'tr_section_one_sample'   => $Vvdgfa3pgtce.$Vpkhn1luipsp_sample_two,
        'tr_formula'              => $Vpkhn1luipsp_formula,
        'tr_section_two_title'    => $Vpkhn1luipsp_section_two_title,
        'tr_section_two_sample'   => $Vpkhn1luipsp_sample_three,
        'tr_section_three_title'  => $Vpkhn1luipsp_section_three_title,
        'tr_section_three_sample' => $Vpkhn1luipsp_sample_four,
        'tr_section_four_title'   => $Vpkhn1luipsp_section_four_title,
        'tr_section_four_sample'  => $Vpkhn1luipsp_sample_five,
        'tr_section_five_title'   => $Vpkhn1luipsp_section_five_title,
        'tr_section_five_sample'  => $Vpkhn1luipsp_sample_six,
        'tr_comment_title'        => $Vpkhn1luipsp_comment_title,
        'tr_comment'              => $Vpkhn1luipsp_comment,
      );
      
  }
  
}