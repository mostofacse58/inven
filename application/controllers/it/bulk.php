<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bulk extends My_Controller {

function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    date_default_timezone_set('Atlantic/Azores');
 }


function index(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Upload Serial No';
    $data['display']='it/bulkup';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
}

function save(){
   if ($_FILES['data_file']['name'] != "") {
    print_r($_FILES['data_file']['name']);
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
    $department_id=$this->session->userdata('department_id');
      if($totalrows>3){
      for ($i = 3; $i <= $totalrows; $i++) {
      		$data=array();
          $data=array();
          $data['product_id']=$objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
          $data['asset_encoding']=$objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
          $data['invoice_no']=$objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
          $data['machine_price']=$objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
          $data['amount_hkd']=$data['machine_price']*0.088;
          $data['purchase_date']=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));
          $data['other_description']=$objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
          $data['supplier_id']=676;
          $data['user_id']=29;
          $data['department_id']=3;
          $data['detail_status']=1;
          $data['forpurchase_department_id']=3;
          $data['remarks']=$data['other_description'];
          $data['it_status']=2;
          $data['machine_other']=2;
          $code_count=$this->db->query("SELECT max(code_count) as counts 
            FROM product_detail_info 
            WHERE department_id=3 
            AND machine_other=2")->row('counts');
          $data['ventura_code']='ADMIN'.str_pad($code_count + 1, 6, '0', STR_PAD_LEFT);
          $data['code_count']=$code_count + 1;
          $query=$this->db->insert('product_detail_info',$data);
        ///////////////////Details/////////////
    }
$this->session->set_userdata('exception', 'Upload successfully!');
redirect("it/bulk");
}else{
$this->session->set_userdata('exception_err', "No data found.");
}
}else{
 $this->session->set_userdata('exception_err', 'File is required');
}
}

}


}