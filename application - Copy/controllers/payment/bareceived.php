<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bareceived extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/budgeta_model');
      $this->load->model('payment/bareceived_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Budget Adjustment Lists';
    $data['lists']=$this->bareceived_model->lists();
    $data['display']='payment/rbalists';
    $this->load->view('admin/master',$data);
    } else {
      redirect("logincontroller");
    }
   }  
    function view($master_id=FALSE){
      $data['heading']='Budget Adjustment View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->budgeta_model->get_info($master_id);
      $data['hlist']=$this->budgeta_model->getDetails($master_id);
      $data['display']='payment/budgetaviewhtml';
      $this->load->view('admin/master',$data);
    }
    
  function approved($master_id=FALSE){
    $check=$this->bareceived_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/bareceived/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->budgeta_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/bareceived/lists");
  }
  

 }