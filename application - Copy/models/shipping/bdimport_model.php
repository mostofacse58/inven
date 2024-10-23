<?php
class Bdimport_model extends CI_Model {
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
        $condition=$condition."  AND (g.import_number LIKE '%$import_number%' OR g.invoice_no LIKE '%$import_number%') ";
      }
      if($this->input->get('season')!=''){
        $import_number=$this->input->get('season');
        $condition=$condition."  AND (g.season LIKE '%$season%' OR g.season LIKE '%$season%') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $query=$this->db->query("SELECT * FROM shipping_import_master g
        WHERE g.import_status>=2 
        AND g.department_id=$department_id 
        $condition");
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
      WHERE g.import_status>=2 AND g.department_id=$department_id 
      $condition
      ORDER BY g.import_id DESC 
      LIMIT $start,$limit")->result();
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
        $info=$this->db->query("SELECT g.*
        FROM  shipping_import_master g 
        WHERE g.import_id=$import_id")->row();

        $department_id=$this->session->userdata('department_id');
        $data['courier_freight_usd']=$this->input->post('courier_freight_usd');
        $data['cnf_from_broker_tkd']=$this->input->post('cnf_from_broker_tkd');
        $data['logistics_charges_tkd']=$this->input->post('logistics_charges_tkd');
        $data['uepz_gate_tips']=$this->input->post('uepz_gate_tips');
        $data['eta_uttara_factory']=$this->input->post('eta_uttara_factory');
        $data['exception_remarks']=$this->input->post('exception_remarks');
        //echo $data['eta_uttara_factory'];
        //print_r($info->eta_port); exit();
        // if($data['eta_uttara_factory']!=0 ||$data['eta_uttara_factory']==''){
        //   $datetime1 = date_create($data['eta_uttara_factory']);
        //   $datetime2 = date_create($info->eta_port);
        //   $interval = date_diff($datetime1, $datetime2);
        //   $data['eta_cgp_to_fty']=$interval->format('%a')+1;
        // }
        

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
        ////////////////////
        $this->db->WHERE('import_id',$import_id);
        $query=$this->db->update('shipping_import_master',$data);
              
       return $query;
    }
  


 
  
}
