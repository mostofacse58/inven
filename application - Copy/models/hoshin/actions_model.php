<?php
class Actions_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('team')!=''){
          $team=$this->input->get('team');
          $condition=$condition."  AND p.team='$team' ";
        }
        if($this->input->get('department_id')!=''){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND p.department_id='$department_id' ";
        }
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
        WHERE 1  $condition");
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_GET){
        if($this->input->get('team')!=''){
          $team=$this->input->get('team');
          $condition=$condition."  AND p.team='$team' ";
        }
        if($this->input->get('department_id')!=''){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND p.department_id='$department_id' ";
        }
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
        WHERE 1  $condition
      ORDER BY p.actions_id DESC 
      LIMIT $start,$limit")->result();
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
  function save($actions_id) {
      $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['actions_name']=$this->input->post('actions_name');
      $data['person_name']=$this->input->post('person_name');
      $data['team']=$this->input->post('team');
      $data['departmental_goal']=$this->input->post('departmental_goal');
      $data['category']=$this->input->post('category');
      $data['target_type']=$this->input->post('target_type');
      $data['target']=$this->input->post('target');
      $data['department_id']=$this->input->post('department_id');
     // $data['start_date']=alterDateFormat($this->input->post('start_date'));
      $data['end_date']=alterDateFormat($this->input->post('end_date'));
      //$data['status']=$this->input->post('status');
      $data['user_id']=$this->session->userdata('user_id');
      if($actions_id==FALSE){
        $query=$this->db->insert('actions_table',$data);
        $query=$this->db->insert_id();
      }else{
        $this->db->WHERE('actions_id',$actions_id);
        $query=$this->db->update('actions_table',$data);
      }
    return $query;
  }
  function delete($actions_id) {
    $this->db->WHERE('actions_id',$actions_id);
    $query=$this->db->delete('actions_table');
    return $query;
  }
  function getLists() {
      $department_id=$this->input->post('department_id');
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
      ORDER BY p.actions_id DESC ")->result();
      return $result;
  }
  function saveupdate() {
      $actions_id=$this->input->post('actions_id');
      $person_name=$this->input->post('person_name');
      $achievment=$this->input->post('achievment');
      $target=$this->input->post('target');
      $end_date=$this->input->post('end_date');
      $actions_name=$this->input->post('actions_name');
      $departmental_goal=$this->input->post('departmental_goal');
      $category=$this->input->post('category');
      $i=0;
      $query=false;
      foreach ($actions_id as $value) {
        $data2['departmental_goal']=$departmental_goal[$i];
        $data2['actions_name']=$actions_name[$i];
        $data2['category']=$category[$i];
        $data2['end_date']=alterDateFormat($end_date[$i]);
        $data2['target']=$target[$i];
        $data2['person_name']=$person_name[$i];
        $data2['achievment']=$achievment[$i];
        $this->db->WHERE('actions_id',$value);
        $query=$this->db->update('actions_table',$data2);
        $i++;
      }
     return $query;
  }
  
}
