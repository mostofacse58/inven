<?php
class Cbudgety_model extends CI_Model {
    function lists() {
        $department_id=$this->session->userdata('department_id');
        $user_id=$this->session->userdata('user_id');
        $condition=' ';
        if($user_id==104){
          $condition=$condition."  AND (a.by_department=6 OR a.by_department=15) ";
        }else{
            $condition=$condition." AND a.by_department=$department_id ";
        }
        $result=$this->db->query("SELECT a.*,d.department_name
            FROM budget_yearly_master a 
            INNER JOIN department_info d ON(d.department_id=a.by_department)
            WHERE  a.status>=2 $condition
            ORDER BY a.master_id DESC")->result();
        return $result;
    }
   
   function approved($master_id) {
        $data=array();
        $data['status']=3;
        $data['confirm_by']=$this->session->userdata('user_id');
        $data['confirm_date']=date('Y-m-d');
        $this->db->WHERE('master_id',$master_id);
        $query=$this->db->Update('budget_yearly_master',$data);
        return $query;
     }
    ////////////////////////
  
}
