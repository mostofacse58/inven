<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finishedgoods extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('finishedgoods/finishedgoods_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'finishedgoods/finishedgoods/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->finishedgoods_model->get_count();
        $config['per_page'] = $perpage;
        $total_rows=$config['total_rows'];
        $choice = ceil($config["total_rows"] / $config["per_page"]);
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
        ////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->finishedgoods_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Finished Goods Info';
        //$data['list']=$this->finishedgoods_model->lists();
        $data['display']='finishedgoods/lists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Finished Goods Info';
        $data['display']='finishedgoods/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($goods_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Machine Info';
        $data['info']=$this->finishedgoods_model->get_info($goods_id);
        $data['display']='finishedgoods/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function save($goods_id=FALSE){
        $this->form_validation->set_rules('file_no','File No','trim|required');
        $this->form_validation->set_rules('style_no','Style No','trim');
        $this->form_validation->set_rules('color_name','Color','trim|required');
        $this->form_validation->set_rules('quantity','Quantity','trim|required');
        $this->form_validation->set_rules('floor_no','Workshop','trim|required');
        $this->form_validation->set_rules('line_no','Line No','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->finishedgoods_model->save($goods_id);
            if($check && !$goods_id){
                $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $goods_id){
                $this->session->set_userdata('exception','Update successfully');
               }else{
                $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("finishedgoods/finishedgoods/lists");
         }else{
            $data['heading']='Add New Finished Goods Info';
            if($goods_id){
              $data['heading']='Edit Finished Goods Info';
              $data['info']=$this->finishedgoods_model->get_info($goods_id);  
            }
            $data['machinelist']=$this->look_up_model->getMainProductMachine(12);
            $data['slist']=$this->look_up_model->getSupplier();
            $data['display']='finishedgoods/add';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($goods_id=FALSE){
      $check=$this->finishedgoods_model->delete($goods_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("finishedgoods/finishedgoods/lists");
    }

   function printsticker(){
      $data['lists']=$this->finishedgoods_model->printsticker();
      $this->load->view('finishedgoods/printsticker',$data);
    }

 
   
 }