<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assetissue extends My_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('it/assetissue_model');
     }
      
    function lists(){
      
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'it/assetissue/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->assetissue_model->get_count();
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
        $data['list']=$this->assetissue_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('line_id','Location','trim');
        $this->form_validation->set_rules('asset_encoding','TPM','trim');
        ////////////////////////////
        $data['heading']='Fixed Asset Issue Lists';
        $data['display']='it/assetissuelist';
        $data['llist']=$this->look_up_model->getlocation();
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Asset Issue';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['mlist']=$this->assetissue_model->getStockAsset();
        $data['llist']=$this->look_up_model->getlocation();
        $data['display']='it/addFAissue';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function add2(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Asset Issue';
        //$data['mlist']=$this->assetissue_model->getStockAsset();
        $data['llist']=$this->look_up_model->getlocation();
        $data['display']='it/addmulti_status';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($asset_issue_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Asset Issue';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['info']=$this->assetissue_model->get_info($asset_issue_id);
        $data['mlist']=$this->assetissue_model->getStockAsset($asset_issue_id);
        $data['llist']=$this->look_up_model->getlocation();
        $data['display']='it/addFAissue';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }

    }
   
    function save($asset_issue_id=FALSE){
      $this->session->set_userdata('input_location',$this->input->post('location_id'));
      $check=$this->assetissue_model->save($asset_issue_id);
      if($check && !$asset_issue_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $asset_issue_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("it/assetissue/lists");
    }
    
   function save2(){
        $check=$this->assetissue_model->save2();
        $this->session->set_userdata('exception','Saved successfully');
        redirect("it/assetissue/lists");
    }
    function delete($asset_issue_id=FALSE){
      $check=$this->assetissue_model->delete($asset_issue_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("it/assetissue/lists");
    }
  function takeoverForm($asset_issue_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Machine Take Over Form';
    $data['info']=$this->assetissue_model->get_info($asset_issue_id);
    $data['display']='it/takeoverForm';
    $this->load->view('admin/master',$data);
    } else {
      redirect("logincontroller");
    }
  }

  function underService(){
    if ($this->session->userdata('user_id')) {
    $check=$this->assetissue_model->underService();
    $this->session->set_userdata('exception','This asset go to Under Service');
    redirect("it/assetissue/lists");
    } else {
      redirect("logincontroller");
    }
  }
    function returndate(){
        if ($this->session->userdata('user_id')) {
        $check=$this->assetissue_model->returndate();
        $this->session->set_userdata('exception','Return successfully');
        redirect("it/assetissue/lists");
        } else {
          redirect("logincontroller");
        }
    }

   //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($asset_issue_id){
        echo "DELETABLE";
    }

    public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->assetissue_model->getStockAssetList($term);
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