<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Selection extends CI_Controller{
  private $limit = 20;

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('vacancy_model','applicant_model','candidate_model','master_model'));
    $this->load->library('parser');

  }

  function index()
  {

  }

  public function firstPhase($vacId='')
  {
    $vacId   = decode_url($vacId);
    $phaseLs = $this->vacancy_model->getPhaseLs($vacId);
    $vac     = $this->vacancy_model->getRow($vacId);
    $phas    = $this->master_model->getPhaseRow(1);
    $eduLs   = $this->master_model->getEduLevelLs();

    $phase   = array();
    $j       = 0;
    foreach ($phaseLs as $pha) {
      // TODO count candidate on each phase
      $appNum = $this->applicant_model->countByPhase($vac->vacancy_id,$pha->phase_code);
      $phase[$j] = array(
        'phaseActive' => '',
        'phaseCode'   => $pha->phase_code,
        'phaseName'   => $pha->phase_name,
        'selectUrl'   => site_url('vacancy/selection/phase/'.encode_url($vacId).'/'.encode_url($pha->phase_code)),
        'appNum'      => $appNum,

      );
      if ($pha->phase_code == 1) {
        $phase[$j]['phaseActive'] = 'active';
      }
      $j++;
    }
    $hiredNum = $this->applicant_model->countHired($vacId);
    $data = array(
      'vacId'      => encode_url($vacId),
      'subtitle'   => $phas->title,
      'editUrl'    => site_url('vacancy/formEdit/'.encode_url($vacId)),
      'vacCode'    => $vac->vacancy_code,
      'vacTitle'   => $vac->vacancy_title,
      'phase'      => $phase,
      'hiredNum'   => $hiredNum,
      'rejectNum'  => $this->applicant_model->countRejected($vacId),
      'optEdu'     => $eduLs,
    );
    $this->parser->parse('selection/view_first',$data);
  }

  public function lastPhase($vacId='')
  {
    $vacId = decode_url($vacId);
    $phaseLs = $this->vacancy_model->getPhaseLs($vacId);
    $vac     = $this->vacancy_model->getRow($vacId);
    $phas    = $this->master_model->getPhaseRow(2);

    $phase = array();
    $j = 0;
    foreach ($phaseLs as $pha) {
      // TODO count candidate on each phase
      $appNum = $this->applicant_model->countByPhase($vac->vacancy_id,$pha->phase_code);
      $phase[$j] = array(
        'phaseActive' => '',
        'phaseCode'   => $pha->phase_code,
        'phaseName'   => $pha->phase_name,
        'selectUrl'   => site_url('vacancy/selection/phase/'.encode_url($vacId).'/'.encode_url($pha->phase_code)),
        'appNum'      => $appNum,

      );
      if ($pha->phase_code == 2) {
        $phase[$j]['phaseActive'] = 'active';
      }
      $j++;
    }
    $hiredNum = $this->applicant_model->countHired($vacId);
    $data = array(
      'vacId'      => encode_url($vacId),
      'subtitle'   => $phas->title,
      'editUrl'    => site_url('vacancy/formEdit/'.encode_url($vacId)),
      'vacCode'    => $vac->vacancy_code,
      'vacTitle'   => $vac->vacancy_title,
      'phase'      => $phase,
      'hiredNum'   => $hiredNum,
      'rejectNum'  => $this->applicant_model->countRejected($vacId),
    );
    $this->parser->parse('selection/view_last',$data);

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
    $phaseLs = $this->vacancy_model->getPhaseLs($vacId);
    $vac     = $this->vacancy_model->getRow($vacId);
    $phas    = $this->master_model->getPhaseRow($phaseCode);

    $phase = array();
    $j = 0;
    foreach ($phaseLs as $pha) {
      // TODO count candidate on each phase
      $appNum = $this->applicant_model->countByPhase($vac->vacancy_id,$pha->phase_code);
      $phase[$j] = array(
        'phaseActive' => '',
        'phaseCode'   => $pha->phase_code,
        'phaseName'   => $pha->phase_name,
        'selectUrl'   => site_url('vacancy/selection/phase/'.encode_url($vacId).'/'.encode_url($pha->phase_code)),
        'appNum'      => $appNum,

      );
      if ($pha->phase_code == $phaseCode) {
        $phase[$j]['phaseActive'] = 'active';
      }
      $j++;
    }
    $hiredNum = $this->applicant_model->countHired($vacId);
    $data = array(
      'vacId'      => encode_url($vacId),
      'subtitle'   => $phas->title,
      'editUrl'    => site_url('vacancy/formEdit/'.encode_url($vacId)),
      'vacCode'    => $vac->vacancy_code,
      'vacTitle'   => $vac->vacancy_title,
      'phase'      => $phase,
      'hiredNum'   => $hiredNum,
      'rejectNum'  => $this->applicant_model->countRejected($vacId),
    );
    $this->parser->parse('selection/view_phase',$data);
  }

  public function showPhase()
  {
    $vacId  = decode_url($this->input->post('vacId'));

  }

  public function showCvList()
  {
    $vacId  = decode_url($this->input->post('vacId'));

    // criteria
    // $eduMin = $this->input->post('eduMin');
    $extra['ageMin'] = $this->input->post('ageMin');
    $extra['ageMax'] = $this->input->post('ageMax');
    $gender = $this->input->post('gender');
    if ($gender == 'male' ) {
      $extra['gender'] = 1;

    } elseif ($gender == 'female') {
      $extra['gender'] = 0;
    }

    $page   = $this->input->post('page');
    $offset = ($page - 1) * $this->limit;
    $ls     = $this->applicant_model->getByPhaseLs($vacId, 1,0,$this->limit,$offset,$extra);
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
