<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edu_level extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('eduLevel_model');

  }

  function index()
  {
    $this->load->view('edu_level/view');

  }

  public function formAdd()
  {
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/edu_level/processAdd',
      'hdnId'   => '',
      'txtName'   => '',
      'nmScore'   => '',
    );
    $this->parser->parse('edu_level/form', $data);
  }

  public function formEdit()
  {
    $id  = $this->input->post('id');
    $old = $this->eduLevel_model->getById($id);
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/edu_level/processEdit',
      'hdnId'     => $id,
      'txtName'   => $old->title,
      'nmScore'   => $old->score,
    );
    $this->parser->parse('edu_level/form', $data);
  }

  public function jsonList()
  {

    $list = $this->eduLevel_model->get_datatables();
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
        $row[] = $r->score;
        $row['id'] = $r->id;

        $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->eduLevel_model->count_all(),
      "recordsFiltered" => $this->eduLevel_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  public function processAdd()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('txt_name', 'Name', 'required|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('nm_score', 'Score', 'required');

    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {

      $title = $this->input->post('txt_name');
      $score  = $this->input->post('nm_score');
      $this->eduLevel_model->add($title,$score);
      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);

  }

  public function processEdit()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('nm_score', 'Score', 'required');
    if ($this->form_validation->run() == FALSE) {

      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $id     = $this->input->post('id');
      $title  = $this->input->post('txt_name');
      $score  = $this->input->post('nm_score');
      $this->eduLevel_model->edit($id,$title,$score);

      $respond = array('status'=>'OK','msg' => '');
    }
    echo json_encode($respond);

  }

  public function processRemove()
  {
    $code = $this->input->post('id');
    if ($this->eduLevel_model->isUsed($code) == FALSE) {
      $this->eduLevel_model->remove($code);
      $respond = array('status'=>'OK','msg' => '');

    } else {
      $respond = array('status'=>'ERROR','msg' => '');

    }
    echo json_encode($respond);


  }

}
