<?php
class Gatepass_model extends CI_Model {
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
    $data=$this->db->query("SELECT count(*) as counts FROM gatepass_master g
        WHERE g.gatepass_status<8 
        AND g.department_id=$department_id $condition")->row('counts');
    
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
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status<8 
      AND g.department_id=$department_id $condition
      ORDER BY g.gatepass_status ASC,
      g.create_date DESC,g.gatepass_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }
  function get_detail($gatepass_id){
    $result=$this->db->query("SELECT gd.*
      FROM  gatepass_details gd 
      WHERE gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }
  function get_info($gatepass_id){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT g.*,u.user_name as checked_by_name,
      u1.user_name as approved_by_name,i.*,
      d.department_name,u2.user_name,u3.user_name as received_by_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u2 ON(u2.id=g.user_id)
      LEFT JOIN user u ON(u.id=g.checked_by)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      LEFT JOIN user u3 ON(u3.id=g.received_by) 
      WHERE g.gatepass_id=$gatepass_id")->row();
      return $result;
    }
    function save($gatepass_id) {
        $data=array();
        $department_id=$this->session->userdata('department_id');
        $data['employee_id']=$this->input->post('employee_id');
        $data['gatepass_type']=$this->input->post('gatepass_type');
        $data['carried_by']=$this->input->post('carried_by');
        $data['create_date']=alterDateFormat($this->input->post('create_date'));
        $data['vehicle_no']=$this->input->post('vehicle_no');
        $data['container_no']=$this->input->post('container_no');
        $data['issue_from']=$this->input->post('issue_from');
        if($this->input->post('gatepass_type')==1)
        $data['return_date']=alterDateFormat($this->input->post('return_date'));

        $data['wh_whare']=$this->input->post('wh_whare');
        $data['issue_to']=$this->input->post('issue_to');
        if($data['wh_whare']=='F4')
          $data['sub_contract_status']=1;
        $data['create_time']=date('h:i A');
        $data['gatepass_note']=$this->input->post('gatepass_note');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$this->session->userdata('department_id');
        ////////////////////
        if($_FILES['attachment']['name']!=""){
        $config['upload_path'] = './gatepass/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '300000';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("attachment")){
          $upload_info = $this->upload->data();
          $data['attachment']=$upload_info['file_name'];
        }
        }
        
        ///////////////
        if($gatepass_id==FALSE){
          $no_count=$this->db->query("SELECT max(no_count) as counts 
            FROM gatepass_master 
            WHERE 1")->row('counts');
          ////////
          $data['gatepass_no']=str_pad($no_count + 1, 6, '0', STR_PAD_LEFT);
          $data['no_count']=$no_count + 1;
          $query=$this->db->insert('gatepass_master',$data);
          $gatepass_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('gatepass_id',$gatepass_id);
          $query=$this->db->update('gatepass_master',$data);
          
        }
        $this->db->WHERE('gatepass_id',$gatepass_id);
        $this->db->delete('gatepass_details');

        $product_name=$this->input->post('product_name');
        $product_code=$this->input->post('product_code');
        $product_quantity=$this->input->post('product_quantity');
        $unit_name=$this->input->post('unit_name');
        $remarks=$this->input->post('remarks');
        $po_no=$this->input->post('po_no');
        $carton_no=$this->input->post('carton_no');
        $bag_qty=$this->input->post('bag_qty');
        $invoice_no=$this->input->post('invoice_no');
        $i=0;
        $data2['gatepass_id']=$gatepass_id;
        $data2['department_id']=$department_id;
        $data2['gatepass_type']=$data['gatepass_type'];
        foreach ($product_name as $value) {
          $data2['product_name']=$value;
          $data2['product_code']=$product_code[$i];
          $data2['product_quantity']=$product_quantity[$i];
          $data2['unit_name']=$unit_name[$i];
          $data2['po_no']=$po_no[$i];
          $data2['carton_no']=$carton_no[$i];
          $data2['bag_qty']=$bag_qty[$i];
          $data2['invoice_no']=$invoice_no[$i];
          $data2['remarks']=$remarks[$i];
          $query=$this->db->insert('gatepass_details',$data2);
        $i++;
        }
       return $query;
    }
  
    function delete($gatepass_id) {
      $this->db->WHERE('gatepass_id',$gatepass_id);
      $query=$this->db->delete('gatepass_master');
      $this->db->WHERE('gatepass_id',$gatepass_id);
      $query=$this->db->delete('gatepass_details');
      return $query;
  }
  function getProductUnit(){
     $result=$this->db->query("SELECT * FROM product_unit ORDER BY unit_name ASC")->result();
      return $result;
  }
  function getIssueTo(){
    $department_id=$this->session->userdata('department_id');
     $result=$this->db->query("SELECT * FROM issue_to_master 
      WHERE 1
      ORDER BY issue_to_name ASC")->result();
      return $result;
  }
  function getData($data_from,$term) {
    $department_id=$this->session->userdata('department_id');
    //echo $data_from;
    if($data_from==1){
      $result=$this->db->query("SELECT p.*,pd.ventura_code,u.unit_name
          FROM product_info p
          LEFT JOIN product_detail_info pd ON(p.product_id=pd.product_id AND pd.department_id=$department_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          WHERE p.department_id=$department_id 
          AND (p.product_name LIKE '%$term%' 
          OR p.product_code LIKE '%$term%' 
          OR pd.ventura_code LIKE '%$term%' 
          OR pd.asset_encoding LIKE '%$term%')
          ORDER BY p.product_name ASC")->result();
        return $result;
    }else{
      $erpdb = $this->load->database('erpdb', TRUE);
      $data=$erpdb->query("SELECT TOP 200  ITEM_CODE as  product_code,'0' as product_id,
        DES as product_name,UNIT as unit_name
        FROM BD_ITEM_CODE 
        WHERE (ITEM_CODE LIKE '%$term%' OR DES LIKE '%$term%') 
         ")->result();
      return $data;
    }   
  }
  function fsave($gatepass_id) {
        
     // return $query;
    }

  
}
