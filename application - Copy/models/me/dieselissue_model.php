<?php
class Dieselissue_model extends CI_Model {
    function lists() {
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*,m.motor_name,
          d.fuel_using_dept_name,t.driver_name
          FROM  fuel_issue_master a
          INNER JOIN motor_info m ON(a.motor_id=m.motor_id)
          LEFT JOIN fuel_using_dept d ON(a.fuel_using_dept_id=d.fuel_using_dept_id)
          LEFT JOIN driver_info t ON(a.taken_by=t.driver_id)
          LEFT JOIN user u ON(u.id=a.user_id) 
          WHERE a.department_id=12 
          ORDER BY a.fuel_issue_id DESC")->result();
        return $result;
    }
    
    function get_info($fuel_issue_id){
      $result=$this->db->query("SELECT a.*,m.motor_name,
        d.fuel_using_dept_name,t.driver_name
        FROM  fuel_issue_master a
        INNER JOIN motor_info m ON(a.motor_id=m.motor_id)
        LEFT JOIN fuel_using_dept d ON(a.fuel_using_dept_id=d.fuel_using_dept_id)
        LEFT JOIN driver_info t ON(a.taken_by=t.driver_id)
        LEFT JOIN user u ON(u.id=a.user_id) 
        WHERE a.department_id=12 AND a.fuel_issue_id=$fuel_issue_id")->row();
      return $result;
    }

  function save($fuel_issue_id) {
    $data=array();
    $data['issue_date']=alterDateFormat($this->input->post('issue_date'));
    $data['fuel_using_dept_id']=$this->input->post('fuel_using_dept_id');
    $data['motor_id']=$this->input->post('motor_id');
    $data['fuel_r_start_point_km_liter']=$this->input->post('fuel_r_start_point_km_liter');
    $data['fuel_r_end_point_km_liter']=$this->input->post('fuel_r_end_point_km_liter');
    $data['start_hour']=$this->input->post('start_hour');
    $data['stop_hour']=$this->input->post('stop_hour');
    $data['run_km_liter']=$this->input->post('run_km_liter');
    $data['run_hour']=$this->input->post('run_hour');
    $data['issue_qty']=$this->input->post('issue_qty');
    $data['taken_by']=$this->input->post('taken_by');
    $data['req_no']=$this->input->post('req_no');
    $data['on_officicer_km']=$this->input->post('on_officicer_km');
    $data['product_id']=$this->input->post('product_id');
    $data['unit_price']=$this->input->post('unit_price');
    $data['amount']=$this->input->post('amount');
    $data['notes']=$this->input->post('notes');
    $data['department_id']=12;
    $data['create_date']=date('Y-m-d');
    $data['user_id']=$this->session->userdata('user_id');
    if($fuel_issue_id==FALSE){
    $query=$this->db->insert('fuel_issue_master',$data);
      $fuel_issue_id=$this->db->insert_id();
      $this->look_up_model->storecrud("MINUS",$data['product_id'],$data['issue_qty']);
    }else{
      /////////////// 
      $pre_qty=$this->db->query("SELECT issue_qty FROM fuel_issue_master
        WHERE fuel_issue_id=$fuel_issue_id")->row('issue_qty');
      $this->look_up_model->storecrud("ADD",$data['product_id'],$pre_qty);
      ////////////
      $this->look_up_model->storecrud("MINUS",$data['product_id'],$data['issue_qty']);
      //////////////////////
      $this->db->WHERE('fuel_issue_id',$fuel_issue_id);
      $query=$this->db->update('fuel_issue_master',$data);
    }
    return $fuel_issue_id;
  }

  function delete($fuel_issue_id) {
      $info=$this->db->query("SELECT * FROM fuel_issue_master
        WHERE fuel_issue_id=$fuel_issue_id")->row();
      $this->look_up_model->storecrud("ADD",$info->product_id,$info->issue_qty);
      
      $this->db->WHERE('fuel_issue_id',$fuel_issue_id);
      $query=$this->db->delete('fuel_issue_master');
      return $query;
  }

  function getDropdown($table_name){
    $result=$this->db->query("SELECT * 
      FROM $table_name WHERE 1")->result();
    return $result;
  }
  
}
