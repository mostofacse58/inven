<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Issuestatus extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/issuestatus_model');
     }
    function reportResult($department_id=FALSE){
        $data['heading']='Issue Report ';
        $data['department_id']=$department_id;
        $data['resultdetail']=$this->issuestatus_model->reportResult($department_id);
        $this->load->view('nologin/issuestatus',$data);
    }
  
}