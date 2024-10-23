<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbudgeta extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/budgeta_model');
      $this->load->model('payment/applications_model');
      $this->load->model('payment/cbudgeta_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Budget Adjustment Lists';
    $data['lists']=$this->cbudgeta_model->lists();
    $data['display']='payment/cbalists';
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
      $this->load->model('communication');
      $data['info']=$this->budgeta_model->get_info($master_id);
      $emailaddress="finance.accounts@bdventura.com";
      $subject="Budget Request Receive Notification";
      $message=$this->load->view('payment/budget_received_email', $data,true); 
      //$this->communication->send($emailaddress,$subject,$message);
  ////////////////////////
    $check=$this->cbudgeta_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/cbudgeta/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->budgeta_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/cbudgeta/lists");
  }
  

 }