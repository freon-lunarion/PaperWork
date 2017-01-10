<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('role_model','module_model'));

  }

  function index()
  {
    $this->load->view('role/view');
  }

  public function formAdd()
  {
    $this->load->library('parser');
    $ls = $this->module_model->getList();
    $mdlLs = array();
    $i = 0;
    foreach ($ls as $row) {
      $mdlLs[$i]['moduleName'] = $row->module_title;
      $mdlLs[$i]['moduleCode'] = $row->module_code;
      $mdlLs[$i]['self']       = 0;
      $mdlLs[$i]['group']      = 0;
      $mdlLs[$i]['sub']        = 0;
      $i++;
    }

    $data = array(
      'actionUrl' => base_url().'index.php/setting/role/processAdd',
      'hdnId'     => '',
      'txtName'   => '',
      'rdStatus0' => '',
      'rdStatus1' => 'checked',
      'module'    => $mdlLs,

    );
    $this->parser->parse('role/form', $data);
  }

  public function formEdit()
  {
    $this->load->model(array('permission_model'));
    $id  = $this->input->post('id');
    $old = $this->role_model->getById($id);
    $ls = $this->module_model->getList();
    $mdlLs = array();
    $i = 0;

    foreach ($ls as $row) {
      $mdlLs[$i]['moduleName'] = $row->module_title;
      $mdlLs[$i]['moduleCode'] = $row->module_code;
      $access = $this->permission_model->getByModuleAndRole($row->module_code,$id);
      if (count($access)) {
        $mdlLs[$i]['self']  = ($access->self_write * 2) + ($access->self_read * 1);
        $mdlLs[$i]['group'] = ($access->group_write * 2) + ($access->group_read * 1);
        $mdlLs[$i]['sub']   = ($access->sub_write * 2) + ($access->sub_read * 1);

      } else {
        $mdlLs[$i]['self']  = 0;
        $mdlLs[$i]['group'] = 0;
        $mdlLs[$i]['sub']   = 0;

      }
      $i++;


    }
    $this->load->library('parser');
    $data = array(
      'actionUrl' => base_url().'index.php/setting/role/processEdit',
      'hdnId'     => $id,
      'txtName'   => $old->role_name,
      'rdStatus0' => '',
      'rdStatus1' => '',
      'module'    => $mdlLs

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
        // $row[] = anchor('setting/permission/byRole/'.$r->id,$r->title);
        $row[] =$r->title;
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
    $this->load->model(array('permission_model'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $title  = $this->input->post('txt_name');
      $status = $this->input->post('rd_status');
      $role_id = $this->role_model->add($title,$status);
      $mdlLs = $this->module_model->getList();
      foreach ($mdlLs as $row) {
        // every module access will be change from integer value to binary value, eg 2 -> 10, 3->11
        // first digit (from left) is write access
        // second digit (from left) is read access
        // 0 -> 00 -> no access
        // 1 -> 01 -> read only
        // 2 -> 10 -> write only
        // 3 -> 11 -> write and read
        //
        // each module have three diffrent access
        // self  : for self-own data
        // group : for data on same group/area
        // sub   : for data on sub group/area

        $self  = decbin($this->input->post('slc_self_'.$module_code));
        $group = decbin($this->input->post('slc_group_'.$module_code));
        $sub   = decbin($this->input->post('slc_sub_'.$module_code));

        $this->permission_model->add(
          $row->module_code,$role_id,
          substr($self,1,1),substr($self,0,1),
          substr($group,1,1),substr($group,0,1),
          substr($sub,1,1),substr($sub,0,1)
        );
      }

      $respond = array('status'=>'OK','msg' => '');

    }
    echo json_encode($respond);
  }

  public function processEdit()
  {
    $this->load->model(array('permission_model'));

    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_name', 'Name', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());

    } else {
      $id = $this->input->post('id');
      $title  = $this->input->post('txt_name');
      $status = $this->input->post('rd_status');
      $this->role_model->edit($id,$title,$status);
      $mdlLs = $this->module_model->getList();
      foreach ($mdlLs as $row) {
        // every module access will be change from integer value to binary value, eg 2 -> 10, 3->11
        // first digit (from left) is write access
        // second digit (from left) is read access
        // 0 -> 00 -> no access
        // 1 -> 01 -> read only
        // 2 -> 10 -> write only
        // 3 -> 11 -> write and read
        //
        // each module have three diffrent access
        // self  : for self-own data
        // group : for data on same group/area
        // sub   : for data on sub group/area
        $self  = decbin($this->input->post('slc_self_'.$module_code));
        $group = decbin($this->input->post('slc_group_'.$module_code));
        $sub   = decbin($this->input->post('slc_sub_'.$module_code));

        // check on role_module table
        if ($this->permission_model->isAvailable($row->module_code,$id)) {

          $this->permission_model->edit(
            $row->module_code,$id,
            substr($self,1,1),substr($self,0,1),
            substr($group,1,1),substr($group,0,1),
            substr($sub,1,1),substr($sub,0,1)
          );
        } else {
          $this->permission_model->add(
            $row->module_code,$id,
            substr($self,1,1),substr($self,0,1),
            substr($group,1,1),substr($group,0,1),
            substr($sub,1,1),substr($sub,0,1)
          );

        }

      }

      $respond = array('status'=>'OK','msg' => '');
    }
    echo json_encode($respond);
  }

  public function processRemove()
  {
    $id = $this->input->post('id');

    $this->role_model->remove($id);
    $respond = array('status'=>'OK','msg' => '');
    echo json_encode($respond);

  }

}
