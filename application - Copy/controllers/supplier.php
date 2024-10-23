<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('supplier_model');
     }
    
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Supplier Informatoion';
        $data['list']=$this->supplier_model->lists();
        $data['display']='supplier/supplierinfo';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Supplier Informatoion';
        $data['display']='supplier/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($supplier_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Supplier Informatoion';
        $data['info']=$this->supplier_model->get_info($supplier_id);
        $data['display']='supplier/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function save($supplier_id=FALSE){
        $this->form_validation->set_rules('supplier_name','Supplier Name','trim|required');
        $this->form_validation->set_rules('phone_no','Phone No','trim|required');
        $this->form_validation->set_rules('mobile_no','Mobile No','trim');
        $this->form_validation->set_rules('email_address','Email Address','trim');
        $this->form_validation->set_rules('company_address','Address','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->supplier_model->save($supplier_id);
            if($check && !$supplier_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $supplier_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("supplier/lists");
         }else{
            $data['heading']='Add New Supplier Informatoion';
            if($supplier_id){
              $data['heading']='Edit Supplier Informatoion';
              $data['info']=$this->supplier_model->get_info($supplier_id);  
            }
            $data['display']='supplier/add';
            $this->load->view('admin/master',$data);
         }
    }
    function delete($supplier_id=FALSE){
      $check=$this->supplier_model->delete($supplier_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("supplier/lists");
    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkSupplier($supplier_id){
        $chk=$this->db->query("SELECT * FROM product_detail_info 
          WHERE supplier_id=$supplier_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
  function Download($file = "") {
    // load ci download helder
    $this->load->helper('download');
    $data = file_get_contents("asset/photo/".$file); // Read the file's 
    $name = $file;
    force_download($name, $data);
  }

 }