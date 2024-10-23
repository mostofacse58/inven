<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gatepass extends My_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('it/gatepass_model');
     }
      
    function lists(){
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'it/gatepass/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->gatepass_model->get_count();
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
        $data['list']=$this->gatepass_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('line_id','Location','trim');
        $this->form_validation->set_rules('asset_encoding','TPM','trim');
        ////////////////////////////
        $data['heading']='Servicing Lists';
        $data['display']='it/gatepasslist';
        $data['llist']=$this->look_up_model->getlocation();
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Add';
        $data['mlist']=$this->look_up_model->getMainProductSerial1();
        $data['llist']=$this->look_up_model->getlocation();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='it/addServicing';
        $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
    }
   
    function edit($gatepass_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit';
        $data['llist']=$this->look_up_model->getlocation();
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['mlist']=$this->look_up_model->getMainProductSerial1();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='it/addServicing';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
   function save($gatepass_id=FALSE){
      $check=$this->gatepass_model->save($gatepass_id);
      if($check && !$gatepass_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $gatepass_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("it/gatepass/lists");
    }

    function delete($gatepass_id=FALSE){
      $check=$this->gatepass_model->delete($gatepass_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("it/gatepass/lists");
    }
    function gatein($gatepass_id){
      $data['gatepass_status']=2;
      $this->db->where('gatepass_id', $gatepass_id);
      $this->db->update('gatepass_costing',$data);
      $this->session->set_userdata('exception','In successfully');
      redirect("it/gatepass/lists");
    }
   
 }