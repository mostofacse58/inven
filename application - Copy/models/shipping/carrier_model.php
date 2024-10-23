<?php
class Carrier_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT *
            FROM shipping_carrier_info 
            ORDER BY id")->result();
        return $result;
    }

    
    function get_info($id){
        $result=$this->db->query("SELECT * FROM shipping_carrier_info 
            WHERE id=$id ")->row();
        return $result;
    }
    function save($id=FALSE){
        $data=array();
        $data['carrier_name']=$this->input->post('carrier_name');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($id==FALSE){
        $query=$this->db->insert('shipping_carrier_info',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('shipping_carrier_info',$data);
        }
       return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('shipping_carrier_info');
        return $query;
  }

  
}
