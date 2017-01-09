<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(
      array(
        'permission_model',
        'role_model',
        'module_model'
      )
    );
  }

  function index()
  {

  }

  public function byRole($role_id=0)
  {
    
  }

  public function byModule($module_code='')
  {

  }

  public function formAdd()
  {

  }

  public function formEdit()
  {

  }

}
