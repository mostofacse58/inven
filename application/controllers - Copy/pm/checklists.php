<?php if ( ! defined('BASEPATH')) exme('No direct script access allowed');
class Checklists extends My_Controller {
function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    $this->load->model('pm/checklists_model');
 }
 function lists(){
      $data=array();
          $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=30;
        $this->load->library('pagination');
        $config['base_url']=base_url().'pm/checklists/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->checklists_model->get_count();
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
        $total_rows=$config['total_rows'];
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->checklists_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('model_no','No','trim');
        $this->form_validation->set_rules('check_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        ////////////////////////////
        $data['heading']='PLANNED / PREVENTIVE MAINTENANCE CHECK LIST';
        $data['display']='pm/checklistslist';
        $this->load->view('admin/master',$data);
       }
    function add(){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Add SOP';
      $data['clist']=$this->look_up_model->getCategory($this->session->userdata('department_id'));
      $data['display']='pm/addsop';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }
   function edit($id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Edit SOP';
        $data['info']=$this->checklists_model->get_info($id);
        $data['clist']=$this->look_up_model->getCategory($this->session->userdata('department_id'));
        $data['display']='pm/addsop';
        $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
    }
  function addFile(){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Update Data';
      $data['display']='pm/uploadSOP';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }
  public function sample() {
    $file='checkLists.xlsx';
        // load ci download helder
        $this->load->helper('download');
        $data = file_get_contents("asset/sample/".$file); // Read the file's 
        $name = $file;
        force_download($name, $data);
    }

    function save($id='') {
        $data=array();
        $data['model_no']=$this->input->post('model_no');
        $data['category_id']=$this->input->post('category_id');
        $data['department_id']  = $this->session->userdata('department_id');
        $check_name=$this->input->post('check_name');
        $i=0;
        foreach ($check_name as $value) {
          $data['check_name']=$value;
          if($id==''){
            $query=$this->db->insert('maintenance_checklist',$data);
          }else{
            $this->db->WHERE('id',$id);
            $query=$this->db->update('maintenance_checklist',$data);
          }
        $i++;
        }
        $this->session->set_userdata('exception','Saved successfully');
      redirect("pm/checklists/lists");
    }
function uplaoddata(){
   if ($_FILES['data_file']['name'] != "") {
    $configUpload['upload_path'] = FCPATH . 'asset/excel/';
    $configUpload['allowed_types'] = 'xls|xlsx|csv';
    $configUpload['max_size'] = '50000';
    $this->load->library('upload', $configUpload);
    if($this->upload->do_upload('data_file')) {
    $upload_data = $this->upload->data(); 
    $file_name = $upload_data['file_name'];
    $extension = $upload_data['file_ext']; 
    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); 
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();       
    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    $department_id=$this->input->post('department_id');
    if($totalrows>2){
      $data['department_id']  = $this->session->userdata('department_id');
      $data['user_id']  = $this->session->userdata('user_id');
      $data['model_no']  = $objWorksheet->getCellByColumnAndRow(1, 1)->getValue();
     for ($i = 2; $i <= $totalrows; $i++) {
      $data['check_name']  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
      $query=$this->db->insert('maintenance_checklist',$data);
    }
    //unlink('./asset/excel/' . $file_name); 
    $this->session->set_userdata('exception', 'Upload successfully!');
    redirect("pm/checklists/lists");
  }else{
  $this->session->set_userdata('exception_err', "No data found.");
  redirect("pm/checklists/addFile");
  }
  }
  }else{
   $this->session->set_userdata('exception_err', 'File is required');
   redirect("pm/checklists/addFile");
  }
 }




}