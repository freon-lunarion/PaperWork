<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vacancy_model extends CI_Model{

  public function getList($unit_id=array(),$keyword=NULL,$open_date=NULL,$close_date=NULL,$limit=10,$offset=0)
  {
    $this->db->select('id as vacancy_id');
    $this->db->select('short_text as vacancy_code');
    $this->db->select('long_text as vacancy_title');
    $this->db->select('open_date');
    $this->db->select('close_date');
    $this->db->select('is_visible');
    $this->db->from('vacancy');
    $this->db->where_in('unit_id',$unit_id);
    if (is_null($keyword) == FALSE) {
      $this->db->group_start();
      $this->db->like('LOWER(short_text)',strtolower($keyword));
      $this->db->or_like('LOWER(long_text)',strtolower($keyword));
      $this->db->group_end();

    }
    if (is_null($open_date) == FALSE && is_null($close_date) == FALSE) {
      $this->db->group_start();
      $this->db->where('open_date >=',$open_date);
      $this->db->where('close_date <=',$close_date);
      $this->db->group_end();

    }
    $this->db->limit($limit,$offset);
  }

  public function getRow($id=0)
  {
    // $this->db->select('id as vacancy_id');
    // $this->db->select('short_text as vacancy_code');
    // $this->db->select('long_text as vacancy_title');
    // $this->db->select('open_date');
    // $this->db->select('close_date');
    // $this->db->select('is_visible');
    $this->db->select('*');
    $this->db->from('vacancy');
    $this->db->where('id',$id);

  }
}
