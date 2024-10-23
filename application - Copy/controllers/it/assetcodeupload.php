<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assetcodeupload extends My_Controller {

function __construct(){
    parent::__construct();
    $this->load->library('excel'); //load PHPExcel library 
    $this->load->model('it/assetcodeupload_model');
    date_default_timezone_set('Atlantic/Azores');
 }


function addExcel(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Upload Serial No';
    $data['slist']=$this->look_up_model->getSupplier();
    $data['display']='it/uploadexcel';
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
    $department_id=$this->session->userdata('department_id');
      if($totalrows>3){
      for ($i = 3; $i <= $totalrows; $i++) {
      	$product_name  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
        $category_name  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
        $product_code  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
        $asset_encoding  = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
      	////////////////Start/////////////
      	if($product_name==''&&$asset_encoding==''){
          $this->session->set_userdata('exception_err', "Please fill up all data currectly.");
          redirect("it/assetcodeupload/addExcel");
        }
      }
      for ($i = 3; $i <= $totalrows; $i++) {
        $product_name  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
        $category_name  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
        $product_code  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
        $asset_encoding  = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
        $purchase_date  = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));
        $invoice_no  = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
        $brand_name  = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
      		/////////////////product////////////
      	$productinfo=$this->assetcodeupload_model->checkproduct($product_name,$product_code,$category_name);
      	if($productinfo!=0){
      		$product_id=$productinfo;
      	}else{
      		  $pdata=array();
            $pdata['product_name']=$product_name;
            $pdata['china_name']=$objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
            $pdata['category_id']=$this->assetcodeupload_model->checkcat($category_name);
            $pdata['department_id']=$department_id;
            if($product_code=='') $product_code=$product_name;
            $pdata['product_code']=$product_code;
            $pdata['product_model']=$product_code;
            if($brand_name!='')
            $pdata['brand_id']=$this->assetcodeupload_model->checkBrand($brand_name);
            $pdata['product_description']=$objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
            $pdata['machine_other']=2;
            $product_id=$this->assetcodeupload_model->insertproduct($pdata);
      	 }
        ///////////////////Details/////////////
        $status=$objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
          $status=strtoupper($status);
      	$checkSN=$this->assetcodeupload_model->checkSN($asset_encoding,$product_id);

      	if($checkSN!=0){
      		$product_detail_id=$checkSN;
      	}else{
      		$pddata=array();
      		$pddata['product_id']=$product_id;
      		$pddata['asset_encoding']=$asset_encoding;
	        $pddata['invoice_no']=$invoice_no;
	        $pddata['machine_price']=$objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
	        $pddata['purchase_date']=$purchase_date;
          $pddata['other_description']=$objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
          $pddata['department_id']=$department_id;
          $pddata['machine_other']=2;
          $code_count=$this->db->query("SELECT max(code_count) as counts 
          FROM product_detail_info 
          WHERE department_id=$department_id 
          AND machine_other=2")->row('counts');
          $pddata['ventura_code']=$this->session->userdata('dept_shortcode').str_pad($code_count + 1, 6, '0', STR_PAD_LEFT);
          $pddata['code_count']=$code_count + 1;
          $pddata['supplier_id']=$this->input->post('supplier_id');
          if($status=="STOCK"){
            $pddata['it_status']=2;
          }
          if($status=="DAMAGE"||$status=="BROKEN"){
            $pddata['it_status']=4;
          }

          $product_detail_id=$this->assetcodeupload_model->insertSN($pddata);
    	    }
          ///////////// Assign Section/////////////
    	    $adata=array();
      	    
      if($status=='USE'){
      	  $location_name=$objWorksheet->getCellByColumnAndRow(14, $i)->getValue();
      	  $department_name=$objWorksheet->getCellByColumnAndRow(12, $i)->getValue();
      	  $employee_id=$objWorksheet->getCellByColumnAndRow(13, $i)->getValue();
      	  $adata=array();
      		$adata['product_detail_id']=$product_detail_id;

      		if($location_name!=''){
      		$adata['location_id']=$this->assetcodeupload_model->checklocation($location_name);
      	    }
      	  $adata['department_id']=$department_id;
      		$adata['issue_date']=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(15, $i)->getValue()));
            if($employee_id!=''){
            $adata['employee_id']=str_pad($employee_id, 5, '0', STR_PAD_LEFT);
            
            $adata['issue_type']=2;
            }elseif($department_name!=''){
            $adata['issue_type']=1;
            }else{
            $adata['issue_type']=3;
            }
            if($department_name!=''){
            $adata['take_department_id']=$this->assetcodeupload_model->checkDPT($department_name);
            }
      	$adata['user_id']=$this->session->userdata('user_id');
		    $this->assetcodeupload_model->insertIssue($adata);
		    $arraydata=array();
      	$arraydata['it_status']=1;
		    $arraydata['assign_date']=$adata['issue_date'];
		    $this->db->WHERE('product_detail_id',$product_detail_id);
		    $this->db->update('product_detail_info',$arraydata);
	   }
}
unlink('./asset/excel/' . $file_name); 
$this->session->set_userdata('exception', 'Upload successfully!');
redirect("it/assetcodeupload/addExcel");
}else{
$this->session->set_userdata('exception_err', "No data found.");
}
}else{
 $this->session->set_userdata('exception_err', 'File is required');
}
}

}


}