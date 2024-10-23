<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Budget extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/budget_model');
      $this->load->model('payment/applications_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Monthly Budget Lists';
    $data['lists']=$this->budget_model->lists();
    $data['display']='payment/blists';
    $this->load->view('admin/master',$data);
    } else {
      redirect("logincontroller");
    }
   }
  function add(){
    if($this->session->userdata('user_id')) {
      $data['heading']='Add Budget';
      $data['hlist']=$this->budget_model->getDetails();
      $data['display']='payment/addbudget';
      $this->load->view('admin/master',$data);
    }else{
      redirect("logincontroller");
    }
  }
    
  function edit($master_id){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Edit Budget';
      $data['master_id']=$master_id;
      $data['info']=$this->budget_model->get_info($master_id);
      $data['hlist']=$this->budget_model->getDetails($master_id);
      $data['display']='payment/addbudget';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }

  function save($master_id=FALSE){
    $check=$this->budget_model->save($master_id);
      if($check && !$master_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $master_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("payment/budget/lists");
  }
   function deletes($master_id=FALSE){
         $check=$this->budget_model->deletes($master_id);
           if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
         }
        redirect("payment/budget/lists");
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
        $data['heading']='Budget View';
        $data['info']=$this->budget_model->get_info($master_id);
        $data['hlist']=$this->budget_model->getDetails($master_id);
        $data['master_id']=$master_id;
        $this->load->view('payment/budgetviewExcel', $data);
       } else {
         redirect("logincontroller");
      }
    }
    function submit($master_id){
      $data['status']=2;
      $this->db->where('master_id', $master_id);
      $this->db->update('budget_master',$data);
      $this->session->set_userdata('exception','Submit successfully');
      redirect("payment/budget/lists");
    }
  

 }