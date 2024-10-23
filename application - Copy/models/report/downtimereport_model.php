<?php
class Downtimereport_model extends CI_Model {
	
	 function reportrResult(){
    $condition='';
    $floor_id=$this->input->post('floor_id');
    $product_detail_id=$this->input->post('product_detail_id');
    if($floor_id!='All'){
      $condition.=" AND f.floor_id=$floor_id";
    }
    if($product_detail_id!='All'){
      $condition.=" AND pd.product_detail_id=$product_detail_id";
    }
    $from_date=alterDateFormat($this->input->post('from_date'));
    $to_date=alterDateFormat($this->input->post('to_date'));
    $result=$this->db->query("SELECT p.product_name,p.product_code, md.*,
          md.line_id as line_no,md.supervisor_id as supervisor_name,md.me_id as me_name,
          pd.tpm_serial_code
          FROM machine_downtime_info md 
          INNER JOIN floorline_info fl ON(md.line_id=fl.line_no)
          INNER JOIN floor_info f ON(fl.floor_id=f.floor_id)
          INNER JOIN product_detail_info pd ON(md.product_status_id=pd.tpm_serial_code)
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          WHERE md.down_date BETWEEN '$from_date' and '$to_date' $condition
          ORDER BY md.machine_downtime_id DESC")->result();
        return $result;
	}
  function getFloor(){
    $result=$this->db->query("SELECT * FROM floor_info WHERE floor_no!='EGM'")->result();
      return $result;
  }

}