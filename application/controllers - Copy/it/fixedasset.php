<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixedasset extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('it/fixedasset_model');
     }
    
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Fixed Asset Info';
        $data['list']=$this->fixedasset_model->lists();
        $data['display']='it/fixedassetlist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Fixed Asset Info';
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['blist']=$this->look_up_model->getBrand();
        $data['mtlist']=$this->look_up_model->getMachineType();
        $data['display']='it/addfixedasset';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    function edit($product_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Fixed Asset Info';
        $data['info']=$this->fixedasset_model->get_info($product_id);
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['mtlist']=$this->look_up_model->getMachineType();
        $data['blist']=$this->look_up_model->getBrand();
        $data['display']='it/addfixedasset';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
   
    function save($product_id=FALSE){
        if($product_id==FALSE){
          $this->form_validation->set_rules('product_model','Product Model No','trim|required|is_unique[product_info.product_model]');
        }else{
          $this->form_validation->set_rules('product_model','Product Model No','trim|required');
        }
        $this->form_validation->set_rules('product_name','English Name','trim|required');
        $this->form_validation->set_rules('china_name','Chinese  Name','trim');
        $this->form_validation->set_rules('category_id','Category','trim|required');
        $this->form_validation->set_rules('brand_id','Brand Name','trim|required');
        $this->form_validation->set_rules('unit_id','Product Unit','trim|required');
        $this->form_validation->set_rules('product_description','Description','trim|');
        $this->form_validation->set_rules('minimum_stock','minimum Stock Qty','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->fixedasset_model->save($product_id);
            if($check && !$product_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $product_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("it/fixedasset/lists");
         }else{
            $data['heading']='Add New Fixed Asset Info';
            if($product_id){
              $data['heading']='Edit Fixed Asset Info';
              $data['info']=$this->fixedasset_model->get_info($product_id);  
            }
            $data['clist']=$this->look_up_model->getCategory(12);
            $data['mlist']=$this->look_up_model->getMaterialType();
            $data['blist']=$this->look_up_model->getBrand();
            $data['mtlist']=$this->look_up_model->getMachineType();
            $data['display']='it/addfixedasset';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($product_id=FALSE){
      $check=$this->fixedasset_model->delete($product_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("it/fixedasset/lists");
    }

    
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkMachineUse($product_id){
        $chk=$this->db->query("SELECT * FROM product_detail_info 
          WHERE product_id=$product_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function views($product_id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Fixed Asset Details Information';
        $data['info']=$this->fixedasset_model->get_info($product_id);
        $data['display']='it/viewfixedassetdetails';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
   
 }