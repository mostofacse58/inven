<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('unit_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Unit Name';
        $data['list']=$this->unit_model->lists();
        $data['display']='admin/unit';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function serial(){
        if ($this->session->userdata('user_id')) {
        $list=$this->unit_model->serial();
       
        $code_count=1;

        foreach ($list as  $value) {
          $product_detail_id=$value->product_detail_id;
          $data['ventura_code']='VL'.str_pad($code_count, 6, '0', STR_PAD_LEFT);
          $data['code_count']=$code_count;
          $this->db->WHERE('product_detail_id',$product_detail_id);
          $query=$this->db->update('product_detail_info',$data);
          $code_count++;
        }
          
        
        } else {
           redirect("logincontroller");
        }
    }

    function edit($unit_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Unit';
        $data['list']=$this->unit_model->lists();
        $data['info']=$this->unit_model->get_info($unit_id);
        $data['display']='admin/unit';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($unit_id=FALSE){
        $this->form_validation->set_rules('unit_name','Unit Name','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->unit_model->save($unit_id);
            if($check && !$unit_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $unit_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("unit/lists");

         }else{
            $data['heading']='Add Unit Name';
            $data['list']=$this->unit_model->lists();
            $data['dlist']=$this->unit_model->dlists();
            if($unit_id){
              $data['heading']='Edit Unit';
              $data['info']=$this->unit_model->get_info($unit_id);  
            }
            $data['display']='admin/unit';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($unit_id=FALSE){
           $check=$this->unit_model->delete($unit_id);
        if($check){ 
           $this->session->set_userdata('exception','Unit Name delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("unit/lists");

    }
//////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($unit_id){
        $chk=$this->db->query("SELECT * FROM product_info 
          WHERE unit_id=$unit_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }

 }