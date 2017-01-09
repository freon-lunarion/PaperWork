<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('area_model'));
  }

  function index()
  {
    $this->load->view('area/view');
  }

  private function optParent()
  {
    $ls = $this->area_model->getList(NULL,TRUE);
    $result = array('0'=>'ROOT');
    foreach ($ls as $r) {
      $result[$r->area_id] = $r->area_title;
    }
    return $result;
  }

  public function formAdd()
  {
    $this->load->helper('form');
    $this->load->library('parser');
    $parent = $this->input->post('parent');
    $optParent = $this->optParent();
    $data      = array(
      'actionUrl' => base_url().'index.php/setting/area/processAdd',
      'hdnId'     => '',
      'txtName'   => '',
      'valParent' => $parent,
      'optParent' => $optParent,
    );
    $this->parser->parse('area/form', $data);
  }

  public function formEdit()
  {
    $this->load->helper('form');
    $this->load->library('parser');

    $id        = $this->input->post('id');
    $old       = $this->area_model->getById($id);
    $optParent = $this->optParent();
    $data      = array(
      'actionUrl' => base_url().'index.php/setting/area/processEdit',
      'hdnId'     => $id,
      'txtName'   => $old->area_title,
      'valParent' => $old->parent,
      'optParent' => $optParent,
    );
    $this->parser->parse('area/form', $data);
  }

  public function jsonList()
  {
    $parentId = $this->input->post('parent');
    $list = $this->area_model->get_datatables($parentId);
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
      "recordsTotal" => $this->area_model->count_all($parentId),
      "recordsFiltered" => $this->area_model->count_filtered($parentId),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);

  }

  public function jsonBreadcrumb($id=0,$temp = array())
  {
    if ($id == 0) {
      $temp[] = array('id'=>0,'name'=>'ROOT');
      echo json_encode($temp);

    } else {
      $row = $this->area_model->getById($id);
      $temp[] = array(
        'id'   => $row->area_id,
        'name' => $row->area_title
      );
      if (is_null($row->parent) || $row->parent == 0 ) {
        $temp[] = array('id'=>0,'name'=>'ROOT');
        $result = array_reverse($temp);
        echo json_encode($result);
      } else {
        return $this->jsonBreadcrumb($row->parent,$temp);
      }

    }
  }

  public function jsonDetail()
  {
    $id  = $this->input->post('id');
    $rec = $this->area_model->getById($id);
    echo json_encode($rec);
  }

  public function processAdd()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('slc_parent', 'Parent', 'required|integer');

    if ($this->form_validation->run() == FALSE) {

      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $title  = $this->input->post('txt_name');
      $parent = $this->input->post('slc_parent');
      $this->area_model->add($title,$parent);
      $respond = array('status'=>'OK','msg' => '');
    }
    echo json_encode($respond);
  }

  public function processEdit()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('txt_name', 'Title', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('slc_parent', 'Parent', 'required|integer');

    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $id     = $this->input->post('id');
      $title  = $this->input->post('txt_name');
      $parent = $this->input->post('slc_parent');
      $this->area_model->edit($id,$title,$parent);
      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);

  }

  public function processRemove()
  {
    $id = $this->input->post('id');
    if ($this->area_model->isUsed($id) == FALSE) {
      $this->area_model->remove($id);
      $respond = array('status'=>'OK','msg' => validation_errors());

    } else {
      $respond = array('status'=>'ERROR','msg' => '');

    }
    echo json_encode($respond);

  }

}
