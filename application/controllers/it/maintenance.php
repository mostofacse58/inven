<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends My_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('it/maintenance_model');
     }
      
    function lists(){
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'it/maintenance/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->maintenance_model->get_count();
        $total_rows=$config['total_rows'];
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
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->maintenance_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('line_id','Location','trim');
        $this->form_validation->set_rules('asset_encoding','TPM','trim');
        ////////////////////////////
        $data['heading']='Maintenance Lists';
        $data['display']='it/maintenancelist';
        $data['llist']=$this->look_up_model->getlocation();
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Add';
        $data['clist']=$this->maintenance_model->getCategory();
        $data['llist']=$this->look_up_model->getlocation();
        $data['display']='it/addmaintenance';
        $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
    }
   
    function edit($maintenance_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit';
        $data['info']=$this->maintenance_model->get_info($maintenance_id);
        $data['clist']=$this->maintenance_model->getCategory();
        $data['llist']=$this->look_up_model->getlocation();
        $data['display']='it/addmaintenance';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
   function save($maintenance_id=FALSE){
      $check=$this->maintenance_model->save($maintenance_id);
      if($check && !$maintenance_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $maintenance_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("it/maintenance/lists");
    }

    function delete($maintenance_id=FALSE){
      $check=$this->maintenance_model->delete($maintenance_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("it/maintenance/lists");
    }

 }