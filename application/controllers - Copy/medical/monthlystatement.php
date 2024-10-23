<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monthlystatement extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('medical/monthlystatement_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Medical statement (Monthly)';
		$data['clist']=$this->look_up_model->getCategory(12);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSymptom();
	    $data['display']='medical/monthlystatement';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Medical statement (Monthly) ';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSymptom();
        $this->form_validation->set_rules('department_id','department Name','trim');
        $this->form_validation->set_rules('symptoms_id','Name','trim');
        $this->form_validation->set_rules('from_date','Date','trim');
        $this->form_validation->set_rules('to_date','date','trim');
        if ($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $department_id=$this->input->post('department_id');
        $data['department_id']=$this->input->post('department_id');
        $data['symptoms_id']=$this->input->post('symptoms_id');
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['resultdetail']=$this->monthlystatement_model->reportrResult($department_id,$data['symptoms_id'],$data['from_date'],$data['to_date']);
        $data['display']='medical/monthlystatement';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='medical/monthlystatement';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($department_id=FALSE,$symptoms_id,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='Medical statement (Monthly) ';
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['resultdetail']=$this->monthlystatement_model->reportrResult($department_id,$symptoms_id,$from_date,$to_date);
        $this->load->view('medical/monthlystatementExcel',$data);
    }
   
    
}