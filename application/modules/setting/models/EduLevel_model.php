<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EduLevel_model extends CI_Model{
  var $table = 'education_level';
  var $column_select = array('id','title','score');

  var $column_order = array('id','title', 'score'); //set column field database for datatable orderable
  var $column_search = array('title'); //set column field database for datatable searchable
  var $order = array('score' => 'desc'); // default order

  private function _get_datatables_query()
  {
    $this->db->select($this->column_select);

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
      return $this->db->count_all_results();
  }
  public function getList()
  {
    $this->db->select('code as id');
    $this->db->select('title as title');

    return $this->db->get($this->table)->result();
  }

  public function isUsed($id=0)
  {
    $this->db->select('count(id) as val');
    $this->db->where('id', $id);
    $vp = $this->db->get('$this->tabl')->row()->val;

    if ($vp > 0 ) {
      return TRUE;
    } else {
      return false;
    }


  }

  public function getById($id=0)
  {
    $this->db->select('id');
    $this->db->select('title ');
    $this->db->select('score ');

    $this->db->where('id', $id);
    return $this->db->get($this->table)->row();
  }

  public function add($title='',$score=0)
  {

      $data =array(
        'title'        => $title,
        'score'        => $score,
      );

      $this->db->insert($this->table,$data);
      return TRUE;

  }

  public function edit($id=0,$title='',$score=0)
  {
    $data =array(
      'title'        => $title,
      'score'        => $score,
    );
    $this->db->where('id', $id);
    $this->db->update($this->table,$data);
  }

  public function remove($id=0)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
  }

}
