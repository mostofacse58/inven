<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transportation extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/transportation_model');
     }
    function SearchForm(){
        $data['heading']='Transportation  Report';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
	    $data['display']='commonr/transportation';
        $this->load->view('admin/master',$data);
     }

    function reportrResult(){
        $data['heading']='Transportation  Report ';
        $data['slist']=$this->look_up_model->getSupplier();
        $data['dlist']=$this->look_up_model->departmentList();
        $this->form_validation->set_rules('po_number','PO No','trim');
        $this->form_validation->set_rules('product_code','Code','trim');
        $this->form_validation->set_rules('from_date','Date','trim');
        $this->form_validation->set_rules('to_date','date','trim');
        $this->form_validation->set_rules('take_department_id','date','trim');
        $this->form_validation->set_rules('supplier_id','supplier','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['po_number']=$this->input->post('po_number');
        $data['product_code']=$this->input->post('product_code');
        $data['po_status']=$this->input->post('po_status');
        $data['take_department_id']=$this->input->post('take_department_id');
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['resultdetail']=$this->transportation_model->reportrResult($data['take_department_id'],$data['po_status'],$data['supplier_id'],$data['po_number'],$data['product_code'],$data['from_date'],$data['to_date']);
        $data['display']='commonr/transportation';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/transportation';
        $this->load->view('admin/master',$data);
        }
    }
    function downloadExcel($take_department_id=FALSE,$po_status,$supplier_id,$po_number=FALSE,$product_code=FALSE,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='Transportation  Report ';
        $data['resultdetail']=$this->transportation_model->reportrResult($po_status,$po_number,$product_code,$take_department_id,$supplier_id,$from_date,$to_date);
        $this->load->view('commonr/transportationExcel',$data);
    }
    
   function downloadPdf($category_id,$department_id,$supplier_id,$product_code,$from_date,$to_date) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Transportation  Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->itemreceivereport_model->reportrResult($category_id,$department_id,$product_code,$from_date,$to_date);
    $pdfFilePath='po_reports'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/itemreceivereportPdf', $data, true);
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