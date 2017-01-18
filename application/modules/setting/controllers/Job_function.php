<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_function extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('jobFunction_model');

  }

  function index()
  {
    $this->load->view('job_function/view');

  }

  public function formAdd()
  {
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/job_function/processAdd',
      'txtCode'   => '',
      'txtName'   => '',
      'txtLink'   => '',
    );
    $this->parser->parse('job_function/form', $data);
  }

  public function formEdit()
  {
    $id  = $this->input->post('id');
    $old = $this->jobFunction_model->getById($id);
    $this->load->library('parser');
    $data = array(
      'actionUrl'    => base_url().'index.php/setting/job_function/processEdit',
      'hdnId'        => $old->id,
      'txtName'      => $old->title,

    );

    $this->parser->parse('job_function/form', $data);
  }

  public function jsonList()
  {

    $list = $this->jobFunction_model->get_datatables();
    $action = array(
      ''
    );
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $r) {
        $no++;
        $row = array();
        $row[] = $r->id;
        $row[] = $r->title;
        $row['id'] = $r->id;
        $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->jobFunction_model->count_all(),
      "recordsFiltered" => $this->jobFunction_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  public function processAdd()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[3]|max_length[250]');


    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $title        = $this->input->post('txt_name');

      $this->jobFunction_model->add($title);
      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);

  }

  public function processEdit()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[3]|max_length[250]');

    if ($this->form_validation->run() == FALSE) {

      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $id           = $this->input->post('id');
      $title        = $this->input->post('txt_name');

      $this->jobFunction_model->edit($id,$title);

      $respond = array('status'=>'OK','msg' => '');
    }
    echo json_encode($respond);

  }

  public function processRemove()
  {
    $id = $this->input->post('id');
    if ($this->jobFunction_model->isUsed($id) == FALSE) {
      $this->jobFunction_model->remove($id);
      $respond = array('status'=>'OK','msg' => '');

    } else {
      $respond = array('status'=>'ERROR','msg' => '');

    }
    echo json_encode($respond);


  }

}
