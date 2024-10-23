<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indent extends My_Controller {
	function __construct(){
        parent::__construct();
        
        $this->load->model('indent_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Purchase Indent';
        $data['list']=$this->indent_model->lists();
        $data['display']='admin/indent';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($pi_id){
        if($this->session->userdata('user_id')){
        $data['heading']='Edit Purchase Indent';
        $data['list']=$this->indent_model->lists();
        $data['info']=$this->indent_model->get_info($pi_id);
        $data['display']='admin/indent';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($pi_id=FALSE){
        $this->form_validation->set_rules('pi_no','Purchase Indent','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->indent_model->save($pi_id);
            if($check && !$pi_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $pi_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("indent/lists");

         }else{
            $data['heading']='Add Purchase Indent';
            $data['list']=$this->indent_model->lists();
            if($pi_id){
              $data['heading']='Edit Material';
              $data['info']=$this->indent_model->get_info($pi_id);  
            }
            $data['display']='admin/indent';
            $this->load->view('admin/master',$data);
         }

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkPI($pi_id){
        $chk=$this->db->query("SELECT * FROM purchase_master WHERE pi_id=$pi_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function delete($pi_id=FALSE){
      $check=$this->indent_model->delete($pi_id);
        if($check){ 
           $this->session->set_userdata('exception','Purchase Indent Info delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("indent/lists");

    }


 }