<?php
class Issuestatus_model extends CI_Model {
	
	 function reportResult($department_id){
    $result=$this->db->query("SELECT d.department_name, r.*,
      (SELECT SUM(id.quantity) as tquantity 
      FROM item_issue_detail id WHERE r.issue_id=id.issue_id) as tquantity,
      (SELECT SUM(id1.sub_total) as tsub_total 
      FROM item_issue_detail id1 WHERE r.issue_id=id1.issue_id) as tsub_total,
      d1.department_name as res_dept_name,m.mlocation_name
      FROM store_issue_master r
      LEFT JOIN department_info d ON(r.take_department_id=d.department_id)
      INNER JOIN department_info d1 ON(r.department_id=d1.department_id)
      LEFT JOIN location_info l ON(r.location_id=l.location_id)
      LEFT JOIN main_location m ON(l.mlocation_id=m.mlocation_id)
      WHERE r.department_id=$department_id
      AND r.issue_date BETWEEN '2019-02-01' AND  '2019-02-31'
      GROUP BY r.issue_id
      ORDER BY r.issue_id DESC")->result();
    return $result;
          
	}
  
 


}