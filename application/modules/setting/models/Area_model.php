<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model{
  var $table = 'area';
  var $column_select = array('id','title');
  var $column_order = array(null, 'title','is_active'); //set column field database for datatable orderable
  var $column_search = array('title','is_active'); //set column field database for datatable searchable
  var $order = array('id' => 'asc'); // default order
  private function _get_datatables_query($parentId=0)
  {
    $this->db->select($this->column_select);
    $this->db->from($this->table);
    $this->db->where('parent', $parentId);
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

  function get_datatables($parentId=0)
  {
      $this->_get_datatables_query($parentId);
      if($_POST['length'] != -1) {
        $this->db->limit($_POST['length'], $_POST['start']);
      }
      $query = $this->db->get();
      return $query->result();
  }

  function count_filtered($parentId=0)
  {
      $this->_get_datatables_query($parentId);
      $query = $this->db->get();
      return $query->num_rows();
  }

  public function count_all($parentId=0)
  {
      $this->db->from($this->table);
      $this->db->where('parent', $parentId);

      return $this->db->count_all_results();
  }
  public function getList($parent=NULL,$is_active=NULL)
  {
    $this->db->select('id as area_id');
    $this->db->select('title as area_title');
    $this->db->select('parent');
    $this->db->select('is_active');

    if (is_null($parent) == FALSE) {
      $this->db->where('parent', $parent);
    }

    if (is_null($is_active) == FALSE) {
      $this->db->where('is_active', $is_active);
    }

    return $this->db->get('area')->result();
  }

  public function getById($id=0)
  {
    $this->db->select('id as area_id');
    $this->db->select('title as area_title');
    $this->db->select('parent');
    $this->db->select('is_active');
    $this->db->where('id', $id);
    return $this->db->get('area')->row();
  }

  public function isUsed($id=0)
  {
    $this->db->select('COUNT(id) as val');
    $this->db->where('area_id', $id);
    $vac = $this->db->get('vacancy')->row()->val;

    $this->db->select('COUNT(id) as val');
    $this->db->where('area_id', $id);
    $ura = $this->db->get('user_role_area')->row()->val;

    if ($vac == 0 && $ura == 0) {
      return FALSE;
    } else {
      return TRUE;
    }

  }

  public function getParent($id=0)
  {
    $parentId = $this->db->select('parent')
      ->where('id',$id)
      ->get('area')
      ->row()->parent;
    return $this->db->select('id as area_id, area_title')
      ->where('id',$parentId)
      ->get('area')
      ->row();
  }

  public function add($title='',$parent=0)
  {
    $data = array(
      'title' => $title,
      'parent' => $parent,
      'is_active' => 1
    );
    $this->db->insert('area', $data);
    // echo $this->db->set($data)->get_compiled_insert('area');
    return $this->db->insert_id();
  }

  public function edit($id=0,$title='',$parent=0)
  {
    $data = array(
      'title' => $title,
      'parent' => $parent
    );
    $this->db->where('id', $id);
    $this->db->update('area', $data);
  }

  public function editName($id=0,$title='')
  {
    $data = array(
      'title' => $title
    );
    $this->db->where('id', $id);
    $this->db->update('area', $data);

  }

  public function editParent($id=0,$parent=0)
  {
    $data = array(
      'parent' => $parent
    );
    $this->db->where('id', $id);
    $this->db->update('area', $data);

  }

  public function remove($id=0)
  {
    $this->db->where('id', $id);
    $this->db->delete('area');

  }

}
