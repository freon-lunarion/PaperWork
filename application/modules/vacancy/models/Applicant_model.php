<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicant_model extends CI_Model{

  public function countCvScreen($vacancy_id=0)
  {
    $this->db->select('count(a.id) as val');
    $this->db->where('a.id NOT IN (SELECT in vacancy_id  FROM application_phase)');
    $this->db->where('a.vacancy_id', $vacancy_id)
    $count1 = $this->db->get('application a')->row()->val;

    $this->db->select('count(a.id) as val');
    $this->db->from('application a');
    $this->db->where('a.vacancy_id', $vacancy_id);
    $this->db->where('ap.phase_status','PEND');
    $this->db->join('application_phase ap', 'a.id = ap.application_id', 'left');
    $count2 = $this->db->get()->row()->val;

  }
}
