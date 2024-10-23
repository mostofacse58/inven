<?php
class Box_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT b.*,r.rack_name
            FROM box_info b,rack_info r
            WHERE b.rack_id=r.rack_id AND  b.department_id=$department_id
            ORDER BY b.box_id")->result();
        return $result;
    }

    
    function get_info($box_id){
        $result=$this->db->query("SELECT * FROM box_info 
            WHERE box_id=$box_id")->row();
        return $result;
    }
    function save($box_id=FALSE){
        $data=array();
        $data['box_name']=$this->input->post('box_name');
        $data['rack_id']=$this->input->post('rack_id');
        $data['department_id']=$this->session->userdata('department_id');
        if($box_id==FALSE){
        $query=$this->db->insert('box_info',$data);
        }else{
          $this->db->WHERE('box_id',$box_id);
          $query=$this->db->update('box_info',$data);
        }
       return $query;
     
    }
    function delete($box_id) {
        $this->db->WHERE('box_id',$box_id);
        $query=$this->db->delete('box_info');
        return $query;
  }

  
}
