<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Itemledger extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/itemledger_model');
     }
    
    function search(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Item Ledger Report';
	    $data['display']='gatep/itemledgerreport';
        $this->load->view('admin/master',$data);
        } else {
        redirect("logincontroller");
        }
    }
    function searchResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Item Ledger Report';
        $data['dlist']=$this->itemledger_model->getDepartment();
        $this->form_validation->set_rules('product_code','Code','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim');
        $this->form_validation->set_rules('to_date','To Date','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['product_code']=$this->input->post('product_code');
        $from_date=alterDateFormat($this->input->post('from_date'));
        $to_date=alterDateFormat($this->input->post('to_date'));
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['resultdetail']=$this->itemledger_model->searchResult($data['product_code'],$from_date,$to_date);
        $data['display']='gatep/itemledgerreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='gatep/itemledgerreport';
        $this->load->view('admin/master',$data);
        }
        }else {
           redirect("logincontroller");
        } 
    }
    function resultPDF($product_code,$from_date,$to_date){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Item Ledger Report';
      $data['resultdetail']=$this->itemledger_model->searchResult($product_code,$from_date,$to_date);
        $data['product_code']=$product_code;
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $pdfFilePath='Returnable_report'.date('Y-m-d').'.pdf';
        $this->load->library('mpdf');
        $mpdf=new mPDF('utf-8');
        $mpdf = new mPDF('bn','L','','','15','15','28','15');
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('gatep/itemledgerreportpdf', $data, true);
        $mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'D');
       }else{
        redirect("logincontroller");
      }
    }
   

}