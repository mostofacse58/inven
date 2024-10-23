<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbudget extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/budget_model');
      $this->load->model('payment/applications_model');
      $this->load->model('payment/cbudget_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Monthly Budget Lists';
    $data['lists']=$this->cbudget_model->lists();
    $data['display']='payment/cblists';
    $this->load->view('admin/master',$data);
    } else {
      redirect("logincontroller");
    }
   }
  function view($master_id=FALSE){
      $data['heading']='Budget View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->budget_model->get_info($master_id);
      $data['hlist']=$this->budget_model->getDetails($master_id);
      $data['display']='payment/budgetviewhtml';
      $this->load->view('admin/master',$data);
    }
    

  function loadExcel($master_id=FALSE,$year=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Audit Report';
        $data['info']=$this->budget_model->get_info($master_id);
        $data['hlist']=$this->budget_model->getHeadList($data['info']);
        $data['master_id']=$master_id;
        $this->load->view('payment/paymentExcel', $data);
       } else {
         redirect("logincontroller");
      }
    }
    function approved($master_id=FALSE){
      $this->load->model('communication');
      $data['info']=$this->budget_model->get_info($master_id);
      $emailaddress="finance.accounts@bdventura.com";
      $subject="Budget Request Receive Notification";
      $message=$this->load->view('payment/budget_received_email', $data,true); 
      //$this->communication->send($emailaddress,$subject,$message);
  ////////////////////////
    $check=$this->cbudget_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/cbudget/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->budget_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/cbudget/lists");
  }
  

 }