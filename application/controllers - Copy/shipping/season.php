<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Season extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('shipping/season_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Season';
        $data['list']=$this->season_model->lists();
        $data['display']='shipping/seasoninfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Season';
        $data['list']=$this->season_model->lists();
        $data['info']=$this->season_model->get_info($id);
        $data['display']='shipping/seasoninfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($id=FALSE){
        $this->form_validation->set_rules('season','Season','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->season_model->save($id);
            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("shipping/season/lists");

         }else{
            $data['heading']='Add New Season';
            $data['list']=$this->season_model->lists();
            if($id){
              $data['heading']='Edit Season';
              $data['info']=$this->season_model->get_info($id);  
            }
            $data['display']='shipping/seasoninfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
           $check=$this->season_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("shipping/season/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($id){
        $chk=$this->db->query("SELECT i.*
         FROM shipping_imseason_master i,shipping_season_info p 
          WHERE i.file_no=p.file_no 
          AND p.id=$id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }