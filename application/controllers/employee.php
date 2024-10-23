<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends My_Controller {
	function __construct(){
        parent::__construct();
        
        $this->load->model('employee_model');
        $this->load->model('config_model');
     }
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Employee Info';
        $data['list']=$this->employee_model->lists();
        $data['display']='admin/employee';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($employee_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Employee Info';
        $data['list']=$this->employee_model->lists();
        $data['info']=$this->employee_model->get_info($employee_id);
        $data['display']='admin/employee';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    function save($employee_id=FALSE){
        $this->form_validation->set_rules('employee_name','Employee Name','trim|required');
        $this->form_validation->set_rules('designation','Designation','trim|required');
        $this->form_validation->set_rules('employee_cardno','ID No','trim|required');

         if ($this->form_validation->run() == TRUE) {
            $check=$this->employee_model->save($employee_id);
            if($check && !$employee_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $employee_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("employee/lists");

         }else{
            $data['heading']='Add New Employee Info';
            $data['list']=$this->employee_model->lists();
            if($employee_id){
              $data['heading']='Edit Employee Info';
              $data['info']=$this->employee_model->get_info($employee_id);  
            }
            
            $data['display']='admin/employee';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($employee_id=FALSE){
           $check=$this->employee_model->delete($employee_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("employee/lists");

    }


 }