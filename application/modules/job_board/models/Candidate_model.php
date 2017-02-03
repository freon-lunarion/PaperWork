<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_model extends CI_Model{
  private $tableMain = 'candidate';

  public function countByEmail($email='')
  {
    $this->db->select('count(id) as val');
    $this->db->where('LOWER(email)', strtolower($email));
    $result = $this->db->get($this->tableMain)->row();
    if (count($result)) {
      return $result->val;
    } else {
      return FALSE;
    }
  }

  public function getById($id='')
  {
    $this->db->from($this->tableMain);
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function getByEmail($email = '')
  {
    $this->db->select('id');
    $this->db->where('LOWER(email)', strtolower($email));
    $result = $this->db->get($this->tableMain)->row();
    if (count($result)) {
      return $result->id;
    } else {
      return FALSE;
    }
  }

  public function getPassword($candidate_id = 0)
  {
    $this->db->select('password');
    $this->db->where('candidate_id', $candidate_id);
    $result = $this->db->get($this->tableMain)->row();
    if (count($result)) {
      return $result->email;
    } else {
      return FALSE;
    }
  }

  public function getEmail($candidate_id = 0)
  {
    $this->db->select('email');
    $this->db->where('candidate_id', $candidate_id);
    $result = $this->db->get($this->tableMain)->row();
    if (count($result)) {
      return $result->email;
    } else {
      return FALSE;
    }
  }

  public function add($fullname='',$birthdate='1970-01-01',$gender_code=1,$email='',$phone='')
  {
    $bd = explode('-',$birthdate);
    $pw = $bd[2].$bd[1].$bd[0]; // DDMMYYYY
    $data = array(
      'fullname'    => $fullname,
      'birthdate'   => $birthdate,
      'gender_code' => $gender_code,
      'email'       => strtolower($email),
      'phone'       => $phone,
      'password'    => md5($pw),
      'is_active'   => 1,
    );

    $this->db->insert($this->tableMain, $data);
    return $this->db->insert_id();
  }

  public function addEdu($candidate_id = 0,$level=0,$institution='',$major='',$result='',$begin='1970-01-01',$end='1970-01-01')
  {
    $data = array(
      'candidate_id' => $candidate_id,
      'level,'       => $level,
      'institution,' => $institution,
      'major,'       => $major,
      'result,'      => $result,
      'begin,'       => $begin,
      'end'          => $end
    );
    $this->db->insert('candidate_education', $data);
  }

  public function addExp($candidate_id = 0,$company_name='',$company_fields=0,$job_name='',$job_function=0,$job_description='',$job_level=0,$begin='1970-01-01',$end='1970-01-01')
  {
    $data = array(
      'candidate_id'    => $candidate_id,
      'company_name'    => $company_name,
      'company_fields'  => $company_fields,
      'job_name'        => $job_name,
      'job_function'    => $job_function,
      'job_description' => $job_description,
      'job_level'       => $job_level,
      'begin,'          => $begin,
      'end'             => $end
    );
    $this->db->insert('candidate_exp', $data);
  }

  public function editStatus($candidate_id=0,$is_active= 1)
  {
    $data = array(
      'is_active'   => $is_active,
    );
    $this->db->where('candidate_id', $candidate_id);
    $this->db->update($this->tableMain, $data);
  }

  public function editPassword($candidate_id=0,$password='')
  {
    $data = array(
      'password'   => md5($password),
    );
    $this->db->where('candidate_id', $candidate_id);
    $this->db->update($this->tableMain, $data);
  }

  public function editBio($candidate_id=0,$fullname= '',$birthdate='',$gender_code='')
  {
    $data = array(
      'fullname'    => $fullname,
      'birthdate'   => $birthdate,
      'gender_code' => $gender_code,
    );
    $this->db->where('candidate_id', $candidate_id);
    $this->db->update($this->tableMain, $data);
  }

  public function editContact($candidate_id=0,$email= '',$phone='')
  {
    $data = array(
      'fullname'    => $fullname,
      'birthdate'   => $birthdate,
      'gender_code' => $gender_code,
      'email'       => $email,
      'phone'       => $phone,
      'password'    => md5($pw),
      'is_active'   => 1,
    );
    $this->db->where('candidate_id', $candidate_id);
    $this->db->update($this->tableMain, $data);
  }

  public function editEdu($id=0,$level=0,$institution='',$major='',$result='',$begin='1970-01-01',$end='1970-01-01')
  {
    $data = array(
      'level,'       => $level,
      'institution,' => $institution,
      'major,'       => $major,
      'result,'      => $result,
      'begin,'       => $begin,
      'end'          => $end
    );
    $this->db->where('id', $id);
    $this->db->update('candidate_education', $data);
  }

  public function editExp($id=0,$company_name='',$company_fields=0,$job_name='',$job_function=0,$job_description='',$job_level=0,$begin='1970-01-01',$end='1970-01-01')
  {
    $data = array(
      'company_name'    => $company_name,
      'company_fields'  => $company_fields,
      'job_name'        => $job_name,
      'job_function'    => $job_function,
      'job_description' => $job_description,
      'job_level'       => $job_level,
      'begin,'          => $begin,
      'end'             => $end
    );
    $this->db->where('id', $id);
    $this->db->update('candidate_exp', $data);
  }

  public function removeEdu($id=0)
  {
    $this->db->where('id', $id);
    $this->db->delete('candidate_education');
  }

  public function removeExp($id=0)
  {
    $this->db->where('id', $id);
    $this->db->delete('candidate_exp');
  }

}
