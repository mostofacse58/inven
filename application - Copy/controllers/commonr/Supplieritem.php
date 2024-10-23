<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplieritem extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/Supplieritem_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Supplier Item Report';
		$data['clist']=$this->look_up_model->getCategory(12);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['palist']=$this->look_up_model->getSupplier();
	    $data['display']='commonr/Supplieritem';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Supplier Item Report ';
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['palist']=$this->look_up_model->getSupplier();
        $data['dlist']=$this->look_up_model->departmentList();
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('supplier_id','Supplier','trim|required');
        $this->form_validation->set_rules('department_id','Dept. Name','trim|required');
        $this->form_validation->set_rules('product_code','ITEM CODE','trim');
        $this->form_validation->set_rules('from_date','Date','trim');
        $this->form_validation->set_rules('to_date','date','trim');
        if ($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $product_code=$this->input->post('product_code');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['department_id']=$this->input->post('department_id');
        $data['reference_no']=$this->input->post('reference_no');
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['resultdetail']=$this->Supplieritem_model->reportrResult($data['department_id'],$category_id,$data['supplier_id'],$product_code,$data['reference_no'],$data['from_date'],$data['to_date']);
        $data['display']='commonr/Supplieritem';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/Supplieritem';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($department_id,$category_id,$supplier_id,$product_code=FALSE,$reference_no=FALSE,$from_date=FALSE,$to_date=FALSE){
        $data['heading']='Items Receive Report ';
        $data['resultdetail']=$this->Supplieritem_model->reportrResult($department_id,$category_id,$supplier_id,$product_code,$reference_no,$from_date,$to_date);
         $this->load->view('commonr/SupplieritemExcel',$data);
    }

  

   function downloadPdf($category_id,$department_id,$supplier_id,$product_code,$from_date,$to_date) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Items Receive Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->Supplieritem_model->reportrResult($category_id,$department_id,$supplier_id,$product_code,$from_date,$to_date);
    $pdfFilePath='sparesReceivePdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/SupplieritemPdf', $data, true);
    $mpdf->setHtmlHeader($header);
    $mpdf->pagenumPrefix = '  Page ';
    $mpdf->pagenumSuffix = ' - ';
    $mpdf->nbpgPrefix = ' out of ';
    $mpdf->nbpgSuffix = '';
    $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    } else {
       redirect("logincontroller");
    }
    }
    
}