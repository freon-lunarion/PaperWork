<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vacancy_model extends CI_Model{

  private function _getQuery($start='1990-01-01 00:00:00', $end='9999-12-31 23:59:59', $keyword='',$limit=10,$offset=0)
  {
    $this->db->select('id as vacancy_id');
    $this->db->select('short_text as vacancy_code');
    $this->db->select('long_text as vacancy_title');
    $this->db->select('is_visible');
    if ($keyword != '') {
      $this->db->group_start();
      $this->db->like('long_text', $keyword);
      $this->db->or_like('short_text', $keyword);
      $this->db->group_end();
    }

    $this->db->group_start();

    $this->db->group_start();
    $this->db->where('open_date >=', $start);
    $this->db->where('close_date <=', $end);
    $this->db->group_end();

    $this->db->or_group_start();
    $this->db->where('close_date >=', $start);
    $this->db->where('close_date <=', $end);
    $this->db->group_end();

    $this->db->or_group_start();
    $this->db->where('open_date >=', $start);
    $this->db->where('open_date <=', $end);
    $this->db->group_end();

    $this->db->or_group_start();
    $this->db->where('open_date <=', $start);
    $this->db->where('close_date >=', $end);
    $this->db->group_end();

    $this->db->group_end();
    $this->db->from('vacancy');
    $this->db->limit($limit,$offset);
    $this->db->order_by('close_date','desc');
    $this->db->order_by('open_date','desc');
    $this->db->order_by('short_text');
  }

  public function getList($start='1990-01-01 00:00:00', $end='9999-12-31 23:59:59', $keyword='',$limit=10,$offset=0)
  {
    $query = $this->_getQuery($start,$end,$keyword,$limit,$offset)->get();
    return $query->result();
  }

  public function countAll()
  {
    $this->db->select('count(*)');
    $this->db->from('vacancy');
    return $this->db->get()->row()->val;

  }

  public function countFiltered($start='1990-01-01 00:00:00', $end='9999-12-31 23:59:59', $keyword='',$limit=10,$offset=0)
  {
    $query = $this->_getQuery($start,$end,$keyword,$limit,$offset)->get();
    return $query->num_rows();

  }

  public function getRow($id=0)
  {
    $this->db->select('*');
    $this->db->from('vacancy');
    $this->db->where('id',$id);
  }

  public function isPublish($id=0)
  {
    $this->db->select('is_active');
    $this->db->where('id', $id);
    return $this->db->get('vacancy')->row()->is_active;
  }

  public function haveApplicant($vacancy_id=0)
  {
    $this->db->select('count(*)');
    $this->db->where('vacancy_id', $vacancy_id);
    if ($this->db->get('application')->row()->val) {
      return true;
    } else {
      return false;
    }
  }

  public function add($short_text='',$long_text='',$open_date='',$close_date='',$qty=1,$job_type=0,$job_function=0,$job_level=0,$description='',$requirement='',$benefit='',$is_visible=FALSE,$area_id=1)
  {
    $at   = date('Y-m-d H:i:s');
    $by   = 0; // TODO change to user_id from login session
    $data = array(
      'short_text'   => $short_text,
      'long_text'    => $long_text,
      'open_date'    => $open_date,
      'close_date'   => $close_date,
      'qty'          => $qty,
      'job_type'     => $job_type,
      'job_function' => $job_function,
      'job_level'    => $job_level,
      'description'  => $description,
      'requirement'  => $requirement,
      'benefit'      => $benefit,
      'area_id'      => $area_id,
      'created_by'   => $by,
      'created_at'   => $at,
      'modifed_by'   => $by,
      'modifed_at'   => $at,
      'is_visible'   => $is_visible
    );
    $this->db->insert('vacancy', $data);

    return $this->db->insert_id();
  }

  public function edit($id=0,$short_text='',$long_text='',$open_date='',$close_date='',$qty=1,$job_type=0,$job_function=0,$job_level=0,$description='',$requirement='',$benefit='',$is_visible=FALSE,$area_id=1)
  {
    $at   = date('Y-m-d H:i:s');
    $by   = 0; // TODO change to user_id from login session
    $data = array(
      'short_text'   => $short_text,
      'long_text'    => $long_text,
      'open_date'    => $open_date,
      'close_date'   => $close_date,
      'qty'          => $qty,
      'job_type'     => $job_type,
      'job_function' => $job_function,
      'job_level'    => $job_level,
      'description'  => $description,
      'requirement'  => $requirement,
      'benefit'      => $benefit,
      'area_id'      => $area_id,
      'modifed_by'   => $by,
      'modifed_at'   => $at,
      'is_visible'   => $is_visible
    );
    $this->db->where('id', $id);
    $this->db->update('vacancy', $data);
  }

  public function editStatus($id=0,$is_visible=TRUE)
  {
    $at   = date('Y-m-d H:i:s');
    $by   = 0; // TODO change to user_id from login session
    $data = array(
      'modifed_by'   => $by,
      'modifed_at'   => $at,
      'is_visible'   => $is_visible
    );
    $this->db->where('id', $id);
    $this->db->update('vacancy', $data);
  }

  public function remove($id='')
  {
    $this->db->where('vacancy_id', $id);
    $this->db->delete('vacancy_question');

    $this->db->where('vacancy_id', $id);
    $this->db->delete('vacancy_phase');

    $this->db->where('id', $id);
    $this->db->delete('vacancy');
  }

  public function getPhaseLs($vacancy_id=0)
  {
    $this->db->select('p.code as phase_code');
    $this->db->select('p.title as phase_name');
    $this->db->where('vp.vacancy_id', $vacancy_id);
    $this->db->from('vacancy_phase vp');
    $this->db->join('phase p', 'vp.phase_code = p.code', 'left');
    $this->db->order_by('vp.order_value');
    return $this->db->get()->result;
  }
}
