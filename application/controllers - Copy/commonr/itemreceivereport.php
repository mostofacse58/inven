<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Itemreceivereport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/itemreceivereport_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Items Receive Report';
		$data['clist']=$this->look_up_model->getCategory(12);
        $data['dlist']=$this->look_up_model->departmentList();
	    $data['display']='commonr/itemreceivereport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Items Receive Report ';
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['dlist']=$this->look_up_model->departmentList();
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
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
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['resultdetail']=$this->itemreceivereport_model->reportrResult($category_id,$data['department_id'],$product_code,$data['from_date'],$data['to_date'],$data['reference_no']);
        $data['display']='commonr/itemreceivereport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/itemreceivereport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($category_id,$department_id,$product_code,$from_date,$to_date) {
        $data['heading']='Items Receive Report ';
        $data['category_id']=$category_id;
        $data['product_code']=$product_code;
        $data['rack_id']=$rack_id;
        $data['resultdetail']=$this->itemreceivereport_model->reportrResult($category_id,$department_id,$product_code,$from_date,$to_date);
        $this->load->view('commonr/itemreceivereportExcel',$data);
    }
    function getBox(){
          $rack_id=$this->input->post('rack_id');
           $result=$this->db->query("SELECT *
            FROM box_info 
            WHERE department_id=12 
            and rack_id=$rack_id")->result();
        echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->box_id.'" >'.$value->box_name.'</option>';
      }
    exit;
   }
   function downloadPdf($category_id,$department_id,$product_code,$from_date,$to_date) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Items Receive Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->itemreceivereport_model->reportrResult($category_id,$department_id,$product_code,$from_date,$to_date);
    $pdfFilePath='sparesReceivePdf'.date('Y-m-d H:i').'.pdf';
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