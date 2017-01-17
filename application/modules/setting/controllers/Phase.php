<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phase extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('phase_model');

  }

  function index()
  {
    $this->load->view('phase/view');

  }

  public function formAdd()
  {
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/phase/processAdd',
      'txtCode'   => '',
      'txtName'   => '',
      'txtLink'   => '',
    );
    $this->parser->parse('phase/form', $data);
  }

  public function formEdit()
  {
    $id  = $this->input->post('id');
    $old = $this->phase_model->getByCode($id);
    $this->load->library('parser');
    $data = array(
      'actionUrl'    => base_url().'index.php/setting/phase/processEdit',
      'hdnId'        => $old->phase_code,
      'txtName'      => $old->phase_title,
      'rdMandatory0' => '',
      'rdMandatory1' => '',
      'rdSchedule0'  => '',
      'rdSchedule1'  => '',
    );

    if ($old->is_mandatory == 1) {
      $data['rdMandatory1'] = 'checked';
    } else {
      $data['rdMandatory0'] = 'checked';

    }

    if ($old->has_schedule == 1) {
      $data['rdSchedule1'] = 'checked';
    } else {
      $data['rdSchedule0'] = 'checked';

    }

    $this->parser->parse('phase/form', $data);
  }

  public function jsonList()
  {

    $list = $this->phase_model->get_datatables();
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
        $row[] = $r->is_mandatory;
        $row[] = $r->has_schedule;
        $row['id'] = $r->code;

        $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->phase_model->count_all(),
      "recordsFiltered" => $this->phase_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  public function processAdd()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[3]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('rd_mandatory', 'Mandatory', 'required');
    $this->form_validation->set_rules('rd_schedule', 'Schedule', 'required');

    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $title        = $this->input->post('txt_name');
      $is_mandatory = $this->input->post('rd_mandatory');
      $has_schedule = $this->input->post('rd_schedule');
      $this->phase_model->add($title,$is_mandatory,$has_schedule);
      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);

  }

  public function processEdit()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[3]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('rd_mandatory', 'Mandatory', 'required');
    $this->form_validation->set_rules('rd_schedule', 'Schedule', 'required');
    if ($this->form_validation->run() == FALSE) {

      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $id           = $this->input->post('id');
      $title        = $this->input->post('txt_name');
      $is_mandatory = $this->input->post('rd_mandatory');
      $has_schedule = $this->input->post('rd_schedule');
      $this->phase_model->edit($id,$title,$is_mandatory,$has_schedule);

      $respond = array('status'=>'OK','msg' => '');
    }
    echo json_encode($respond);

  }

  public function processRemove()
  {
    $code = $this->input->post('id');
    if ($this->phase_model->isUsed($code) == FALSE) {
      $this->phase_model->remove($code);
      $respond = array('status'=>'OK','msg' => '');

    } else {
      $respond = array('status'=>'ERROR','msg' => '');

    }
    echo json_encode($respond);


  }

}
