<?php if ( ! defined('BASEPATH')) exme('No direct script access allowed');
class Bulkupload extends My_Controller {
function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    $this->load->model('common/bulkupload_model');
    date_default_timezone_set('Atlantic/Azores');
 }
function addExcel(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Upload Serial No';
    $data['dlist']=$this->look_up_model->departmentList();
    $data['slist']=$this->look_up_model->getSupplier();
    $data['display']='common/bulkupload';
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
    if($totalrows>3){
    for ($i = 3; $i <= $totalrows; $i++) {
      $product_name  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
      $category_name  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
      $product_code  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
      $unit_price  = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
      ////////////////Start/////////////
      if($product_name==''&&$category_name==''){
        $this->session->set_userdata('exception_err', "Please fill up all data currectly.");
        redirect("common/bulkupload/addExcel");
      }
    }

    for($i = 3; $i <= $totalrows; $i++) {
      $product_name  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
      $category_name  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
      $product_code  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
      $unit_price  = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
      $unit_name  = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
      $stock  = $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
      $minstock  = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
      $box_name  = $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
        /////////////////product////////////
      $productinfo=$this->bulkupload_model->checkproduct($product_name,$category_name);
      if($productinfo!=0){
        $product_id=$productinfo;
      }else{
        $pdata=array();
          $pdata['product_name']=$product_name;
          $pdata['china_name']=$objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
          $pdata['category_id']=$this->bulkupload_model->checkcat($category_name);
          $pdata['department_id']=$department_id;
          $pdata['unit_id']=$this->bulkupload_model->checkUnit($unit_name);
          $pdata['box_id']=$this->bulkupload_model->checklocation($box_name);
	      if($product_code==''){
	        $product_code_count=$this->db->query("SELECT max(product_code_count) as counts FROM product_info 
	          WHERE department_id=$department_id and product_type=2")->row('counts');
	        $random=strtoupper(substr(md5('ABCDSTSHJUHUHUHUIHUIHIU5454L'.mt_rand(0,1005)),0,4));

	        $pdata['product_code']='BD'.$random.str_pad($product_code_count + 1, 10, '0', STR_PAD_LEFT);
	        $pdata['product_code_count']=$product_code_count + 1;
          }else{
          	$pdata['product_code']=$product_code;
          }
          $pdata['product_model']=$pdata['product_code'];
          $pdata['stock_quantity']=$stock;
          $pdata['main_stock']=$stock;
          $pdata['minimum_stock']=$minstock;
          $pdata['product_type']=2;
          $pdata['product_description']=$objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
          $pdata['machine_other']=2;
          $product_id=$this->bulkupload_model->insertproduct($pdata);
          }
      }
unlink('./asset/excel/' . $file_name); 
$this->session->set_userdata('exception', 'Upload successfully!');
redirect("common/bulkupload/addExcel");
}else{
$this->session->set_userdata('exception_err', "No data found.");
}
}else{
 $this->session->set_userdata('exception_err', 'File is required');
}
}

}


}