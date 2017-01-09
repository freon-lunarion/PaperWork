<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model{

  public function getAreaList()
  {
    $this->db->select('id as area_id');
    $this->db->select('title as area_title');
    $this->db->select('parent');
    $this->db->where('is_active', 1);

    return $this->db->get('area')->result();
  }

  public function getRoleList()
  {
    $this->db->select('id as role_id');
    $this->db->select('title as role_title');
    $this->db->where('is_active', TRUE);
    return $this->db->get('role')->result();
  }

  public function getModuleList()
  {
    $this->db->select('code as module_code');
    $this->db->select('title as module_title');
    return $this->db->get('module')->result();

  }

}
