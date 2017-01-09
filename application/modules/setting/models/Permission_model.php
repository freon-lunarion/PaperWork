<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model{

  public function getListByRole($role_id=0)
  {
    $this->db->select('self_read');
    $this->db->select('group_read');
    $this->db->select('sub_read');
    $this->db->select('self_write');
    $this->db->select('group_write');
    $this->db->select('sub_write');

    $this->db->from('role_module');
    $this->db->where('role_id', $id);

    return $this->db->get()->result();
  }

  public function getListByModule($module_code=0)
  {
    $this->db->select('self_read');
    $this->db->select('group_read');
    $this->db->select('sub_read');
    $this->db->select('self_write');
    $this->db->select('group_write');
    $this->db->select('sub_write')
    
    $this->db->from('role_module');
    $this->db->where('module_code', strtolower($module_code));

    return $this->db->get()->result();
  }

  public function getById($id='')
  {
    $this->db->from('role_module');
    $this->db->where('id', $id);
    return $this->db->get()->result();
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
