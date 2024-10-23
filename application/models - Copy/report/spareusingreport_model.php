<?php
class Spareusingreport_model extends CI_Model {
	 function reportrResult(){
    $condition='';
    $category_id=$this->input->post('category_id');
    $floor_id=$this->input->post('floor_id');
    $product_detail_id=$this->input->post('product_detail_id');
    $product_code=$this->input->post('product_code');
    if($category_id!='All'){
      $condition.=" AND p.category_id=$category_id";
    }
    $use_type=$this->input->post('use_type');
    if($use_type!='All'){
      $condition.=" AND sm.use_type=$use_type";
    }
    if($floor_id!='All'){
      $condition.=" AND fl.floor_id=$floor_id";
    }
    if($product_detail_id!='All'){
      $condition.=" AND sm.product_detail_id=$product_detail_id";
    }
    if($product_code!=''){
      $condition.=" AND sd.product_code='$product_code' ";
    }
    $from_date=alterDateFormat($this->input->post('from_date'));
    $to_date=alterDateFormat($this->input->post('to_date'));
    
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND sm.use_date BETWEEN '$from_date' AND '$to_date'";
    }
    
    $result=$this->db->query("SELECT p.product_name,
          p.china_name,p.product_code,sd.unit_price,u.unit_name, 
          sd.product_id,fl.line_no,sm.using_ref_no,sm.use_date,
          m.me_name,sm.other_id,sm.requisition_no,sd.amount_hkd,sd.currency,
          sd.quantity as qty,pd.tpm_serial_code,pp.product_model,sd.FIFO_CODE
          FROM spares_use_detail sd 
          INNER JOIN spares_use_master sm ON(sd.spares_use_id=sm.spares_use_id)
          LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
          INNER JOIN product_info p ON(sd.product_id=p.product_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN me_info m ON(sm.me_id=m.me_id)
          LEFT JOIN product_detail_info pd ON(sm.asset_encoding=pd.asset_encoding OR sm.asset_encoding=pd.ventura_code OR sm.asset_encoding=pd.tpm_serial_code)
          LEFT JOIN product_info pp ON(pd.product_id=pp.product_id)
          WHERE sm.department_id=12 AND sd.TRX_TYPE='TPMISSUE'
          $condition 
          ORDER BY sm.spares_use_id ASC")->result();
        return $result;
      }
  function getMachineInfo() {
        $product_detail_id=$this->input->post('product_detail_id');
        $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
          c.category_name,mt.machine_type_name,b.brand_name
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          WHERE pd.department_id=12 and 
           pd.product_detail_id='$product_detail_id' ")->row();
        return $result;
    }
  function getFloor(){
    $result=$this->db->query("SELECT * FROM floor_info")->result();
      return $result;
  }

}