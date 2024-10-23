<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('audit/package_model');
        $this->load->model('audit/head_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Package List';
        $data['list']=$this->package_model->lists();
        $data['hlist']=$this->head_model->lists();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='audit/packageinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function addedit($package_id=FALSE){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Package';
        $data['hlist']=$this->head_model->lists();
        $data['dlist']=$this->look_up_model->departmentList();
        if($package_id!=''){
            $data['heading']='Edit Package';
            $data['info']=$this->package_model->get_info($package_id);
        }
        $data['display']='audit/padd';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    
    function save($package_id=FALSE){
        $this->form_validation->set_rules('head_id','Head','trim|required');
        $this->form_validation->set_rules('acategory','Category','trim|required');
        $this->form_validation->set_rules('sub_head_name','Sub Head','trim|required');
        $this->form_validation->set_rules('weight','Weight','trim|required');
        $this->form_validation->set_rules('department_id','Department','trim');
        $this->form_validation->set_rules('criteria_1','Criteria 1','trim');
        $this->form_validation->set_rules('criteria_2','Criteria 2','trim');
        $this->form_validation->set_rules('criteria_3','Criteria 3','trim');
        $this->form_validation->set_rules('year','Criteria 3','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->package_model->save($package_id);

            if($check && !$package_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $package_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("audit/package/lists");
         }else{
            $data['heading']='Add New Package';
            $data['hlist']=$this->head_model->lists();
            if($id){
              $data['heading']='Edit Package';
              $data['info']=$this->package_model->get_info($package_id);  
            }
            $data['dlist']=$this->look_up_model->departmentList();
            $data['display']='audit/padd';
            $this->load->view('admin/master',$data);
         }
    }

    function delete($package_id=FALSE){
           $check=$this->package_model->delete($package_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("audit/package/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($package_id){
        $chk=$this->db->query("SELECT i.*
         FROM shipping_imsupplier_master i
          WHERE  p.id=$package_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }