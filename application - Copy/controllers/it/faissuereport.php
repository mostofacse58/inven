<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faissuereport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('it/faissuereport_model');
     }
    function searchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Items Issue Report';
        $data['dlist']=$this->look_up_model->departmentList();
		$data['clist']=$this->look_up_model->getCategory(1);
	    $data['display']='itreport/faissuereport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportResult(){
        $data['heading']='Items Issue Report ';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['clist']=$this->look_up_model->getCategory(1);
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('department_id','Department','trim|required');
        $this->form_validation->set_rules('employee_id','Employee ID','trim');
        if ($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $department_id=$this->input->post('department_id');
        $data['category_id']=$this->input->post('category_id');
        $data['employee_id']=$this->input->post('employee_id');
        $data['department_id']=$this->input->post('department_id');
        $data['resultdetail']=$this->faissuereport_model->reportResult($category_id,$department_id,$data['employee_id']);
        $data['spareslist']=$this->faissuereport_model->reportSparesResult($category_id,$department_id,$data['employee_id']);
        $data['relist']=$this->faissuereport_model->reportSparesReturn($category_id,$department_id,$data['employee_id']);
        $data['display']='itreport/faissuereport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='itreport/faissuereport';
        $this->load->view('admin/master',$data);
        }
        
    }
function downloadPdf($category_id=FALSE,$department_id=FALSE,$employee_id=FALSE) {
    $data['heading']='Items Issue Report ';
    $data['category_id']=$category_id;
    $data['department_id']=$department_id;
    $data['resultdetail']=$this->faissuereport_model->reportResult($category_id,$department_id,$employee_id);
    $data['relist']=$this->faissuereport_model->reportSparesReturn($category_id,$department_id,$employee_id);
    $data['spareslist']=$this->faissuereport_model->reportSparesResult($category_id,$department_id,$employee_id);
    $this->load->view('itreport/faissuereportExcel',$data);
    }
    
}