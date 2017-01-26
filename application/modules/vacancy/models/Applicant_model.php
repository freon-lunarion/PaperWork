<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicant_model extends CI_Model{


  public function getByPhaseList($vacancy_id=0,$phase_code=0,$limit=20,$offset=0)
  {
    $this->db->select('a.candidate_id');
    $this->db->select('a.created_at');
    $this->db->select('a.modified_at');
    $this->db->select('c.fullname');

    $this->db->from('application_phase ap');
    $this->db->join('application a', 'ap.application_id = a.id', 'left');

    $this->db->join('candidate c', 'a.candidate_id = c.id', 'left');
    $this->db->where('ap.status_code', 0);
    $this->db->where('ap.phase_code', $phase_code=0);
    $this->db->where('a.vacancy_id', $vacancy_id);

    $this->db->limit($limit,$offset);
    return $this->db->get()->result();
  }

  public function getByFirstPhaseList($vacancy_id=0,$criteria=array(),$limit=20,$offset=0)
  {
    if (isset($criteria['eduMin']) && is_numeric($criteria['eduMin'])) {
      $this->db->select('c.id');

      $this->db->from('application_phase ap');
      $this->db->join('application a', 'ap.application_id = a.id', 'left');
      $this->db->join('candidate c', 'a.candidate_id = c.id', 'left');
      $this->db->join('candidate_education ed', 'c.id = ed.candidate_id', 'left');
      $this->db->join('education_level el', 'el.id = ed.level', 'left');
      $this->db->where('el.score >=', $criteria['eduMin']);
      $this->db->where('ap.status_code', 0);
      $this->db->where('ap.phase_code', 1);
      $this->db->where('a.vacancy_id', $vacancy_id);

      $temp = $this->db->get()->result();
      $cand_edu = array();
      foreach ($temp as $row) {
        $cand_edu[] = $row->id;
      }
    }

    if (isset($criteria['expMin']) && is_numeric($criteria['expMin'])) {
      $this->db->select('c.id');
      $this->db->from('application_phase ap');
      $this->db->join('application a', 'ap.application_id = a.id', 'left');
      $this->db->join('candidate c', 'a.candidate_id = c.id', 'left');
      $this->db->join('candidate_education ed', 'c.id = ed.candidate_id', 'left');
      $this->db->join('education_level el', 'el.id = ed.level', 'left');
      $this->db->join('candidate_exp ce', 'c.id = ce.candidate_id', 'left');
      $this->db->where('ap.status_code', 0);
      $this->db->where('ap.phase_code', 1);
      $this->db->where('a.vacancy_id', $vacancy_id);
      $this->db->where("DATEDIFF(a.created_at, ce.begin)/365.25 <= ".$criteria['expMin'] );

      $temp = $this->db->get()->result();
      $cand_exp = array();
      foreach ($temp as $row) {
        $cand_exp[] = $row->id;
      }
    }

    $this->db->select('a.candidate_id');
    $this->db->select('a.created_at');
    $this->db->select('a.modified_at');
    $this->db->select('c.fullname');

    $this->db->from('application_phase ap');
    $this->db->join('application a', 'ap.application_id = a.id', 'left');

    $this->db->join('candidate c', 'a.candidate_id = c.id', 'left');
    $this->db->where('ap.status_code', 0);
    $this->db->where('ap.phase_code', 1);
    $this->db->where('a.vacancy_id', $vacancy_id);

    if (isset($criteria['ageMin']) && isset($criteria['ageMax'])) {

      $this->db->where("DATEDIFF(a.created_at, c.birthdate)/365.25 >= ".$criteria['ageMin'] );
      $this->db->where("DATEDIFF(a.created_at, c.birthdate)/365.25 <= ".$criteria['ageMax'] );
    }

    if (isset($cand_edu) && count($cand_edu)) {
      $this->db->where_in('a.candidate_id', $cand_edu);
    }

    if (isset($cand_exp) && count($cand_exp)) {
      $this->db->where_in('a.candidate_id', $cand_exp);
    }

    if (isset($criteria['gender']) && ($criteria['gender'] == 0 || $criteria['gender'] == 1)) {
      $this->db->where('c.gender_code', $criteria['gender']);
    }

    if (isset($criteria['salMin']) && isset($criteria['salMax'])) {
      $this->db->where('a.salary >=', $criteria['salMin']);
      $this->db->where('a.salary <=', $criteria['salMax']);
    }
    $this->db->order_by('a.created_at', 'asc');
    $this->db->limit($limit,$offset);
    return $this->db->get()->result();
  }

  public function countByFirstPhase($vacancy_id=0,$criteria=array())
  {
    if (isset($criteria['eduMin']) && is_numeric($criteria['eduMin'])) {
      $this->db->select('c.id');

      $this->db->from('application_phase ap');
      $this->db->join('application a', 'ap.application_id = a.id', 'left');
      $this->db->join('candidate c', 'a.candidate_id = c.id', 'left');
      $this->db->join('candidate_education ed', 'c.id = ed.candidate_id', 'left');
      $this->db->join('education_level el', 'el.id = ed.level', 'left');
      $this->db->where('el.score >=', $criteria['eduMin']);
      $this->db->where('ap.status_code', 0);
      $this->db->where('ap.phase_code', 1);
      $this->db->where('a.vacancy_id', $vacancy_id);

      $temp = $this->db->get()->result();
      $cand_edu = array();
      foreach ($temp as $row) {
        $cand_edu[] = $row->id;
      }
    }

    if (isset($criteria['expMin']) && is_numeric($criteria['expMin'])) {
      $this->db->select('c.id');
      $this->db->from('application_phase ap');
      $this->db->join('application a', 'ap.application_id = a.id', 'left');
      $this->db->join('candidate c', 'a.candidate_id = c.id', 'left');
      $this->db->join('candidate_education ed', 'c.id = ed.candidate_id', 'left');
      $this->db->join('education_level el', 'el.id = ed.level', 'left');
      $this->db->join('candidate_exp ce', 'c.id = ce.candidate_id', 'left');
      $this->db->where('ap.status_code', 0);
      $this->db->where('ap.phase_code', 1);
      $this->db->where('a.vacancy_id', $vacancy_id);
      $this->db->where("DATEDIFF(a.created_at, ce.begin)/365.25 <= ".$criteria['expMin'] );

      $temp = $this->db->get()->result();
      $cand_exp = array();
      foreach ($temp as $row) {
        $cand_exp[] = $row->id;
      }
    }

    $this->db->select('count(a.candidate_id) as val');

    $this->db->from('application_phase ap');
    $this->db->join('application a', 'ap.application_id = a.id', 'left');

    $this->db->join('candidate c', 'a.candidate_id = c.id', 'left');
    $this->db->where('ap.status_code', 0);
    $this->db->where('ap.phase_code', 1);
    $this->db->where('a.vacancy_id', $vacancy_id);

    if (isset($criteria['ageMin']) && isset($criteria['ageMax'])) {

      $this->db->where("DATEDIFF(a.created_at, c.birthdate)/365.25 >= ".$criteria['ageMin'] );
      $this->db->where("DATEDIFF(a.created_at, c.birthdate)/365.25 <= ".$criteria['ageMax'] );
    }

    if (isset($cand_edu) && count($cand_edu)) {
      $this->db->where_in('a.candidate_id', $cand_edu);
    }

    if (isset($cand_exp) && count($cand_exp)) {
      $this->db->where_in('a.candidate_id', $cand_exp);
    }

    if (isset($criteria['gender']) && ($criteria['gender'] == 0 || $criteria['gender'] == 1)) {
      $this->db->where('c.gender_code', $criteria['gender']);
    }

    if (isset($criteria['salMin']) && isset($criteria['salMax'])) {
      $this->db->where('a.salary >=', $criteria['salMin']);
      $this->db->where('a.salary <=', $criteria['salMax']);
    }

    return $this->db->get()->row()->val;
  }

  public function countByPhase($vacancy_id=0,$phase_code=0)
  {
    $this->db->select('COUNT(ap.id) as val');

    $this->db->where('ap.phase_code', $phase_code);
    $this->db->where('ap.status_code', 0);
    $this->db->from('application_phase ap');
    $this->db->join('application a', 'ap.application_id = a.id', 'left');
    $this->db->where('a.vacancy_id', $vacancy_id);

    return $this->db->get()->row()->val;
  }

  public function countHired($vacancy_id=0)
  {
    $this->db->select('COUNT(a.id) as val');
    $this->db->where('a.vacancy_id', $vacancy_id);
    $this->db->where('a.status_code', 1);
    $this->db->from('application a');
    return $this->db->get()->row()->val;

  }
  public function countRejected($vacancy_id=0)
  {
    $this->db->select('COUNT(a.id) as val');
    $this->db->where('a.vacancy_id', $vacancy_id);
    $this->db->where('a.status_code', 2);
    $this->db->from('application a');
    return $this->db->get()->row()->val;
  }

  public function reject($app_id=0,$phase_code='')
  {
    $at   = date('Y-m-d H:i:s');
    $by   = 0; // TODO change to user_id from login session
    $data = array(
      'status_code'   => 2,
      'modified_by'   => $by,
      'modified_at'   => $at,
    );
    $this->db->where('application_id', $app_id);
    $this->db->where('phase_code', $phase_code);
    $this->db->update('application_phase', $data);

    $this->db->where('id', $app_id);
    $this->db->update('application', $data);

  }

  public function approve($app_id=0,$phase_code='')
  {
    $at   = date('Y-m-d H:i:s');
    $by   = 0; // TODO change to user_id from login session
    $data = array(
      'status_code'   => 1,
      'modified_by'   => $by,
      'modified_at'   => $at,
    );
    $this->db->where('application_id', $app_id);
    $this->db->where('phase_code', $phase_code);
    $this->db->update('application_phase', $data);
  }

  public function hire($app_id=0)
  {
    $at   = date('Y-m-d H:i:s');
    $by   = 0; // TODO change to user_id from login session
    $data = array(
      'status_code'   => 1,
      'modified_by'   => $by,
      'modified_at'   => $at,
    );
    $this->db->where('application_id', $app_id);
    $this->db->update('application_phase', $data);

    $this->db->where('id', $app_id);
    $this->db->update('application', $data);
  }

  public function move($app_id=0,$next_phase='')
  {
    $at   = date('Y-m-d H:i:s');
    $by   = 0; // TODO change to user_id from login session
    $this->db->select('id');
    $this->db->where('application_id', $app_id);
    $this->db->where('phase_code', $next_phase);
    $this->db->from('application_phase');
    $check = $this->db->get()->row();
    if (count($check)) {
      $data = array(
        'status_code'    => 0,
        'modified_by'    => $by,
        'modified_at'    => $at,
      );
      $this->db->where('application_id', $app_id);
      $this->db->where('phase_code', $phase_code);
      $this->db->update('application_phase', $data);
    } else {
      $data = array(
        'application_id' => $app_id,
        'phase_code'     => $next_phase,
        'status_code'    => 0,
        'created_by'     => $by,
        'created_at'     => $at,
        'modified_by'    => $by,
        'modified_at'    => $at,
      );
      $this->db->insert('application_phase', $data);
    }

  }


}
