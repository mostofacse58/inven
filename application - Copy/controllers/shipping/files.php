<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('shipping/files_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New File';
        $data['list']=$this->files_model->lists();
        $data['display']='shipping/filesinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit File';
        $data['list']=$this->files_model->lists();
        $data['info']=$this->files_model->get_info($id);
        $data['display']='shipping/filesinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($id=FALSE){
        $this->form_validation->set_rules('file_no','File no','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->files_model->save($id);
            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("shipping/files/lists");

         }else{
            $data['heading']='Add New File';
            $data['list']=$this->files_model->lists();
            if($id){
              $data['heading']='Edit File';
              $data['info']=$this->files_model->get_info($id);  
            }
            $data['display']='shipping/filesinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
           $check=$this->files_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("shipping/files/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($id){
        $chk=$this->db->query("SELECT i.*
         FROM shipping_imfiles_master i,shipping_files_info p 
          WHERE i.file_no=p.file_no 
          AND p.id=$id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }