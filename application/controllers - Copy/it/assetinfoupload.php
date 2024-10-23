<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assetinfoupload extends My_Controller {

function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    date_default_timezone_set('Atlantic/Azores');
 }


function addExcel(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Upload Serial No';
    $data['display']='it/auploadexcel';
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
      if($totalrows>2){
      for ($i = 2; $i <= $totalrows; $i++) {
      	$code  = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
 		$pdata=array();
 		$ventura_code  = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
 		if($ventura_code!=''&&$ventura_code!=''&&$ventura_code!=''){
        $pdata['invoice_no']=$objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
        $pdata['purchase_date']=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
	    $this->db->WHERE('ventura_code',$ventura_code);
	    $this->db->update('product_detail_info',$pdata);
	   } }
}
$this->session->set_userdata('exception', 'Upload successfully!');
redirect("it/assetinfoupload/addExcel");
}else{
$this->session->set_userdata('exception_err', "No data found.");
}
}else{
 $this->session->set_userdata('exception_err', 'File is required');
}
}



}