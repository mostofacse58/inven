<?php
class Report_model extends CI_Model {
    function getDepartment(){
      $result=$this->db->query("SELECT * FROM department_info")->result();
      return $result;
    }
    function returnableResult($department_id,$from_date=FALSE,$to_date=FALSE){
      $condition='';
      if($department_id!='All'){
        $condition.=" AND gm.department_id=$department_id";
      }
      if($from_date!=''&&$to_date !=''){
        $condition.=" AND gm.create_date BETWEEN '$from_date' and '$to_date'";
      }
      $result=$this->db->query("SELECT gm.gatepass_no,gm.create_date,
          gm.create_time,gm.carried_by,gm.gatepass_type,
          gm.employee_id,i.*,d.department_name,gd.*,
          (SELECT IFNULL(SUM(gid.return_qty),0) FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id) as qty
        FROM  gatepass_details gd 
        INNER JOIN gatepass_master gm ON(gd.gatepass_id=gm.gatepass_id) 
        LEFT JOIN  issue_to_master i ON(gm.issue_to=i.issue_to)
        INNER JOIN department_info d ON(gm.department_id=d.department_id)
        WHERE gd.gatepass_type=1 AND (gm.gatepass_status=4 OR gm.gatepass_status>=5)  $condition
        ORDER BY gd.detail_id ASC")->result();
      return $result;
    }
    function nonreturnableResult($department_id,$gatepass_type,$issue_from,$wh_whare,$from_date,$to_date){
      $condition='';
      if($department_id!='All'){
        $condition.=" AND gm.department_id=$department_id ";
      }
      if($issue_from!='All'){
        $condition.=" AND gm.issue_from='$issue_from' ";
      }
      if($wh_whare!='All'){
        $condition.=" AND gm.wh_whare='$wh_whare' ";
      }
      if($from_date!=''&&$to_date !=' '){
        $condition.=" AND gm.create_date BETWEEN '$from_date' and '$to_date'";
      }
      $result=$this->db->query("SELECT gm.gatepass_no,gm.create_date,
          gm.create_time,gm.carried_by,gm.gatepass_type,gm.issue_from,gm.wh_whare,
          gm.employee_id,i.*,d.department_name,gd.*
        FROM  gatepass_details gd 
        INNER JOIN gatepass_master gm ON(gd.gatepass_id=gm.gatepass_id) 
        LEFt JOIN  issue_to_master i ON(gm.issue_to=i.issue_to)
        INNER JOIN department_info d ON(gm.department_id=d.department_id)
        WHERE gd.gatepass_type=$gatepass_type 
        AND gm.gatepass_status>=4 AND gm.gatepass_status!=8  $condition
        ORDER BY gd.detail_id ASC")->result();
    //echo $this->db->last_query(); exit();
     // print_r($result); exit();
      return $result;
    }
    
   

  
}
