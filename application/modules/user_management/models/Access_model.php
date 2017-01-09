<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_model extends CI_Model{

  var $column_search = array('u.username','a.title','r.title'); //set column field database for datatable searchable
  var $column_order = array('u.username','a.title','r.title');
  var $order = array('username' => 'asc'); // default order

  private function _get_datatables_query()
  {
    $this->db->select('ura.id as access_id');
    $this->db->select('ura.area_id');
    $this->db->select('ura.role_id');
    $this->db->select('ura.user_id');
    $this->db->select('r.title as role_name');
    $this->db->select('a.title as area_name');
    $this->db->select('u.username ');
    $this->db->from('user_role_area ura');
    $this->db->join('role r', 'ura.role_id = r.id', 'left');
    $this->db->join('area a', 'ura.area_id = a.id', 'left');
    $this->db->join('user u', 'ura.user_id = u.id', 'left');
    $i = 0;

    foreach ($this->column_search as $item) {
      if($_POST['search']['value']) {
        if ($i===0) {
          // first loop
          $this->db->group_start();
          $this->db->like($item, $_POST['search']['value']);

        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) {
          //last loop
          $this->db->group_end(); //close bracket
        }

      }
      $i++;

    }

    if(isset($_POST['order'])) {
      // here order processing
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if(isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }

  }

  public function get_datatables()
  {
    $this->_get_datatables_query();
    if ($_POST['length'] != 1) {
      $this->db->limit($_POST['length'], $_POST['start']);
    }

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
      $this->db->from('user_role_area ura');
      $this->db->join('role r', 'ura.role_id = r.id', 'left');
      $this->db->join('area a', 'ura.area_id = a.id', 'left');
      $this->db->join('user u', 'ura.user_id = u.id', 'left');
      return $this->db->count_all_results();
  }

  public function getList()
  {
    $this->db->select('ura.id as access_id');
    $this->db->select('ura.area_id');
    $this->db->select('ura.role_id');
    $this->db->select('r.title as role_title');
    $this->db->select('a.title as area_title');
    $this->db->from('user_role_area ura');
    $this->db->join('role r', 'ur.role_id = r.role_id', 'left');
    $this->db->join('area a', 'ur.area_id = a.area_id', 'left');
    return $this->db->get()->result();
  }

  public function getById($id=0)
  {
    $this->db->where('id', $id);
    return $this->db->get('user_role_area')->row();
  }

  public function inOnRecord($user_id=0,$area_id=0,$role_id=0)
  {
    $this->db->select('COUNT(id) as val');
    $this->db->where('user_id', $user_id);
    $this->db->where('area_id', $area_id);
    $this->db->where('role_id', $role_id);

    if ($this->db->get('user_role_area')->row()->val) {
      return true;
    } else {
      return false;
    }
  }

  public function add($user_id=0,$area_id=0,$role_id=0)
  {
    $data = array(
      'user_id' => $user_id,
      'area_id' => $area_id,
      'role_id' => $role_id,
    );

    $this->db->insert('user_role_area', $data);

    return $this->db->insert_id();
  }

  public function remove($id=0)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_role_area');
  }

}
