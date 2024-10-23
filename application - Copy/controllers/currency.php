<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('currency_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Currency Rate';
        $data['clist']=$this->look_up_model->clist();
        $data['list']=$this->currency_model->lists();
        $data['display']='admin/currency';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Currency Rate';
        $data['list']=$this->currency_model->lists();
        $data['clist']=$this->look_up_model->clist();
        $data['info']=$this->currency_model->get_info($id);
        $data['display']='admin/currency';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
      }
    }
    function save($id=FALSE){
        $this->form_validation->set_rules('currency','From','trim|required');
        $this->form_validation->set_rules('in_currency','From','trim|required');
        $this->form_validation->set_rules('convert_rate','Rate','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->currency_model->save($id);
            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("currency/lists");
         }else{
            $data['heading']='Add Currency Rate';
            $data['list']=$this->currency_model->lists();
            if($id){
              $data['heading']='Edit Currency Rate';
              $data['info']=$this->currency_model->get_info($id);  
            }
            $data['clist']=$this->look_up_model->clist();
            $data['display']='admin/currency';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
      $check=$this->currency_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Department Info delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("currency/lists");

    }


 }