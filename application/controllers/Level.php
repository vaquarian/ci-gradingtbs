<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('session') );
    $this->load->model( 'level_model', 'level' );
    $this->load->helper( 'url' );
  }

  public function index()
  {
    $data = array(
      'title' => 'List of Level'
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'level/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'templates/footer' );
  }

  public function level_list( $type = 'vsp' )
  {
    if ( $type == 'vsp' || $type == 'vsc' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      if ( $type == 'vsc' && !empty($this->session->userdata('level')) ) 
      {
        switch( $this->session->userdata('level') ) 
        {
          case 'GROUP PARENT' : 
            $search['level'] = array('1','2','3','4'); break;
          case 'GROUP' :
            $search['level'] = array('2','3','4'); break;
          case 'REGION' :
            $search['level'] = array('3','4'); break;
          case 'ESTATE' : 
            $search['level'] = array('4'); break;
          default :
            $search['level'] = array(); break;
        }
      }
      $list = $this->level->get_datatables( $start, $length, $order, $search );
      $data = array();
      foreach ( $list as $level ) 
      {
        $start++;
        $row = array();
        $row[] = $level->level_name;
        $data[] = $row;
      }

      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->level->count_all(),
        "recordsFiltered" => $this->level->count_filtered( $order, $search ),
        "data" => $data,
      );

      echo json_encode( $output );
      exit();
    }
    else
    {
      show_404();
    }
  }
}