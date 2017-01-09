<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserAccess_model extends CI_Model{

  public function checkLogin($nameOrMail = '', $plainPass = '')
  {

    $this->db->select('COUNT(id) as val');
    $this->db->from('user');
    $this->db->where('password', md5($plainPass));
    $this->db->group_start();
    $this->db->where('LOWER(username)',strtolower($nameOrMail));
    $this->db->or_where('LOWER(email)',strtolower($nameOrMail));
    $this->db->group_end();
    $this->db->where('is_active', TRUE);

    if ($this->db->get()->row()->val) {
      # Password match

      return TRUE;
    } else {
      # Password not match
      return FALSE;
    }
  }

  public function isUserIdValid($id=0)
  {
    $this->db->select('COUNT(id) as val')
    $this->db->from('user');
    $this->db->where('id', $id);
    $this->db->where('is_active', TRUE);

    if ($this->db->get()->row()->val) {
      return TRUE;
    } else {
      return FALSE;
    }
  }



}
