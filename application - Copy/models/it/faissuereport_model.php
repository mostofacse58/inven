<?php
class Faissuereport_model extends CI_Model {

  function reportResult($category_id,$department_id,$employee_id){

    $condition='';
    if($category_id!='All'){
      $condition.=" AND p.category_id=$category_id";
    }
    if($department_id!='All'){
      $condition.=" AND aim.take_department_id='$department_id'";
    }
    if($employee_id!=''){
    $condition=$condition."  AND aim.employee_id=$employee_id ";
    }
    $department_id1=$this->session->userdata('department_id');
    /////////////////
    if($this->session->userdata('department_id')==1){
        $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
        c.category_name,b.brand_name,l.location_name,aim.employee_id,
        pd.it_status,d.department_name,e.employee_name,aim.asset_issue_id,
        aim.issue_date,aim.return_date,aim.issue_status
        FROM  asset_issue_master aim
        INNER JOIN product_detail_info pd  ON(pd.product_detail_id=aim.product_detail_id)        
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN location_info l ON(aim.location_id=l.location_id)
        LEFT JOIN department_info d ON(aim.take_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
        WHERE p.machine_other=2 $condition 
        ORDER BY pd.ventura_code ASC")->result();
      return $result;

    }else{
        $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
        c.category_name,b.brand_name,l.location_name,aim.employee_id,
        pd.it_status,d.department_name,e.employee_name,aim.asset_issue_id,
        aim.issue_date,aim.return_date,aim.issue_status
        FROM  asset_issue_master aim
        INNER JOIN product_detail_info pd  ON(pd.product_detail_id=aim.product_detail_id)        
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN location_info l ON(aim.location_id=l.location_id)
        LEFT JOIN department_info d ON(aim.take_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
        WHERE p.machine_other=2 AND p.department_id=$department_id1 $condition 
        ORDER BY pd.ventura_code ASC")->result();
      return $result;
    }
    
          
	}
  function reportSparesResult($category_id,$department_id,$employee_id){
    $condition='';
    if($category_id!='All'){
      $condition.=" AND p.category_id=$category_id";
    }
    if($department_id!='All'){
      $condition.=" AND sim.take_department_id='$department_id'";
    }
    if($employee_id!=''){
    $condition=$condition."  AND sim.employee_id=$employee_id ";
    }
    $department_id1=$this->session->userdata('department_id');
    /////////////////
    if($this->session->userdata('department_id')==1){
        $result=$this->db->query("SELECT p.product_name,p.product_code,
        p.product_model,d.department_name,e.employee_name,
        c.category_name,b.brand_name,l.location_name,
        sim.*,iid.*
        FROM  item_issue_detail iid
        INNER JOIN store_issue_master sim  ON(sim.issue_id=iid.issue_id)        
        INNER JOIN product_info p ON(p.product_id=iid.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN location_info l ON(sim.location_id=l.location_id)
        LEFT JOIN department_info d ON(sim.take_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(sim.employee_id=e.employee_cardno)
        WHERE p.machine_other=2  $condition 
        ORDER BY sim.issue_id ASC")->result();
      return $result;

    }else{
        $result=$this->db->query("SELECT p.product_name,p.product_code,
        p.product_model,d.department_name,e.employee_name,
        c.category_name,b.brand_name,l.location_name,
        sim.*,iid.*
        FROM  item_issue_detail iid
        INNER JOIN store_issue_master sim  ON(sim.issue_id=iid.issue_id)        
        INNER JOIN product_info p ON(p.product_id=iid.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN location_info l ON(sim.location_id=l.location_id)
        LEFT JOIN department_info d ON(sim.take_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(sim.employee_id=e.employee_cardno)
        WHERE p.machine_other=2 AND p.department_id=$department_id1 $condition 
        ORDER BY sim.issue_id ASC")->result();
      return $result;
    }

    }
    function reportSparesReturn($category_id,$department_id,$employee_id){
    $condition='';
    if($category_id!='All'){
      $condition.=" AND p.category_id=$category_id";
    }
    if($department_id!='All'){
      $condition.=" AND r.from_department_id='$department_id'";
    }
    if($employee_id!=''){
    $condition=$condition."  AND r.employee_id=$employee_id ";
    }
    $department_id1=$this->session->userdata('department_id');
    /////////////////
    if($this->session->userdata('department_id')==1){
        $result=$this->db->query("SELECT p.product_name,p.product_code,
        p.product_model,d.department_name,e.employee_name,
        c.category_name,b.brand_name,
        r.*
        FROM  issue_return_info r
        INNER JOIN product_info p ON(p.product_id=r.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN department_info d ON(r.from_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(r.employee_id=e.employee_cardno)
        WHERE p.machine_other=2  $condition 
        ORDER BY r.ireturn_id ASC")->result();
      return $result;

    }else{
        $result=$this->db->query("SELECT p.product_name,p.product_code,
        p.product_model,d.department_name,e.employee_name,
        c.category_name,b.brand_name,
        r.*
        FROM  issue_return_info r
        INNER JOIN product_info p ON(p.product_id=r.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN department_info d ON(r.from_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(r.employee_id=e.employee_cardno)
        WHERE p.machine_other=2 
        AND p.department_id=$department_id1 $condition 
        ORDER BY r.ireturn_id ASC")->result();
      return $result;
    }

    }
}