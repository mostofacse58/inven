<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stockout extends My_Controller {
    function __construct()  {
        parent::__construct();
        $this->load->model('wh/stockout_model');
       // $this->load->library('excel'); //load PHPExcel library 
     }
    
    function lists(){
      $data=array();
       if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      //////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'wh/stockout/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->stockout_model->get_count();
        $total_rows=$config['total_rows'];
        $config['per_page'] = $perpage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = 2;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">Next »</span>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = "</a></li>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $total_rows=$config['total_rows'];
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->stockout_model->lists($config["per_page"],$data['page']);
        $data['waiting']=$this->stockout_model->waiting();
        $data['total']=$this->stockout_model->total();
        ////////////////////////////
        $data['heading']='Carton Information';
        $data['display']='wh/stockoutlist';
        $this->load->view('admin/master',$data);
       }
    function dashboard(){
        $data['waiting']=$this->stockout_model->waiting();
        $data['alreadyIn']=$this->stockout_model->alreadyIn();
        $data['heading']='Invoice Wise Information';
        $data['list']=$this->stockout_model->getGroupByInvoice();
        $data['display']='wh/outInvlist';
        $this->load->view('admin/master',$data);
       }
      function po($export_invoice_no){
        $data['waiting']=$this->stockout_model->waitingInv($export_invoice_no);
        $data['alreadyIn']=$this->stockout_model->alreadyInv($export_invoice_no);
        $data['heading']='PO Wise Information';
        $data['list']=$this->stockout_model->getGroupByPo($export_invoice_no);
        $data['display']='wh/outpo';
        $this->load->view('admin/master',$data);
      }

    function add(){
        $data['heading']='Add Carton Information';
        $data['llists']=$this->stockout_model->getLocation();
        $data['display']='wh/addout';
        $this->load->view('admin/master',$data);
        
    }
    function edit($id){
        $data['heading']='Edit Carton Information';
        $data['info']=$this->stockout_model->get_info($id);
        $data['llists']=$this->stockout_model->getLocation();
        $data['display']='wh/addout';
        $this->load->view('admin/master',$data);

    }
   
    function save($id=FALSE){
        $this->form_validation->set_rules('po_no','PO','trim');
        $this->form_validation->set_rules('customer','customer','trim|required');
        $this->form_validation->set_rules('file_no','FILE','trim');
        $this->form_validation->set_rules('carton_no','CARTON','trim|required');
        $this->form_validation->set_rules('bag_qty','BAG QTY','trim|required');
        $this->form_validation->set_rules('factory_style','Factory Style','trim|');
        $this->form_validation->set_rules('customer_syle','customer style','trim|required');
        $this->form_validation->set_rules('color','color','trim|required');
        $this->form_validation->set_rules('barcode_no','barcode','trim|required');
        $this->form_validation->set_rules('out_document_no','Document No','trim');
        $this->form_validation->set_rules('export_invoice_no','Invocie No','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->stockout_model->save($id);
             if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
            redirect("wh/stockout/lists");
         }else{
            $data['heading']='Add Carton Information';
            if($id){
              $data['heading']='Edit Carton Information';
              $data['info']=$this->stockout_model->get_info($id);  
            }
            $data['llists']=$this->stockout_model->getLocation();
            $data['display']='wh/addout';
            $this->load->view('admin/master',$data);
         }
      }
    function delete($id=FALSE){
      $check=$this->stockout_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("wh/stockout/lists");
    }

    function views($id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Item Details Information';
        $data['info']=$this->stockout_model->get_info($id);
        $data['display']='wh/itemview';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function addbulk(){
      $data['heading']='Update Data';
      $data['display']='wh/bulkout';
      $this->load->view('admin/master',$data);
    }
  public function sample() {
        $file='stockout.xlsx';
        // load ci download helder
        $this->load->helper('download');
        $data = file_get_contents("asset/sample/".$file); // Read the file's 
        $name = $file;
        force_download($name, $data);
    }
   

   function bulkin(){
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
    if($totalrows>2){
      $data['department_id']  = $this->session->userdata('department_id');
     for ($i = 2; $i <= $totalrows; $i++) {
      $data['customer']  = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
      $data['file_no']  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
      $data['po_no']  = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
      $data['carton_no']  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
      $data['bag_qty']  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
      $data['factory_style']  = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
      $data['customer_syle']  = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
      $data['color']  = $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
      $data['barcode_no']  = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
      $data['export_invoice_no']  = $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
      $data['out_document_no']  = $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
      $data['create_date']=date('Y-m-d');
      $query=$this->db->insert('stock_out_master',$data);
    }
    //unlink('./asset/excel/' . $file_name); 
    $this->session->set_userdata('exception', 'Upload successfully!');
    redirect("wh/stockout/lists");
  }else{
  $this->session->set_userdata('exception_err', "No data found.");
  redirect("wh/stockout/addbulk");
  }
  }
  }else{
   $this->session->set_userdata('exception_err', 'File is required');
   redirect("wh/stockout/addbulk");
  }
 }
   
 }