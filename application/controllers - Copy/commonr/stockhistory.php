<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stockhistory extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/stockhistory_model');
     }
    function SearchForm(){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Stock History Report';
	      $data['display']='commonr/stockhistory';
        $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
    }
  function reportrResult(){
     if ($this->session->userdata('user_id')) {
      $data['heading']='Stock History Report ';
      $this->form_validation->set_rules('FIFO_CODE',' ','trim');
      $this->form_validation->set_rules('product_code',' ','trim');
      $this->form_validation->set_rules('po_no',' ','trim');
      $this->form_validation->set_rules('LOCATION','Box Name','trim');
      $this->form_validation->set_rules('from_date',' ','trim');
      $this->form_validation->set_rules('to_date',' ','trim');
      if ($this->form_validation->run() == TRUE) {
      $product_code=$this->input->post('product_code');
      $LOCATION=$this->input->post('LOCATION');
      $po_no=$this->input->post('po_no');
      $FIFO_CODE=$this->input->post('FIFO_CODE');
      $from_date=alterDateFormat($this->input->post('from_date'));
      $to_date=alterDateFormat($this->input->post('to_date'));
      ////////////////////
      $data['LOCATION']=$this->input->post('LOCATION');
      $data['product_code']=$this->input->post('product_code');
      $data['po_no']=$this->input->post('po_no');
      $data['FIFO_CODE']=$this->input->post('FIFO_CODE');
      $data['from_date']=alterDateFormat($this->input->post('from_date'));
      $data['to_date']=alterDateFormat($this->input->post('to_date'));
      $data['resultdetail']=$this->stockhistory_model->reportrResult($product_code,$LOCATION,$po_no,$FIFO_CODE,$from_date,$to_date);
      $data['display']='commonr/stockhistory';
      $this->load->view('admin/master',$data);
      }else{
      $data['display']='commonr/stockhistory';
      $this->load->view('admin/master',$data);
      }
      } else {
         redirect("logincontroller");
      } 
    }

    function downloadExcel($product_code=FALSE,$LOCATION=FALSE,$po_no=FALSE,$FIFO_CODE=FALSE,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='Stock History Report ';
        $data['resultdetail']=$this->stockhistory_model->reportrResult($product_code,$LOCATION,$po_no,$FIFO_CODE,$from_date,$to_date);
        $this->load->view('commonr/stockhistoryExcel',$data);
    }
    
   function downloadPdf($product_code=FALSE,$LOCATION=FALSE,$po_no=FALSE,$FIFO_CODE=FALSE,$from_date=FALSE,$to_date=FALSE) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Stock History Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->stockhistory_model->reportrResult($category_id,$rack_id,$box_id,$product_code);
    $pdfFilePath='sparesStockPdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/stockhistoryPdf', $data, true);
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