<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library("excel");
        $this->load->model('shipping/report_model');
        if($this->session->userdata('language')=='chinese'){
        $this->lang->load('chinese', "chinese");
        }else{
          $this->lang->load('english', "english");
        }
     }
    function importForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Import Report';
	    $data['display']='shipping/importreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function importExcel($master_id=FALSE){
    if($this->session->userdata('user_id')) {
        $this->excel->setActiveSheetIndex(0);
        $data = $this->report_model->importExcel();  
        //print_r($data); exit();
        $this->excel->stream('name_of_file.xls', $data);
       }else{
        redirect("logincontroller");
      }
    }

   
    
}