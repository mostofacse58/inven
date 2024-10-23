<?php
class Supplier_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT c.*
            FROM supplier_info c
            WHERE 1
            ORDER BY c.supplier_id")->result();
        return $result;
    }

    
    function get_info($supplier_id){
        $result=$this->db->query("SELECT * FROM supplier_info 
            WHERE supplier_id=$supplier_id")->row();
        return $result;
    }
    function save($supplier_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $data=array();
        if($_FILES['payment_term_file']['name']!=""){
            $config['upload_path'] = './asset/photo/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = '300000';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("payment_term_file")){
                $upload_info = $this->upload->data();
                $data['payment_term_file']=$upload_info['file_name'];
            }
        }
        if($_FILES['vat_number_file']['name']!=""){
            $config['upload_path'] = './asset/photo/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = '300000';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("vat_number_file")){
                $upload_info = $this->upload->data();
                $data['vat_number_file']=$upload_info['file_name'];
            }
        }
        $data['payment_terms']=$this->input->post('payment_terms');
        $data['vat_number']=$this->input->post('vat_number');
        $data['supplier_name']=$this->input->post('supplier_name');
        $data['phone_no']=$this->input->post('phone_no');
        $data['mobile_no']=$this->input->post('mobile_no');
        $data['email_address']=$this->input->post('email_address');
        $data['company_address']=$this->input->post('company_address');
        $data['department_id']=$this->session->userdata('department_id');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($supplier_id==FALSE){
        $query=$this->db->insert('supplier_info',$data);
        }else{
          $this->db->WHERE('supplier_id',$supplier_id);
          $query=$this->db->update('supplier_info',$data);
        }
       return $query;
     
    }
    function delete($supplier_id) {
        $this->db->WHERE('supplier_id',$supplier_id);
        $query=$this->db->delete('supplier_info');
        return $query;
  }

  
}
