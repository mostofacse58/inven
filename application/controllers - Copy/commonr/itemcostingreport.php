<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Itemcostingreport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/itemcostingreport_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Item Monthly Expense Report';
		$data['clist']=$this->look_up_model->getCategory(12);
        $data['mllist']=$this->look_up_model->getMainLocation();
        $data['llist']=$this->look_up_model->getlocation();
	    $data['display']='commonr/itemcostingreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Item Monthly Expense Report ';
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['mllist']=$this->look_up_model->getMainLocation();
        $data['llist']=$this->look_up_model->getlocation();
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('product_code','ITEM CODE','trim');
        $this->form_validation->set_rules('mlocation_id','Main Area','trim|required');
        $this->form_validation->set_rules('location_id','Location','trim|required');
        $this->form_validation->set_rules('from_date','Date','trim|required');
        $this->form_validation->set_rules('to_date','date','trim|required');
        if ($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $product_code=$this->input->post('product_code');
        $mlocation_id=$this->input->post('mlocation_id');
        $location_id=$this->input->post('location_id');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['mlocation_id']=$this->input->post('mlocation_id');
        $data['location_id']=$this->input->post('location_id');
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['resultdetail']=$this->itemcostingreport_model->reportrResult($category_id,$mlocation_id,$location_id,$data['from_date'],$data['to_date'],$product_code);
        $data['display']='commonr/itemcostingreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/itemcostingreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($category_id=FALSE,$rack_id=FALSE,$box_id=FALSE,$mlocation_id=FALSE,$product_code=FALSE) {
        $data['heading']='Item Monthly Expense Report ';
        $data['category_id']=$category_id;
        $data['product_code']=$product_code;
        $data['rack_id']=$rack_id;
        $data['resultdetail']=$this->itemcostingreport_model->reportrResult($category_id,$rack_id,$box_id,$mlocation_id,$product_code);
        $this->load->view('commonr/itemissueExcel',$data);
    }
    function getBox(){
          $rack_id=$this->input->post('rack_id');
           $result=$this->db->query("SELECT *
            FROM box_info 
            WHERE mlocation_id=12 
            and rack_id=$rack_id")->result();
        echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->box_id.'" >'.$value->box_name.'</option>';
      }
    exit;
   }
   function downloadPdf($category_id=FALSE,$rack_id=FALSE,$box_id=FALSE,$product_code=FALSE) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Item Monthly Expense Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->itemcostingreport_model->reportrResult($category_id,$rack_id,$box_id,$product_code);
    $pdfFilePath='sparesIssuePdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/itemissuePdf', $data, true);
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