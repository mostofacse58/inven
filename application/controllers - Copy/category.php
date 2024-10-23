<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
     }
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Category';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['list']=$this->category_model->lists();
        $data['display']='admin/category';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($category_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Category';
        $data['list']=$this->category_model->lists();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['info']=$this->category_model->get_info($category_id);
        $data['display']='admin/category';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function save($category_id=FALSE){
        $this->form_validation->set_rules('category_name','Category Name','trim|required');
        $this->form_validation->set_rules('department_id','Department No','trim|required');
        $this->form_validation->set_rules('cat_type','Type','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->category_model->save($category_id);
            if($check && !$category_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $category_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("category/lists");

         }else{
            $data['heading']='Add New Category';
            $data['list']=$this->category_model->lists();
            $data['dlist']=$this->look_up_model->departmentList();
            if($category_id){
              $data['heading']='Edit Category';
              $data['info']=$this->category_model->get_info($category_id);  
            }
            $data['display']='admin/category';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($category_id=FALSE){
           $check=$this->category_model->delete($category_id);
        if($check){ 
           $this->session->set_userdata('exception','Category delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("category/lists");

    }


 }