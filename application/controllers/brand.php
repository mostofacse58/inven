<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends My_Controller {
	function __construct(){
        parent::__construct();
        
        $this->load->model('brand_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Brand';
        $data['list']=$this->brand_model->lists();
        $data['display']='admin/brand';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($brand_id){
        if($this->session->userdata('user_id')){
        $data['heading']='Edit Brand';
        $data['list']=$this->brand_model->lists();
        $data['info']=$this->brand_model->get_info($brand_id);
        $data['display']='admin/brand';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }

    }
    
    function save($brand_id=FALSE){
        $this->form_validation->set_rules('brand_name','Brand','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->brand_model->save($brand_id);

            if($check && !$brand_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $brand_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("brand/lists");

         }else{
            $data['heading']='Add New Brand';
            $data['list']=$this->brand_model->lists();
            if($brand_id){
              $data['heading']='Edit Brand';
              $data['info']=$this->brand_model->get_info($brand_id);  
            }
            $data['display']='admin/brand';
            $this->load->view('admin/master',$data);
         }

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkBrand($brand_id){
        $chk=$this->db->query("SELECT * FROM product_info WHERE brand_id=$brand_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function delete($brand_id=FALSE){
      $check=$this->brand_model->delete($brand_id);
        if($check){ 
           $this->session->set_userdata('exception','Brand Info delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("brand/lists");

    }


 }