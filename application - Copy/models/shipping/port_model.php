<?php
class Port_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT *
            FROM shipping_supplier_port 
            ORDER BY id")->result();
        return $result;
    }

    
    function get_info($id){
        $result=$this->db->query("SELECT * FROM shipping_supplier_port 
            WHERE id=$id ")->row();
        return $result;
    }
    function save($id=FALSE){
        
        $data=array();
        $data['port_of_loading']=$this->input->post('port_of_loading');
        $data['supplier_name2']=$this->input->post('supplier_name2');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($id==FALSE){
        $query=$this->db->insert('shipping_supplier_port',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('shipping_supplier_port',$data);
        }
       return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('shipping_supplier_port');
        return $query;
  }

  
}
