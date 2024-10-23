<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('department_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Department Information';
        $data['list']=$this->department_model->lists();
        $data['display']='admin/department';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($department_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Department Information';
        $data['list']=$this->department_model->lists();
        $data['info']=$this->department_model->get_info($department_id);
        $data['display']='admin/department';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
      }
    }
    function save($department_id=FALSE){
        $this->form_validation->set_rules('department_name','Department Name','trim|required');
        $this->form_validation->set_rules('dept_head_email','Email Address','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->department_model->save($department_id);
            if($check && !$department_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $department_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("department/lists");

         }else{
            $data['heading']='Add New Department Information';
            $data['list']=$this->department_model->lists();
            if($department_id){
              $data['heading']='Edit Department Information';
              $data['info']=$this->department_model->get_info($department_id);  
            }
            
            $data['display']='admin/department';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($department_id=FALSE){
      $check=$this->department_model->delete($department_id);
        if($check){ 
           $this->session->set_userdata('exception','Department Info delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("department/lists");

    }


 }