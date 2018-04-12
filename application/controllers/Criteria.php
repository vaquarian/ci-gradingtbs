<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Criteria extends CI_Controller {

  public $hidden_menu = null;
  public $sub_menu_access = null;
  public $access = null;
  public $allowed_menu = null;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library( array('form_validation', 'session') );
    $this->is_loggedin();
    $this->load->helper( array('html', 'url', 'form', 'security') );
    $this->load->model( 'criteria_model', 'criteria' );
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
    $disallowed_sub_menu = array();
    $allowed_sub_menu = array();
    if ( !empty($this->sub_menu_access) )
    {
      foreach ( $this->sub_menu_access as $sub_menu ) 
      {
        if ( $sub_menu->view_permission == '0' ) {
          $disallowed_sub_menu[] = $sub_menu->menu_name;
        } else if ( $sub_menu->view_permission == '1' ) {
          $allowed_sub_menu[] = $sub_menu->menu_name;
        }
      }
    }
    $this->hidden_menu = $this->role_access->get_menu_access( $disallowed_sub_menu );
    $this->allowed_menu = array_merge( $allowed_sub_menu, $this->hidden_menu );
    $this->access = $this->role_access->get_crud_access( 'Master Grading Criteria', $this->session->userdata['role_id'] );
    if ( $this->access->view_permission != '1' && $this->uri->segment(3) != 'vsc' )
    {
      redirect('home');
    }
  }
  
  public function index()
  {
    $data = array(
      'title' => 'Master Grading Criteria',
      'description' => '',
      'css_files' => array( 
          'assets/css/select/bootstrap-select.min.css' 
      ),
      'js_files' => array( 
          base_url() . 'assets/js/select/bootstrap-select.min.js', 
          base_url() . 'assets/js/custom/vs.criteria.js'
      ),
      'allowed_menu' => $this->allowed_menu,
      'add_permission' => $this->access->add_permission
    );

    $this->load->view( 'templates/header', $data );
    $this->load->view( 'criteria/index', $data );
    $this->load->view( 'templates/footer_js', $data );
    $this->load->view( 'modal/criteria_modal_form', $data );
    $this->load->view( 'templates/footer' );
  }

  public function criteria_list( $type = 'vsp' )
  {
    if ( $type == 'vsp' || $type == 'vsc' )
    {
      $draw = intval( $this->input->post('draw') );
      $start = intval( $this->input->post('start') );
      $length = intval( $this->input->post('length') );
      $order = $this->input->post('order');
      $search = $this->input->post('search');
      
      $data = array();
      $list = $this->criteria->get_datatables( $start, $length, $order, $search );
      foreach ( $list as $criteria ) 
      {
        $start++;
        $action = '';
        $row = array();
        $row[] = $criteria->index_num;
        $row[] = $criteria->criteria_code;        
        $row[] = $criteria->criteria_name;        
        $row[] = $criteria->type;
        $row[] = $criteria->state;

        if ( $type == 'vsp' )
        {
          if ( $this->access->edit_permission == '1' ) 
          {
            $action .= '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit Criteria" onclick="send_action('."'edit','".$criteria->criteria_code."'".')"><i class="glyphicon glyphicon-pencil"></i></a> ';
          }
          if ( $this->access->delete_permission == '1' ) 
          {
            $action .= '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete Criteria" onclick="send_action('."'delete','".$criteria->criteria_code."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
          }
        }
        $row[] = $action;
        $data[] = $row;
      }
      
      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->criteria->count_all(),
        "recordsFiltered" => $this->criteria->count_filtered( $order, $search ),
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
    
  public function criteria_edit( $id )
  {
    $data = $this->criteria->get_by_id( $id );
    echo json_encode( $data );
    exit();
  }

  public function criteria_add()
  {
    $this->_form_validation( 'insert' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'criteria_code' => strtoupper($this->input->post('criteria_code')),
      'index_num' => $this->input->post('index_num'),
      'criteria_name' => strtoupper($this->input->post('criteria_name')),
      'type' => $this->input->post('type'),
      'state' => $this->input->post('state'),
      'create_user' => $this->session->userdata('user_name'),
      'create_date' => $now
    );
    $this->criteria->save( $data );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  public function criteria_update()
  {
    $this->_form_validation( 'update' );
    $now = date('Y-m-d H:i:s');
    $data = array(
      'index_num' => $this->input->post('index_num'),
      'criteria_name' => strtoupper($this->input->post('criteria_name')),
      'type' => $this->input->post('type'),
      'state' => $this->input->post('state'),
      'modify_user' => $this->session->userdata('user_name'),
      'modify_date' => $now
    );
    $this->criteria->update(array(
                'criteria_code' => $this->input->post('criteria_code')
            ), $data);
    echo json_encode( array("status" => TRUE) );
    exit();
  }
  
  public function criteria_delete( $id )
  {
    $this->criteria->delete_by_id( $id );
    echo json_encode( array("status" => TRUE) );
    exit();
  }

  function alpha_space_only( $string )
  {
    if ( !preg_match("/^[a-zA-Z ]+$/", $string) )
    {
      $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  private function _form_validation( $type = 'insert' )
  {
    $this->form_validation->set_error_delimiters('', '');
    if ( $type == 'insert' ) {
      $this->form_validation->set_rules('criteria_code', 'Criteria Code', 'trim|required|min_length[2]|max_length[10]|xss_clean|is_unique[grading_criteria.criteria_code]',
                                          array(
                                              'is_unique' => 'This %s already exists.'
                                          ) );
      $this->form_validation->set_rules('index_num', 'Criteria Index', 'trim|required|xss_clean|is_unique[grading_criteria.index_num]',
                                          array(
                                              'is_unique' => 'This %s already exists.'
                                          ) );
    } else {
      $this->form_validation->set_rules('criteria_code', 'Criteria Code', 'trim|required|min_length[2]|max_length[10]|xss_clean');
      $this->form_validation->set_rules('index_num', 'Criteria Index', 'trim|required|xss_clean');
    }
    $this->form_validation->set_rules('criteria_name', 'Criteria Name', 'trim|required|min_length[5]|max_length[50]|xss_clean');
    $this->form_validation->set_rules('type', 'Criteria Type', 'trim|required|xss_clean');
    $this->form_validation->set_rules('state', 'Criteria Condition', 'trim|required|xss_clean');

    $response = array();
    $response['status'] = TRUE;
    if ( $this->form_validation->run() === FALSE )
    {
      $errors = array();
      foreach ($this->input->post() as $key => $value)
      {
        $errors[$key] = form_error($key);
      }
      $response['errors'] = array_filter($errors);
      $response['status'] = FALSE;

      echo json_encode( $response );
      exit();
    }
  }
}