<?php
class Budget_model extends CI_Model {
    function lists() {
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
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*,d.department_name
            FROM budget_master a 
            INNER JOIN department_info d ON(d.department_id=a.by_department)
            WHERE a.by_department=$department_id
            ORDER BY a.master_id DESC")->result();
        return $result;
    }
    function get_info($master_id){
      $result=$this->db->query("SELECT a.*,d.department_name,d2.department_name as to_department_name
        FROM budget_master a 
        INNER JOIN department_info d ON(d.department_id=a.by_department)
        INNER JOIN department_info d2 ON(d2.department_id=a.department_id)
        WHERE master_id=$master_id ")->row();
      return $result;
    }
    function getLastMonth($head_id,$for_month){
      $department_id=$this->session->userdata('department_id');
      $row=$this->db->query("SELECT IFNULL(amount2,0) as amount
        FROM budget_details b ,budget_master a
        WHERE a.master_id=b.master_id 
        AND b.head_id=$head_id 
        AND a.for_month='$for_month' 
        AND b.department_id=$department_id ")->row();
      if(empty($row)){
        return 0;
      }else{
        return $row->amount;
      }
    }
    function getLastMonthCost($head_id,$for_month){
      $department_id=$this->session->userdata('department_id');
      $dcode=$this->session->userdata('dept_shortcode');
      $row=$this->db->query("SELECT IFNULL(damount,0) as amount
        FROM budget_details b ,budget_master a
        WHERE a.master_id=b.master_id 
        AND b.department_id=$department_id
        AND b.head_id=$head_id 
        AND a.for_month='$for_month' ")->row();
      return $row->amount;
    }

    function getDetails($master_id=FALSE){
      $condition='';
      $department_id=$this->session->userdata('department_id');
      if($master_id==FALSE){
    		$result=$this->db->query("SELECT s.*, 0 as amount,0 as amount2,
    			0 as amount3,0 as amount4,0 as amount5,
          0 as amount6, '' as remarks
          FROM acccunt_head_info s 
          WHERE 1
          ORDER BY s.head_name ASC")->result();
    	}else{
        $result=$this->db->query("SELECT s.*,a.*
          FROM budget_details s 
          INNER JOIN acccunt_head_info a ON(s.head_id=a.head_id)
          WHERE  s.master_id=$master_id
          ORDER BY a.head_name ASC")->result();
    	}
      //print_r($result); exit();
      return $result;
    }

    function save($master_id) {
      $department_id=$this->session->userdata('department_id');

        $data=array();
        $data['for_month']=$this->input->post('for_month');
        $data['create_date']=date('Y-m-d');
        $data['user_id']=$this->session->userdata('user_id');
        $data['by_department']=$this->session->userdata('department_id');

        $i=0;
        if($master_id==FALSE){
          $counts=$this->db->query("SELECT MAX(master_id) as counts 
            FROM budget_master 
            WHERE 1")->row('counts');
          $data['budget_no']='BDB'.str_pad($counts + 1, 6, '0', STR_PAD_LEFT);
          $query=$this->db->insert('budget_master',$data);
          $master_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('master_id',$master_id);
          $this->db->WHERE('by_department',$department_id);
          $query=$this->db->UPDATE('budget_master',$data);
          $this->db->WHERE('master_id',$master_id);
          $this->db->WHERE('department_id',$department_id);
          $this->db->delete('budget_details');
        }
        $i=0;
        /////////////////////////////////////////
        $head_id=$this->input->post('head_id');
        $amount=$this->input->post('amount');
        $amount2=$this->input->post('amount2');
        $amount3=$this->input->post('amount3');
        $amount4=$this->input->post('amount4');
        $amount5=$this->input->post('amount5');
        $amount6=$this->input->post('amount6');
        $remarks=$this->input->post('remarks');
        ///////////////////////////////////
        $i=0;
        $total_amount=0;
        $data2['department_id']=$department_id;
        foreach ($head_id as $value) {
          $data2['head_id']=$value;
          $data2['amount']=$amount[$i];
          $data2['amount2']=$amount2[$i];
          $data2['amount3']=$amount3[$i];
          $data2['amount4']=$amount4[$i];
          $data2['amount5']=$amount5[$i];
          $data2['amount6']=$amount6[$i];
          $data2['remarks']=$remarks[$i];
          $data2['master_id']=$master_id;
          $query=$this->db->insert('budget_details',$data2);
          $total_amount=$total_amount+$amount[$i];
        $i++;
        }
        $data3['total_amount']=$total_amount;
        $this->db->WHERE('master_id',$master_id);
        $this->db->WHERE('by_department',$department_id);
        $query=$this->db->UPDATE('budget_master',$data3);
      return $master_id;
    }
   function deletes($master_id) {
     $department_id=$this->session->userdata('department_id');
      $this->db->WHERE('master_id',$master_id);
      $this->db->WHERE('department_id',$department_id);
      $query=$this->db->delete('budget_details');
      $this->db->WHERE('master_id',$master_id);
      $this->db->WHERE('by_department',$department_id);
      $query=$this->db->delete('budget_master');
      return $query;
    }
    function decisions($master_id) {
      $data=array();
      $data['status']=$this->input->post('status');
      $data['comment_note']=$this->session->userdata('user_name').":".$this->input->post('comment_note');
      $this->db->WHERE('master_id',$master_id);
      $query=$this->db->Update('budget_master',$data);
      return $query;
   }
    ////////////////////////
  
}
