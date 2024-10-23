<?php

class Login_model extends CI_Model {
 public function checkValidUser($email_address, $password) {
    $password=md5($password);
    $email_address=strtolower($email_address);
    $result=$this->db->query("SELECT u.*,o.org_name,p.post_name,
      d.department_name,d.stock_holder,d.dept_shortcode
      FROM user u 
      LEFT JOIN org_info o ON(u.org_id=o.org_id) 
      LEFT JOIN post p ON(u.post_id=p.post_id)
      LEFT JOIN department_info d ON(u.department_id=d.department_id)
      WHERE  1 and 
      u.email_address='$email_address' and u.password='$password'")->row();
      return $result;
  } 
  public function trycheck($email_address) {
    $email_address=strtolower($email_address);
    $result=$this->db->query("SELECT u.*
      FROM user u 
      WHERE  u.email_address='$email_address'")->row();
      return $result;
  } 

   public function checkValidEmail($email_address) {
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('email_address', $email_address);
    return $result = $this->db->get()->first_row();
  }
  public function loggedin() {
        return (bool) $this->session->userdata('loggedin');
    }

  public function getAllCompanyInformation(){
    $this->db->select();
    $this->db->from("company");
    return $this->db->get()->result();
  }
  public function updateCompanyInformation($company_info){
    //$this->db->set($company_info);
    $this->db->update("company",$company_info);
  }
  
   public function updateEmail($company_email){
    
    $this->db->update("user",$company_email);
  }

   public function select_user_roll_by_employee_id($user_id) {
        $this->db->select('sys_user_role.*', FALSE);
        $this->db->select('sys_menu.*', FALSE);
        $this->db->from('sys_user_role');
        $this->db->join('sys_menu','sys_user_role.menu_id=sys_menu.menu_id', 'left');
        $this->db->where('sys_user_role.user_id', $user_id);
        $query_result = $this->db->get();
        $result = $query_result->result();        
        return $result;
    }
  public function get_user_info($user_id){
   $result=$this->db->query("SELECT * FROM user WHERE id=$user_id")->row();
   return $result;
  }
   function saverequisition($photo){
        $data=array();
        $data['employee_name']=$this->input->post('employee_name');
        $data['employee_card_id']=$this->input->post('employee_card_id');
        $data['post_id']=$this->input->post('post_id');
        $data['joining_date']=alterDateFormat($this->input->post('joining_date'));
        $data['department_id']=$this->input->post('department_id');
        $data['per_mobile_no']=$this->input->post('per_mobile_no');
        $data['email_address']=$this->input->post('email_address');
        $data['photo']=$photo;
        $query=$this->db->insert('sim_management',$data);
        return $query;
      }

  
}
?>