<?php
class Laptop_model extends CI_Model {
    function lists(){
        $result=$this->db->query("SELECT l.*,e.employee_name,e.employee_no,e.department_name,b.brand_name
            FROM laptop_info l
            INNER JOIN employee_info e ON(e.employee_id=l.employee_id)
            INNER JOIN brand_info b ON(b.brand_id=l.brand_id)
            WHERE 1
            ORDER BY l.laptop_id")->result();
        return $result;
    }
    
    function get_info($laptop_id){
        $result=$this->db->query("SELECT l.*,e.employee_name,e.department_name,b.brand_name
            FROM laptop_info l
            INNER JOIN employee_info e ON(e.employee_id=l.employee_id)
            INNER JOIN brand_info b ON(b.brand_id=l.brand_id)
            WHERE l.laptop_id=$laptop_id")->row();
        return $result;
    }
    function save($laptop_id=FALSE){
        $data=array();
        $data['employee_id']=$this->input->post('employee_id');
        $data['brand_id']=$this->input->post('brand_id');
        $data['sn_no']=$this->input->post('sn_no');
        $data['user_no']=$this->input->post('user_no');
        if($laptop_id==FALSE){
        $query=$this->db->insert('laptop_info',$data);
        }else{
          $this->db->WHERE('laptop_id',$laptop_id);
          $query=$this->db->update('laptop_info',$data);
        }
       return $query;
     
    }
    function delete($laptop_id) {
        $this->db->WHERE('laptop_id',$laptop_id);
        $query=$this->db->delete('laptop_info');
        return $query;
    }
    function getTableInfo($table_name){
        $result=$this->db->query("SELECT * FROM $table_name")->result();
        return $result;
    }

  
}
