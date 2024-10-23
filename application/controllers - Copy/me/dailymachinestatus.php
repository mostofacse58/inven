<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dailymachinestatus extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('report/dailymachinestatus_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        if($this->input->post('from_date')!=''){
         $data['from_date']=alterDateFormat($this->input->post('from_date'));
        }else{
         $data['from_date']=date('Y-m-d');
        }
        $data['heading']='Daily Machine Status Report';
		$data['flist']=$this->dailymachinestatus_model->getFloor();
	    $data['display']='report/dailymachinestatus';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['flist']=$this->dailymachinestatus_model->getFloor();
        $data['heading']='Daily Machine Status Report';
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['from_date']=$this->input->post('from_date');
            $data['floor_id']=$this->input->post('floor_id');
            $data['resultdetail']=$this->dailymachinestatus_model->reportrResult($data['floor_id'],$data['from_date']);
            $data['display']='report/dailymachinestatus';
            $this->load->view('admin/master',$data);
        }else{
        $data['display']='report/dailymachinestatus';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($from_date=FALSE) {
        $data['heading']='Daily Machine Status Report';
        $data['flist']=$this->dailymachinestatus_model->getFloor();
        $data['from_date']=$from_date;
        $this->load->view('excel/dailymachinestatusExcel',$data);
    }
  
}