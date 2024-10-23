<?php
class Customer_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT *
            FROM shipping_customer_info 
            ORDER BY id")->result();
        return $result;
    }

    
    function get_info($id){
        $result=$this->db->query("SELECT * FROM shipping_customer_info 
            WHERE id=$id ")->row();
        return $result;
    }
    function save($id=FALSE){
        
        $data=array();
        $data['customer_name']=$this->input->post('customer_name');
        $data['address']=$this->input->post('address');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($id==FALSE){
        $query=$this->db->insert('shipping_customer_info',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('shipping_customer_info',$data);
        }
       return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('shipping_customer_info');
        return $query;
  }

  
}
