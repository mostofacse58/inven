<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Itassetreport extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/itassetreport_model');
     }


    function index(){
        $data['heading']='Asset Report ';
        $data['resultdetail']=$this->itassetreport_model->reportResult();
        $this->load->view('nologin/itassetreport',$data);
    }

    
}