<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model{

  private function _getQueryByRole($role_id=0)
  {
    $colSearch = array('m.title');
    $colOrder  = array(null,'m.title');
    $oder      = array('id'=> 'asc');
    $this->db->select('m.id as id');

    $this->db->select('m.title as module_name');
    $this->db->select('rm.self_read');
    $this->db->select('rm.group_read');
    $this->db->select('rm.sub_read');
    $this->db->select('rm.self_write');
    $this->db->select('rm.group_write');
    $this->db->select('rm.sub_write');

    $this->db->from('role_module rm');
    $this->db->join('module m', 'rm.module_code = m.code', 'left');
    $i = 0;
    foreach ($colSearch as $item) {
      if ($_POST['search']['value']) {
        if ($i === 0) {
          $this->db->group_start();
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);

        }

        if (count($search) - 1 == $i) {
          $this->db->group_end();
        }
      }
      $i++;
    }
    if (isset($_POST['order'])) {
      $this->db->order_by($colOrder[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
    } else if (isset($this->order)){
      $this->db->order_by(key($order),$order[key($order)]);
    }
  }

  private function _getQueryByModule($module_code='')
  {
    $search = array('r.title');
    $colShis->db->select('r.title as role_name');
    $colOrder  = array(null,'r.title');
    $oder      = array('id'=> 'asc');
    $this->db->select('m.id as id');

    $this->db->select('rm.self_read');
    $this->db->select('rm.group_read');
    $this->db->select('rm.sub_read');
    $this->db->select('rm.self_write');
    $this->db->select('rm.group_write');
    $this->db->select('rm.sub_write');

    $this->db->from('role_module rm');
    $this->db->join('role r', 'rm.role_id = r.id', 'left');
    $i = 0;
    foreach ($colSearch as $item) {
      if ($_POST['search']['value']) {
        if ($i === 0) {
          $this->db->group_start();
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);

        }

        if (count($search) - 1 == $i) {
          $this->db->group_end();
        }
      }
      $i++;
    }
    if (isset($_POST['order'])) {
      $this->db->order_by($colOrder[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
    } else if (isset($this->order)){
      $this->db->order_by(key($order),$order[key($order)]);
    }
  }

  public function countFilteredByRole($role_id=0)
  {
    $this->_getQueryByRole($role_id);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function countFilteredByModule($module_code=0)
  {
    $this->_getQueryByModule($module_code);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function countAllByRole($role_id=0)
  {
    $this->db->from('role_module rm');
    $this->db->join('module m', 'rm.module_code = m.code', 'left');
    $this->db->where('role_id', $role_id);
    return $this->db->count_all_results();

  }

  public function countAllByModule($module_code='')
  {
    $this->db->from('role_module rm');
    $this->db->join('role r', 'rm.role_id = r.id', 'left');
    $this->db->where('module_code', $module_code);
    return $this->db->count_all_results();

  }

  public function getListByModule($module_code='')
  {
    $this->_getQueryByModule($module_code);
    if($_POST['length'] != -1){
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();

  }

  public function getListByRole($role_id=0)
  {
    $this->_getQueryByRole($role_id);
    if($_POST['length'] != -1){
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();

  }

  public function getById($id='')
  {
    $this->db->from('role_module');
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function getByModuleAndRole($module_code='',$role_id='')
  {
    $this->db->from('role_module');
    $this->db->where('role_id', $role_id);
    $this->db->where('module_code', $module_code);
    return $this->db->get()->row();
  }

  public function isAvailable($module_code='',$role_id=0)
  {
    $this->db->select('count(id) as val');
    $this->db->from('role_module');
    $this->db->where('LOWER(module_code)', strtolower($module_code));
    $this->db->where('role_id', $role_id);

    if ($this->db->get()->row()->val) {
      return false;
    } else {
      return true;
    }
  }

  public function add($module_code='',$role_id='',$self_read=1,$self_write=1,$group_read=1,$group_write=0,$sub_read=0,$sub_write=0)
  {
    if ($this->isAvailable($module_code,$role_id)) {
      $data = array(
        'module_code' => $module_code ,
        'role_id'     => $role_id ,
        'self_read'   => $self_read ,
        'self_write'  => $self_write ,
        'group_read'  => $group_read ,
        'group_write' => $group_write ,
        'sub_read'    => $sub_read ,
        'sub_write'   => $sub_write ,
      );

      $this->db->insert('role_module', $data);
      return $this->db->insert_id();
    } else {
      $this->change($module_code,$role_id,$self_read,$self_write,$group_read,$group_write,$sub_read,$sub_write);
    }
  }

  public function edit($module_code='',$role_id='',$self_read=1,$self_write=1,$group_read=1,$group_write=0,$sub_read=0,$sub_write=0)
  {
    $data = array(
      'self_read'   => $self_read ,
      'self_write'  => $self_write ,
      'group_read'  => $group_read ,
      'group_write' => $group_write ,
      'sub_read'    => $sub_read ,
      'sub_write'   => $sub_write ,
    );
    $this->db->where('LOWER(module_code)', strtolower($module_code));
    $this->db->where('role_id', $role_id);
    $this->db->update('role_module', $data);
  }

  public function editPermission($module_code='',$role_id=0,$permission='',$status)
  {
    if ($this->isAvailable($module_code,$role_id)) {
      $this->add($module_code,$role_id,0,0,0,0,0,0);
    }
    $data = array(
      'permission'   => $status
    );
    $this->db->where('LOWER(module_code)', strtolower($module_code));
    $this->db->where('role_id', $role_id);
    $this->db->update('role_module', $data);

  }

  public function editSelfRead($module_code='',$role_id=0,$status=1)
  {
    $this->changePermission('self_read',$status);
  }

  public function editSelfWrite($module_code='',$role_id=0,$status=1)
  {
    $this->changePermission('self_write',$status);
  }

  public function editGroupRead($module_code='',$role_id=0,$status=1)
  {
    $this->changePermission('group_read',$status);
  }

  public function editGroupWrite($module_code='',$role_id=0,$status=1)
  {
    $this->changePermission('group_write',$status);
  }

  public function editSubRead($module_code='',$role_id=0,$status=1)
  {
    $this->changePermission('sub_read',$status);
  }

  public function editSubWrite($module_code='',$role_id=0,$status=1)
  {
    $this->changePermission('sub_write',$status);
  }



}
