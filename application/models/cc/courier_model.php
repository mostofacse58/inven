<?php
class Courier_model extends CI_Model {
  function __construct(){
    parent::__construct();
    //$msdb = $this->load->database('msdb', TRUE);
 }
  public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND g.requisition_no LIKE '%$requisition_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $query=$this->db->query("SELECT * FROM courier_master g
        WHERE g.courier_status<7 AND 
        g.department_id=$department_id $condition");
    $data = count($query->result());
    return $data;
  }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('requisition_no')!=''){
      $requisition_no=$this->input->get('requisition_no');
      $condition=$condition."  AND g.requisition_no LIKE '%$requisition_no%' ";
      }
    }
    
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by_name,i.*,d.department_name
      FROM  courier_master g 
      LEFT JOIN  chargeback_info i ON(g.chargeback_id=i.chargeback_id)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.prepared_by)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.courier_status<7 AND g.department_id=$department_id $condition
      ORDER BY g.courier_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }
  function get_detail($courier_id){
    $result=$this->db->query("SELECT gd.*
      FROM  courier_detail gd 
      WHERE gd.courier_id=$courier_id")->result();
    return $result;
  }
  function get_info($courier_id){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT g.*,u.user_name,
      u1.user_name as approved_by_name,s.ship_name,
      i.*,d.department_name,u2.user_name  as received_by_name
      FROM  courier_master g 
      LEFT JOIN  chargeback_info i ON(g.chargeback_id=i.chargeback_id)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN  ship_to_info s ON(g.ship_id=s.ship_id)
      LEFT JOIN user u ON(u.id=g.prepared_by)
      LEFT JOIN user u2 ON(u2.id=g.received_by)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.courier_id=$courier_id")->row();
      return $result;
    }
    function save($courier_id) {
        $data=array();
        $department_id=$this->session->userdata('department_id');
        $data['issuer']=$this->input->post('issuer');
        $data['authorised_by']=$this->input->post('authorised_by');
        $data['issue_date']=alterDateFormat($this->input->post('issue_date'));
        $data['shipper_name']=$this->input->post('shipper_name');
        $data['ship_id']=$this->input->post('ship_id');
        $data['ship_name']=$this->input->post('ship_name');
        $data['ship_address']=$this->input->post('ship_address');
        $data['shipper_address']=$this->input->post('shipper_address');
        $data['ship_attention']=$this->input->post('ship_attention');
        $data['shipper_attention']=$this->input->post('shipper_attention');
        $data['ship_telephone']=$this->input->post('ship_telephone');
        $data['shipper_telephone']=$this->input->post('shipper_telephone');
        $data['ship_email']=$this->input->post('ship_email');
        $data['shipper_email']=$this->input->post('shipper_email');
        $data['chargeback_id']=$this->input->post('chargeback_id');
        $data['account_no_vlmbd']=$this->input->post('account_no_vlmbd');
        $data['account_name']=$this->input->post('account_name');
        $data['demand_eta']=alterDateFormat($this->input->post('demand_eta'));
        $data['shipping_mode']=$this->input->post('shipping_mode');
        $data['payment_method']=$this->input->post('payment_method');
        $data['total_amount']=$this->input->post('total_amount');
        $data['prepared_by']=$this->session->userdata('user_id');
        $data['department_id']=$this->session->userdata('department_id');
        ////////////////////
         if($_FILES['attachment']['name']!=""){
        $config['upload_path'] = './gatepass/';
        $config['allowed_types'] = 'pdf|PDF|xlsx|xls|jpg|jpeg';
        $config['max_size'] = '300000';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("attachment")){
          $upload_info = $this->upload->data();
          $data['attachment']=$upload_info['file_name'];
        }}
        ///////////////
        if($courier_id==FALSE){
          $no_count=$this->db->query("SELECT max(courier_id) as counts 
            FROM courier_master 
          WHERE 1")->row('counts');
          $data['requisition_no']='C'.str_pad($no_count + 1, 6, '0', STR_PAD_LEFT);
          $query=$this->db->insert('courier_master',$data);
          $courier_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('courier_id',$courier_id);
          $query=$this->db->update('courier_master',$data);
          
        }
        $this->db->WHERE('courier_id',$courier_id);
        $this->db->delete('courier_detail');

        $particulars=$this->input->post('particulars');
        $unit_price=$this->input->post('unit_price');
        $quantity=$this->input->post('quantity');
        $unit_name=$this->input->post('unit_name');
        $amount=$this->input->post('amount');
        $weight=$this->input->post('weight');
        $vol_weight=$this->input->post('vol_weight');
        $length=$this->input->post('length');
        $width=$this->input->post('width');
        $height=$this->input->post('height');
        $i=0;
        $data2['courier_id']=$courier_id;
        $data2['department_id']=$department_id;
        foreach ($particulars as $value) {
          $data2['particulars']=$value;
          $data2['unit_price']=$unit_price[$i];
          $data2['quantity']=$quantity[$i];
          $data2['unit_name']=$unit_name[$i];
          $data2['weight']=$weight[$i];
          $data2['length']=$length[$i];
          $data2['width']=$width[$i];
          $data2['height']=$height[$i];
          $data2['vol_weight']=$vol_weight[$i];
          $data2['amount']=$amount[$i];
          $query=$this->db->insert('courier_detail',$data2);
        $i++;
        }
       return $query;
    }
  
    function delete($courier_id) {
      $this->db->WHERE('courier_id',$courier_id);
      $query=$this->db->delete('courier_master');
      $this->db->WHERE('courier_id',$courier_id);
      $query=$this->db->delete('courier_detail');
      return $query;
  }

  function Userlists(){
     $result=$this->db->query("SELECT u.* FROM user u,post p
      WHERE p.post_id=u.post_id AND p.post_lavel='Director' AND u.status='ACTIVE'
      ORDER BY u.user_name ASC")->result();
      return $result;
  }
  function ShipTolists(){
     $result=$this->db->query("SELECT * FROM ship_to_info
      ORDER BY ship_name ASC")->result();
      return $result;
  }
 


  
}
