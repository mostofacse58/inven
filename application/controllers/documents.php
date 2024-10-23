<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documents extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('documents_model');
     }
    
    function lists(){
        $data['list']=$this->documents_model->lists();
        ////////////////////////////
        $data['heading']='Documents List ';
        $data['display']='documentslist';
        $this->load->view('admin/master',$data);
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Documents';
        $data['display']='addDocument';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    function edit($document_id){
        $data['heading']='Edit Documents';
        $data['info']=$this->documents_model->get_info($document_id);
        $data['display']='addDocument';
        $this->load->view('admin/master',$data);
    }
   
    function save($document_id=FALSE){
    	$imgchk=1;
        if($document_id==FALSE){
            $data=array();
            if($_FILES['file_name']['name']!=""){
                $config1['upload_path'] = './documents/';
                $config1['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG|pdf|xlsx|xls|doc|docx';
                $config1['max_size'] = '150000';
                $config1['encrypt_name'] = TRUE;
                $config1['detect_mime'] = TRUE;
                $this->load->library('upload', $config1);
                if ($this->upload->do_upload("file_name")){
                $upload_info1 = $this->upload->data();
                $data['file_name']=$upload_info1['file_name'];
            }else{
              $imgchk=2;
              $error=$this->upload->display_errors();
              $data['exception_err']=$error;
            }
          }else{
              $imgchk=2;
              $data['exception_err']='File is required';
          }
        }else{
            if($_FILES['file_name']['name']!=""){
                $config1['upload_path'] = './documents/';
                $config1['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG|pdf|xlsx|xls|doc|docx';
                $config1['max_size'] = '150000';
                $config1['encrypt_name'] = TRUE;
                $config1['detect_mime'] = TRUE;
                $this->load->library('upload', $config1);
                if ($this->upload->do_upload("file_name")){
                $upload_info1 = $this->upload->data();
                $data['file_name']=$upload_info1['file_name'];
            }else{
              $imgchk=2;
              $error=$this->upload->display_errors();
              $data['exception_err']=$error;
            }
        }
        }
        $this->form_validation->set_rules('title_name','Title','trim|required');
        $this->form_validation->set_rules('description','Description','trim|');
         if ($this->form_validation->run() == TRUE&&$imgchk==1) {
            $check=$this->documents_model->save($data,$document_id);
        if($check && !$document_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&& $document_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
          redirect("documents/lists");
         }else{
            $data['heading']='Add Documents';
            if($document_id){
              $data['heading']='Edit Documents';
              $data['info']=$this->documents_model->get_info($document_id);  
            }
            $data['display']='addDocument';
            $this->load->view('admin/master',$data);
         }

    }

    function delete($document_id=FALSE){
      $check=$this->documents_model->delete($document_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("documents/lists");
    }
    public function fliedownload($file = "") {
        // load ci download helder
        $this->load->helper('download');
        $data = file_get_contents("documents/".$file); // Read the file's 
        $name = $file;
        force_download($name, $data);
    }
    
   
 }