<?php
class Gatepass_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
      
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT sim.* FROM gatepass_costing sim
        INNER JOIN product_detail_info pd ON(sim.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        LEFT JOIN department_info d ON(d.department_id=sim.for_department_id)
        WHERE sim.department_id=$department_id $condition");
      $data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
      if($this->input->get('location_name')!=''){
        $location_name=$this->input->get('location_name');
        $condition=$condition."  AND sim.location_name='$location_name' ";
      }
     }
     $result=$this->db->query("SELECT sim.*,pd.*,p.product_name,p.product_code
      FROM gatepass_costing sim
      INNER JOIN product_detail_info pd ON(sim.product_detail_id=pd.product_detail_id)
      INNER JOIN product_info p ON(p.product_id=pd.product_id)
      LEFT JOIN department_info d ON(d.department_id=sim.for_department_id)
      LEFT JOIN user u ON(u.id=sim.user_id) 
      WHERE  sim.department_id=$department_id  
      $condition
      ORDER BY sim.gatepass_id DESC LIMIT $start,$limit")->result();
    return $result;
  }
  function get_info($gatepass_id){
      $result=$this->db->query("SELECT sim.*,p.product_name,p.product_code,
        c.category_name
        FROM gatepass_costing sim
        INNER JOIN product_detail_info pd ON(sim.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN user u ON(u.id=sim.user_id) 
        WHERE 1 AND sim.gatepass_id=$gatepass_id")->row();
      return $result;
  }

  function save($gatepass_id) {
    $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['department_id']=$department_id;
      $data['for_department_id']=$this->input->post('for_department_id');
      $data['employee_id']=$this->input->post('employee_id');
      $data['product_detail_id']=$this->input->post('product_detail_id');
      $data['location_name']=$this->input->post('location_name');
      $data['servicing_date']=alterDateFormat($this->input->post('servicing_date'));
      $data['problem_details']=$this->input->post('problem_details');
      $data['reference_no']=$this->input->post('reference_no');
      $data['out_quantity']=$this->input->post('out_quantity');
      $data['issuer_to_name']=$this->input->post('issuer_to_name');
      $data['user_id']=$this->session->userdata('user_id');
      $data['service_details']=$this->input->post('service_details');
      $data['servicing_cost']=$this->input->post('servicing_cost');
      $data['servicing_type']=$this->input->post('servicing_type');
      if($gatepass_id==FALSE){
        $query=$this->db->insert('gatepass_costing',$data);
        ///////////////////////
      }else{
        $this->db->WHERE('gatepass_id',$gatepass_id);
        $query=$this->db->update('gatepass_costing',$data);
      }
    return $query;
  }
 
  
  function delete($gatepass_id) {
      $this->db->WHERE('gatepass_id',$gatepass_id);
      $query=$this->db->delete('gatepass_costing');
      return $query;
  }
  

  
}
