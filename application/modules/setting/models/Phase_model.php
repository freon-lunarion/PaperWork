<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phase_model extends CI_Model{
  var $table = 'phase';
  var $column_select = array('code','title','is_mandatory','has_schedule');

  var $column_order = array('code', 'title','is_mandatory','has_schedule'); //set column field database for datatable orderable
  var $column_search = array('title'); //set column field database for datatable searchable
  var $order = array('code' => 'asc'); // default order

  private function _get_datatables_query()
  {
    $this->db->select($this->column_select);
    $this->db->where('is_begin', 0);
    $this->db->where('is_end', 0);
    $this->db->from($this->table);
    $i = 0;
    foreach ($this->column_search as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {

        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
        {
          $this->db->group_end(); //close bracket
        }
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order))
    {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function get_datatables()
  {
      $this->_get_datatables_query();
      if($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
      $query = $this->db->get();
      return $query->result();
  }

  function count_filtered()
  {
      $this->_get_datatables_query();
      $query = $this->db->get();
      return $query->num_rows();
  }

  public function count_all()
  {
      $this->db->from($this->table);
      $this->db->where('is_begin', 0);
      $this->db->where('is_end', 0);
      return $this->db->count_all_results();
  }
  public function getList()
  {
    $this->db->select('code as phase_code');
    $this->db->select('title as phase_title');

    return $this->db->get('phase')->result();
  }

  public function isUsed($phase_code=0)
  {
    $this->db->select('count(id) as val');
    $this->db->where('phase_code', $phase_code);
    $vp = $this->db->get('vacancy_phase')->row()->val;

    if ($vp > 0 ) {
      return TRUE;
    } else {
      $this->db->select('count(id) as val');
      $this->db->where('phase_code', $phase_code);
      $as = $this->db->get('application_schedule')->row()->val;

      if ($as > 0) {
        return TRUE;
      } else {
        $this->db->select('count(id) as val');
        $this->db->where('phase_code', $phase_code);
        $ap = $this->db->get('application_phase')->row()->val;

        if ($ap > 0) {
          return true;
        } else{
          return false;
        }
      }
    }


  }

  public function getByCode($code=0)
  {
    $this->db->select('code as phase_code');
    $this->db->select('title as phase_title');
    $this->db->select('is_mandatory');
    $this->db->select('has_schedule');
    $this->db->where('code', $code);
    return $this->db->get('phase')->row();
  }

  public function add($title='',$is_mandatory=FALSE,$has_schedule=TRUE)
  {

      $data =array(
        'title'        => $title,
        'is_mandatory' => $is_mandatory,
        'has_schedule' => $has_schedule,
      );

      $this->db->insert('phase',$data);
      return TRUE;

  }

  public function edit($code=0,$title='',$is_mandatory=FALSE,$has_schedule=TRUE)
  {
    $data =array(
      'title'        => $title,
      'is_mandatory' => $is_mandatory,
      'has_schedule' => $has_schedule,
    );
    $this->db->where('code', $code);
    $this->db->update('phase',$data);
  }

  public function remove($code=0)
  {
    $this->db->where('code', $code);
    $this->db->delete('phase');
  }

}
