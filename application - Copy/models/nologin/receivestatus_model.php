<?php
class Receivestatus_model extends CI_Model {
	
	 function reportResult($department_id){
    $result=$this->db->query("SELECT d.department_name, r.*,
    	SUM(id.quantity) as tquantity,
      SUM(id.amount) as tsub_total
      FROM purchase_master r
      INNER JOIN purchase_detail id ON(id.purchase_id=r.purchase_id)
      INNER JOIN department_info d ON(r.department_id=d.department_id)
      WHERE 1
      AND 1
      GROUP BY r.purchase_id
      ORDER BY r.purchase_id DESC")->result();
    return $result;
          
	}
  
 


}