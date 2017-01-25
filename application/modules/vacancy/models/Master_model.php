<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getJobLevel()
  {
    return $this->db->get('job_level')->result();
  }

  public function getJobType()
  {
    return $this->db->get('job_type')->result();
  }

  public function getJobFunction()
  {
    return $this->db->get('job_function')->result();
  }

  public function getArea()
  {
    // $userId = 0; // TODO get form userId session
    // $this->db->select('area_id');
    // $this->db->where('user_id', $userId);
    // $temp = $this->db->get('user_role_area')->result();
    // $array = array();
    // foreach ($temp as $r) {
    //   $array[] = $r->area_id;
    // }
    // if (count($array)) {
      $this->db->select('id,title');
      $this->db->where('is_active', 1);
      // $this->db->where_in('id', $array);
      return $this->db->get('area')->result();
    // } else {
    //   return array();
    // }
  }

  public function getPhaseLs()
  {
    $this->db->select('code, title, is_mandatory, has_schedule');
    $this->db->where('is_begin', 0);
    $this->db->where('is_end', 0);
    return $this->db->get('phase')->result();

  }

  public function getPhaseRow($phase_code)
  {
    $this->db->select('code, title, is_mandatory, has_schedule');
    $this->db->where('code', $phase_code);
    return $this->db->get('phase')->row();

  }

  public function getEduLevelLs()
  {
    $this->db->select('score,title');
    $this->db->from('education_level');
    $this->db->order_by('score','desc');
    return $this->db->get()->result();

  }

}
