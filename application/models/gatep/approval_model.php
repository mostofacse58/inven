<?php 
class Approval_model extends CI_Model {
  public function get_count(){
    /// 22, 6 Robert, 17 SPark, 16 all thomas
    $condition=' ';
    $department_id=$this->session->userdata('department_id');
    if($department_id==6){
      $condition=$condition." AND (g.department_id=6 OR g.department_id=22 OR g.department_id=34 OR g.department_id=15 OR g.department_id=36) ";
    }elseif($department_id==17){
      $condition=$condition."  AND (g.department_id=17) ";
    }elseif($department_id==28){
      $condition=$condition."  AND (g.department_id=28) ";
    }elseif($department_id==7){
      $condition=$condition."  AND (g.department_id=7) ";
    }elseif($department_id==18){
      $condition=$condition."  AND (g.department_id=18) ";
    }elseif($department_id==29){
      $condition=$condition."  AND (g.department_id=29) ";
    }elseif($department_id==19){
      $condition=$condition."  AND (g.department_id=19) ";
    }elseif($department_id==12){
      $condition=$condition."  AND (g.department_id=12) ";
    }elseif($department_id==5){
      $condition=$condition."  AND (g.department_id=5) ";
    }else{
      $condition=$condition."  AND g.department_id!=6 
                               AND g.department_id!=22 
                               AND g.department_id!=34
                               AND g.department_id!=17
                               AND g.department_id!=28
                               AND g.department_id!=7
                               AND g.department_id!=15
                               AND g.department_id!=18
                               AND g.department_id!=19
                               AND g.department_id!=12
                               AND g.department_id!=5
                               AND g.department_id!=36
                               AND g.department_id!=29 ";

    }

    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $data=$this->db->query("SELECT count(*) as counts 
      FROM gatepass_master g
        WHERE g.gatepass_status>=3 
        AND g.sub_contract_status=2 $condition")->row('counts');
      return $data;
    }

  public  function lists($limit,$start){
    $condition=' ';
    $department_id=$this->session->userdata('department_id');
    if($department_id==6){
      $condition=$condition."  AND (g.department_id=6 OR g.department_id=22 OR g.department_id=34 OR g.department_id=15 OR g.department_id=36) ";
    }elseif($department_id==17){
      $condition=$condition."  AND (g.department_id=17) ";
    }elseif($department_id==28){
      $condition=$condition."  AND (g.department_id=28) ";
    }elseif($department_id==7){
      $condition=$condition."  AND (g.department_id=7) ";
    }elseif($department_id==18){
      $condition=$condition."  AND (g.department_id=18) ";
    }elseif($department_id==29){
      $condition=$condition."  AND (g.department_id=29) ";
    }elseif($department_id==19){
      $condition=$condition."  AND (g.department_id=19) ";
    }elseif($department_id==12){
      $condition=$condition."  AND (g.department_id=12) ";
    }elseif($department_id==5){
      $condition=$condition."  AND (g.department_id=5) ";
    }else{
      $condition=$condition." AND g.department_id!=6 
                              AND g.department_id!=22 
                              AND g.department_id!=34
                              AND g.department_id!=17
                              AND g.department_id!=28
                              AND g.department_id!=7
                              AND g.department_id!=15
                              AND g.department_id!=18
                              AND g.department_id!=19
                              AND g.department_id!=12
                              AND g.department_id!=5
                              AND g.department_id!=36
                              AND g.department_id!=29 ";
    }

    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status>=3 
      AND g.sub_contract_status=2
      $condition
      ORDER BY g.gatepass_status ASC,
      g.create_date,g.gatepass_no DESC
      LIMIT $start,$limit")->result();
    return $result;
  }

    
  

  
}
