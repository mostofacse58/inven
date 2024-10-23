<?php
class Currency_model extends CI_Model {

    function lists() {
        $result=$this->db->query("SELECT * FROM currency_convert_table")->result();
        return $result;
    }
    function get_info($id){
        $result=$this->db->query("SELECT * FROM currency_convert_table WHERE id=$id")->row();
        return $result;
    }
    function save($id) {
        $data=array();
        $data['currency']=strtoupper($this->input->post('currency'));
        $data['in_currency']=strtoupper($this->input->post('in_currency'));
        $data['convert_rate']=$this->input->post('convert_rate');
        $data['update_date']=date('Y-m-d');
        if($id==FALSE){
        $query=$this->db->insert('currency_convert_table',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('currency_convert_table',$data);
        }
        
         return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('currency_convert_table');
        return $query;
  }

  
}
