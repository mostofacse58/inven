<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('audit/schedule_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Schedule List';
        $data['list']=$this->schedule_model->lists();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='audit/schedulelist';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($master_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Schedule';
        $data['list']=$this->schedule_model->lists();
        $data['info']=$this->schedule_model->get_info($master_id);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='audit/schedulelist';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    
    function save($master_id=FALSE){
        $this->form_validation->set_rules('quater','Quater','trim|required');
        $this->form_validation->set_rules('acategory','Category','trim|required');
        $this->form_validation->set_rules('atype','Type','trim|required');
        $this->form_validation->set_rules('start_date','Date','trim|required');
        $this->form_validation->set_rules('end_date','Date','trim|required');
        $this->form_validation->set_rules('year','Year','trim|required');
        $this->form_validation->set_rules('department_id','Department','trim|required');
        $this->form_validation->set_rules('note','note','trim');
         if($this->form_validation->run() == TRUE) {
            $check=$this->schedule_model->save($master_id);
            if($check && !$master_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $master_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
            redirect("audit/schedule/lists");
         }else{
            $data['heading']='Add New Schedule';
            $data['list']=$this->schedule_model->lists();
            $data['dlist']=$this->look_up_model->departmentList();
            if($master_id){
              $data['heading']='Edit Schedule';
              $data['info']=$this->schedule_model->get_info($master_id);  
            }
            $data['display']='audit/schedulelist';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($master_id=FALSE){
        $check=$this->schedule_model->delete($master_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("audit/schedule/lists");

    }
    function send($master_id=FALSE){
        $check=$this->schedule_model->send($master_id);
        if($check){ 
           $this->session->set_userdata('exception','Send successfully');
         }else{
           $this->session->set_userdata('exception','Send Falied');
         }
        redirect("audit/schedule/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
 


 }