<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/stock_model');
     }
    function SearchForm(){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Items Stock Report';
	    $data['clist']=$this->look_up_model->getCategory(12);
      $data['dlist']=$this->look_up_model->departmentList();
      $data['display']='commonr/stock';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Items Stock Report ';
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['dlist']=$this->look_up_model->departmentList();
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('product_code','ITEM CODE','trim');
        $this->form_validation->set_rules('rack_id','Rack Name','trim|required');
        $this->form_validation->set_rules('box_id','Box Name','trim');
        $this->form_validation->set_rules('department_id','department Name','trim');
        if ($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $rack_id=$this->input->post('rack_id');
        $product_code=$this->input->post('product_code');
        $department_id=$this->input->post('department_id');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['department_id']=$this->input->post('department_id');
        $data['rack_id']=$this->input->post('rack_id');
        $data['box_id']=$this->input->post('box_id');
        $data['resultdetail']=$this->stock_model->reportrResult($category_id,$rack_id,$data['box_id'],$department_id,$product_code);
        $data['display']='commonr/stock';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/stock';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function safetyitem(){
      $data['heading']='Items Stock Report ';
      $data['clist']=$this->look_up_model->getCategory(12);
      $data['dlist']=$this->look_up_model->departmentList();
      $department_id=$this->session->userdata('department_id');
      $data['category_id']='All';
      $data['product_code']='';
      $data['department_id']=$this->session->userdata('department_id');
      $data['rack_id']='All';
      $data['box_id']='All';
      $data['resultdetail']=$this->stock_model->safetyitem($department_id);
      $data['display']='commonr/stock';
      $this->load->view('admin/master',$data);
    }

    function downloadExcel($category_id=FALSE,$rack_id=FALSE,$box_id=FALSE,$department_id=FALSE,$product_code=FALSE) {
        $data['heading']='Items Stock Report ';
        $data['category_id']=$category_id;
        $data['product_code']=$product_code;
        $data['rack_id']=$rack_id;
        $data['resultdetail']=$this->stock_model->reportrResult($category_id,$rack_id,$box_id,$department_id,$product_code);
        $this->load->view('commonr/stockExcel',$data);
    }
    function getBox(){
        $department_id=$this->session->userdata('department_id');
        $rack_id=$this->input->post('rack_id');
        $result=$this->db->query("SELECT *
            FROM box_info 
            WHERE department_id=$department_id 
            and rack_id='$rack_id'")->result();
        echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->box_id.'" >'.$value->box_name.'</option>';
      }
    exit;
   }
   function downloadPdf($category_id=FALSE,$rack_id=FALSE,$box_id=FALSE,$department_id,$product_code=FALSE) {
    if ($this->session->userdata('user_id')) {
      $data['heading']='Items Stock Report ';
      $data['category_id']=$category_id;
      $data['product_code']=$product_code;
      $data['rack_id']=$rack_id;
      $data['resultdetail']=$this->stock_model->reportrResult($category_id,$rack_id,$box_id,$department_id,$product_code);
      $pdfFilePath='sparesStockPdf'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','A4','','','15','15','30','18');
      $header = $this->load->view('header', $data, true);
      $html=$this->load->view('commonr/stockPdf', $data, true);
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
    function getcategory(){
      $department_id=$this->input->post('department_id');
       $result=$this->db->query("SELECT *
        FROM category_info 
        WHERE department_id=$department_id")->result();
      echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->category_id.'" >'.$value->category_name.'</option>';
      }
   exit;
  }

  function getAssetlist(){
      $department_id=$this->input->post('department_id');
       $result=$this->db->query("SELECT *
        FROM product_info 
        WHERE department_id=$department_id 
        AND product_type=1 AND machine_other=2")->result();
      echo '<option value="All">All</option>';
      foreach($result as $value) {
        echo '<option value="'.$value->product_id.'" >'.$value->product_name.'</option>';
      }
   exit;
  }

}