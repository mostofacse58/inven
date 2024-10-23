<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rbudgety extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/budgety_model');
      $this->load->model('payment/rbudgety_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Yearly Budget Lists';
    $data['lists']=$this->rbudgety_model->lists();
    $data['display']='payment/rbudgety';
    $this->load->view('admin/master',$data);
    } else {
      redirect("logincontroller");
    }
   }  
    function view($master_id=FALSE){
      $data['heading']='Yearly Budget View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->budgety_model->get_info($master_id);
      $data['hlist']=$this->budgety_model->getDetails($master_id);
      $data['display']='payment/budgetyviewhtml';
      $this->load->view('admin/master',$data);
    }
    
  function approved($master_id=FALSE){
    $check=$this->rbudgety_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/rbudgety/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->budgety_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/rbudgety/lists");
  }
  

 }