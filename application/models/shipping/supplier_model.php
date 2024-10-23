<?php
class Supplier_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT *
            FROM shipping_supplier_info 
            ORDER BY id")->result();
        return $result;
    }

    
    function get_info($id){
        $result=$this->db->query("SELECT * FROM shipping_supplier_info 
            WHERE id=$id ")->row();
        return $result;
    }
    function save($id=FALSE){
        
        $data=array();
        $data['supplier_name']=$this->input->post('supplier_name');
        $data['description']=$this->input->post('description');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($id==FALSE){
        $query=$this->db->insert('shipping_supplier_info',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('shipping_supplier_info',$data);
        }
       return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('shipping_supplier_info');
        return $query;
  }

  
}
