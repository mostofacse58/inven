<?php if ( ! defined('BASEPATH')) exme('No direct script access allowed');
class Maintenance extends My_Controller {
function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    $this->load->model('pm/maintenance_model');
 }
 function lists(){
      $data=array();
          $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=30;
        $this->load->library('pagination');
        $config['base_url']=base_url().'pm/maintenance/lists/';
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
        $total_rows=$config['total_rows'];
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->maintenance_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('model_no','No','trim');
        $this->form_validation->set_rules('tpm_code','Name','trim');
        ////////////////////////////
        $data['heading']='Maintenance Lists';
        $data['display']='pm/lists';
        $this->load->view('admin/master',$data);
       }
    function add(){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Add Schedule';
      $data['display']='pm/add';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }
   function edit($pm_id){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Edit Schedule';
      $data['info']=$this->maintenance_model->get_info($pm_id);
      $data['display']='pm/add';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }
  function delete($pm_id=FALSE){
      $check=$this->maintenance_model->delete($pm_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("pm/maintenance/lists");
    }
  function addFile(){
      $data['heading']='Update Data';
      $data['display']='pm/uploadSchedule';
      $this->load->view('admin/master',$data);
  }
  public function sample() {
        $file='pm.xlsx';
        // load ci download helder
        $this->load->helper('download');
        $data = file_get_contents("asset/sample/".$file); // Read the file's 
        $name = $file;
        force_download($name, $data);
    }

    function save($pm_id=FALSE){
        $check=$this->maintenance_model->save($pm_id);
        if($check &&!$pm_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&&$pm_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
      redirect("pm/maintenance/lists");
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
     for ($i = 2; $i <= $totalrows; $i++) {
      $data['pm_date']  =date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
      $code  = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
      $info=$this->db->query("SELECT p.product_model,p.product_name
        FROM  product_detail_info pd , product_info p 
        WHERE p.product_id=pd.product_id 
        AND (pd.tpm_serial_code='$code' OR pd.asset_encoding='$code' OR pd.ventura_code='$code') ")->row();
      $data['tpm_code']=$code;
      $data['model_no']=$info->product_model;
      $data['product_name']=$info->product_name;
      $data['pm_status']='Pending';
      $query=$this->db->insert('pm_master',$data);
    }
    //unlink('./asset/excel/' . $file_name); 
    $this->session->set_userdata('exception', 'Upload successfully!');
    redirect("pm/maintenance/lists");
  }else{
  $this->session->set_userdata('exception_err', "No data found.");
  redirect("pm/maintenance/addFile");
  }
  }
  }else{
   $this->session->set_userdata('exception_err', 'File is required');
   redirect("pm/maintenance/addFile");
  }
 }

 ////////////////////////////////////
 function planm($pm_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Plan Maintenance';
    $data['info']=$this->maintenance_model->get_info($pm_id);
    $data['details']=$this->maintenance_model->getchecklist($data['info']->tpm_code);
    $data['display']='pm/addpm';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
}
function updatepm($pm_id=FALSE){
    $check=$this->maintenance_model->updatepm($pm_id);
    if($check &&!$pm_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&&$pm_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
  redirect("pm/maintenance/lists");

}
 function view($pm_id){
    if ($this->session->userdata('user_id')) {
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Plan Maintenance Details';
    $data['info']=$this->maintenance_model->get_info($pm_id);
    $data['details']=$this->maintenance_model->getworkdetail($pm_id);
    $data['sdetail']=$this->maintenance_model->getsdetail($data['info']->sref_no);
   // print_r($data['details']);
    $data['display']='pm/view';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
}




}