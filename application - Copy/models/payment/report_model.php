<?php
class Report_model extends CI_Model {
    function getDepartment(){
      $result=$this->db->query("SELECT * FROM department_info")->result();
      return $result;
    }
    function supplierResult($department_id,$supplier_id,$from_date=NULL,$to_date=NULL){
      $condition='';
      if($department_id!='All'){
        $condition.=" AND a.to_department_id=$department_id";
      }
      if($supplier_id!='All'){
        $condition.=" AND a.supplier_id=$supplier_id";
      }
      if($from_date!=''&&$to_date !=' '){
        $condition.=" AND a.applications_date BETWEEN '$from_date' and '$to_date'";
      }
      $result=$this->db->query("SELECT ad.*,a.*,s.supplier_name,
      	h.head_name,d.department_name,
      	(SELECT group_concat(d2.dcode separator '+') as dcode_group  
          FROM payment_dept_amount d2
          WHERE ad.payment_id=d2.payment_id 
          GROUP BY d2.payment_id) as dcode_group
        FROM  payment_application_detail ad 
        INNER JOIN payment_application_master a ON(ad.payment_id=a.payment_id) 
        INNER JOIN department_info d ON(a.to_department_id=d.department_id)
        INNER JOIN supplier_info s ON(s.supplier_id=a.supplier_id) 
        INNER JOIN acccunt_head_info h ON(h.head_id=ad.head_id) 
        WHERE a.status>=5 AND a.status!=8  $condition
        ORDER BY ad.detail_id ASC")->result();
      return $result;
    }

 
   

  
}
