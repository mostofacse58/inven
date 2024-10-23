<?php
class Daction_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
        if($this->input->get('person_name')!=''){
          $person_name=$this->input->get('person_name');
          $condition=$condition."  AND p.person_name='$person_name' ";
        }
        if($this->input->get('departmental_goal')!=''){
          $departmental_goal=$this->input->get('departmental_goal');
          $condition=$condition."  AND p.departmental_goal LIKE '%$departmental_goal%'  ";
        }
        if($this->input->get('actions_name')!=''){
          $actions_name=$this->input->get('actions_name');
          $condition=$condition."  AND p.actions_name LIKE '%$actions_name%'  ";
        }
        if($this->input->get('end_date')!=''){
          $end_date=$this->input->get('end_date');
          $condition=$condition."  AND p.end_date LIKE '$end_date%'  ";
        }
      }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT p.*,d.department_name 
        FROM actions_table p
        LEFT JOIN department_info d ON(p.department_id=d.department_id)
        WHERE p.department_id=$department_id  $condition");
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_GET){
        if($this->input->get('person_name')!=''){
          $person_name=$this->input->get('person_name');
          $condition=$condition."  AND p.person_name='$person_name' ";
        }
        if($this->input->get('departmental_goal')!=''){
          $departmental_goal=$this->input->get('departmental_goal');
          $condition=$condition."  AND p.departmental_goal LIKE '%$departmental_goal%'  ";
        }
        if($this->input->get('actions_name')!=''){
          $actions_name=$this->input->get('actions_name');
          $condition=$condition."  AND p.actions_name LIKE '%$actions_name%'  ";
        }
        if($this->input->get('end_date')!=''){
          $end_date=$this->input->get('end_date');
          $condition=$condition."  AND p.end_date LIKE '$end_date%'  ";
        }
      }
    $result=$this->db->query("SELECT p.*,d.department_name 
        FROM actions_table p
        LEFT JOIN department_info d ON (p.department_id=d.department_id)
        WHERE p.department_id=$department_id  $condition
      ORDER BY p.actions_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }
  function getLists() {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_POST){
        if($this->input->post('person_name')!=''){
          $person_name=$this->input->post('person_name');
          $condition=$condition."  AND p.person_name='$person_name' ";
        }
        if($this->input->post('category')!=''){
          $category=$this->input->post('category');
          $condition=$condition."  AND p.category ='$category' ";
        }
        if($this->input->post('departmental_goal')!=''){
          $departmental_goal=$this->input->post('departmental_goal');
          $condition=$condition."  AND p.departmental_goal LIKE '%$departmental_goal%'  ";
        }
        if($this->input->post('month')!=''){
          $month=$this->input->post('month');
          $condition=$condition."  AND p.end_date LIKE '$month%' ";
        }
      }
    $result=$this->db->query("SELECT p.*,d.department_name 
        FROM actions_table p
        LEFT JOIN department_info d ON (p.department_id=d.department_id)
        WHERE p.department_id=$department_id  
        $condition
      ORDER BY p.actions_id DESC
      LIMIT 0, 50 ")->result();
      return $result;
  }
  ///////////
  function get_info($actions_id){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT p.*,d.department_name 
      FROM actions_table p
      LEFT JOIN department_info d ON(p.department_id=p.department_id)
      WHERE p.actions_id=$actions_id")->row();
      return $result;
  }
  function save() {
      $actions_id=$this->input->post('actions_id');
      $person_name=$this->input->post('person_name');
      $achievment=$this->input->post('achievment');
      $actions_name=$this->input->post('actions_name');
      $i=0;
      $query=false;
      foreach ($actions_id as $value) {
        $data2['person_name']=$person_name[$i];
        $data2['achievment']=$achievment[$i];
        $data2['actions_name']=$actions_name[$i];
        $this->db->WHERE('actions_id',$value);
        $query=$this->db->update('actions_table',$data2);
        $i++;
      }
     return $query;
  }

  
}
