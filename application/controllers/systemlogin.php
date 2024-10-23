<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Systemlogin extends CI_Controller {
      function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
     }
	public function index() {
    if($this->session->userdata('loggedinventory')==TRUE){
      redirect('dashboard'); 
    }else{
    redirect("https://vlmbd.com/oneplatform/");
   }
  }
  public function autologin($email_address,$password) {
    $email_address=$this->custom->encrypt_decrypt($email_address,'decrypt');
    $password=$this->custom->encrypt_decrypt($password,'decrypt');

    $checkUser = $this->login_model->checkValidUser($email_address, $password);

    $localIP = getHostByName(getHostName());  $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $this->session->set_userdata("computer_id", $localIP);
    $this->session->set_userdata("pc_name", $host_name);
    $this->session->set_userdata("user_id", $checkUser->id);        
    $this->session->set_userdata("medical_yes", $checkUser->medical_yes);
    $this->session->set_userdata("stock_holder", $checkUser->stock_holder);
    $this->session->set_userdata("user_type", $checkUser->super_user);
    $this->session->set_userdata("department_id", $checkUser->department_id);
    $this->session->set_userdata("department_name", $checkUser->department_name);
    $this->session->set_userdata("user_cat", $checkUser->user_cat);
    $this->session->set_userdata("update", $checkUser->update);
    $this->session->set_userdata("delete", $checkUser->delete);
    $this->session->set_userdata("loggedinventory",TRUE);
    redirect('dashboard/index');
  }
  
  public function logout(){
      $url=$this->session->userdata('main_url');
      $this->session->unset_userdata('user_id');
      $this->session->unset_userdata('user_cat');
      $this->session->unset_userdata('stock_holder');
      $this->session->unset_userdata('medical_yes');
      $this->session->unset_userdata('pc_name');
      $this->session->unset_userdata('computer_id');
      $this->session->unset_userdata('user_type');
      $this->session->unset_userdata('update');
      $this->session->unset_userdata('delete');
      $this->session->unset_userdata('loggedinventory');
      $this->session->set_userdata("app_login_status", 0);
      redirect("https://vlmbd.com/oneplatform/");
    }

}

