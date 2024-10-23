<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Camerastatus extends My_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('cctv/camerastatus_model');
     }
      
    function lists(){
      
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=50;
        $this->load->library('pagination');
        $config['base_url']=base_url().'cctv/camerastatus/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->camerastatus_model->get_count();
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
        $data['list']=$this->camerastatus_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('asset_encoding','CODE','trim');
        ////////////////////////////////////////
        $data['heading']='CCTV Status';
        $data['display']='cctv/camerastatuslist';
        $data['llist']=$this->look_up_model->getlocation();
        $this->load->view('admin/master',$data);
        }else{
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Status';
        $data['llist']=$this->look_up_model->getlocation();
        $data['mlist']=$this->camerastatus_model->getCCTVList();
        $data['display']='cctv/addStatus';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($cctv_main_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Asset Issue';
        $data['llist']=$this->look_up_model->getlocation();
        $data['info']=$this->camerastatus_model->get_info($cctv_main_id);
        $data['mlist']=$this->camerastatus_model->getCCTVList($cctv_main_id);
        $data['display']='cctv/addStatus';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }

    }
   
    function save($cctv_main_id=FALSE){
      $check=$this->camerastatus_model->save($cctv_main_id);
      if($check && !$cctv_main_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $cctv_main_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("cctv/camerastatus/lists");
    }
    

    function delete($cctv_main_id=FALSE){
      $check=$this->camerastatus_model->delete($cctv_main_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("cctv/camerastatus/lists");
    }

    
    function takeoverForm($cctv_main_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Machine Take Over Form';
        $data['info']=$this->camerastatus_model->get_info($cctv_main_id);
        $data['display']='cctv/takeoverForm';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
    
    function getCameraLine(){
          $location_id=$this->input->post('location_id');
           $result=$this->db->query("SELECT pd.product_detail_id,aim.issue_purpose,
            pd.asset_encoding 
            FROM asset_issue_master aim
            INNER JOIN product_detail_info pd ON(aim.product_detail_id=pd.product_detail_id)
            INNER JOIN product_info p ON(p.product_id=pd.product_id)
            WHERE aim.department_id=1 AND p.category_id=83
            AND aim.location_id=$location_id AND pd.it_status=1
            GROUP BY pd.product_detail_id")->result();
          ;
      echo '<option value="">Select CCTV NO</option>';
      foreach ($result as $value) {
      echo '<option value="'.$value->product_detail_id.'" >'.$value->asset_encoding.'('.$value->issue_purpose.')'.'</option>';
      }
    exit;
   }

   //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($cctv_main_id){
        $chk=$this->db->query("SELECT * FROM machine_downtime_info 
          WHERE cctv_main_id=$cctv_main_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }

   
 }