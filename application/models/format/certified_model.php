<?php
class Certified_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    $department_id=$this->session->userdata('department_id');
    if($department_id==6){
      $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=22 OR pm.department_id=6) ";
    }elseif($department_id==15){
       $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=40 OR pm.department_id=41) ";
    }elseif($department_id==9){
      $condition=$condition."  AND (pm.department_id=9) ";
    }elseif($department_id==4){
      $condition=$condition." AND (pm.department_id=4) ";
    }elseif($department_id==5){
      $condition=$condition." AND (pm.department_id=5 OR pm.department_id=17 OR pm.department_id=28 OR pm.department_id=29 OR pm.department_id=18 OR pm.department_id=12) ";
    }elseif($department_id==28){
      $condition=$condition." AND (pm.department_id=28) ";
    }elseif($department_id==19){
      $condition=$condition."  AND (pm.department_id=19) ";
    }elseif($department_id==7){
      $condition=$condition."  AND (pm.department_id=7) ";
    }elseif($department_id==29){
      $condition=$condition."  AND (pm.department_id=29) ";;
    }else{
      $condition=$condition."  AND (pm.department_id=1 OR pm.department_id=2 OR pm.department_id=3 OR pm.department_id=12 OR pm.department_id=16) ";
    }

    
    if($_GET){
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pm.pi_no='$pi_no' ";
      }
      if($this->input->get('department_id')!='All'){
        $department_id=$this->input->get('department_id');
        $condition=$condition."  AND pm.department_id='$department_id' ";
      }
      if($this->input->get('pi_status')!='All'){
        $pi_status=$this->input->get('pi_status');
        $condition=$condition."  AND pm.pi_status='$pi_status' ";
      }
     }
     $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  pi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_status>=3 AND pm.review_status=2 $condition");
      $data = count($query->result());
      return $data;
    }

  function lists($limit,$start) {
      $condition=' ';
      $department_id=$this->session->userdata('department_id');
      $department_id=$this->session->userdata('department_id');
    if($department_id==6){
      $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=22 OR pm.department_id=6) ";
    }elseif($department_id==15){
       $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=40 OR pm.department_id=41) ";
    }elseif($department_id==9){
      $condition=$condition."  AND (pm.department_id=9) ";
    }elseif($department_id==4){
      $condition=$condition."  AND (pm.department_id=4) ";
    }elseif($department_id==5){
      $condition=$condition."  AND (pm.department_id=5 OR pm.department_id=17 OR pm.department_id=28 OR pm.department_id=29 OR pm.department_id=18 OR pm.department_id=12) ";
    }elseif($department_id==28){
      $condition=$condition."  AND (pm.department_id=28) ";
    }elseif($department_id==19){
      $condition=$condition."  AND (pm.department_id=19) ";
    }elseif($department_id==7){
      $condition=$condition."  AND (pm.department_id=7) ";
    }elseif($department_id==29){
      $condition=$condition."  AND (pm.department_id=29) ";;
    }else{
      $condition=$condition."  AND (pm.department_id=1 OR pm.department_id=2 OR pm.department_id=3 OR pm.department_id=12 OR pm.department_id=16) ";
    }
      if($_GET){
        if($this->input->get('pi_no')!=''){
          $pi_no=$this->input->get('pi_no');
          $condition=$condition."  AND pm.pi_no='$pi_no' ";
        }
        if($this->input->get('department_id')!='All'){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND pm.department_id='$department_id' ";
        }
        if($this->input->get('pi_status')!='All'){
        $pi_status=$this->input->get('pi_status');
        $condition=$condition."  AND pm.pi_status='$pi_status' ";
      }
       }
      $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
        d.department_name as responsible_department_name,
        dr.deptrequisn_no      
        FROM  pi_master pm 
        LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
        LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
        LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
        LEFT JOIN user u ON(u.id=pm.requested_by) 
        WHERE pm.pi_status>=3 AND pm.review_status=2 $condition
        ORDER BY pm.pi_status ASC, pm.pi_id DESC 
        LIMIT $start,$limit")->result();
      return $result;
  }
  function getpendingPi($pi_status) {
       $condition=' ';
        $department_id=$this->session->userdata('department_id');
        $department_id=$this->session->userdata('department_id');
      if($department_id==6){
        $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=22 OR pm.department_id=6) ";
      }elseif($department_id==15){
         $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=40 OR pm.department_id=41) ";
      }elseif($department_id==9){
        $condition=$condition."  AND (pm.department_id=9) ";
      }elseif($department_id==4){
        $condition=$condition."  AND (pm.department_id=4) ";
      }elseif($department_id==5){
        $condition=$condition."  AND (pm.department_id=5 OR pm.department_id=17 OR pm.department_id=28 OR pm.department_id=29 OR pm.department_id=18 OR pm.department_id=12) ";
      }elseif($department_id==28){
        $condition=$condition."  AND (pm.department_id=28) ";
      }elseif($department_id==19){
        $condition=$condition."  AND (pm.department_id=19) ";
      }elseif($department_id==7){
        $condition=$condition."  AND (pm.department_id=7) ";
      }elseif($department_id==29){
        $condition=$condition."  AND (pm.department_id=29) ";;
      }else{
        $condition=$condition."  AND (pm.department_id=1 OR pm.department_id=2 OR pm.department_id=3 OR pm.department_id=12 OR pm.department_id=16) ";
      }

      $result=$this->db->query("SELECT pm.* 
          FROM  pi_master pm 
          WHERE pm.pi_status=$pi_status $condition
          ORDER BY pm.pi_id DESC")->result();
        return $result;
  }
  function certify($pi_id) {
      $data=array();
      $data['pi_status']=4;
      $data['certified_date']=date('Y-m-d H:i:s');
      $data['certified_by']=$this->session->userdata('user_id');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
  }
   function returns($pi_id) {
      $data=array();
      $data['reject_note']=$this->session->userdata('user_name').":".$this->input->post('reject_note');
      $data['pi_status']=$this->input->post('pi_status');
      $data['certified_date']=date('Y-m-d H:i:s');
      $data['certified_by']=$this->session->userdata('user_id');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->update('pi_master',$data);
      $cdata['comments']=$this->session->userdata('user_name').":".$this->input->post('reject_note');
      $cdata['pi_id']=$pi_id;
      $cdata['date']=date('Y-m-d');
      $cdata['user_name']=$this->session->userdata('user_name');

      $query=$this->db->insert('pi_comment_info',$cdata);

      return $query;
     }

  
}
