<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('user_model');
  }

  function index()
  {
    $this->load->view('view_main');
  }

  public function formAdd()
  {
    $this->load->library('parser');
    $data = array(
      'actionUrl'    => base_url().'index.php/user_management/user_management/processAdd',
      'hdnId'        => '',
      'txtUsername'  => '',
      'txtFirstname' => '',
      'txtLastname'  => '',
      'txtNickname'  => '',
      'txtEmail'     => '',
      'rdStatus0'    => '',
      'rdStatus1'    => 'checked',
    );
    $this->parser->parse('form_user', $data);
  }

  public function formEdit()
  {
    $id = $this->input->post('id');
    $old = $this->user_model->getById($id);
    $this->load->library('parser');
    $data = array(
      'actionUrl'    => base_url().'index.php/user_management/user_management/processEdit',
      'hdnId'        => $id,
      'txtUsername'  => $old->username,
      'txtFirstname' => $old->firstname,
      'txtLastname'  => $old->lastname,
      'txtNickname'  => $old->nickname,
      'txtEmail'     => $old->email,
      'rdStatus0'    => '',
      'rdStatus1'    => '',
    );
    if ($old->is_active) {
      $data['rdStatus1'] = 'checked';
    } else {
      $data['rdStatus0'] = 'checked';

    }
    $this->parser->parse('form_user', $data);
  }

  public function formPassword()
  {
    $id = $this->input->post('id');
    $this->load->library('parser');
    $data = array(
      'actionUrl'    => base_url().'index.php/user_management/user_management/processPassword',
      'hdnId'        => $id,

    );
    $this->parser->parse('form_pass', $data);

  }

  public function jsonList()
  {
    $list = $this->user_model->get_datatables();
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
        $row[] = $r->firstname;
        $row[] = $r->lastname;
        $row[] = $r->nickname;
        $row[] = $r->email;
        $row['id'] = $r->id;

        $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->user_model->count_all(),
      "recordsFiltered" => $this->user_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  public function processAdd()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_username', 'Username', 'required|min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_firstname', 'Firstname', 'required|min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_lastname', 'Lastname', 'min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_nickname', 'Nickname', 'required|min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_email', 'Email', 'required|valid_email');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());
    } else {
      $username  = $this->input->post('txt_username');
      $firstname = $this->input->post('txt_firstname');
      $lastname  = $this->input->post('txt_lastname');
      $nickname  = $this->input->post('txt_nickname');
      $email     = $this->input->post('txt_email');
      $status    = $this->input->post('rd_status');
      $password = 'abcd1234';


      if ($this->user_model->isEmailAvailable($email) == FALSE) {
        $respond = array('status'=>'ERROR','msg' => 'Email is not available');

      } else if ($this->user_model->isUsernameAvailable($username) == FALSE) {
        $respond = array('status'=>'ERROR','msg' => 'Username is not available');

      } else {
        $this->user_model->add($username,$password,$email,$firstname,$lastname,$nickname);

        $respond = array('status'=>'OK','msg' => '');

      }

    }
    echo json_encode($respond);
  }

  public function processEdit()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_username', 'Username', 'required|min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_firstname', 'Firstname', 'required|min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_lastname', 'Lastname', 'min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_nickname', 'Nickname', 'required|min_length[2]|max_length[250]|alpha_dash');
    $this->form_validation->set_rules('txt_email', 'email', 'required|valid_email');
    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());
    } else {
      $id        = $this->input->post('id');
      $old       = $this->user_model->getById($id);
      $username  = $this->input->post('txt_username');
      $firstname = $this->input->post('txt_firstname');
      $lastname  = $this->input->post('txt_lastname');
      $nickname  = $this->input->post('txt_nickname');
      $email     = $this->input->post('txt_email');
      $status    = $this->input->post('rd_status');

      if ($this->user_model->isEmailAvailable($email) == FALSE && $old->email != $email) {
        $respond = array('status'=>'ERROR','msg' => 'Email is not available');

      } else if ($this->user_model->isUsernameAvailable($username) == FALSE && $old->username != $username) {
        $respond = array('status'=>'ERROR','msg' => 'Username is not available');

      } else {
        $password = 'abc123';
        $this->user_model->edit($id, $username,$email,$firstname,$lastname,$nickname,$status);

        $respond = array('status'=>'OK','msg' => '');

      }
      echo json_encode($respond);

    }
  }

  public function processPassword()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('pass_new', 'New Password', 'required|min_length[6]|max_length[100]|alpha_dash');
    $this->form_validation->set_rules('pass_confirm', 'Confirm Password', 'required|min_length[6]|max_length[100]|alpha_dash|matches[pass_new]');

    if ($this->form_validation->run() == FALSE) {
      $respond = array('status'=>'ERROR','msg' => validation_errors());
    } else {
      $id      = $this->input->post('id');
      $new     = $this->input->post('pass_new');
      $confirm = $this->input->post('pass_confirm');

      if ($new == $confirm) {
        $this->user_model->editPassword($id, $confirm);
        $respond = array('status'=>'OK','msg' => '');
      } else {
        $respond = array('status'=>'ERROR','msg' => 'New and Confirm Password not same');

      }

    }
    echo json_encode($respond);

  }


}
