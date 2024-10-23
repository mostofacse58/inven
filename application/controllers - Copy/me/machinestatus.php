<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machinestatus extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('me/machinestatus_model');
     }
      
    function lists(){
      
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'me/machinestatus/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->machinestatus_model->get_count();
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
        $data['list']=$this->machinestatus_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('line_id','Location','trim');
        $this->form_validation->set_rules('tpm_serial_code','TPM','trim');
        ////////////////////////////
        $data['heading']='Used Machine Status Info';
        $data['display']='me/machinestatuslist';
        $data['flist']=$this->machinestatus_model->getFloorLine();
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Machine Assign';
        $data['mlist']=$this->machinestatus_model->getUNUSEDMachine();
        $data['flist']=$this->machinestatus_model->getFloorLine();
        $data['display']='me/addmachinestatus';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function add2(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Machine Assign';
        //$data['mlist']=$this->machinestatus_model->getUNUSEDMachine();
        $data['flist']=$this->machinestatus_model->getFloorLine();
        $data['display']='me/addmulti_status';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($product_status_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Machine Assign';
        $data['info']=$this->machinestatus_model->get_info($product_status_id);
        $data['mlist']=$this->machinestatus_model->getUNUSEDMachine($product_status_id);
        $data['flist']=$this->machinestatus_model->getFloorLine();
        $data['display']='me/addmachinestatus';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }

    }
   
    function save($product_status_id=FALSE){
        $this->form_validation->set_rules('product_detail_id','Product Name','trim|required');
        $this->form_validation->set_rules('line_id','Location','trim|required');
        $this->form_validation->set_rules('assign_date','Assign Date','trim|required');
        $this->form_validation->set_rules('note','Note','trim');
        $this->form_validation->set_rules('machine_status','Status','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $check=$this->machinestatus_model->save($product_status_id);
            if($check && !$product_status_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $product_status_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
            redirect("me/machinestatus/lists");
        }else{
            $data['heading']='Add New Machine Assign';
            if($product_status_id){
              $data['heading']='Edit Machine Assign';
              $data['info']=$this->machinestatus_model->get_info($product_status_id);  
            }
            $data['mlist']=$this->machinestatus_model->getUNUSEDMachine($product_status_id);
            $data['flist']=$this->machinestatus_model->getFloorLine();
            $data['display']='me/addmachinestatus';
            $this->load->view('admin/master',$data);
        }

    }
     function save2(){
          $check=$this->machinestatus_model->save2();
          $this->session->set_userdata('exception','Saved successfully');
          redirect("me/machinestatus/lists");
      }
    function delete($product_status_id=FALSE){
      $check=$this->machinestatus_model->delete($product_status_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/machinestatus/lists");
    }
    function takeoverForm($product_status_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Machine Take Over Form';
        $data['info']=$this->machinestatus_model->get_info($product_status_id);
        $data['display']='me/takeoverForm';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
    function mtakeover(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Multiple Take Over';
        $data['display']='me/mtakeoverForm';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
    
    function saveTakeover($product_status_id){
      $data['take_over_status']=2;
      $data['takeover_date']=alterDateFormat($this->input->post('takeover_date'));
      $data['takeover_man']=$this->session->userdata('user_id');
      $this->db->where('product_status_id', $product_status_id);
      $this->db->update('product_status_info',$data);
      /////////////////////
      $info=$this->db->query("SELECT * FROM  product_status_info 
          WHERE product_status_id=$product_status_id")->row();
      //////////////////////
      $product_detail_id=$info->product_detail_id;
      $data3['tpm_status']=2;
      $data3['line_id']=NULL;
      $data3['assign_date']=NULL;
      $data3['takeover_date']=alterDateFormat($this->input->post('takeover_date'));
      $this->db->WHERE('product_detail_id',$product_detail_id);
      $query=$this->db->update('product_detail_info',$data3);

      $this->session->set_userdata('exception','Take Over successfully');
      redirect("me/machinestatus/lists");
    }
    function savemultipletake(){
          $check=$this->machinestatus_model->savemultipletake();
          $this->session->set_userdata('exception','Takeover successfully');
          redirect("me/machinestatus/lists");
      }
    function idle($product_status_id){
        if ($this->session->userdata('user_id')) {
        $check=$this->machinestatus_model->idle($product_status_id);
        $this->session->set_userdata('exception','This machine idle successfully');
        redirect("me/machinestatus/lists");
        } else {
          redirect("logincontroller");
        }
    }
     function underservice(){
        if ($this->session->userdata('user_id')) {
        $check=$this->machinestatus_model->underservice();
        $this->session->set_userdata('exception','This machine on under service successfully');
        redirect("me/machinestatus/lists");
        } else {
          redirect("logincontroller");
        }
    }

   //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($product_status_id){
        $chk=$this->db->query("SELECT * FROM machine_downtime_info 
          WHERE product_status_id=$product_status_id")->result();
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
        $rows = $this->machinestatus_model->getUNUSEDMachineList($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
       
                $pr[] = array('id' => ($c + $r), 
                    'product_detail_id' => $row->product_detail_id,
                    'product_status_id' => $row->product_status_id, 
                    'label' => $row->product_name . " (" . $row->tpm_serial_code . ")", 
                    'tpm_serial_code' => $row->tpm_serial_code,
                    'from_location_name' => $row->to_location_name ,
                    'product_name' => $row->product_name,
                    'ventura_code' => $row->ventura_code
                    );
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
    public function suggestionstake(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
          die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->machinestatus_model->getAssignMachineList($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
       
                $pr[] = array('id' => ($c + $r), 'product_status_id' => $row->product_status_id, 'label' => $row->product_name . " (" . $row->tpm_serial_code . ")", 'tpm_serial_code' => $row->tpm_serial_code ,'product_name' => $row->product_name,'line_no' => $row->line_no,'ventura_code' => $row->ventura_code);
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