<?php
class Materialusing_model extends CI_Model {
   public function get_count(){
    $department_id=$this->session->userdata('department_id');
        $query=$this->db->query("SELECT sm.*,p.product_name,pd.tpm_serial_code,
          m.me_name,fl.line_no,u.user_name,
          (SELECT SUM(sd.quantity) FROM spares_use_detail sd 
          WHERE sm.spares_use_id=sd.spares_use_id) as totalquantity
          FROM  spares_use_master sm 
          LEFT JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
          LEFT JOIN product_info p ON(p.product_id=pd.product_id)
          LEFT JOIN me_info m ON(sm.me_id=m.me_id)
          LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          WHERE sm.department_id=$department_id 
          ORDER BY sm.spares_use_id DESC");
  
 
      $data = count($query->result());
      return $data;
    }

    function lists($limit,$start) {
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*,p.product_name,pd.tpm_serial_code,
          m.me_name,fl.line_no,u.user_name,
          (SELECT SUM(sd.quantity) FROM spares_use_detail sd 
          WHERE sm.spares_use_id=sd.spares_use_id) as totalquantity
          FROM  spares_use_master sm 
          LEFT JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
          LEFT JOIN product_info p ON(p.product_id=pd.product_id)
          LEFT JOIN me_info m ON(sm.me_id=m.me_id)
          LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          WHERE sm.department_id=$department_id 
          ORDER BY sm.spares_use_id DESC LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($spares_use_id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*,p.product_name,p.product_code,
          m.me_name,u.user_name,pd.tpm_serial_code,fl.line_no,
          (SELECT SUM(sd.quantity) FROM spares_use_detail sd WHERE sm.spares_use_id=sd.spares_use_id) as totalquantity
          FROM  spares_use_master sm 
          LEFT JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
          LEFT JOIN product_info p ON(p.product_id=pd.product_id)
          LEFT JOIN me_info m ON(sm.me_id=m.me_id)
          LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          WHERE sm.department_id=$department_id and 
           sm.spares_use_id=$spares_use_id")->row();
        return $result;
    }

   
    function save($spares_use_id) {
        $data=array();
        $department_id=$this->session->userdata('department_id');
        $data['use_type']=$this->input->post('use_type');
        $data['line_id']=$this->input->post('line_id');
        if($this->input->post('use_type')==1){
        $data['product_detail_id']=$this->input->post('product_detail_id');
       }else{
        $data['use_purpose']=$this->input->post('use_purpose');
       }
        $data['me_id']=$this->input->post('me_id');
        $data['other_id']=$this->input->post('other_id');
        $data['requisition_no']=$this->input->post('requisition_no');
        $data['use_date']=alterDateFormat($this->input->post('use_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $product_id=$this->input->post('product_id');
        $quantity=$this->input->post('quantity');
        $i=0;

        if($spares_use_id==FALSE){
          $using_ref_no=$this->db->query("SELECT MAX(spares_use_id) as using_ref_no
             FROM spares_use_master WHERE department_id=$department_id")->row('using_ref_no');
          $using_ref_no ='ME'.str_pad($using_ref_no + 1, 6, '0', STR_PAD_LEFT);
          $data['using_ref_no']=$using_ref_no;

          $query=$this->db->insert('spares_use_master',$data);
          $spares_use_id=$this->db->insert_id();
        foreach ($product_id as $value) {
             $data1['product_id']=$value;
             $data1['spares_use_id']=$spares_use_id;
             $data1['quantity']=$quantity[$i];
             $data1['user_id']=$this->session->userdata('user_id');
             $query=$this->db->insert('spares_use_detail',$data1);
             $i++;
           }
        }else{
          $this->db->WHERE('spares_use_id',$spares_use_id);
          $query=$this->db->update('spares_use_master',$data);
          $this->db->WHERE('spares_use_id',$spares_use_id);
          $this->db->delete('spares_use_detail',$data);
          foreach ($product_id as $value) {
             $data1['product_id']=$value;
             $data1['spares_use_id']=$spares_use_id;
             $data1['quantity']=$quantity[$i];
             $data1['user_id']=$this->session->userdata('user_id');
             $query=$this->db->insert('spares_use_detail',$data1);
             $i++;
           }
        } 
        return $query;
    }
  
    function delete($spares_use_id) {
        $this->db->WHERE('spares_use_id',$spares_use_id);
        $query=$this->db->delete('spares_use_detail');
        $this->db->WHERE('spares_use_id',$spares_use_id);
        $query=$this->db->delete('spares_use_master');
        return $query;
  }
  public function getDetails($spares_use_id=''){
   $result=$this->db->query("SELECT sd.*,p.*,c.category_name,u.unit_name,m.mtype_name
        FROM spares_use_detail sd
        INNER JOIN product_info p ON(sd.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
        WHERE sd.spares_use_id=$spares_use_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  
    
  
}
