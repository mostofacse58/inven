<?php
class Rfq_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('rfq_no')!=''){
        $rfq_no=$this->input->get('rfq_no');
        $condition=$condition."  AND pm.rfq_no='$rfq_no' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' ) ";
      }
      if($this->input->get('rfi_no')!=''){
        $rfi_no=$this->input->get('rfi_no');
        $condition=$condition."  AND pm.rfi_no='$rfi_no' ";
      }
      if($this->input->get('rfi_no')!=''){
        $rfi_no=$this->input->get('rfi_no');
        $condition=$condition."  AND pmd.rfi_no='$rfi_no' ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
        $condition=$condition."  AND pm.for_department_id=$for_department_id ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id=$supplier_id ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.rfq_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
     if($this->input->get('product_code')!=''||$this->input->get('rfi_no')!=''){
        $query=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name      
          FROM  rfq_master pm 
          INNER JOIN rfq_detail pmd ON(pm.rfq_id=pmd.rfq_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.department_id=$department_id  
          AND pm.status!=5 
          
          $condition
          GROUP BY pm.rfq_id")->result();
     }else{
        $query=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name      
          FROM  rfq_master pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.status!=5 
          AND  pm.department_id=$department_id 
       
          $condition")->result();
         }
     $data = count($query);
     return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('rfq_no')!=''){
        $rfq_no=$this->input->get('rfq_no');
        $condition=$condition."  AND pm.rfq_no='$rfq_no' ";
      }
      if($this->input->get('rfi_no')!=''){
        $rfi_no=$this->input->get('rfi_no');
        $condition=$condition."  AND pm.rfi_no='$rfi_no' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%') ";
      }
      if($this->input->get('rfi_no')!=''){
        $rfi_no=$this->input->get('rfi_no');
        $condition=$condition."  AND pmd.rfi_no='$rfi_no' ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
        $condition=$condition."  AND pm.for_department_id=$for_department_id ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id=$supplier_id ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.rfq_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $department_id=$this->session->userdata('department_id');
    if($this->input->get('product_code')!=''||$this->input->get('rfi_no')!=''){
      $result=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name,s.company_name      
          FROM  rfq_master pm 
          INNER JOIN rfq_detail pmd ON(pm.rfq_id=pmd.rfq_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE  pm.status!=5  AND  pm.department_id=$department_id 
          $condition
        GROUP BY pm.rfq_id
        ORDER BY pm.rfq_id DESC 
        LIMIT $start,$limit")->result();
     }else{
      $result=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name,s.company_name      
          FROM  rfq_master pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.status!=5 AND  pm.department_id=$department_id 
          $condition
        ORDER BY pm.rfq_id DESC 
        LIMIT $start,$limit")->result();
       }
      return $result;
    }
    function get_info($rfq_id){
         $result=$this->db->query("SELECT pm.*,s.supplier_name,
          u.user_name,u1.user_name as received_by_name,d.department_name,
          (SELECT SUM(pud.quantity) FROM rfq_detail pud 
          WHERE pm.rfq_id=pud.rfq_id) as totalquantity
          FROM  rfq_master pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          LEFT JOIN user u1 ON(u1.id=pm.received_by) 
          WHERE pm.rfq_id=$rfq_id")->row();
        return $result;
    }
    function save($rfq_id) {
        $hkdrate=getHKDRate($this->input->post('currency'));
        ////////////////////////////////////////////////////
        $department_id=$this->session->userdata('department_id');
        $data=array();
        if($_FILES['attachment']['name']!=""){
        $config['upload_path'] = './rfq/';
        $config['allowed_types'] = 'pdf|docx|doc|png|PNG|JPEG|JPG|PDF';
        $config['max_size'] = '5000';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("attachment")){
          $upload_info = $this->upload->data();
          $data['attachment']=$upload_info['file_name'];
        } }
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['grand_total']=$this->input->post('grand_total');
        $data['rfq_date']=alterDateFormat($this->input->post('rfq_date'));
        $data['quotation_date']=alterDateFormat($this->input->post('quotation_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $data['for_department_id']=$department_id;
        $data['currency']=$this->input->post('currency');
        $data['quotation_no']=$this->input->post('quotation_no');
        $rfi_no=$this->input->post('rfi_no');
        $rfi_no=str_replace(" ","",$rfi_no);
        $data['rfi_no']=$rfi_no;
        $chkrfi_no=$rfi_no;
        $data['rfi_id']=$this->input->post('rfi_id');
        $data['note']=$this->input->post('note');
        ////////////////////////////////////////
        $product_id=$this->input->post('product_id');
        $quantity=$this->input->post('quantity');
        $unit_price=$this->input->post('unit_price');
        $amount=$this->input->post('amount');
        $product_code=$this->input->post('product_code');
        $specification=$this->input->post('specification');
        $i=0;
        $year=date('y');
        $month=date('m');
        $day=date('dHis');
        $grand_total=0;
        $ymd="$year$month$day";
        if($rfq_id==FALSE){
          $data['rfq_no']=$ymd;
          $query=$this->db->insert('rfq_master',$data);
          $rfq_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('rfq_id',$rfq_id);
          $query=$this->db->UPDATE('rfq_master',$data);
          $this->db->WHERE('rfq_id',$rfq_id);
          $query=$this->db->update('rfq_detail',array('status'=>5));
        }
        $data1['currency']=$this->input->post('currency');
        /////////////////
        foreach ($product_id as $value) {
           $data1['rfq_id']=$rfq_id;
           $data1['product_id']=$value;
           $data1['quantity']=$quantity[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['product_code']=$product_code[$i];
           $data1['specification']=$specification[$i];
           $grand_total=$grand_total+$amount[$i];
           $data1['amount']=$amount[$i];
           $data1['department_id']=$data['for_department_id'];
           $data1['date']=alterDateFormat($this->input->post('rfq_date'));
           $query=$this->db->insert('rfq_detail',$data1);
           $i++;
         }
        return $query;
     }
  
  function delete($rfq_id) {
    $this->db->WHERE('rfq_id',$rfq_id);
    $query=$this->db->update('rfq_detail',array('status'=>5));
    $this->db->WHERE('rfq_id',$rfq_id);
    $query=$this->db->update('rfq_master',array('status'=>5));
    return $query;
  }
  public function getDetails($rfq_id=''){
   $result=$this->db->query("SELECT p.*,pud.*,c.category_name,u.unit_name
        FROM rfq_detail pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.rfq_id=$rfq_id AND pud.status!=5
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  function submit($rfq_id) {
    $this->db->WHERE('rfq_id',$rfq_id);
    $query=$this->db->Update('rfq_master',array('status'=>2));
    return $query;
 }
 
    
  
}
