<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CandidateAccess extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function checkLogin($email = '', $plainPass = '')
  {
    $this->db->select('COUNT(id) as val');
    $this->db->from('candidate');
    $this->db->where('password', md5($plainPass));
    $this->db->where('LOWER(email)',strtolower($nameOrMail));
    $this->db->where('is_active', TRUE);

    if ($this->db->get()->row()->val) {
      # Password match

      return TRUE;
    } else {
      # Password not match
      return FALSE;
    }
  }

}
