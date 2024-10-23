<?php
class Dailymachinestatus_model extends CI_Model {
	function reportrResult($floor_id,$from_date,$machine_status){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT count(ps.product_status_id) as total
          FROM  product_status_info ps,floorline_info fl,floor_info f 
          WHERE ps.line_id=fl.line_id AND fl.floor_id=f.floor_id 
          AND f.floor_id=$floor_id AND ps.machine_status=$machine_status
          AND ps.assign_date<='$from_date' AND 
          ps.take_over_status=1  AND ps.department_id=12")->row('total');
        return $result;
	}
  function getFloor(){
    $result=$this->db->query("SELECT * FROM floor_info 
      WHERE floor_no!='EGM'")->result();
      return $result;
  }
  function NotfoundMachine($detail_status){
  $result=$this->db->query("SELECT count(pd.product_detail_id) as total
      FROM  product_detail_info pd
      WHERE pd.detail_status=$detail_status
      AND pd.department_id=12  ")->row('total');
    return $result;
  }

}