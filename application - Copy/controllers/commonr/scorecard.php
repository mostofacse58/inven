<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Scorecard extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/scorecard_model');
     }
    function SearchForm(){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Supplier Score card';
        $data['slist']=$this->look_up_model->getSupplier();
        $data['display']='commonr/scorecard';
        $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
    }
  function reportrResult(){
    if ($this->session->userdata('user_id')) {
      $data['heading']='Supplier Score card ';
      $data['slist']=$this->look_up_model->getSupplier();
      $this->form_validation->set_rules('supplier_id',' ','trim');
      $this->form_validation->set_rules('po_number',' ','trim');
      $this->form_validation->set_rules('pi_no','Box Name','trim');
      $this->form_validation->set_rules('from_date',' ','trim');
      $this->form_validation->set_rules('to_date',' ','trim');
      if ($this->form_validation->run() == TRUE) {
      $supplier_id=$this->input->post('supplier_id');
      $pi_no=$this->input->post('pi_no');
      $po_number=$this->input->post('po_number');
      $from_date=alterDateFormat($this->input->post('from_date'));
      $to_date=alterDateFormat($this->input->post('to_date'));
      ////////////////////
      $data['supplier_id']=$this->input->post('supplier_id');
      $data['po_number']=$this->input->post('po_number');
      $data['from_date']=alterDateFormat($this->input->post('from_date'));
      $data['to_date']=alterDateFormat($this->input->post('to_date'));
      $data['resultdetail']=$this->scorecard_model->reportrResult($supplier_id,$po_number,$from_date,$to_date);
      $data['display']='commonr/scorecard';
      $this->load->view('admin/master',$data);
      }else{
      $data['display']='commonr/scorecard';
      $this->load->view('admin/master',$data);
      }
      } else {
         redirect("logincontroller");
      } 
    }

    function downloadExcel($supplier_id=FALSE,$po_number=FALSE,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='Supplier Score card ';
        $data['resultdetail']=$this->scorecard_model->reportrResult($supplier_id,$po_number,$from_date,$to_date);
        $this->load->view('commonr/scorecardExcel',$data);
    }
    
   function downloadPdf($supplier_id=FALSE,$pi_no=FALSE,$po_number=FALSE,$FIFO_CODE=FALSE,$from_date=FALSE,$to_date=FALSE) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Supplier Score card ';
    $data['category_id']=$category_id;
    $data['supplier_id']=$supplier_id;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->scorecard_model->reportrResult($category_id,$rack_id,$box_id,$supplier_id);
    $pdfFilePath='sparesStockPdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/scorecardPdf', $data, true);
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