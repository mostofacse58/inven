<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tutorial extends CI_Controller {
  function __construct() {
	  parent::__construct();
    $this->load->model('tutorial_model');
  }

 function helpdesk($id=FALSE){
    $data['heading']='No';
    $data['mlist']=$this->tutorial_model->getmenu();
    if($id!=FALSE){
      $data['info']=$this->tutorial_model->getinfo($id);
      $data['display']='tutorial/show';
    }else{
      $data['display']='tutorial/home';
    }
    $this->load->view('tutorial/master',$data);
  }
  
	
   

	
}