<?php
class Itemledger_model extends CI_Model {
    function getDepartment(){
      $result=$this->db->query("SELECT * FROM department_info")->result();
      return $result;
    }
    function searchResult($product_code,$from_date,$to_date){
      $condition='';
      if($product_code!='All'){
        $condition.=" AND gd.product_code='$product_code'";
      }
      if($from_date!=''&&$to_date !=' '){
        $condition.=" AND gm.create_date BETWEEN '$from_date' and '$to_date'";
      }
      $condition1='';
      if($product_code!='All'){
        $condition1.=" AND gd1.product_code='$product_code'";
      }
      if($from_date!=''&&$to_date !=' '){
        $condition1.=" AND gm1.create_date BETWEEN '$from_date' and '$to_date'";
      }
      $result=$this->db->query("SELECT cc.* FROM ( 
        (SELECT gm.gatepass_no,gm.create_date,
          gm.create_time,gm.carried_by,gm.checkin_datetime,
          gm.employee_id,gd.product_code,gd.product_name,
          gd.product_quantity,gd.unit_name, 1 as type
        FROM  gatepass_details gd 
        INNER JOIN gatepass_master gm ON(gd.gatepass_id=gm.gatepass_id) 
        WHERE gm.gatepass_status=5 $condition
        ORDER BY gd.detail_id ASC)
        UNION 
        (SELECT gm1.gatepass_no,gm1.create_date,
          gm1.create_time,gm1.carried_by,gm1.checkin_datetime,
          gm1.employee_id,gd1.product_code,gd1.product_name,gd1.product_quantity,
          gd1.unit_name,2 as type
        FROM  gatepass_details_stock gd1 
        INNER JOIN gatepass_master_stock gm1 ON(gd1.gatepass_id=gm1.gatepass_id) 
        WHERE gm1.gatepass_status=5 $condition1
        ORDER BY gd1.detail_id ASC)
         )as cc ORDER BY cc.checkin_datetime ASC")->result();
      return $result;
    }
    
   

  
}
