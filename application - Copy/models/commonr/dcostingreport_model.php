<?php
class Dcostingreport_model extends CI_Model {
	 function SparesCostResult($take_department_id,$from_department_id,$from_date,$to_date){
    if($from_department_id==12){
        $condition='';
        if($from_date!=''&&$to_date !=' '){
          $condition.=" AND sim.use_date BETWEEN '$from_date' AND '$to_date'";
        }
        $result['sparescost']=$this->db->query("SELECT IFNULL(SUM(sim.total_amount_hkd),0) as sparescost
          FROM  spares_use_master sim
          WHERE  sim.department_id=12 
          AND sim.take_department_id=$take_department_id  
          $condition ")->row('sparescost');
      }else{
        $condition='';
        if($from_date!=''&&$to_date !=' '){
          $condition.=" AND sim.issue_date BETWEEN '$from_date' AND '$to_date'";
        }
        $result['sparescost']=$this->db->query("SELECT IFNULL(SUM(sim.total_amount_hkd),0) as sparescost
          FROM  store_issue_master sim
          WHERE  sim.department_id=$from_department_id 
          AND sim.take_department_id=$take_department_id  
          $condition ")->row('sparescost');
      }
        /////////////////////////
      $condition1='';
      if($from_date!=''&&$to_date !=' '){
	      $condition1.=" AND sim.purchase_date BETWEEN '$from_date' AND '$to_date'";
	    }
        $result['facost']=$this->db->query("SELECT IFNULL(SUM(sim.amount_hkd),0) as facost
          FROM  product_detail_info sim
          WHERE sim.department_id=$from_department_id 
          AND sim.forpurchase_department_id=$take_department_id 
          $condition1")->row('facost');
        //////////////////////////
        $condition2='';
        if($from_date!=''&&$to_date !=' '){
	      $condition2.=" AND sim.servicing_date BETWEEN '$from_date' AND '$to_date'";
	    }
        $sercost=$this->db->query("SELECT IFNULL(SUM(sim.servicing_cost),0) as sercost
          FROM  gatepass_costing sim
          WHERE sim.department_id=$from_department_id 
          AND sim.for_department_id=$take_department_id 
          $condition2")->row('sercost');
        $result['sercost']=$sercost*0.088;
        return $result;
          
	}
  function fullfactorySpares($from_department_id,$from_date,$to_date){
    if($from_department_id==12){
      $condition='';
      if($from_date!=''&&$to_date !=' '){
        $condition.=" AND sim.use_date BETWEEN '$from_date' AND '$to_date'";
      }
      $result=$this->db->query("SELECT IFNULL(SUM(sim.total_amount_hkd),0) as sparescost
          FROM  spares_use_master sim
          WHERE  sim.department_id=12 
          AND sim.take_department_id=0
          $condition ")->row('sparescost');
      return $result;
    }else{
      $condition='';
      if($from_date!=''&&$to_date !=' '){
        $condition.=" AND sim.issue_date BETWEEN '$from_date' AND '$to_date'";
      }
      $result=$this->db->query("SELECT IFNULL(SUM(sim.total_amount_hkd),0) as sparescost
          FROM  store_issue_master sim
          WHERE  sim.department_id=$from_department_id 
          AND sim.take_department_id=0
          $condition ")->row('sparescost');
      return $result;
    }

  }


	// function FixedCostResult($from_department_id,$take_department_id,$from_date,$to_date){
	//     $condition='';
	//     if($from_date!=''&&$to_date !=' '){
	//       $condition.=" AND sim.purchase_date BETWEEN '$from_date' AND '$to_date'";
	//     }
        
 //        return $result;
          
	// }
	// function ServicingCostResult($from_department_id,$take_department_id,$from_date,$to_date){
	//     $condition='';
	//     if($from_date!=''&&$to_date !=' '){
	//       $condition.=" AND sim.servicing_date BETWEEN '$from_date' AND '$to_date'";
	//     }
        
 //        return $result*0.088;
          
	// }
 


}