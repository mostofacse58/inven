<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returnablein extends MY_Controller {
	function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/returnablein_model');
        $this->load->model('gatep/gatepass_model');
     }

     /////////////////

     function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/returnablein/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->returnablein_model->get_count();
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
        //echo $data["page"]; exit();///////////
        $data['list']=$this->returnablein_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/checklists2';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

    
      function searchIn(){
        $data['heading']='Ckecking Gate Pass';
        $data['info']=$this->returnablein_model->checkingInproduct();
        if(count($data['info'])>0){
            $data['chk']=4;
            $gatepass_id=$data['info']->gatepass_id;
            $data['detail']=$this->returnablein_model->get_detailIn($gatepass_id);
        }
        $data['display']='gatep/checkingin';
        $this->load->view('admin/master',$data);
      
        }
    function saveIn($gatepass_id){
       $chk=$this->returnablein_model->saveIn($gatepass_id);
       $this->session->set_userdata('exception','Gate In successfully');
       redirect("gatep/returnablein/lists"); 
    }
    function inForm($gatepass_id){
        $data['chk']=4;
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->returnablein_model->get_detailIn($gatepass_id);
        $data['heading']='Ckecking Gate Pass for IN';
        $data['display']='gatep/checkingin';
        $this->load->view('admin/master',$data);
    }
    function saveComments($gatepass_id){
       $chk=$this->returnablein_model->saveComments($gatepass_id);
       $this->session->set_userdata('exception','Comment save successfully');
       redirect("gatep/returnablein/lists"); 
    }
    function commentForm($gatepass_id){
        $data['chk']=4;
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->returnablein_model->get_detailIn($gatepass_id);
        $data['heading']='Ckecking Gate Pass for IN';
        $data['display']='gatep/returnableincomments';
        $this->load->view('admin/master',$data);
    }
    function view($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->returnablein_model->get_detail($gatepass_id);
        $data['display']='gatep/returnview';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    
 }