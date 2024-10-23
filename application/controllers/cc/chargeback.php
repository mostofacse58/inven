<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chargeback extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->output->nocache();
        $this->load->model('cc/chargeback_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Charge Back To';
        $data['list']=$this->chargeback_model->lists();
        $data['display']='cc/chargebackinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($chargeback_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Charge Back To';
        $data['list']=$this->chargeback_model->lists();
        $data['info']=$this->chargeback_model->get_info($chargeback_id);
        $data['display']='cc/chargebackinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($chargeback_id=FALSE){
        $this->form_validation->set_rules('chargeback_name','Name','trim|required');
        $this->form_validation->set_rules('description','Description','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->chargeback_model->save($chargeback_id);
            if($check && !$chargeback_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $chargeback_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("cc/chargeback/lists");

         }else{
            $data['heading']='Add Charge Back To';
            $data['list']=$this->chargeback_model->lists();
            if($chargeback_id){
              $data['heading']='Edit Issue To';
              $data['info']=$this->chargeback_model->get_info($chargeback_id);  
            }
            $data['display']='cc/chargebackinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($chargeback_id=FALSE){
        $check=$this->chargeback_model->delete($chargeback_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("cc/chargeback/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($chargeback_id){
        $chk=$this->db->query("SELECT * FROM courier_master 
          WHERE chargeback_id=$chargeback_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    

    


 }