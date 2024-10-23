<?php if ( ! defined('BASEPATH')) exme('No direct script access allowed');
class Codeuploaded extends My_Controller {
function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    date_default_timezone_set('Atlantic/Azores');
 }
  function addExcel(){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Update Data';
      $data['dlist']=$this->look_up_model->departmentList();
      $data['display']='common/codeuploaded';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }

function save(){
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
     for ($i = 2; $i <= $totalrows; $i++) {
      $product_code  = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
      $columnOne  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
      $columnTwo  = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
      $columnThree  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
      $columnFour  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
     // echo "$columnFour";
      ////////////////Start/////////////
     if($product_code!=''){
        $pdata=array();
        $pdata['safety_stock_qty']=$columnOne;
        $pdata['reorder_level']=$columnTwo;
        $pdata['minimum_stock']=$columnThree;
        $pdata['usage_category']=$columnFour;
        print_r($pdata);
        exit();
        $this->db->WHERE('product_code',$product_code);
        $this->db->WHERE('department_id',$department_id);
        $this->db->UPDATE('product_info',$pdata);
        }
        //exit();
      }
    unlink('./asset/excel/' . $file_name); 
    $this->session->set_userdata('exception', 'Upload successfully!');
    redirect("common/codeuploaded/addExcel");
  }else{
  $this->session->set_userdata('exception_err', "No data found.");
  }
  }
  }else{
   $this->session->set_userdata('exception_err', 'File is required');
  }
 }




}