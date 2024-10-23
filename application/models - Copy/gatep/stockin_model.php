<?php
class Stockin_model extends CI_Model {
  function __construct(){
    parent::__construct();
    //$msdb = $this->load->database('msdb', TRUE);
 }
  public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $query=$this->db->query("SELECT * FROM gatepass_master_stock g
        WHERE g.gatepass_status<7 AND g.department_id=$department_id $condition");
    $data = count($query->result());
    return $data;
  }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,d.department_name
      FROM  gatepass_master_stock g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status<7 AND g.department_id=$department_id $condition
      ORDER BY g.gatepass_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }
  function get_detail($gatepass_id){
    $result=$this->db->query("SELECT gd.*
      FROM  gatepass_details_stock gd 
      WHERE gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }
  function get_info($gatepass_id){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT g.*,u.user_name as checked_by_name,
      u1.user_name as approved_by_name,d.department_name
      FROM  gatepass_master_stock g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.checked_by)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_id=$gatepass_id")->row();
      return $result;
    }
    function save($gatepass_id) {
        $data=array();
        $department_id=$this->session->userdata('department_id');
        $data['employee_id']=$this->input->post('employee_id');
        $data['carried_by']=$this->input->post('carried_by');
        $data['create_date']=alterDateFormat($this->input->post('create_date'));
        $data['wh_whare']=$this->input->post('wh_whare');
        $data['create_time']=date('h:i A');
        $data['gatepass_note']=$this->input->post('gatepass_note');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$this->session->userdata('department_id');
        if($gatepass_id==FALSE){
          $no_count=$this->db->query("SELECT max(no_count) as counts FROM gatepass_master_stock 
          WHERE department_id=$department_id")->row('counts');
          $data['gatepass_no']='IN'.str_pad($no_count + 1, 6, '0', STR_PAD_LEFT);
          $data['no_count']=$no_count + 1;
          $query=$this->db->insert('gatepass_master_stock',$data);
          $gatepass_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('gatepass_id',$gatepass_id);
          $query=$this->db->update('gatepass_master_stock',$data);
          
        }
        $this->db->WHERE('gatepass_id',$gatepass_id);
        $this->db->delete('gatepass_details_stock');

        $product_name=$this->input->post('product_name');
        $product_code=$this->input->post('product_code');
        $product_quantity=$this->input->post('product_quantity');
        $unit_name=$this->input->post('unit_name');
        $remarks=$this->input->post('remarks');
        $i=0;
        $data2['gatepass_id']=$gatepass_id;
        $data2['department_id']=$department_id;
        foreach ($product_name as $value) {
          $data2['product_name']=$value;
          $data2['product_code']=$product_code[$i];
          $data2['product_quantity']=$product_quantity[$i];
          $data2['unit_name']=$unit_name[$i];
          $data2['remarks']=$remarks[$i];
          $query=$this->db->insert('gatepass_details_stock',$data2);
        $i++;
        }
       return $query;
    }
  
    function delete($gatepass_id) {
      $this->db->WHERE('gatepass_id',$gatepass_id);
      $query=$this->db->delete('gatepass_master_stock');
      $this->db->WHERE('gatepass_id',$gatepass_id);
      $query=$this->db->delete('gatepass_details_stock');
      return $query;
  }


  function getData($term) {
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT p.*
          FROM gatepass_details p
          WHERE p.department_id=$department_id  AND gatepass_type=4
          AND p.product_name LIKE '%$term%'
          GROUP BY p.product_code
          ORDER BY p.product_name ASC")->result();
        return $result;
    }

  
}
