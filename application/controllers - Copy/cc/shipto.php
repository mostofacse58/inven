<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipto extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->output->nocache();
        $this->load->model('cc/shipto_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Receiver';
        $data['list']=$this->shipto_model->lists();
        $data['display']='cc/shiptoinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($ship_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Receiver';
        $data['list']=$this->shipto_model->lists();
        $data['info']=$this->shipto_model->get_info($ship_id);
        $data['display']='cc/shiptoinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($ship_id=FALSE){
        $this->form_validation->set_rules('ship_name','Name','trim|required');
        $this->form_validation->set_rules('ship_attention','Attention','trim|required');
        $this->form_validation->set_rules('ship_telephone','Telephone','trim');
        $this->form_validation->set_rules('ship_email','Email','trim');
        $this->form_validation->set_rules('ship_address','address','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->shipto_model->save($ship_id);
            if($check && !$ship_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $ship_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("cc/shipto/lists");

         }else{
            $data['heading']='Add Receiver';
            $data['list']=$this->shipto_model->lists();
            if($ship_id){
              $data['heading']='Edit Issue To';
              $data['info']=$this->shipto_model->get_info($ship_id);  
            }
            $data['display']='cc/shiptoinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($ship_id=FALSE){
        $check=$this->shipto_model->delete($ship_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("cc/shipto/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($ship_id){
        $chk=$this->db->query("SELECT * FROM courier_master 
          WHERE ship_id=$ship_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    

    


 }