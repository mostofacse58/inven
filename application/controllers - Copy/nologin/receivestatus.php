<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receivestatus extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/receivestatus_model');
     }
    function reportResult($department_id=FALSE){
        $data['heading']='Receive Report ';
        $data['department_id']=$department_id;
        $data['resultdetail']=$this->receivestatus_model->reportResult($department_id);
        $this->load->view('nologin/receivestatus',$data);
    }
  
}