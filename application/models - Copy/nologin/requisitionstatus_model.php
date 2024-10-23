<?php
class Requisitionstatus_model extends CI_Model {
	
	 function reportResult($department_id){
    $result=$this->db->query("SELECT r.*,
      d.department_name,
      d1.department_name as res_dept_name,
      (SELECT  SUM(d.required_qty) as tquantity FROM requisition_item_details d  
      WHERE d.requisition_id=r.requisition_id) as tquantity
      FROM requisition_master r
      INNER JOIN department_info d ON(r.department_id=d.department_id)
      INNER JOIN department_info d1 ON(r.responsible_department=d1.department_id)
      WHERE 1
      ORDER BY r.requisition_id DESC")->result();
    return $result;
          
	}
  
 


}