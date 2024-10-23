<?php
class Floorline_model extends CI_Model {

    function lists(){
        $result=$this->db->query("SELECT r.*,f.floor_no
            FROM floorline_info r,floor_info f 
            WHERE r.floor_id=f.floor_id 
            ORDER BY line_id")->result();
        return $result;
    }

    function flists(){
        $result=$this->db->query("SELECT * FROM floor_info")->result();
        return $result;
    }
    function get_info($line_id){
        $result=$this->db->query("SELECT * FROM floorline_info 
            WHERE line_id=$line_id")->row();
        return $result;
    }
    function save($line_id=FALSE){
        $data=array();
        $data['floor_id']=$this->input->post('floor_id');
        $data['line_no']=strtoupper($this->input->post('line_no'));
        if($line_id==FALSE){
        $query=$this->db->insert('floorline_info',$data);
        }else{
          $this->db->WHERE('line_id',$line_id);
          $query=$this->db->update('floorline_info',$data);
        }
       return $query;
     
    }
    function delete($line_id) {
        $this->db->WHERE('line_id',$line_id);
        $query=$this->db->delete('floorline_info');
        return $query;
  }

  
}
