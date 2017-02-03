<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getGenderList()
  {
    return $this->db->get('ref_gender')->result();
  }

  public function getEduLevelList()
  {
    $this->db->order_by('score', 'desc');
    return $this->db->get('education_level')->result();
  }

  public function getJobLevelList()
  {
    return $this->db->get('job_level')->result();
  }

  public function getJobFuncList()
  {
    return $this->db->get('job_function')->result();
  }

  public function getJobTypeList()
  {
    return $this->db->get('job_type')->result();
  }

  public function getCompFieldList()
  {
    $this->db->where('is_active', 1);
    return $this->db->get('company_field')->result();
  }

}
