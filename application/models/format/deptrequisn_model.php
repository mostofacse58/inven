<?php
class Deptrequisn_model extends CI_Model {
  public function get_count(){
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_GET){
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pm.pi_no='$pi_no' ";
      }
      if($this->input->get('pi_status')!=''){
        $pi_status=$this->input->get('pi_status');
        $condition=$condition."  AND pm.pi_status='$pi_status' ";
      }
     }
    $query=$this->db->query("SELECT pm.*,pt.p_type_name,u.user_name  
      FROM  pi_master pm 
      LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
      LEFT JOIN user u ON(u.id=pm.requested_by) 
      WHERE pm.department_id=$department_id  AND pm.pi_type=1 $condition");
      $data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
      $condition=' ';
      if($_GET){
        if($this->input->get('pi_no')!=''){
          $pi_no=$this->input->get('pi_no');
          $condition=$condition."  AND pm.pi_no='$pi_no' ";
        }
        if($this->input->get('pi_status')!='All'){
        $pi_status=$this->input->get('pi_status');
        $condition=$condition."  AND pm.pi_status='$pi_status' ";
        }
      }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT pm.*,pt.p_type_name,u.user_name,d.department_name,dr.deptrequisn_no      FROM  pi_master pm 
      LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
      LEFT JOIN user u ON(u.id=pm.requested_by) 
      WHERE pm.department_id=$department_id AND pm.pi_type=1 $condition
      ORDER BY pm.pi_id DESC LIMIT $start,$limit")->result();
    return $result;
    }
    function getpendingPi($pi_status,$pi_id=FALSE) {
      if($pi_id==FALSE){
        $result=$this->db->query("SELECT pm.* 
          FROM  pi_master pm 
          WHERE pm.pi_status=$pi_status
          AND pm.responsible_department=15
          ORDER BY pm.pi_id DESC")->result();
      }else{
        $result=$this->db->query("SELECT *, 1 as dddd
          FROM  pi_master  
          WHERE pi_status=$pi_status
          AND responsible_department=15 
          AND pi_id=$pi_id
          UNION
          SELECT *,2 as dddd
          FROM  pi_master
          WHERE pi_status=$pi_status
          AND responsible_department=15 
          AND pi_id!=$pi_id ")->result();
      }
      return $result;
      
    }
    function get_info($pi_id){
         $result=$this->db->query("SELECT pm.*,pt.p_type_name,
          u.user_name,d.department_name,d1.division,dr.deptrequisn_no,
          u2.user_name as confirm_by,u3.user_name as receive_by,
          u4.user_name as approve_by,u5.user_name as certified_name,
          u6.user_name as verified_name,
          d1.department_name as demand_department_name
          FROM  pi_master pm 
          LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id)
          LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          LEFT JOIN user u2 ON(u2.id=pm.confirmed_by)
          LEFT JOIN user u3 ON(u3.id=pm.received_by)
          LEFT JOIN user u4 ON(u4.id=pm.approved_by)
          LEFT JOIN user u5 ON(u5.id=pm.certified_by)
          LEFT JOIN user u6 ON(u6.id=pm.verified_by)
          WHERE pm.pi_id=$pi_id")->row();
        return $result;
    }
    public function getDetails($pi_id=''){
     $result=$this->db->query("SELECT p.*,c.category_name,pud.*,
          p.unit_price as unit_oprice,p.currency as currency_origin,s.supplier_name,
          (SELECT GROUP_CONCAT(po.po_number) as ponumber FROM po_pline po 
          WHERE po.pi_no=pud.pi_no AND pud.product_id=po.product_id) as ponumber
          FROM pi_item_details pud
          LEFT JOIN product_info p ON(pud.product_id=p.product_id)
          LEFT JOIN supplier_info s ON(pud.supplier_id=s.supplier_id)
          LEFT JOIN category_info c ON(p.category_id=c.category_id)
          WHERE pud.pi_id=$pi_id 
          ORDER BY pud.unit_name ASC")->result();
     return $result;
    }
     public function getPRDetails($requisition_id=''){
     $result=$this->db->query("SELECT p.*,c.category_name,pud.*,
      p.unit_price as unit_oprice,p.currency as currency_origin,
      u.unit_name,0 as additional_qty,p.minimum_stock as safety_qty,
      pud.required_qty as purchased_qty
          FROM requisition_item_details pud
          LEFT JOIN product_info p ON(pud.product_id=p.product_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN category_info c ON(p.category_id=c.category_id)
          WHERE pud.requisition_id=$requisition_id 
          ORDER BY pud.product_id ASC")->result();
     return $result;
    }
    function save($pi_id) {
        $data=array();
        $data['purchase_type_id']=$this->input->post('purchase_type_id');
        $data['product_type']=$this->input->post('product_type');
        $data['pi_no']=trim($this->input->post('pi_no'));
        $data['pi_date']=alterDateFormat($this->input->post('pi_date'));
        $data['demand_date']=alterDateFormat($this->input->post('demand_date'));
        $data['promised_date']=alterDateFormat($this->input->post('promised_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['requested_by']=$this->session->userdata('user_id');
        $data['department_id']=$this->session->userdata('department_id');
        $data['for_department_id']=$this->input->post('for_department_id');
        $data['other_note']=$this->input->post('other_note');
        $data['purchase_category']=$this->input->post('purchase_category');
        $data['responsible_department']=15;
        $data['create_date']=date('Y-m-d');
        ////////////////////////////////////////
        $product_id=$this->input->post('product_id');
        $product_code=$this->input->post('product_code');
        $product_name=$this->input->post('product_name');
        $specification=$this->input->post('specification');
        $required_qty=$this->input->post('required_qty');
        $stock_qty=$this->input->post('stock_qty');
        $purchased_qty=$this->input->post('purchased_qty');
        $safety_qty=$this->input->post('safety_qty');
        $additional_qty=$this->input->post('additional_qty');
        $remarks=$this->input->post('remarks');
        $unit_name=$this->input->post('unit_name');
        $unit_price=$this->input->post('unit_price');
        $currency=$this->input->post('currency');
        $file_no=$this->input->post('file_no');
        $i=0;

        if($pi_id==FALSE){
        $reference_no=$this->db->query("SELECT IFNULL(MAX(pi_id),0) as reference_no
             FROM pi_master WHERE 1")->row('reference_no');
        $reference_no ='VLBD'.date('mi').str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        $data['reference_no']=$reference_no;
        $query=$this->db->insert('pi_master',$data);
        $pi_id=$this->db->insert_id();
        foreach ($product_id as $value) {
           $hkdrate=getHKDRate($currency[$i]);
           $data1['product_id']=$value;
           $data1['pi_id']=$pi_id;
           $data1['product_code']=$product_code[$i];
           $data1['product_name']=$product_name[$i];
           $data1['specification']=$specification[$i];
           $data1['required_qty']=$required_qty[$i];
           $data1['stock_qty']=$stock_qty[$i];
           $data1['purchased_qty']=$purchased_qty[$i];
           $data1['additional_qty']=$additional_qty[$i];
           $data1['safety_qty']=$safety_qty[$i];
           $data1['unit_name']=$unit_name[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['amount']=$unit_price[$i]*$purchased_qty[$i];
           $data1['currency']=$currency[$i];
           $data1['amount_hkd']=$hkdrate*$data1['amount'];
           $data1['file_no']=$file_no[$i];
           $data1['remarks']=$remarks[$i];
           $data1['department_id']=$this->session->userdata('department_id');
           $data1['pi_no']=trim($this->input->post('pi_no'));
           $query=$this->db->insert('pi_item_details',$data1);
           $i++;
         }
        }else{
        $this->db->WHERE('pi_id',$pi_id);
        $query=$this->db->UPDATE('pi_master',$data);
          $textpi='';
          foreach ($product_id as $value) {
           $chkiteminfo=$this->db->query("SELECT * FROM pi_item_details 
            WHERE pi_id=$pi_id AND product_id=$value")->row();
           if(count($chkiteminfo)>0){
             if($chkiteminfo->required_qty>$required_qty[$i]){
              $textpi.=" Decrease qty ".$required_qty[$i]." instead ".$chkiteminfo->required_qty. " for ".$product_name[$i]."<br>";
             }elseif($chkiteminfo->required_qty<$required_qty[$i]){
               $textpi.=" Increase qty ".$required_qty[$i]." instead ".$chkiteminfo->required_qty. " for ".$product_name[$i]."<br>";
             }
          }else{
            $textpi.=" Add This item ".$product_name[$i]." qty ".$required_qty[$i]."<br>";
          }

          $i++;
         } 
         $returncheck=$this->db->query("SELECT * FROM pi_master 
        WHERE pi_id=$pi_id AND reject_note IS NOT NULL")->row();
         if(count($returncheck)>0){
         if($textpi!=''){
          $data4['update_text']=$textpi;
          $data4['update_date']=date('Y-m-d');
          $data4['pi_id']=$pi_id;
          $this->db->insert('pi_update_info',$data4);
         } }
         $this->db->WHERE('pi_id',$pi_id);
         $this->db->delete('pi_item_details');
         $i=0;
         foreach ($product_id as $value) {
           $hkdrate=getHKDRate($currency[$i]);
           $data1['product_id']=$value;
           $data1['pi_id']=$pi_id;
           $data1['product_code']=$product_code[$i];
           $data1['product_name']=$product_name[$i];
           $data1['specification']=$specification[$i];
           $data1['required_qty']=$required_qty[$i];
           $data1['stock_qty']=$stock_qty[$i];
           $data1['purchased_qty']=$purchased_qty[$i];
           $data1['additional_qty']=$additional_qty[$i];
           $data1['safety_qty']=$safety_qty[$i];
           $data1['unit_name']=$unit_name[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['amount']=$unit_price[$i]*$purchased_qty[$i];
           $data1['currency']=$currency[$i];
           $data1['file_no']=$file_no[$i];
           $data1['amount_hkd']=$hkdrate*$data1['amount'];
           $data1['remarks']=$remarks[$i];
           $data1['department_id']=$this->session->userdata('department_id');
           $data1['pi_no']=trim($this->input->post('pi_no'));
           $query=$this->db->insert('pi_item_details',$data1);
           $i++;
         }
        } 
      return $query;
    }
  
    function delete($pi_id) {
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->delete('pi_item_details');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->delete('pi_master');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->delete('pi_update_info');
      return $query;
     }

  function getRequisitionProduct($term) {
    $department_id=$this->session->userdata('department_id');
    $product_type = $this->input->get('product_type', true);
    $medical_yes=$this->session->userdata('medical_yes');
    $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
     FROM product_info p
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
      WHERE p.department_id=$department_id 
      AND p.product_type=2  
      AND p.type='$product_type' 
      AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
      ORDER BY p.product_name ASC")->result();
    return $result;
    }
   function approved($pi_id) {
        $this->db->WHERE('pi_id',$pi_id);
        $query=$this->db->Update('pi_master',array('pi_status'=>2));
        return $query;
     }
  public function getsafetyStock(){
   $department_id=$this->session->userdata('department_id');
   $medical_yes=$this->session->userdata('medical_yes');
      $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
       FROM product_info p
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.department_id=$department_id AND p.product_type=2 AND p.main_stock<p.minimum_stock
        ORDER BY p.product_name ASC
        LIMIT 0,10")->result();
   return $result;
  }
  function submit($pi_id) {
    $this->db->WHERE('pi_id',$pi_id);
    $query=$this->db->Update('pi_master',array('pi_status'=>3));
    return $query;
 }
 function returns($pi_id) {
      $data=array();
      $data['pi_status']=1;
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
   }
 function rejected($pi_id) {
      $data=array();
      $data['pi_status']=8;
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
   }
  
}
