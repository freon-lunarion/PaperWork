<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

  var $table = 'user';
  var $column_select = array('id','username','firstname','lastname','nickname','email','is_active');

  var $column_order = array('username','firstname','lastname','nickname','email','email','is_active'); //set column field database for datatable orderable
  var $column_search = array('username','firstname','lastname','nickname','email','email','is_active'); //set column field database for datatable searchable
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

  public function getActive()
  {
    $this->db->select('id as user_id');
    $this->db->select('username');
    $this->db->where('is_active', TRUE);
    $this->db->order_by('username');
    return $this->db->get('user')->result();
  }

  public function isIdValid($id=0)
  {
    $this->db->select('COUNT(id) as val');
    $this->db->from($this->table);
    $this->db->where('id', $id);
    if ($this->db->get()->row()->val) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function isEmailAvailable($email='')
  {
    $this->db->select('COUNT(id) as val');
    $this->db->from($this->table);
    $this->db->where('LOWER(email)', strtolower($email));

    if ($this->db->get()->row()->val) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function isUsernameAvailable($username='')
  {
    $this->db->select('COUNT(id) as val');
    $this->db->from($this->table);
    $this->db->where('LOWER(username)', strtolower($username));

    if ($this->db->get()->row()->val) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function getById($id=0)
  {
    $this->db->select('id');
    $this->db->select('username');
    $this->db->select('firstname');
    $this->db->select('lastname');
    $this->db->select('nickname');
    $this->db->select('email');
    $this->db->select('is_active');
    return $this->db->get('user')->row();
  }

  public function add($username='',$password='',$email='',$firstname='',$lastname='',$nickname='')
  {
    if ($this->isUsernameAvailable($username) && $this->isEmailAvailable($email)) {
      $data = array(
        'username'  => strtolower($username),
        'password'  => md5($password),
        'email'     => strtolower($email),
        'is_active' => TRUE,
        'firstname' => $firstname,
        'lastname'  => $lastname,
        'nickname'  => $nickname,
      );
      $this->db->insert($this->table, $data);
      return $this->db->insert_id();
    } else {
      return false;
    }
  }

  public function edit($id=0,$username='',$email='',$firstname='',$lastname='',$nickname='',$status=TRUE)
  {
      $data = array(
        'username'  => strtolower($username),
        'email'     => strtolower($email),
        'is_active' => $status,
        'firstname' => $firstname,
        'lastname'  => $lastname,
        'nickname'  => $nickname,
      );
      $this->db->where('id', $id);
      $this->db->update($this->table, $data);
      return TRUE;
  }

  public function editStatus($id=0,$status=FALSE)
  {
    if ($this->isIdValid($id)) {
      $data = array(
        'is_active' => $status,
      );
      $this->db->where('id', $id);
      $this->db->update('user', $data);
      return TRUE;

    } else {
      return false;
    }
  }

  public function editEmail($id=0,$email='')
  {
    if ($this->isEmailAvailable($email)) {
      $data = array(
        'email'     => strtolower($email),
      );
      $this->db->where('id', $id);
      $this->db->update('user', $data);
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function editUsername($id=0,$username='')
  {
    if ($this->isUsernameAvailable($email)) {
      $data = array(
        'username'  => strtolower($username),
      );
      $this->db->where('id', $id);
      $this->db->update('user', $data);
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function editPassword($id=0,$password='')
  {
    if ($this->isIdValid($id)) {
      $data = array(
        'password'  => md5($password),
      );
      $this->db->where('id', $id);
      $this->db->update('user', $data);
      return TRUE;
    } else {
      return FALSE;
    }
  }

}
