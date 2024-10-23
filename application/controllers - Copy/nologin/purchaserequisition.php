<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchaserequisition extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/purchaserequisition_model');
     }
    function reportResult(){
        $data['heading']='Requisition Report ';
        $data['resultdetail']=$this->purchaserequisition_model->reportResult();
        $this->load->view('nologin/purchaserequisition',$data);
    }
  
}