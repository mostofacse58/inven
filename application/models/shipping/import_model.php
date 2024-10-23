<?php
class Import_model extends CI_Model {
  function __construct(){
    parent::__construct();
    //$msdb = $this->load->database('msdb', TRUE);
 }
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('ex_fty_date')!=''){
        $ex_fty_date=$this->input->get('ex_fty_date');
        $condition=$condition."  AND g.ex_fty_date='$ex_fty_date' ";
      }

      if($this->input->get('port_of_loading')!='All'){
        $port_of_loading=$this->input->get('port_of_loading');
        $condition=$condition."  AND g.port_of_loading LIKE '%$port_of_loading%' ";
      }
      if($this->input->get('port_of_discharge')!='All'){
        $port_of_discharge=$this->input->get('port_of_discharge');
        $condition=$condition."  AND g.port_of_discharge='$port_of_discharge' ";
      }
      if($this->input->get('customer_name')!='All'){
        $customer_name=$this->input->get('customer_name');
        $condition=$condition."  AND g.customer_name LIKE '%$customer_name%' ";
      }

      if($this->input->get('supplier_name')!='All'){
        $supplier_name=$this->input->get('supplier_name');
        $condition=$condition."  AND g.supplier_name='$supplier_name' ";
      }

      if($this->input->get('file_no')!=''){
        $file_no=$this->input->get('file_no');
        $file_no=implode(",",$file_no); 
        $condition=$condition."  AND g.file_no LIKE '%$file_no%' ";
      }
     if($this->input->get('import_number')!=''){
        $import_number=$this->input->get('import_number');
        $condition=$condition."  AND (g.import_number LIKE '%$import_number%' OR  g.invoice_no LIKE '%$import_number%') ";
      }
      if($this->input->get('season')!=''){
        $import_number=$this->input->get('season');
        $condition=$condition."  AND (g.season LIKE '%$season%' OR g.season LIKE '%$season%') ";
      }
     }
    // echo "$condition"; exit();
    $department_id=$this->session->userdata('department_id');
    $query=$this->db->query("SELECT * FROM shipping_import_master g
        WHERE g.import_status<7 AND 
        g.department_id=$department_id $condition");
    $data = count($query->result());
    return $data;
  }

  public  function lists($limit,$start){
    $condition=' ';
    if($_GET){
      if($this->input->get('ex_fty_date')!=''){
        $ex_fty_date=$this->input->get('ex_fty_date');
        $condition=$condition."  AND g.ex_fty_date='$ex_fty_date' ";
      }

      if($this->input->get('port_of_loading')!='All'){
        $port_of_loading=$this->input->get('port_of_loading');
        $condition=$condition."  AND g.port_of_loading LIKE '%$port_of_loading%' ";
      }
      if($this->input->get('port_of_discharge')!='All'){
        $port_of_discharge=$this->input->get('port_of_discharge');
        $condition=$condition."  AND g.port_of_discharge='$port_of_discharge' ";
      }
      if($this->input->get('customer_name')!='All'){
        $customer_name=$this->input->get('customer_name');
        $condition=$condition."  AND g.customer_name LIKE '%$customer_name%' ";
      }

      if($this->input->get('supplier_name')!='All'){
        $supplier_name=$this->input->get('supplier_name');
        $condition=$condition."  AND g.supplier_name='$supplier_name' ";
      }

      if($this->input->get('file_no')!=''){
        $file_no=$this->input->get('file_no');
        $file_no=implode(",",$file_no); 
        $condition=$condition."  AND g.file_no LIKE '%$file_no%' ";
      }
     if($this->input->get('import_number')!=''){
        $import_number=$this->input->get('import_number');
        $condition=$condition."  AND (g.import_number LIKE '%$import_number%' OR g.invoice_no LIKE '%$import_number%') ";
      }
      if($this->input->get('season')!=''){
        $import_number=$this->input->get('season');
        $condition=$condition."  AND (g.season LIKE '%$season%' OR g.season LIKE '%$season%') ";
      }
     }

    
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by
      FROM  shipping_import_master g 
      LEFT JOIN user u ON(u.id=g.cn_input_by)
      WHERE g.import_status<7 AND g.department_id=$department_id 
      $condition
      ORDER BY g.import_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }
  function get_detail($import_id){
    $result=$this->db->query("SELECT gd.*
      FROM  import_detail gd 
      WHERE gd.import_id=$import_id")->result();
    return $result;
  }
  function get_info($import_id){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT g.*,u.user_name
      FROM  shipping_import_master g 
      LEFT JOIN user u ON(u.id=g.cn_input_by)
      WHERE g.import_id=$import_id")->row();
      return $result;
    }
    function save($import_id) {
        $data=array();
        $file_no=$this->input->post('file_no');
        $data['file_no']=implode(",",$file_no);
        $season=$this->input->post('season');
        $data['season']=implode(",",$season);
        $customer_name=$this->input->post('customer_name');
        $data['customer_name']=implode(",",$customer_name);

        $department_id=$this->session->userdata('department_id');
        $data['ex_fty_date']=$this->input->post('ex_fty_date');
        $data['port_of_loading']=$this->input->post('port_of_loading');
        $data['routing']=$this->input->post('routing');
        $data['port_of_discharge']=$this->input->post('port_of_discharge');
        $data['shipped_qty']=$this->input->post('shipped_qty');
        $data['shipping_packages']=$this->input->post('shipping_packages');
        $data['building_material']=$this->input->post('building_material');
        $data['cutting_die_material']=$this->input->post('cutting_die_material');
        $data['machineries_part']=$this->input->post('machineries_part');
        $data['others_weight']=$this->input->post('others_weight');
        $data['mmk_weight']=$this->input->post('mmk_weight');
        $data['mkm_weight']=$this->input->post('mkm_weight');
        $data['coach_weight']=$this->input->post('coach_weight');
        $data['katespade_weight']=$this->input->post('katespade_weight');
        $data['total_consignment']=$data['building_material']+$data['cutting_die_material']+$data['machineries_part']+$data['others_weight']+$data['mmk_weight']+$data['mkm_weight']+$data['coach_weight']+$data['katespade_weight'];
        
        $data['supplier_name']=$this->input->post('supplier_name');
        $data['invoice_no']=$this->input->post('invoice_no');
        $data['invoice_date']=$this->input->post('invoice_date');
        $data['invoice_amount']=$this->input->post('invoice_amount');
        $data['supplier_name2']=$this->input->post('supplier_name2');
        $data['hk_re_export_inv']=$this->input->post('hk_re_export_inv');
        $data['shipping_terms']=$this->input->post('shipping_terms');
        $data['vessel_voyage']=$this->input->post('vessel_voyage');
        $data['carrier_name']=$this->input->post('carrier_name');
        $data['etd_port']=$this->input->post('etd_port');
        $data['eta_port']=$this->input->post('eta_port');
        $datetime1 = date_create($data['etd_port']);
	    	$datetime2 = date_create($data['eta_port']);
		    $interval = date_diff($datetime1, $datetime2);
		    $data['port_to_port']=$interval->format('%a')+1;
        $data['bl_no']=$this->input->post('bl_no');
        $data['obl_no']=$this->input->post('obl_no');
        $data['container_no']=$this->input->post('container_no');
        $data['number_of_consignment']=$this->input->post('number_of_consignment');
        $data['korea_to_hkg_port']=$this->input->post('korea_to_hkg_port');
        $data['trucking_fee']=$this->input->post('trucking_fee');
        $data['freight_amount']=$this->input->post('freight_amount');

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

        $data['export_declaration']=$this->input->post('export_declaration');
        $data['air_reason_record']=$this->input->post('air_reason_record');
        $data['cn_input_by']=$this->session->userdata('user_id');
        $data['department_id']=$this->session->userdata('department_id');
        ////////////////////
         if($_FILES['attachment']['name']!=""){
        $config['upload_path'] = './shipping/';
        $config['allowed_types'] = 'pdf|PDF|xlsx|xls|jpg|jpeg';
        $config['max_size'] = '300000';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("attachment")){
          $upload_info = $this->upload->data();
          $data['attachment']=$upload_info['file_name'];
        }}
        ///////////////
        if($import_id==FALSE){
          $data['create_date']=date('Y-m-d');
          $no_count=$this->db->query("SELECT max(import_id) as counts 
            FROM shipping_import_master 
          WHERE 1")->row('counts');
          $data['import_number']='IMP'.str_pad($no_count + 1, 6, '0', STR_PAD_LEFT);
          $query=$this->db->insert('shipping_import_master',$data);
          $import_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('import_id',$import_id);
          $query=$this->db->update('shipping_import_master',$data);
        }
       
       return $query;
    }
  
    function delete($import_id) {
      $this->db->WHERE('import_id',$import_id);
      $query=$this->db->delete('shipping_import_master');
      return $query;
  }

  function getdata($table){
     $result=$this->db->query("SELECT * FROM $table
      ORDER BY id ASC")->result();
      return $result;
  }
  function getdata2($table){
     $result=$this->db->query("SELECT * FROM $table
     	GROUP BY port_of_loading
      ORDER BY id ASC")->result();
      return $result;
  }

 
  
}
