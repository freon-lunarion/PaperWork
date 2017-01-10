<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model{

  var $table = 'role';
  var $column_select = array('id','title');

  var $column_order = array(null, 'title','is_active'); //set column field database for datatable orderable
  var $column_search = array('title','is_active'); //set column field database for datatable searchable
  var $order = array('id' => 'asc'); // default order

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

  public function getList($isActive=NULL)
  {
    $this->db->select('id as role_id');
    $this->db->select('title as role_name');

    if (is_null($isActive) == FALSE) {
      $this->db->where('is_active',$isActive);

    }

    return $this->db->get('role')->result();
  }

  public function getById($id=0)
  {
    $this->db->select('id as role_id');
    $this->db->select('title as role_name');
    $this->db->select('is_active');
    $this->db->where('id', $id);
    return $this->db->get('role')->row();
  }

  public function isUsed($id=0)
  {
    $this->db->select('COUNT(id) as val');
    $this->db->where('role_id', $id);
    $rm = $this->db->get('role_module')->row()->val;

    if ( $rm == 0) {
      return FALSE;
    } else {
      return TRUE;
    }

  }

  public function add($name='',$status=1)
  {
    $data = array(
      'title' => $name,
      'is_active' => $status
    );
    $this->db->insert('role', $data);
    return $this->db->insert_id();
  }

  public function edit($id=0,$name='',$status=TRUE)
  {
    $data = array(
      'title' => $name,
      'is_active' => $status

    );
    $this->db->where('id', $id);
    $this->db->update('role', $data);
    return TRUE;

  }

  public function editName($id=0,$name='')
  {
    $data = array(
      'title' => $name,
    );
    $this->db->where('id', $id);
    $this->db->update('role', $data);
    return TRUE;
  }

  public function editStatus($id=0,$status=TRUE)
  {
    $data = array(
      'is_active' => $status
    );
    $this->db->where('id', $id);
    $this->db->update('role', $data);
    return TRUE;
  }

  public function remove($id=0)
  {
    $this->db->where('role_id', $id);
    $this->db->delete('user_role_area');

    $this->db->where('role_id', $id);
    $this->db->delete('role_module');

    $this->db->where('id', $id);
    $this->db->delete('role');
    return TRUE;

  }

}
