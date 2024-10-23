<?php
class Monthlydieselreport_model extends CI_Model {	
	function reportrResult($motor_id,$fuel_using_dept_id,$driver_id,$from_date,$to_date){
    $condition='';
    if($motor_id!='All'){
      $condition.=" AND a.motor_id=$motor_id";
    }
    if($fuel_using_dept_id!='All'){
      $condition.=" AND a.fuel_using_dept_id=$fuel_using_dept_id";
    }
    if($driver_id!='All'){
      $condition.=" AND a.driver_id=$driver_id";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND a.issue_date BETWEEN '$from_date' AND '$to_date'";
    }
    
    $result=$this->db->query("SELECT a.*,m.motor_name,
          d.fuel_using_dept_name,t.driver_name
          FROM  fuel_issue_master a
          INNER JOIN motor_info m ON(a.motor_id=m.motor_id)
          LEFT JOIN fuel_using_dept d ON(a.fuel_using_dept_id=d.fuel_using_dept_id)
          LEFT JOIN driver_info t ON(a.taken_by=t.driver_id)
          LEFT JOIN user u ON(u.id=a.user_id)
          WHERE a.department_id=12 $condition
          ORDER BY a.fuel_issue_id ASC")->result();
        return $result;
      }
 }