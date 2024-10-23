<?php

class Config_model extends CI_Model {
 public function checkValidUser($email_address, $password) {
        $query=$this->db->query("SELECT u.*,p.* 
        	FROM user u
        	LEFT JOIN post p ON(u.post_id=p.post_id)
        	WHERE u.email_address='$email_address' 
          and  u.password='$password'");
        return $result = $query->row();
    }
	
	
	function userList(){
    $department_id=$this->session->userdata('department_id');
		// if ($this->session->userdata('user_type')!='1'):
            //$data=$this->db->query("SELECT u.*,p.post_name,d.department_name  
            // FROM user u
            // LEFT JOIN post p ON(u.post_id=p.post_id)
            // LEFT JOIN department_info d ON(u.department_id=d.department_id)
            // WHERE u.department_id=$department_id OR u.department_id=0
            // ORDER BY u.id DESC")->result();
            // else:
            $data=$this->db->query("SELECT u.*,p.post_name,d.department_name 
            FROM user u
            LEFT JOIN post p ON(u.post_id=p.post_id)
            LEFT JOIN department_info d ON(u.department_id=d.department_id)
            ORDER BY u.id DESC")->result();
            // endif;
	   
		 return $data;
  }
		 function postList(){
             $data=$this->db->order_by("post_name","asc")->get("post")->result();
		 return $data;
         }

   function  savePost($post_id){
          $data=array();
          $data['post_name']=$this->input->post('post_name');
       
          if($post_id==FALSE){
          $query=$this->db->insert('post',$data);
          }else{
            $this->db->WHERE('post_id',$post_id);
            $query=$this->db->update('post',$data);
          }
          
           return $query;
          }
      public function loggedin() {
        return (bool) $this->session->userdata('loggedinventory');
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
  public function checkValidEmail($email_address) {
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('email_address', $email_address);
    return $result = $this->db->get()->first_row();
  }


   
  
}
?>