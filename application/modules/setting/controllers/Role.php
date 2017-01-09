<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('role_model'));

  }

  function index()
  {
    $this->load->view('role/view');
  }

  public function formAdd()
  {
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/role/processAdd',
      'hdnId'     => '',
      'txtName'   => '',
      'rdStatus0' => '',
      'rdStatus1' => 'checked',
    );
    $this->parser->parse('role/form', $data);
  }

  public function formEdit()
  {
    $id  = $this->input->post('id');
    $old = $this->role_model->getById($id);
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/role/processEdit',
      'hdnId'     => $id,
      'txtName'   => $old->role_name,
      'rdStatus0' => '',
      'rdStatus1' => '',
    );

    if ($old->is_active) {
      $data['rdStatus1'] = 'checked';
    } else {
      $data['rdStatus0'] = 'checked';

    }
    $this->parser->parse('role/form', $data);
  }

  public function jsonList()
  {
    $list = $this->role_model->get_datatables();
    $action = array(
      ''
    );
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $r) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $r->title;
        $row['id'] = $r->id;

        $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->role_model->count_all(),
      "recordsFiltered" => $this->role_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  // public function jsonDetail()
  // {
  //   $id  = $this->input->post('id');
  //   $rec = $this->role_model->getById($id);
  //   echo json_encode($rec);
  // }

  public function processAdd()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $title  = $this->input->post('txt_name');
      $status = $this->input->post('rd_status');
      $this->role_model->add($title,$status);

      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);
  }

  public function processEdit()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $id = $this->input->post('id');
      $title  = $this->input->post('txt_name');
      $status = $this->input->post('rd_status');
      $this->role_model->edit($id,$title,$status);

      $respond = array('status'=>'OK','msg' => '');
    }
    echo json_encode($respond);
  }

  public function processRemove()
  {
    $id = $this->input->post('id');
    if ($this->role_model->isUsed($id) == FALSE) {
      $this->role_model->remove($id);
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);

  }

}
