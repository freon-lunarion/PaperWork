<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _model extends CI_Model{

  public function getList($limit=100,$offset=0)
  {
    $this->db->select('*');
    $this->db->from('tableName');
    $this->db->limit($limit,$offset);
    return $this->db->get()->result();
  }

  public function getById($id='')
  {
    $this->db->from('tableName');
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function add($field1='',$field2='')
  {
    $data = array(
      'field1' => $field1,
      'field2' => $field2
    );

    $this->db->insert('tableName', $data);
    return $this->db->insert_id();
  }

  public function change($id=0,$field1='',$field2='')
  {
    $data = array(
      'field1' => $field1,
      'field2' => $field2
    );
    $this->db->where('id', $id);
    $this->db->update('tableName', $data);
    return TRUE;
  }

  public function remove($id=0)
  {
    $this->db->where('id', $id);
    $this->db->delete('tableName');
    return TRUE;

  }

}
