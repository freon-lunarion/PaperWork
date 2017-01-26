<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getRow($candidate_id=0)
  {
    $this->db->select('c.*');
    $this->db->select('r.title as gender');
    $this->db->where('c.id', $candidate_id);
    $this->db->from('candidate c');
    $this->db->join('ref_gender rg', 'rg.id = c.gender_code', 'left');
    return $this->db->get()->row();

  }

  public function getExpLast($candidate_id=0)
  {
    $this->db->select('ce.*');
    $this->db->select('jf.title as function');
    $this->db->select('jl.title as level');
    $this->db->select('jt.title as type');

    $this->db->from('candidate_exp ce');
    $this->db->join('job_function jf', 'jf.job_function = ce.id', 'left');
    $this->db->join('job_level jl', 'jl.job_level = ce.id', 'left');
    $this->db->join('job_type jt', 'jt.job_type = ce.id', 'left');
    $this->db->order_by('end','desc');
    $this->db->order_by('begin','end');
    return $this->db->get()->row();
  }

  public function getExpList($candidate_id=0)
  {
    $this->db->select('ce.*');
    $this->db->select('jf.title as function');
    $this->db->select('jl.title as level');
    $this->db->select('jt.title as type');

    $this->db->from('candidate_exp ce');
    $this->db->join('job_function jf', 'jf.job_function = ce.id', 'left');
    $this->db->join('job_level jl', 'jl.job_level = ce.id', 'left');
    $this->db->join('job_type jt', 'jt.job_type = ce.id', 'left');
    $this->db->order_by('end','desc');
    $this->db->order_by('begin','end');
    return $this->db->get()->result();

  }

  public function getEduLast($candidate_id=0)
  {
    $this->db->select('ce.*');
    $this->db->select('c.title as level_name');
    $this->db->from('candidate_education ce');
    $this->db->join('education_level el', 'ce.level = el.id', 'left');
    $this->db->order_by('end','desc');
    $this->db->order_by('begin','end');
    return $this->db->get()->row();
  }

  public function getEduList($candidate_id=0)
  {
    $this->db->select('ce.*');
    $this->db->select('c.title as level_name');
    $this->db->from('candidate_education ce');
    $this->db->join('education_level el', 'ce.level = el.id', 'left');
    $this->db->order_by('end','desc');
    $this->db->order_by('begin','end');
    return $this->db->get()->result();
  }

}
