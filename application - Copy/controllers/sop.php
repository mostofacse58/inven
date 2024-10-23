<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sop extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('sop_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      //////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'sop/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->sop_model->get_count();
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
        $data['list']=$this->sop_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////
        $data['heading']='sop List ';
        $data['display']='soplist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add sop';
        $data['display']='addsop';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    function edit($id){
        $data['heading']='Edit sop';
        $data['info']=$this->sop_model->get_info($id);
        $data['display']='addsop';
        $this->load->view('admin/master',$data);
    }
   
    function save($id=FALSE){
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('menu','Menu','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->sop_model->save($id);
        if($check && !$id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&& $id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
          redirect("sop/lists");
         }else{
            $data['heading']='Add sop';
            if($id){
              $data['heading']='Edit sop';
              $data['info']=$this->sop_model->get_info($id);  
            }
            $data['display']='addDocument';
            $this->load->view('admin/master',$data);
         }
    }

    function delete($id=FALSE){
      $check=$this->sop_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("sop/lists");
    }
    public function fliedownload($file = "") {
        // load ci download helder
        $this->load->helper('download');
        $data = file_get_contents("sop/".$file); // Read the file's 
        $name = $file;
        force_download($name, $data);
    }
    
   
 }