<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vacancy extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('vacancy_model'));

  }

  function index()
  {
    $this->load->view('view_main');
  }

  public function jsonList()
  {
    $this->load->model(array('applicant_model'));
    $keyword   = $this->input->post('');
    $page      = $this->input->post('');
    $start     = $this->input->post('');
    $end       = $this->input->post('');
    $limit     = 10;
    $offset    = ($page - 1) * $limit;
    $vacancyLs = $this->vacancy_model->getList($start,$end,$keyword,$limit,$offset);
    $i = 0;
    foreach ($vacancyLs as $vac) {
      $phaseLs = $this->vacancy_model->getPhaseLs($vac->vacancy_id);
      $j = 0;
      foreach ($phaseLs as $pha) {
        // TODO count candidate on each phase
        $j++;
      }
      $i++;
    }

    $filterNum = $this->vacancy_model->countFiltered($start,$end,$keyword,$limit,$offset);

  }

  public function formAdd()
  {

  }

  public function formEdit()
  {
    $id = $this->input->post('id');

  }

  public function processAdd()
  {
    // New Page for form
  }

  public function processEdit($id)
  {
    // New Page for form

  }

  public function processRemove()
  {
    $id = $this->input->post('id');

  }
}
