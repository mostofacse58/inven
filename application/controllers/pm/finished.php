<?php if ( ! defined('BASEPATH')) exme('No direct script access allowed');
class Finished extends My_Controller {
function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    $this->load->model('pm/finished_model');
 }
 function lists($year=FALSE){
      $data=array();
        $data['list']=$this->finished_model->lists($year);
        $this->form_validation->set_rules('model_no','No','trim');
        $this->form_validation->set_rules('tpm_code','Name','trim');
        $data['heading']='Maintenance Lists';
        $data['display']='pm/flists';
        $this->load->view('admin/master',$data);
       }


 function view($pm_id){
    if ($this->session->userdata('user_id')) {
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Plan Maintenance Details';
    $data['info']=$this->finished_model->get_info($pm_id);
    $data['details']=$this->finished_model->getworkdetail($pm_id);
    $data['sdetail']=$this->finished_model->getsdetail($data['info']->sref_no);
    $data['display']='pm/view';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
}




}