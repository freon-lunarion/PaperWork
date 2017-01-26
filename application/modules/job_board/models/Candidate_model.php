<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_model extends CI_Model{
  private $tableMain = 'candidate';

  public function getById($id='')
  {
    $this->db->from($this->tableMain);
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function add($fullname='',$birthdate='1970-01-01',$gender_code=1,$email='',$phone='')
  {
    $bd = explode('-',$birthdate);
    $pw = $bd[2].$bd[1].$bd[0]; // DDMMYYYY
    $data = array(
      'fullname'    => $fullname,
      'birthdate'   => $birthdate,
      'gender_code' => $gender_code,
      'email'       => $email,
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
      'candidate_id' => $$candidate_id,
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
      'candidate_id'    => $$candidate_id,
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

  public function change($id=0,$field1='',$field2='')
  {
    $data = array(
      'field1' => $field1,
      'field2' => $field2
    );
    $this->db->where('id', $id);
    $this->db->update($this->tableMain, $data);
    return TRUE;
  }

}
