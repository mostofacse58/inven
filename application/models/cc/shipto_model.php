<?php
class Shipto_model extends CI_Model {
    function lists(){
        $result=$this->db->query("SELECT m.*
            FROM ship_to_info m
            WHERE 1
            ORDER BY m.ship_id")->result();
        return $result;
    }
    
    function get_info($ship_id){
        $result=$this->db->query("SELECT * FROM ship_to_info 
            WHERE ship_id=$ship_id")->row();
        return $result;
    }
    function save($ship_id=FALSE){
        $data=array();
        $data['ship_name']=$this->input->post('ship_name');
        $data['ship_attention']=$this->input->post('ship_attention');
        $data['ship_telephone']=$this->input->post('ship_telephone');
        $data['ship_email']=$this->input->post('ship_email');
        $data['ship_address']=$this->input->post('ship_address');
        if($ship_id==FALSE){
        $query=$this->db->insert('ship_to_info',$data);
        }else{
          $this->db->WHERE('ship_id',$ship_id);
          $query=$this->db->update('ship_to_info',$data);
        }
       return $query;
     
    }
    function delete($ship_id) {
        $this->db->WHERE('ship_id',$ship_id);
        $query=$this->db->delete('ship_to_info');
        return $query;
  }

  
}
