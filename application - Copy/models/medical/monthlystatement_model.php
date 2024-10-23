<?php
class Monthlystatement_model extends CI_Model {
	
	 function reportrResult($department_id,$symptoms_id,$from_date,$to_date){
    $department_id1=$this->session->userdata('department_id');
    $condition='';
    if($department_id!='All'){
    $condition.=" AND sim.take_department_id=$department_id ";
    }
    if($symptoms_id!='All'){
    $condition.=" AND s.symptoms_id=$symptoms_id ";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND sim.issue_date BETWEEN '$from_date' AND '$to_date'";
    }
    if($symptoms_id=='All'){
    $result=$this->db->query("SELECT sim.issue_date,sim.employee_id,
      sim.employee_name,sim.sex,
          l.location_name,d.department_name,
          (SELECT group_concat(sym.symptoms_name separator '+') as symptoms_group  
          FROM issued_symptoms isym, symptoms_info sym 
          WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=sim.issue_id 
          GROUP BY sim.issue_id) as symptoms_group,

          (SELECT group_concat(p.product_name separator '+') as item_group  
          FROM item_issue_detail idd, product_info p 
          WHERE idd.product_id=p.product_id AND idd.issue_id=sim.issue_id 
          GROUP BY sim.issue_id) as item_group,

          (SELECT SUM(idd2.sub_total) FROM item_issue_detail idd2
           WHERE  idd2.issue_id=sim.issue_id) as cost

          FROM  store_issue_master sim
          LEFT JOIN department_info d ON(sim.take_department_id=d.department_id)
          LEFT JOIN location_info l ON(sim.location_id=l.location_id)
          WHERE sim.medical_yes=1 
          AND sim.department_id=3 
          $condition
          ORDER BY sim.issue_id ASC")->result();
      }else{
        $result=$this->db->query("SELECT sim.*,
          l.location_name,d.department_name,
          (SELECT group_concat(p.product_name separator '+') as item_group  
          FROM item_issue_detail idd, product_info p 
          WHERE idd.product_id=p.product_id AND idd.issue_id=sim.issue_id 
          GROUP BY sim.issue_id) as item_group,

          (SELECT group_concat(sym.symptoms_name separator '+') as symptoms_group  
          FROM issued_symptoms isym, symptoms_info sym 
          WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=sim.issue_id 
          GROUP BY sim.issue_id) as symptoms_group,

          (SELECT SUM(idd2.sub_total) FROM item_issue_detail idd2
           WHERE  idd2.issue_id=sim.issue_id) as cost

          FROM  store_issue_master sim
          LEFT JOIN department_info d ON(sim.take_department_id=d.department_id)
          LEFT JOIN location_info l ON(sim.location_id=l.location_id)
          INNER JOIN issued_symptoms s ON(sim.issue_id=s.issue_id)
          WHERE sim.medical_yes=1 
          AND sim.department_id=3 
          $condition
          ORDER BY sim.issue_id ASC")->result();
        }

        return $result;
      
          
	}
 


}