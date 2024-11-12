<?php
class Rbudgety_model extends CI_Model {
    function lists() {
        $department_id=4;
        $condition=' ';
          if($_GET){
            if($this->input->get('budget_no')!=''){
              $budget_no=$this->input->get('budget_no');
              $condition=$condition."  AND a.budget_no='$budget_no' ";
            }
          
            if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
              $from_date=alterDateFormat($this->input->get('from_date'));
              $to_date=alterDateFormat($this->input->get('to_date'));
              $condition.=" AND a.create_date BETWEEN '$from_date' AND '$to_date'";
            }
        }
        $result=$this->db->query("SELECT a.*,d.department_name
            FROM budget_yearly_master a 
            INNER JOIN department_info d ON(d.department_id=a.by_department)
            WHERE a.department_id=$department_id
            AND a.status>=2
            $condition
            ORDER BY a.master_id DESC")->result();
        return $result;
    }
   
   function approved($master_id) {
        $data=array();
        $data['status']=4;
        $data['received_by']=$this->session->userdata('user_id');
        $data['received_date']=date('Y-m-d');
        $this->db->WHERE('master_id',$master_id);
        $query=$this->db->Update('budget_yearly_master',$data);
        return $query;
     }
    ////////////////////////
  
}
