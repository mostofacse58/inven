<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tpmsparesusing extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/tpmsparesusing_model');
     }
    function reportResult(){
        $data['heading']='TPM Report ';
        $data['resultdetail']=$this->tpmsparesusing_model->reportResult();
        $this->load->view('nologin/tpmsparesusing',$data);
    }
  
}