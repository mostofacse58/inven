<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class License extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('license_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      //////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'license/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->license_model->get_count();
        $config['per_page'] = $perpage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = 2;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">Next »</span>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = "</a></li>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['list']=$this->license_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////
        $data['heading']='License List ';
        $data['display']='licenselist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add License';
        $data['display']='addLicense';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    function edit($document_id){
        $data['heading']='Edit License';
        $data['info']=$this->license_model->get_info($document_id);
        $data['display']='addLicense';
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
            $check=$this->license_model->save($data,$document_id);
        if($check && !$document_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&& $document_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
          redirect("license/lists");
         }else{
            $data['heading']='Add License';
            if($document_id){
              $data['heading']='Edit License';
              $data['info']=$this->license_model->get_info($document_id);  
            }
            $data['display']='addLicense';
            $this->load->view('admin/master',$data);
         }

    }

    function delete($document_id=FALSE){
      $check=$this->license_model->delete($document_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("license/lists");
    }
    public function fliedownload($file = "") {
        // load ci download helder
        $this->load->helper('download');
        $data = file_get_contents("documents/".$file); // Read the file's 
        $name = $file;
        force_download($name, $data);
    }
    
   
 }