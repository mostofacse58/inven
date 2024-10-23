<?php
class Stockin_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
        if($this->input->get('status')!='All'){
          $status=$this->input->get('status');
          $condition=$condition."  AND p.in_status='$status' ";
        }
        if($this->input->get('location')!=''){
          $location=$this->input->get('location');
          $condition=$condition."  AND p.location='$location' ";
        }
        if($this->input->get('barcode_no')!=''){
          $barcode_no=$this->input->get('barcode_no');
          $condition=$condition."  AND p.barcode_no LIKE '%$barcode_no%' ";
        }
        if($this->input->get('po_no')!=''){
          $po_no=$this->input->get('po_no');
          $condition=$condition."  AND p.po_no LIKE '%$po_no%' ";
        }
        if($this->input->get('export_invoice_no')!=''){
          $export_invoice_no=$this->input->get('export_invoice_no');
          $condition=$condition."  AND p.export_invoice_no LIKE '%$export_invoice_no%' ";
        }
      }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM stock_in_master p
        WHERE 1  $condition");
      $data = count($query->result());
      return $data;
    }

    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_GET){
        if($this->input->get('status')!='All'){
          $status=$this->input->get('status');
          $condition=$condition."  AND p.in_status='$status' ";
        }
        if($this->input->get('location')!=''){
          $location=$this->input->get('location');
          $condition=$condition."  AND p.location='$location' ";
        }
        if($this->input->get('barcode_no')!=''){
          $barcode_no=$this->input->get('barcode_no');
          $condition=$condition."  AND p.barcode_no LIKE '%$barcode_no%' ";
        }
        if($this->input->get('po_no')!=''){
          $po_no=$this->input->get('po_no');
          $condition=$condition."  AND p.po_no LIKE '%$po_no%' ";
        }
        if($this->input->get('export_invoice_no')!=''){
          $export_invoice_no=$this->input->get('export_invoice_no');
          $condition=$condition."  AND p.export_invoice_no LIKE '%$export_invoice_no%' ";
        }
      }
      $result=$this->db->query("SELECT p.*,
        u.user_name
        FROM  stock_in_master p
        LEFT JOIN user u ON(u.id=p.user_id) 
        WHERE 1 $condition
        ORDER BY p.id DESC LIMIT $start,$limit")->result();
      return $result;
    }
    function waiting(){
      $result=$this->db->query("SELECT count(id) as waiting
        FROM  stock_in_master p
        WHERE in_status=1 ")->row('waiting');
      return $result;
    }
    function total(){
      $result=$this->db->query("SELECT count(id) as total
        FROM  stock_in_master p
        WHERE 1 ")->row('total');
      return $result;
    }
    function alreadyIn(){
      $result=$this->db->query("SELECT count(id) as alreadyIn
        FROM  stock_in_master p
        WHERE in_status=2 ")->row('alreadyIn');
      return $result;
    }
    function waitingInv($export_invoice_no){
      $result=$this->db->query("SELECT count(id) as waiting
        FROM  stock_in_master p
        WHERE in_status=1 AND export_invoice_no='$export_invoice_no' ")->row('waiting');
      return $result;
    }
    function alreadyInv($export_invoice_no){
      $result=$this->db->query("SELECT count(id) as alreadyIn
        FROM  stock_in_master p
        WHERE in_status=2  AND export_invoice_no='$export_invoice_no' ")->row('alreadyIn');
      return $result;
    }
    function getGroupByInvoice(){
      $result=$this->db->query("SELECT p.export_invoice_no,p.in_status,
        (SELECT count(s.id) as pendingqty FROM stock_in_master s 
        WHERE s.export_invoice_no=p.export_invoice_no AND s.in_status=1) as pendingqty,
        (SELECT count(s1.id) as inqty FROM stock_in_master s1 
        WHERE s1.export_invoice_no=p.export_invoice_no AND s1.in_status=2) as inqty
        FROM  stock_in_master p
        WHERE 1 
        GROUP BY p.export_invoice_no")->result();
      return $result;
    }
    function getGroupByPo($export_invoice_no){
      $result=$this->db->query("SELECT p.po_no,p.in_status,
        (SELECT count(s.id) as pendingqty FROM stock_in_master s 
        WHERE s.po_no=p.po_no AND s.in_status=1 AND s.export_invoice_no='$export_invoice_no') as pendingqty,
        (SELECT count(s1.id) as inqty FROM stock_in_master s1 
        WHERE s1.po_no=p.po_no AND s1.in_status=2 AND s1.export_invoice_no='$export_invoice_no') as inqty
        FROM  stock_in_master p
        WHERE export_invoice_no='$export_invoice_no' 
        GROUP BY p.po_no")->result();
      return $result;
    }
    function get_info($id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*
          FROM  stock_in_master p
          WHERE  p.id=$id")->row();
        return $result;
    }
   
    function save($id) {
        $department_id=$this->session->userdata('department_id');
        $data['po_no']=$this->input->post('po_no');
        $data['customer']=$this->input->post('customer');
        $data['file_no']=$this->input->post('file_no');
        $data['carton_no']=$this->input->post('carton_no');
        $data['bag_qty']=$this->input->post('bag_qty');
        $data['factory_style']=$this->input->post('factory_style');
        $data['customer_syle']=$this->input->post('customer_syle');
        $data['color']=$this->input->post('color');
        $data['barcode_no']=$this->input->post('barcode_no');
        $data['export_invoice_no']=$this->input->post('export_invoice_no');
        $data['department_id']=$department_id;
        $data['create_date']=date('Y-m-d');
        $data['location']=$this->input->post('location');
        $data['user_id']=$this->session->userdata('user_id');
        if($id==FALSE){
        $query=$this->db->insert('stock_in_master',$data);
          $id=$this->db->insert_id();
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('stock_in_master',$data);
        }
      return $id;
    }

    function getLocation(){
     $data = $this->db->query("SELECT * FROM stock_location 
      WHERE  1")->result();
     return $data ;
  }
  
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('stock_in_master');
        return $query;
    }




  
}
