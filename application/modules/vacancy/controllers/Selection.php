<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Selection extends CI_Controller{
  private $limit = 20;

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('vacancy_model','applicant_model','candidate_model'));
  }

  function index()
  {

  }

  public function firstPhase($vacId='')
  {
    $vacId = decode_url($vacId);

  }

  public function lastPhase($vacId='')
  {
    $vacId = decode_url($vacId);

  }

  public function phase($vacId='',$phaseCode='')
  {
    $phaseCode = decode_url($phaseCode);
    if ($phaseCode == '1') {
      redirect('vacancy/selection/firstPhase/'.$vacId);
    } else if ($phaseCode == '2') {
      redirect('vacancy/selection/lastPhase/'.$vacId);
    }
    $vacId = decode_url($vacId);
  }

  public function showPhase()
  {
    $vacId  = decode_url($this->input->post('vacId'));

  }

  public function showCvList()
  {
    $vacId  = decode_url($this->input->post('vacId'));
    $page   = $this->input->post('page');
    $offset = ($page - 1) * $this->limit;
    $ls     = $this->applicant_model->getLsByPhase($vacId, 1,0,$this->limit,$offset);
    foreach ($ls as $row) {
      $edu = $this->candidate_model->getLastEdu($row->candidate_id);
      $exp = $this->candidate_model->getLastExp($row->candidate_id);
    }
  }

  public function showApplicantList()
  {
    $vacId = decode_url($this->input->post('vacId'));
  }

  public function processReject()
  {
    $appId     = decode_url($this->input->post('appId'));
    $phaseCode = decode_url($this->input->post('phaseCode'));
  }

  public function processApprove()
  {
    $appId     = decode_url($this->input->post('appId'));
    $phaseCode = decode_url($this->input->post('phaseCode'));
  }

  public function processHire()
  {
    $appId     = decode_url($this->input->post('appId'));

  }

  public function processMove()
  {
    $appId     = decode_url($this->input->post('appId'));

  }


}
