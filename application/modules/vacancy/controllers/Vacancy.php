<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vacancy extends CI_Controller{

  private $limit = 10;

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('vacancy_model','applicant_model'));

  }

  function index()
  {
    $this->load->view('job/view_main');
  }

  public function showList()
  {
    $this->load->library('parser' );
    $this->load->library('encryption' );
    $keyword   = $this->input->post('keyword');
    $status    = $this->input->post('status');
    $page      = $this->input->post('page');
    $start     = $this->input->post('start');
    $end       = $this->input->post('end');
    if ($page < 1) {
      $page = 1;
    }

    $offset    = ($page - 1) * $this->limit;
    switch ($status) {
      case 'publish':
        $status = TRUE;
        break;
      case 'unpublish':
        $status = FALSE;
        break;
      default:
        $status = NULL;
        break;
    }
    $vacancyLs = $this->vacancy_model->getList($start,$end,$keyword,$status,$this->limit,$offset);
    // var_dump($vacancyLs);
    $respond = array();
    $list    = array();

    foreach ($vacancyLs as $vac) {
      $phaseLs = $this->vacancy_model->getPhaseLs($vac->vacancy_id);
      $phase = array();
      $j = 0;
      foreach ($phaseLs as $pha) {
        // TODO count candidate on each phase
        $appNum = $this->applicant_model->countByPhase($vac->vacancy_id,$pha->phase_code);
        $phase[$j] = array(
          'phaseCode' => $pha->phase_code,
          'phaseName' => $pha->phase_name,
          'selectUrl' => site_url('vacancy/selection/phase/'.encode_url($vac->vacancy_id).'/'.encode_url($pha->phase_code)),
          'appNum'    => $appNum,

        );
        $j++;
      }
      $hiredNum = $this->applicant_model->countHired($vac->vacancy_id);
      $data = array(
        'vacId'      => encode_url($vac->vacancy_id),
        'editUrl'    => site_url('vacancy/formEdit/'.encode_url($vac->vacancy_id)),
        'vacCode'    => $vac->vacancy_code,
        'vacTitle'   => $vac->vacancy_title,
        'phase'      => $phase,
        'hiredNum'   => $hiredNum,
        'rejectNum'  => $this->applicant_model->countRejected($vac->vacancy_id),
      );


      if ($vac->is_visible) {
        $data['panelColor'] = 'panel-info';
        $data['pubStatus']  = '<i class="fa fa-eye-slash"></i> Unpublish';

      } else {
        $data['panelColor'] = 'panel-default';
        $data['pubStatus']  = '<i class="fa fa-eye"></i> Publish';

      }

      if ($hiredNum >= $vac->qty) {
        $data['panelColor'] = 'panel-success';
      }
      $this->parser->parse('job/view_list', $data);
    }


  }

  public function showPage()
  {
    $keyword   = $this->input->post('keyword');
    $status    = $this->input->post('status');
    $page      = $this->input->post('page');
    $start     = $this->input->post('start');
    $end       = $this->input->post('end');

    switch ($status) {
      case 'publish':
        $status = TRUE;
        break;
      case 'unpublish':
        $status = FALSE;
        break;
      default:
        $status = NULL;
        break;
    }
    $totalRec = $this->vacancy_model->countFiltered($start, $end, $keyword,$status);
    $totalPage = ceil($totalRec/$this->limit);
    if ($page < 1) {
      $page = 1;
    } else if ($page > $totalPage) {
      $page = $totalPage;
    }
    $data = array(
      'page' => $page,
      'total' => $totalPage
    );
    echo $this->load->view('job/view_pagination',$data);
  }

  public function formAdd()
  {
    $this->load->model(array('master_model'));
    $this->load->helper(array('form'));
    $ls = $this->master_model->getArea();
    $optArea = array('' => '');
    foreach ($ls as $row) {
      $optArea[$row->id] = $row->title;
    }

    $ls = $this->master_model->getJobType();
    $optJobType = array('' => '');
    foreach ($ls as $row) {
      $optJobType[$row->id] = $row->title;
    }

    $ls = $this->master_model->getJobLevel();
    $optJobLevel = array('' => '');
    foreach ($ls as $row) {
      $optJobLevel[$row->id] = $row->title;
    }

    $ls = $this->master_model->getJobFunction();
    $optJobFunc = array('' => '');
    foreach ($ls as $row) {
      $optJobFunc[$row->id] = $row->title;
    }

    $phase = $this->master_model->getPhaseLs();

    $data =array(
      'optJobType'  => $optJobType,
      'optJobLevel' => $optJobLevel,
      'optJobFunc'  => $optJobFunc,
      'optArea'     => $optArea,
      'phase'       => $phase,
      'hidden'      => array(),
      'code'        => '',
      'name'        => '',
      'qty'         => '',
      'area'        => '',
      'type'        => '',
      'func'        => '',
      'level'       => '',
      'open'        => '',
      'close'       => '',
      'desc'        => '',
      'req'         => '',
      'ben'         => '',
      'processUrl'  => 'vacancy/processAdd',
      'mode'        => 'Add',

    );
    $this->load->view('job/form', $data);
  }

  public function formEdit($en_id=0)
  {
    $id = decode_url($en_id);
    $this->load->model(array('master_model'));
    $this->load->helper(array('form'));

    $ls = $this->master_model->getArea();
    $optArea = array('' => '');
    foreach ($ls as $row) {
      $optArea[$row->id] = $row->title;
    }

    $ls = $this->master_model->getJobType();
    $optJobType = array('' => '');
    foreach ($ls as $row) {
      $optJobType[$row->id] = $row->title;
    }

    $ls = $this->master_model->getJobLevel();
    $optJobLevel = array('' => '');
    foreach ($ls as $row) {
      $optJobLevel[$row->id] = $row->title;
    }

    $ls = $this->master_model->getJobFunction();
    $optJobFunc = array('' => '');
    foreach ($ls as $row) {
      $optJobFunc[$row->id] = $row->title;
    }

    $old = $this->vacancy_model->getRow($id);
    $phase = $this->vacancy_model->getPhaseLs($id);

    $data =array(
      'optJobType'  => $optJobType,
      'optJobLevel' => $optJobLevel,
      'optJobFunc'  => $optJobFunc,
      'optArea'     => $optArea,
      'hidden'      => array('id' => $en_id),
      'code'        => $old->vacancy_code,
      'name'        => $old->vacancy_title,
      'qty'         => $old->qty,
      'area'        => $old->area_id,
      'type'        => $old->job_type,
      'func'        => $old->job_function,
      'level'       => $old->job_level,
      'open'        => $old->open_date,
      'close'       => $old->close_date,
      'desc'        => $old->description,
      'req'         => $old->requirement,
      'ben'         => $old->benefit,
      'processUrl'  => 'vacancy/processEdit',
      'phase'       => $phase,
      'mode'        => 'Edit',
    );
    $this->load->view('job/form', $data);

  }

  public function processAdd()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_code', 'Vacancy Code', 'required|min_length[2]|max_length[10]|alpha_dash');
    $this->form_validation->set_rules('txt_name', 'Vacancy Name', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('nm_qty', 'Quantity', 'required|numeric');
    $this->form_validation->set_rules('slc_area', 'Area', 'required');
    $this->form_validation->set_rules('slc_jobType', 'Job Type', 'required');
    $this->form_validation->set_rules('slc_jobFunc', 'Job Function', 'required');
    $this->form_validation->set_rules('slc_jobLevel', 'Job Level', 'required');
    $this->form_validation->set_rules('dt_open', 'Open Date', 'required');
    $this->form_validation->set_rules('dt_close', 'Close Date', 'required');
    if ($this->form_validation->run() == FALSE) {
      // Show error messeage
    } else {
      // TODO Save and redirect to list
      // Add Header
      $code  = $this->input->post('txt_code');
      $name  = $this->input->post('txt_name');
      $qty   = $this->input->post('nm_qty');
      $area  = $this->input->post('slc_area');
      $type  = $this->input->post('slc_jobType');
      $level = $this->input->post('slc_jobLevel');
      $func  = $this->input->post('slc_jobFunc');
      $open  = $this->input->post('dt_open');
      $close = $this->input->post('dt_close');
      $desc  = $this->input->post('txt_desc');
      $req   = $this->input->post('txt_req');
      $ben   = $this->input->post('txt_benefit');
      $is_visible = FALSE;

      $vacancy_id = $this->vacancy_model->add(
        $code,$name,
        $open,$close,
        $qty,$type,
        $func,$level,
        $desc,$req,
        $ben,$is_visible,
        $area
      );

      if ($vacancy_id) {
        $this->vacancy_model->addPhase($vacancy_id,1,1);
        $phase = $this->input->post('chk_phase[]');
        $count = 2;
        foreach ($phase as $key => $value) {
          $order = $this->input->post('nm_order_'.$value);
          $this->vacancy_model->addPhase($vacancy_id,$value,$order);

          $count++;
        }
        if ($order >= $count) {
          $count = $order+1;
        }
        $this->vacancy_model->addPhase($vacancy_id,2,$count);
        redirect('vacancy');
      } else {
        // Show error messeage

      }
    }

  }

  public function processEdit()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txt_code', 'Vacancy Code', 'required|min_length[2]|max_length[10]|alpha_dash');
    $this->form_validation->set_rules('txt_name', 'Vacancy Name', 'required|min_length[2]|max_length[250]|alpha_numeric_spaces');
    $this->form_validation->set_rules('nm_qty', 'Quantity', 'required|numeric');
    $this->form_validation->set_rules('slc_area', 'Area', 'required');
    $this->form_validation->set_rules('slc_jobType', 'Job Type', 'required');
    $this->form_validation->set_rules('slc_jobFunc', 'Job Function', 'required');
    $this->form_validation->set_rules('slc_jobLevel', 'Job Level', 'required');
    $this->form_validation->set_rules('dt_open', 'Open Date', 'required');
    $this->form_validation->set_rules('dt_close', 'Close Date', 'required');
    if ($this->form_validation->run() == FALSE) {
      // Show error messeage
    } else {
      // TODO Save and redirect to list
      // Add Header
      $id    = decode_url($this->input->post('id'));
      $code  = $this->input->post('txt_code');
      $name  = $this->input->post('txt_name');
      $qty   = $this->input->post('nm_qty');
      $area  = $this->input->post('slc_area');
      $type  = $this->input->post('slc_jobType');
      $level = $this->input->post('slc_jobLevel');
      $func  = $this->input->post('slc_jobFunc');
      $open  = $this->input->post('dt_open');
      $close = $this->input->post('dt_close');
      $desc  = $this->input->post('txt_desc');
      $req   = $this->input->post('txt_req');
      $ben   = $this->input->post('txt_benefit');

      $this->vacancy_model->edit( $id,
        $code,$name,
        $open,$close,
        $qty,$type,
        $func,$level,
        $desc,$req,
        $ben,$area
      );

      redirect('vacancy');
    }

  }

  public function processPublish()
  {
    $id = decode_url($this->input->post('id'));
    if($this->vacancy_model->isPublish($id)){
      $this->vacancy_model->editStatus($id,0);
    } else {
      $this->vacancy_model->editStatus($id,1);
    }
    $respond = array('status'=>'OK','msg' => '');
    echo json_encode($respond);
  }

  public function processRemove()
  {
    $id = decode_url($this->input->post('id'));
    if ($this->vacancy_model->haveApplicant($id) == FALSE) {
      $this->vacancy_model->remove($id);
      $respond = array('status'=>'OK','msg' => '');
    } else {
      $respond = array('status'=>'ERROR','msg' => '');
    }
    echo json_encode($respond);

  }
}
