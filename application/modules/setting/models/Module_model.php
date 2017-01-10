<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_model extends CI_Model{
  var $table = 'module';
  var $column_select = array('code','title');

  var $column_order = array('code', 'title'); //set column field database for datatable orderable
  var $column_search = array('code','title'); //set column field database for datatable searchable
  var $order = array('code' => 'asc'); // default order

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
    $this->db->select('code as module_code');
    $this->db->select('title as module_title');

    return $this->db->get('module')->result();
  }

  public function getByCode($code='')
  {
    $this->db->select('code as module_code');
    $this->db->select('title as module_title');
    $this->db->select('link ');
    $this->db->where('code', $code);
    return $this->db->get('module')->row();
  }
  public function isUsed($code=0)
  {
    $this->db->select('COUNT(id) as val');
    $this->db->where('module_code', $code);
    $rm = $this->db->get('role_module')->row()->val;

    if ( $rm == 0) {
      return FALSE;
    } else {
      return TRUE;
    }

  }

  public function isAvailable($code='')
  {
    $this->db->select('COUNT(code) as val');
    $this->db->where('LOWER(code)', strtolower($code));
    $this->db->from('module');
    if ($this->db->get()->row()->val) {
      return FALSE;
    } else {
      return TRUE;
    }

  }

  public function add($code='',$name='',$link='')
  {
    if ($this->isAvailable($code)) {
      $data =array(
        'code'  => strtolower($code),
        'title' => $name,
        'link'  => $link,
      );

      $this->db->insert('module',$data);
      return TRUE;
    } else {
      return false;
    }
  }

  public function edit($code='',$name='',$link='')
  {
    $data =array(

      'title' => $name,
      'link'  => $link,
    );
    $this->db->where('LOWER(code)', strtolower($code));
    $this->db->update('module',$data);
  }

  public function remove($code='')
  {
    $this->db->where('LOWER(code)', strtolower($code));
    $this->db->delete('module');
  }

}
