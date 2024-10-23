<?php if ( ! defined('BASEPATH')) exit('No direct script ashippingess allowed');

class Import extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->library('excel'); //load PHPExcel library 
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
        $config['base_url']=base_url().'shipping/import/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->import_model->get_count();
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
        $data['list']=$this->import_model->lists($config["per_page"],$data['page'] );
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
        $data['display']='shipping/importcn';
        $this->load->view('admin/master',$data);
        }else{
          redirect("logincontroller");
        }
    }

    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Import Record';
        $data['collapse']='YES';
        $data['plist']=$this->import_model->getdata2('shipping_supplier_port');
        $data['s2list']=$this->import_model->getdata('shipping_supplier_port');
        $data['slist']=$this->import_model->getdata('shipping_supplier_info');
        $data['flist']=$this->import_model->getdata('shipping_file_style_info');
        $data['clist']=$this->import_model->getdata('shipping_customer_info');
        $data['calist']=$this->import_model->getdata('shipping_carrier_info');
        $data['tlist']=$this->import_model->getdata('shipping_terms_info');
        $data['selist']=$this->import_model->getdata('shipping_season_info');
        $data['display']='shipping/addimport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($import_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Import Record';
        $data['collapse']='YES';
        $data['info']=$this->import_model->get_info($import_id);
        $data['plist']=$this->import_model->getdata2('shipping_supplier_port');
        $data['s2list']=$this->import_model->getdata('shipping_supplier_port');
        $data['slist']=$this->import_model->getdata('shipping_supplier_info');
        $data['flist']=$this->import_model->getdata('shipping_file_style_info');
        $data['clist']=$this->import_model->getdata('shipping_customer_info');
        $data['calist']=$this->import_model->getdata('shipping_carrier_info');
        $data['tlist']=$this->import_model->getdata('shipping_terms_info');
        $data['selist']=$this->import_model->getdata('shipping_season_info');
        $data['display']='shipping/addimport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
  
function save($import_id=FALSE){
    $this->form_validation->set_rules('ex_fty_date','ex_fty_date','trim|required');
    $this->form_validation->set_rules('port_of_loading','port_of_loading','trim|required');
    $this->form_validation->set_rules('routing','routing','trim|required');
    $this->form_validation->set_rules('port_of_discharge','port_of_discharge','trim|required');
    $this->form_validation->set_rules('shipped_qty','shipped_qty','trim|required');
    $this->form_validation->set_rules('shipping_packages','shipping_packages','trim');
    $this->form_validation->set_rules('building_material','building_material','trim');
    $this->form_validation->set_rules('cutting_die_material','cutting_die_material','trim');
    $this->form_validation->set_rules('machineries_part','machineries_part','trim');
    $this->form_validation->set_rules('others_weight','others_weight','trim');
    $this->form_validation->set_rules('mmk_weight','mmk_weight','trim');
    $this->form_validation->set_rules('mkm_weight','mkm_weight','trim');
    $this->form_validation->set_rules('coach_weight','coach_weight','trim');
    $this->form_validation->set_rules('katespade_weight','katespade_weight','trim');
    $this->form_validation->set_rules('supplier_name','supplier_name','trim');
    $this->form_validation->set_rules('invoice_no','invoice_no','trim');
    $this->form_validation->set_rules('invoice_date','invoice_date','trim');
    $this->form_validation->set_rules('invoice_amount','invoice_amount','trim');
    $this->form_validation->set_rules('supplier_name2','supplier_name2','trim');
    $this->form_validation->set_rules('hk_re_export_inv','hk_re_export_inv','trim');
    $this->form_validation->set_rules('shipping_terms','shipping_terms','trim');
    $this->form_validation->set_rules('vessel_voyage','vessel_voyage','trim');
    $this->form_validation->set_rules('carrier_name','carrier_name','trim');
    $this->form_validation->set_rules('etd_port','etd_port','trim');
    $this->form_validation->set_rules('eta_port','eta_port','trim');
    $this->form_validation->set_rules('bl_no','bl_no','trim');
    $this->form_validation->set_rules('obl_no','obl_no','trim');
    $this->form_validation->set_rules('container_no','container_no','trim');
    $this->form_validation->set_rules('number_of_consignment','number_of_consignment','trim');
    $this->form_validation->set_rules('korea_to_hkg_port','korea_to_hkg_port','trim');
    $this->form_validation->set_rules('trucking_fee','trucking_fee','trim');
    $this->form_validation->set_rules('freight_amount','freight_amount','trim');
    $this->form_validation->set_rules('export_declaration','export_declaration','trim');
    $this->form_validation->set_rules('air_reason_record','air_reason_record','trim');
    if ($this->form_validation->run() == TRUE) {
        $check=$this->import_model->save($import_id);
        if($check && !$import_id){
           $this->session->set_userdata('exception','Saved sushippingessfully');
           }elseif($check&& $import_id){
               $this->session->set_userdata('exception','Update sushippingessfully');
           }else{
               $this->session->set_userdata('exception','Submission Failed');
           }
      redirect("shipping/import/lists");
     }else{
        $data['heading']='Add Import Record';
        if($import_id){
          $data['heading']='Edit Import Record';
          $data['info']=$this->import_model->get_info($import_id); 
        }
    $data['plist']=$this->import_model->getdata2('shipping_supplier_port');
    $data['s2list']=$this->import_model->getdata('shipping_supplier_port');
    $data['slist']=$this->import_model->getdata('shipping_supplier_info');
    $data['flist']=$this->import_model->getdata('shipping_file_style_info');
    $data['clist']=$this->import_model->getdata('shipping_customer_info');
    $data['calist']=$this->import_model->getdata('shipping_carrier_info');
    $data['tlist']=$this->import_model->getdata('shipping_terms_info');
    $data['selist']=$this->import_model->getdata('shipping_season_info');
        $data['display']='shipping/addimport';
        $this->load->view('admin/master',$data);
     }

}
    function delete($import_id){
      $this->import_model->delete($import_id); 
      $this->session->set_userdata('exception','Delete sushippingessfully');
      redirect("shipping/import/lists");
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
        $data['info']=$this->import_model->get_info($import_id);
        $data['detail']=$this->import_model->get_detail($import_id);
        $data['import_id']=$import_id;
        $file_name='COURIER'.date('Ymdhi')."-$import_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('shipping/importPdf', $data, true);
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
        $data['info']=$this->import_model->get_info($import_id);
        $data['import_id']=$import_id;
        $data2['import_status']=2;
        $this->db->where('import_id', $import_id);
        $this->db->update('shipping_import_master',$data2);
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
      redirect("shipping/import/lists");
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
        $data['display']='shipping/upExcn';
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
      $data['cn_input_by']=$this->session->userdata('user_id');
      $data['department_id']=$this->session->userdata('department_id');
     for ($i = 2; $i <= $totalrows; $i++) {
        $data['ex_fty_date']  = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
        $data['port_of_loading']  = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
        

        $data['routing']  = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
        $data['port_of_discharge']  = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
        $data['shipped_qty']  = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
        $data['shipping_packages']  = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
        $data['building_material']  = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
        $data['cutting_die_material']  = $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
        $data['machineries_part']  = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
        $data['others_weight']  = $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
        $data['mmk_weight']  = $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
        $data['mkm_weight']  = $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
        $data['coach_weight']  = $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();
        $data['katespade_weight']  = $objWorksheet->getCellByColumnAndRow(13, $i)->getValue();
        $data['file_no']  = $objWorksheet->getCellByColumnAndRow(14, $i)->getValue();
        $data['season']  = $objWorksheet->getCellByColumnAndRow(15, $i)->getValue();
        $data['customer_name']  = $objWorksheet->getCellByColumnAndRow(16, $i)->getValue();
        $data['supplier_name']  = $objWorksheet->getCellByColumnAndRow(17, $i)->getValue();
        $data['invoice_no']  = $objWorksheet->getCellByColumnAndRow(18, $i)->getValue();
        $data['invoice_date']  = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(19, $i)->getValue()));
        $data['invoice_amount']  = $objWorksheet->getCellByColumnAndRow(20, $i)->getValue();
        $data['supplier_name2']  = $objWorksheet->getCellByColumnAndRow(21, $i)->getValue();
        $data['hk_re_export_inv']  = $objWorksheet->getCellByColumnAndRow(22, $i)->getValue();
        $data['shipping_terms']  = $objWorksheet->getCellByColumnAndRow(23, $i)->getValue();
        $data['vessel_voyage']  = $objWorksheet->getCellByColumnAndRow(24, $i)->getValue();
         $data['carrier_name']  = $objWorksheet->getCellByColumnAndRow(25, $i)->getValue();

        $data['etd_port']  = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(26, $i)->getValue()));
        $data['eta_port']  = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(27, $i)->getValue()));
        $datetime1 = date_create($data['etd_port']);
        $datetime2 = date_create($data['eta_port']);
        $interval = date_diff($datetime1, $datetime2);
        $data['port_to_port']=$interval->format('%a')+1;

        $data['bl_no']  = $objWorksheet->getCellByColumnAndRow(28, $i)->getValue();
        $data['obl_no']  = $objWorksheet->getCellByColumnAndRow(29, $i)->getValue();
        $data['container_no']  = $objWorksheet->getCellByColumnAndRow(30, $i)->getValue();
        $data['number_of_consignment']  = $objWorksheet->getCellByColumnAndRow(31, $i)->getValue();
        if($data['number_of_consignment']=='')
            $data['number_of_consignment']=0;
        $data['korea_to_hkg_port']  = $objWorksheet->getCellByColumnAndRow(32, $i)->getValue();
        $data['trucking_fee']  = $objWorksheet->getCellByColumnAndRow(33, $i)->getValue();
        $data['freight_amount']  = $objWorksheet->getCellByColumnAndRow(34, $i)->getValue();
        $data['export_declaration']  = $objWorksheet->getCellByColumnAndRow(35, $i)->getValue();
        $data['air_reason_record']  = $objWorksheet->getCellByColumnAndRow(36, $i)->getValue();

        $data['total_consignment']=$data['building_material']+$data['cutting_die_material']+$data['machineries_part']+$data['others_weight']+$data['mmk_weight']+$data['mkm_weight']+$data['coach_weight']+$data['katespade_weight'];
        if(($data['total_consignment']*$data['building_material'])>0)
        $data['air_building_material_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['building_material'];
        if(($data['total_consignment']*$data['cutting_die_material'])>0)
            $data['air_cutting_die_material_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['cutting_die_material'];
        if(($data['total_consignment']*$data['machineries_part'])>0)
            $data['air_machineries_part_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['machineries_part'];
        if(($data['total_consignment']*$data['others_weight'])>0)
            $data['air_others_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['others_weight'];
        if(($data['total_consignment']*$data['mmk_weight'])>0)
            $data['air_mmk_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['mmk_weight'];
        if(($data['total_consignment']*$data['mkm_weight'])>0)
            $data['air_mkm_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['mkm_weight'];
        if(($data['total_consignment']*$data['coach_weight'])>0)
            $data['air_coach_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['coach_weight'];
        if(($data['total_consignment']*$data['katespade_weight'])>0)
            $data['air_katespade_freight']=($data['korea_to_hkg_port']+$data['trucking_fee']+$data['freight_amount'])/$data['total_consignment']*$data['katespade_weight'];
        $invoice_no=$data['invoice_no'];
        ///echo "<pre>"; print_r($data);  echo "</pre>"; exit();
        $port_of_loading=$data['port_of_loading'];

        $pcheck=$this->db->query("SELECT * FROM shipping_supplier_port WHERE port_of_loading='$port_of_loading' ")->result();
        if(count($pcheck)<1){
            $sdata['port_of_loading']=$data['port_of_loading'];
            $sdata['supplier_name2']=$data['supplier_name2'];
            $sdata['user_id']=$this->session->userdata('user_id');
            $sdata['create_date']=date('Y-m-d');
            $query=$this->db->insert('shipping_supplier_port',$sdata);
        }
    $infochk=$this->db->query("SELECT * FROM shipping_import_master
                    WHERE invoice_no='$invoice_no'")->row();
    if(count($infochk)){
        $this->db->where('invoice_no',$invoice_no);
        $this->db->update('shipping_import_master',$data);
    }else{
        $data['create_date']=date('Y-m-d');
        $no_count=$this->db->query("SELECT max(import_id) as counts 
        FROM shipping_import_master 
        WHERE 1")->row('counts');
        $data['import_number']='IMP'.str_pad($no_count + 1, 6, '0', STR_PAD_LEFT);
        $query=$this->db->insert('shipping_import_master',$data);
    }
}
    //unlink('./asset/excel/' . $file_name); 
    $this->session->set_userdata('exception', 'Upload successfully!');
    redirect("shipping/import/lists");
  }else{
  $this->session->set_userdata('exception_err', "No data found.");
  redirect("shipping/import/addExcel");
  }
  }
  }else{
   $this->session->set_userdata('exception_err', 'File is required');
   redirect("shipping/import/addExcel");
  }
 }
public function sample() {
    $file='import_samplecn.xlsx';
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
 
   
 }