<?php
class Downtimechart_model extends CI_Model {
	 function modelwisereport($from_date,$to_date){
      $from_date=$from_date;
      $to_date=$to_date;
      $result=$this->db->query("SELECT p.product_name,p.product_code,p.product_model,
        IFNULL(SUM(md.total_minuts),0) as downtime
        FROM product_info p, 
        machine_downtime_info md,
        product_detail_info pd 
        WHERE p.product_id=pd.product_id AND pd.tpm_serial_code=md.product_status_id 
        AND md.down_date BETWEEN '$from_date' AND '$to_date' 
        GROUP BY p.product_id
        ORDER BY downtime DESC")->result();
      return $result;
          
	}
  function floorwisereport($from_date,$to_date){
      $from_date=$from_date;
      $to_date=$to_date;
      $result=$this->db->query("SELECT f.floor_no,
        IFNULL(SUM(md.total_minuts),0) as downtime
        FROM product_info p, 
        machine_downtime_info md,
        product_detail_info pd,
        floorline_info fl,
        floor_info f
        WHERE p.product_id=pd.product_id AND pd.tpm_serial_code=md.product_status_id  
        AND md.line_id=fl.line_no AND fl.floor_id=f.floor_id AND 
        md.down_date BETWEEN '$from_date' AND '$to_date'
        GROUP BY f.floor_id
        ORDER BY downtime DESC")->result();
      return $result;
          
  }
  function treewisereport($from_date,$to_date){
    $from_date=$from_date;
    $to_date=$to_date;
    $result=$this->db->query("SELECT p.product_name,p.product_code,p.product_model,
      IFNULL(SUM(md.total_minuts),0) as downtime
      FROM product_info p, 
      machine_downtime_info md,
      product_detail_info pd 
      WHERE p.product_id=pd.product_id AND pd.tpm_serial_code=md.product_status_id AND 
      md.down_date BETWEEN '$from_date' AND '$to_date'
      GROUP BY p.product_id
      ORDER BY downtime DESC limit 0,3")->result();
    return $result;
          
  }
}