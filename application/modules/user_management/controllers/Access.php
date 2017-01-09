<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array(
      'user_model',
      'access_model',
      'setting/area_model',
      'setting/role_model'
    ));
  }

  function index()
  {
    $this->load->view('view_access');

  }

  public function jsonList()
  {
    $list = $this->access_model->get_datatables();
    $action = array(
      ''
    );
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $r) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $r->username;
        $row[] = $r->role_name;
        $row[] = $r->area_name;
        $row['id'] = $r->access_id;

        $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->access_model->count_all(),
      "recordsFiltered" => $this->access_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);

  }

  public function formAdd()
  {
    $this->load->helper('form');

    $list = $this->user_model->getActive();
    $optUser  = array(''=>'');
    foreach ($list as $row) {
      $optUser[$row->user_id] = $row->username;
    }

    $list = $this->role_model->getList(TRUE);
    $optRole  = array(''=>'');
    foreach ($list as $row) {
      $optRole[$row->role_id] = $row->role_name;
    }

    $list = $this->area_model->getList(NULL,TRUE);
    $optArea  = array(''=>'');
    foreach ($list as $row) {
      $optArea[$row->area_id] = $row->area_title;
    }

    $data = array(
      'optUser' => $optUser,
      'optRole' => $optRole,
      'optArea' => $optArea,
    );
    $this->load->view('form_access',$data);
  }

  public function processAdd()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('slc_user', 'User', 'required');
    $this->form_validation->set_rules('slc_role', 'Role', 'required');
    $this->form_validation->set_rules('slc_area', 'Area', 'required');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $user_id = $this->input->post('slc_user');
      $area_id = $this->input->post('slc_area');
      $role_id = $this->input->post('slc_role');
      if ($this->access_model->inOnRecord($user_id,$area_id,$role_id)) {
        $respond = array('status'=>'ERROR','msg' => 'Already on record');

      } else {
        $this->access_model->add($user_id,$area_id,$role_id);
        $respond = array('status'=>'OK','msg' => '');

      }

    }
    echo json_encode($respond);

  }

  public function processRemove()
  {
    $id = $this->input->post('id');
    $this->access_model->remove($id);
    $respond = array('status'=>'OK','msg' => '');

    echo json_encode($respond);

  }

}
