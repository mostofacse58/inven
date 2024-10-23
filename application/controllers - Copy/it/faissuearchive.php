<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faissuearchive extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('it/faissuearchive_model');
     }
      
    function lists(){
      
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
      else $perpage=40;
        $this->load->library('pagination');
        $config['base_url']=base_url().'it/faissuearchive/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->faissuearchive_model->get_count();
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
        $data['list']=$this->faissuearchive_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('line_id','Location','trim');
        $this->form_validation->set_rules('asset_encoding','TPM','trim');
        ////////////////////////////
        $data['heading']='FA Issue Archive Lists';
        $data['display']='it/faissuearchivelist';
        $data['llist']=$this->look_up_model->getlocation();
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
   

   //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($asset_issue_id){
        $chk=$this->db->query("SELECT * FROM machine_downtime_info 
          WHERE asset_issue_id=$asset_issue_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }

    public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->faissuearchive_model->getStockAssetList($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
       
                $pr[] = array('id' => ($c + $r), 'product_detail_id' => $row->product_detail_id, 'label' => $row->product_name . " (" . $row->asset_encoding . ")", 'asset_encoding' => $row->asset_encoding ,'product_name' => $row->product_name,'ventura_code' => $row->ventura_code);
                $r++;
            }
            header('Content-Type: application/json');
            die(json_encode($pr));
            exit;
        }else{
            $dsad='';
            header('Content-Type: application/json');
            die(json_encode($dsad));
            exit;
        }
    }
 }