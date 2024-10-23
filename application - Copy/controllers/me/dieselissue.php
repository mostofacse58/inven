<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dieselissue extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('me/dieselissue_model');
     }
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Diesel Issue';
        $data['list']=$this->dieselissue_model->lists();
        $data['display']='me/dieselissuelist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Add New Diesel Issue';
      $data['mlist']=$this->dieselissue_model->getDropdown('motor_info');
      $data['tlist']=$this->dieselissue_model->getDropdown('driver_info');
      $data['dlist']=$this->dieselissue_model->getDropdown('fuel_using_dept');
      $data['display']='me/adddiesel';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
    }
    function edit($fuel_issue_id){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Edit Diesel Issue';
      $data['info']=$this->dieselissue_model->get_info($fuel_issue_id);
      $data['mlist']=$this->dieselissue_model->getDropdown('motor_info');
      $data['tlist']=$this->dieselissue_model->getDropdown('driver_info');
      $data['dlist']=$this->dieselissue_model->getDropdown('fuel_using_dept');
      $data['display']='me/adddiesel';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
    }
  function save($fuel_issue_id=FALSE){
    $this->form_validation->set_rules('issue_date','Date','trim|required');
    $this->form_validation->set_rules('motor_id','Vehicle Name','trim|required');
    $this->form_validation->set_rules('fuel_using_dept_id','Department','trim|required');
    $this->form_validation->set_rules('taken_by','Taken By','trim|required');
    if ($this->form_validation->run() == TRUE) {
    $check=$this->dieselissue_model->save($fuel_issue_id);
      if($check && !$fuel_issue_id){
        $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $fuel_issue_id){
        $this->session->set_userdata('exception','Update successfully');
       }else{
        $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("me/dieselissue/lists");
     }else{
      $data['heading']='Add New Diesel Issue';
        if($fuel_issue_id){
        $data['heading']='Edit Diesel Issue';
        $data['info']=$this->dieselissue_model->get_info($fuel_issue_id);  
        }
    $data['mlist']=$this->dieselissue_model->getDropdown('motor_info');
    $data['tlist']=$this->dieselissue_model->getDropdown('driver_info');
    $data['dlist']=$this->dieselissue_model->getDropdown('fuel_using_dept');
    $data['display']='me/adddiesel';
    $this->load->view('admin/master',$data);
  }
  }
    function delete($fuel_issue_id=FALSE){
      $check=$this->dieselissue_model->delete($fuel_issue_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/machine/lists");
    }

    
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDiesel($fuel_issue_id){
        $chk=$this->db->query("SELECT * FROM fuel_issue_master WHERE fuel_issue_id=$fuel_issue_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function views($fuel_issue_id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Diesel Issue Details Information';
        $data['info']=$this->dieselissue_model->get_info($fuel_issue_id);
        $data['display']='me/viewmachineInfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
   
 }