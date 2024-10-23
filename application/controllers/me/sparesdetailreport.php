<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sparesdetailreport extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('report/sparesdetailreport_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Spares Details Report';
	    $data['display']='report/sparesdetailreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Spares Details Report ';
        $this->form_validation->set_rules('product_code','ITEM CODE','trim');
        if ($this->form_validation->run() == TRUE) {
        $product_code=$this->input->post('product_code');
        $data['product_code']=$this->input->post('product_code');
        $data['info']=$this->sparesdetailreport_model->getInfo($product_code);
        $data['resultdetail']=$this->sparesdetailreport_model->reportrResult($product_code);
        $data['display']='report/sparesdetailreport';
        $this->load->view('admin/master',$data);
        }else{
        
        $data['display']='report/sparesdetailreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($product_code=FALSE) {
        $data['heading']='Spares Details Report ';
        $data['product_code']=$product_code;
        $data['info']=$this->sparesdetailreport_model->getInfo($product_code);
        $data['resultdetail']=$this->sparesdetailreport_model->reportrResult($product_code);
        $this->load->view('excel/sparesdetailreportExcel',$data);
    }
    
}