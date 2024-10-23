<?php
class Purchaserequisition_model extends CI_Model {
	function reportResult(){
    $result=$this->db->query("SELECT d.department_name, r.*,
      (SELECT  SUM(d.required_qty) as tquantity FROM deptrequisn_item_details d  
      WHERE d.deptrequisn_id=r.deptrequisn_id) as tquantity
      FROM deptrequisn_master r
      INNER JOIN department_info d ON(r.department_id=d.department_id)
      WHERE 1
      AND 1
      ORDER BY r.deptrequisn_id DESC")->result();
    return $result;
          
  }
  
 


}