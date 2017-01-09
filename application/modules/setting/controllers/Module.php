<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('module_model');

  }

  function index()
  {
    $this->load->view('module/view');

  }

  public function formAdd()
  {
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/module/processAdd',
      'txtCode'   => '',
      'txtName'   => '',
      'txtLink'   => '',
    );
    $this->parser->parse('module/form', $data);
  }

  public function formEdit()
  {
    $id  = $this->input->post('id');
    $old = $this->module_model->getByCode($id);
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/module/processEdit',
      'txtCode'   => $old->module_code,
      'txtName'   => $old->module_title,
      'txtLink'   => $old->link,
    );
    $this->parser->parse('module/form', $data);
  }

  public function jsonList()
  {

    $list = $this->module_model->get_datatables();
    $action = array(
      ''
    );
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $r) {
        $no++;
        $row = array();
        $row[] = $r->code;
        $row[] = $r->title;
        $row['id'] = $r->code;

        $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->module_model->count_all(),
      "recordsFiltered" => $this->module_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  public function processAdd()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_code', 'Code', 'required|min_length[2]|max_length[30]|alpha_dash');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[3]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('txt_link', 'Link', 'required|min_length[3]|max_length[150]');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $code  = $this->input->post('txt_code');
      $title = $this->input->post('txt_name');
      $link  = $this->input->post('txt_link');
      $this->module_model->add($code,$title,$link);
      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);

  }

  public function processEdit()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[3]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('txt_link', 'Link', 'required|min_length[3]|max_length[150]');
    if ($this->form_validation->run() == FALSE) {

      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $code  = $this->input->post('txt_code');
      $title = $this->input->post('txt_name');
      $link  = $this->input->post('txt_link');
      $this->module_model->edit($code,$title,$link);

      $respond = array('status'=>'OK','msg' => '');
    }
    echo json_encode($respond);

  }

  public function processRemove()
  {
    $code = $this->input->post('id');
    if ($this->module_model->isUsed($code) == FALSE) {
      $this->module_model->remove($code);
      $respond = array('status'=>'OK','msg' => '');

    } else {
      $respond = array('status'=>'ERROR','msg' => '');

    }
    echo json_encode($respond);


  }

}
