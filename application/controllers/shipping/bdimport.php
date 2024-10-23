<?php if ( ! defined('BASEPATH')) exit('No direct script ashippingess allowed');

class Bdimport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->library('excel'); //load PHPExcel library 
        $this->load->model('shipping/bdimport_model');
        $this->load->model('shipping/import_model');
        if($this->session->userdata('language')=='chinese'){
        $this->lang->load('chinese', "chinese");
        }else{
          $this->lang->load('english', "english");
        }
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
        else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'shipping/bdimport/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->bdimport_model->get_count();
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
        ////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['pagination'] = $this->pagination->create_links();
        //echo $data["page"]; exit();///////////
        $data['list']=$this->bdimport_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Import Record Lists';
        $data['plist']=$this->import_model->getdata2('shipping_supplier_port');
        $data['s2list']=$this->import_model->getdata('shipping_supplier_port');
        $data['slist']=$this->import_model->getdata('shipping_supplier_info');
        $data['flist']=$this->import_model->getdata('shipping_file_style_info');
        $data['clist']=$this->import_model->getdata('shipping_customer_info');
        $data['calist']=$this->import_model->getdata('shipping_carrier_info');
        $data['tlist']=$this->import_model->getdata('shipping_terms_info');
        $data['selist']=$this->import_model->getdata('shipping_season_info');
        $data['condition']=$config['suffix'];
        $data['display']='shipping/importbd';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

    
    function edit($import_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Import Record';
        $data['info']=$this->bdimport_model->get_info($import_id);
        $data['display']='shipping/editbdimport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
  
function save($import_id=FALSE){
    $this->form_validation->set_rules('courier_freight_usd',lang('courier_freight_usd'),'trim|required');
    $this->form_validation->set_rules('cnf_from_broker_tkd',lang('cnf_from_broker_tkd'),'trim|required');
    $this->form_validation->set_rules('logistics_charges_tkd',lang('logistics_charges_tkd'),'trim|required');
    $this->form_validation->set_rules('uepz_gate_tips',lang('uepz_gate_tips'),'trim|required');
    $this->form_validation->set_rules('eta_uttara_factory',lang('eta_uttara_factory'),'trim|required');
    $this->form_validation->set_rules('exception_remarks',lang('exception_remarks'),'trim');
    if ($this->form_validation->run() == TRUE) {
        $check=$this->bdimport_model->save($import_id);
        if($check && !$import_id){
           $this->session->set_userdata('exception','Saved sushippingessfully');
           }elseif($check&& $import_id){
               $this->session->set_userdata('exception','Update sushippingessfully');
           }else{
               $this->session->set_userdata('exception','Submission Failed');
           }
      redirect("shipping/bdimport/lists");
     }else{
        $data['heading']='Add Import Record';
        if($import_id){
          $data['heading']='Edit Import Record';
          $data['info']=$this->bdimport_model->get_info($import_id); 
        }
        $data['display']='shipping/editbdimport';
        $this->load->view('admin/master',$data);
     }
}
    function delete($import_id){
      $this->bdimport_model->delete($import_id); 
      $this->session->set_userdata('exception','Delete sushippingessfully');
      redirect("shipping/bdimport/lists");
    }
    function view($import_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['import_id']=$import_id;
        $data['heading']='Import Record Details Information';
        $data['info']=$this->import_model->get_info($import_id);
        $data['display']='shipping/importview';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function loadpdf($import_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='COURIER';
        $data['info']=$this->bdimport_model->get_info($import_id);
        $data['detail']=$this->bdimport_model->get_detail($import_id);
        $data['import_id']=$import_id;
        $file_name='COURIER'.date('Ymdhi')."-$import_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('shipping/bdimportPdf', $data, true);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'F');
        } else {
        redirect("logincontroller");
        }
      }
      public function submit($import_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $dept_head_email=$this->db->query("SELECT * FROM department_info
          WHERE department_id=$department_id")->row('dept_head_email');
        ////////////////////////////////////////
        $data['info']=$this->bdimport_model->get_info($import_id);
        $data['import_id']=$import_id;
        $data2['bdimport_status']=2;
        $this->db->where('import_id', $import_id);
        $this->db->update('shipping_bdimport_master',$data2);
        ///////////////////
        ////////////////////EMAIL SECTION///////////////////
        $this->load->library('email');
        $config['protocol'] = 'mail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from("it@vlmbd.com","Online Import Record System.");
        $this->email->to("arif.hossain@bdventura.com");
        $this->email->subject("Import Record BD Input Notification");
        $message=$this->load->view('shipping/bd_email_body', $data,true);
        $this->email->message($message);
        $this->email->send();
        $this->email->clear(TRUE);
        $this->session->set_userdata('exception','Submit successfully');
      redirect("shipping/bdimport/lists");
    }
    public function getShipTo(){
      $ship_id = $this->input->post('ship_id');
      $info=$this->db->query("SELECT*   
          FROM  ship_to_info  
          WHERE ship_id=$ship_id ")->row();
        $data=array('ship_name'=>$info->ship_name,'ship_address'=>$info->ship_address,'ship_attention'=>$info->ship_attention,'ship_telephone'=>$info->ship_telephone,'ship_email'=>$info->ship_email);
      echo  json_encode($data);
    }
     function addExcel(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Upload Import Data';
        $data['display']='shipping/upExbd';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
function uplaoddata(){
   if ($_FILES['data_file']['name'] != "") {
    $configUpload['upload_path'] = FCPATH . 'asset/excel/';
    $configUpload['allowed_types'] = 'xls|xlsx|csv';
    $configUpload['max_size'] = '500000';
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
    if($totalrows>2){
     for ($i = 2; $i <= $totalrows; $i++) {
        $invoice_no  = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
        $data['courier_freight_usd']  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
        $data['cnf_from_broker_tkd']  = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
        $data['logistics_charges_tkd']  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
        $data['uepz_gate_tips']  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
        $data['eta_uttara_factory']  = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
        $data['exception_remarks']  = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();

        $info=$this->db->query("SELECT g.*
        FROM  shipping_import_master g 
        WHERE g.invoice_no='$invoice_no'")->row();
        $department_id=$this->session->userdata('department_id');
        if(($info->total_consignment*$info->building_material)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->building_material;
        if(($info->total_consignment*$info->cutting_die_material)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->cutting_die_material;
        if(($info->total_consignment*$info->machineries_part)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->machineries_part;
        if(($info->total_consignment*$info->others_weight)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->others_weight;
        if(($info->total_consignment*$info->mmk_weight)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->mmk_weight;
        if(($info->total_consignment*$info->mkm_weight)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->mkm_weight;
        if(($info->total_consignment*$info->coach_weight)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->coach_weight;
        if(($info->total_consignment*$info->katespade_weight)>0)
            $data['air_building_material_freight']=($data['courier_freight_usd']+$data['cnf_from_broker_tkd']+$data['logistics_charges_tkd']+$data['uepz_gate_tips'])/$info->total_consignment*$info->katespade_weight;
        $data['bd_input_by']=$this->session->userdata('user_id');
        $data['update_date']=date('Y-m-d');
        $this->db->where('invoice_no',$invoice_no);
        $this->db->update('shipping_import_master',$data);
   
}
    //unlink('./asset/excel/' . $file_name); 
    $this->session->set_userdata('exception', 'Upload successfully!');
    redirect("shipping/bdimport/lists");
  }else{
  $this->session->set_userdata('exception_err', "No data found.");
  redirect("shipping/bdimport/addExcel");
  }
  }
  }else{
   $this->session->set_userdata('exception_err', 'File is required');
   redirect("shipping/bdimport/addExcel");
  }
 }
public function sample() {
    $file='import_samplebd.xlsx';
    // load ci download helder
    $this->load->helper('download');
    $data = file_get_contents("asset/sample/".$file); // Read the file's 
    $name = $file;
    force_download($name, $data);
}   
function loadExcel(){
if($this->session->userdata('user_id')) {
    $this->excel->setActiveSheetIndex(0);
    $data['lists'] =$this->import_model->lists(50000,0);  
    $this->load->view('shipping/importExcel', $data);
   }else{
    redirect("logincontroller");
  }
}
function loadExcel3(){
if($this->session->userdata('user_id')) {
    $this->excel->setActiveSheetIndex(0);
    $data =$this->bdimport_model->lists(50000,0);  
    //echo count($data); exit();      
    $this->excel->stream('name_of_file.xls', $data);
   }else{
    redirect("logincontroller");
  }
}
 
   
 }