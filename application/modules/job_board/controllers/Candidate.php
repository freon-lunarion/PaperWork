<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $id  = 0 ; //by session candidateId;

  }

  public function register()
  {
    $this->load->view('candidate/form_register');
  }

  public function processRegister()
  {

  }

  public function checkEmail()
  {
    $email = $this->input->post('email');
    $count = $this->candidate_model->countByEmail($email);
    if ($check > 0) {
      return false;
    } else {
      return true;
    }
  }

  public function activation($enToken='')
  {
    // first array is candidateId, second array is email
    $data = explode('|',decode_url($enToken));
    // TODO match candidateId with email

    $record = $this->candidate_model->getByEmail($data[1]);
    $cand = $this->candidate_model->getById($data[0]);

    if ($record == TRUE && $record->id == $data[0] && $cand->is_active == FALSE) {
      $this->load->view('candidate/form_activation');
    } else {

    }

  }

  public function token()
  {

  }

  public function profile($enUserId='')
  {
    $userId = encode_url($enUserId);

  }

  public function forgotPass()
  {
    $this->load->view('candidate/form_forgot');

  }

  public function processForgotPass()
  {

  }

  public function changePass()
  {
    $id  = 0 ; //by session candidateId;
    $old = $this->candidate_model->getById($id);
    $this->load->view('candidate/form_changePass', $data);

  }

  public function processChangePass()
  {

  }

  public function changeBio()
  {
    $id  = 0 ; //by session candidateId;
    $old = $this->candidate_model->getById($id);
    $this->load->view('candidate/form_changeBio', $data);
  }

  public function processChangeBio()
  {

  }

  public function changeContact()
  {
    $id  = 0 ; //by session candidateId;
    $old = $this->candidate_model->getById($id);
    $this->load->view('candidate/form_changeContact', $data);
  }

  public function processChangeContact()
  {

  }

}
