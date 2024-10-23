<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('me/material_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Material Type';
        $data['list']=$this->material_model->lists();
        $data['display']='me/material';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($mtype_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Material Type';
        $data['list']=$this->material_model->lists();
        $data['info']=$this->material_model->get_info($mtype_id);
        $data['display']='me/material';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($mtype_id=FALSE){
        $this->form_validation->set_rules('mtype_name','Material Type','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->material_model->save($mtype_id);

            if($check && !$mtype_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $mtype_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("me/material/lists");

         }else{
            $data['heading']='Add New Material Type';
            $data['list']=$this->material_model->lists();
            if($mtype_id){
              $data['heading']='Edit Material';
              $data['info']=$this->material_model->get_info($mtype_id);  
            }
            $data['display']='me/material';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($mtype_id=FALSE){
           $check=$this->material_model->delete($mtype_id);
        if($check){ 
           $this->session->set_userdata('exception','Material type delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("me/material/lists");

    }


 }