<?php
class Po_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('po_number')!=''){
        $po_number=$this->input->get('po_number');
        $condition=$condition."  AND pm.po_number='$po_number' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
      }
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pmd.pi_no LIKE '$pi_no%' ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
        $condition=$condition."  AND pm.for_department_id='$for_department_id' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     if($this->input->get('product_code')!=''||$this->input->get('pi_no')!=''){
        $query=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
          d1.department_name as for_department_name,s.supplier_name      
          FROM  po_master pm 
          INNER JOIN po_pline pmd ON(pm.po_id=pmd.po_id)
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.created_by) 
          WHERE pm.department_id=15  
          $condition
          GROUP BY pm.po_id");
     }else{
        $query=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
              d1.department_name as for_department_name,s.supplier_name
          FROM  po_master pm 
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.created_by) 
          WHERE pm.department_id=15  $condition");
         }
     $data = count($query->result());
     return $data;
  }
  ///////////////////
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('po_number')!=''){
        $po_number=$this->input->get('po_number');
        $condition=$condition."  AND pm.po_number='$po_number' ";
      }
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pmd.pi_no LIKE '$pi_no%' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
        $condition=$condition."  AND pm.for_department_id='$for_department_id' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
  $department_id=$this->session->userdata('department_id');
  if($this->input->get('product_code')!=''||$this->input->get('pi_no')!=''){
    $result=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
      d1.department_name as for_department_name,s.supplier_name      
      FROM  po_master pm 
      INNER JOIN po_pline pmd ON(pm.po_id=pmd.po_id)
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
      INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
      LEFT JOIN user u ON(u.id=pm.created_by) 
      WHERE pm.department_id=15  
      $condition
      GROUP BY pm.po_id
    ORDER BY pm.po_id DESC LIMIT $start,$limit")->result();
   }else{
    $result=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
          d1.department_name as for_department_name,s.supplier_name
      FROM  po_master pm 
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
      INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
      LEFT JOIN user u ON(u.id=pm.created_by) 
      WHERE pm.department_id=15  $condition
      ORDER BY pm.po_id DESC LIMIT $start,$limit")->result();
     }
    return $result;
  }
  function get_info($po_id){
     $result=$this->db->query("SELECT s.*,pm.*,d.department_name,
          u.user_name,u.email_address,u.mobile,
          d.department_name as for_department_name,
          u2.user_name as approved_by,
          c.*
      FROM  po_master pm 
      LEFT JOIN company_info c ON(pm.company_id=c.id)
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id)
      INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
      LEFT JOIN user u ON(u.id=pm.created_by) 
      LEFT JOIN user u2 ON(u2.id=pm.approved_by)
      WHERE pm.po_id=$po_id")->row();
    return $result;
  }
  function get_info2($po_number){
     $result=$this->db->query("SELECT s.*,pm.*,d.department_name,
          u.user_name,u.email_address,u.mobile,
          d.department_name as for_department_name,
          u2.user_name as approved_by,
          c.*
      FROM  po_master pm 
      LEFT JOIN company_info c ON(pm.company_id=c.id)
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id)
      INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
      LEFT JOIN user u ON(u.id=pm.created_by) 
      LEFT JOIN user u2 ON(u2.id=pm.approved_by)
      WHERE pm.po_number='$po_number' ")->row();
    return $result;
  }
  public function getDetails($po_id=''){
     $result=$this->db->query("SELECT p.*,c.category_name,pud.*
          FROM po_pline pud
          LEFT JOIN product_info p ON(pud.product_id=p.product_id)
          LEFT JOIN category_info c ON(p.category_id=c.category_id)
          WHERE pud.po_id=$po_id 
          ORDER BY pud.product_name ASC")->result();
     return $result;
    }
   
    public function getPIDetails($pi_id=''){
     $result=$this->db->query("SELECT p.*,c.category_name,
          pi.*,pi.purchased_qty as quantity,
          pi.amount as sub_total_amount,'' as remark,
          pm.pi_no,
          (pi.purchased_qty-(SELECT IFNULL(SUM(po.quantity),0) 
          FROM po_pline po 
          WHERE po.pi_id=pi.pi_id 
          AND pi.product_id=po.product_id 
          AND po.po_status!=8)) as quantity
          FROM pi_item_details pi
          LEFT JOIN pi_master pm ON(pi.pi_id=pm.pi_id)
          LEFT JOIN product_info p ON(pi.product_id=p.product_id)
          LEFT JOIN category_info c ON(p.category_id=c.category_id)
          WHERE pi.pi_id=$pi_id
          AND  pi.purchased_qty>(SELECT IFNULL(SUM(po.quantity),0) 
          FROM po_pline po 
          WHERE po.pi_id=pi.pi_id 
          AND pi.product_id=po.product_id 
          AND po.po_status!=8)
          ORDER BY pi.product_name ASC")->result();
      return $result;
    }
    

    public function getPRDetails($requisition_id=''){
     $result=$this->db->query("SELECT p.*,c.category_name,pud.*,
      u.unit_name,0 as additional_qty,p.minimum_stock as safety_qty,pud.required_qty as purchased_qty
          FROM requisition_item_details pud
          LEFT JOIN product_info p ON(pud.product_id=p.product_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN category_info c ON(p.category_id=c.category_id)
          WHERE pud.requisition_id=$requisition_id 
          ORDER BY pud.product_id ASC")->result();
     return $result;
    }
    function save($po_id) {
        $data=array();
        $data['po_type']=$this->input->post('po_type');
        $data['product_type']=$this->input->post('product_type');
        $data['po_date']=alterDateFormat($this->input->post('po_date'));
        $data['delivery_date']=alterDateFormat($this->input->post('delivery_date'));
        if($this->input->post('delivery_date2')!='')
        $data['delivery_date2']=alterDateFormat($this->input->post('delivery_date2'));
        else $data['delivery_date2']=alterDateFormat($this->input->post('delivery_date'));
        if($this->input->post('delivery_date3')!='')
        $data['delivery_date3']=alterDateFormat($this->input->post('delivery_date3'));
        else $data['delivery_date3']=alterDateFormat($this->input->post('delivery_date'));
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['user_id']=$this->session->userdata('user_id');
        $data['for_department_id']=$this->input->post('for_department_id');
        if($this->input->post('po_type')=='BD WO'){
          $data['subject']=$this->input->post('subject');
          $data['dear_name']=$this->input->post('dear_name');
          $data['body_content']=$this->input->post('body_content');
          $data['location']="BHRO1";
        }else{
          $data['mode_of_shipment']=$this->input->post('mode_of_shipment');
          $data['location']="BRW";
        }
        $data['company_id']=$this->input->post('company_id');
        $data['pay_term']=$this->input->post('pay_term');
        $data['currency']=$this->input->post('currency');
        $data['cnc_rate_in_hkd']=$this->input->post('cnc_rate_in_hkd');
        $data['subtotal']=$this->input->post('subtotal');
        $data['discount_amount']=$this->input->post('discount_amount');
        $data['total_amount']=$this->input->post('total_amount');
        $data['term_condition']=$this->input->post('term_condition');
        $data['credit_days']=$this->input->post('credit_days');
        $data['department_id']=15;
        $data['created_by']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        ////////////////////////////////////////
        $product_id=$this->input->post('product_id');
        $product_code=$this->input->post('product_code');
        $product_name=$this->input->post('product_name');
        $specification=$this->input->post('specification');
        $pi_no=$this->input->post('pi_no');
        $unit_price=$this->input->post('unit_price');
        $unit_name=$this->input->post('unit_name');
        $quantity=$this->input->post('quantity');
        $sub_total_amount=$this->input->post('sub_total_amount');
        $remarks=$this->input->post('remarks');
        ////////////////////
       
        // if($this->input->post('po_type')=='BD WO'){
        //   $data1['location']="BHRO1";
        // }else{
        //   $data1['location']="BRW";
        // }
        $data1['location']="BRW";
        $data1['department_id']=$this->input->post('for_department_id');
        $data1['currency']=$this->input->post('currency');
        $data1['cnc_rate_in_hkd']=$this->input->post('cnc_rate_in_hkd');
        $data1['date']=alterDateFormat($this->input->post('po_date'));
        $i=0;
        if($po_id==FALSE){
          $po_number=$this->db->query("SELECT IFNULL(MAX(po_id),0) as po_number
               FROM po_master WHERE 1")->row('po_number');

          $po_number ='BDWA'.str_pad($po_number + 1, 6, '0', STR_PAD_LEFT);
          $data['po_number']=$po_number;

          $reference_no=$this->db->query("SELECT IFNULL(MAX(po_id),0) as reference_no
               FROM po_master WHERE 1")->row('reference_no');
          $reference_no ='BDPO'.date('m').str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
          $data['reference_no']=$reference_no;
        $query=$this->db->insert('po_master',$data);
         $data1['po_number']=$po_number;
        $po_id=$this->db->insert_id();
        foreach ($product_id as $value) {
           $data1['product_id']=$value;
           $data1['po_id']=$po_id;
           $data1['product_code']=$product_code[$i];
           $data1['po_number']=$po_number;
           $data1['supplier_id']=$data['supplier_id'];
           $data1['product_name']=str_replace('"',"Inch",$product_name[$i]); 
           $data1['specification']=str_replace('"',"Inch",$specification[$i]);
           $data1['pi_no']=trim($pi_no[$i]);
           $chkpi_no=trim($pi_no[$i]);
           $dd=$this->db->query("SELECT IFNULL(pi_id,0) as pi_id
               FROM pi_master WHERE pi_no='$chkpi_no' ")->row('pi_id');
           if(count($dd)>0){
             $data1['pi_id']=$dd;
           }else{
            $data1['pi_id']=NULL;
           }
           
           $data1['quantity']=$quantity[$i];
           $data1['unit_name']=$unit_name[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['sub_total_amount']=$sub_total_amount[$i];
           $data1['remarks']=$remarks[$i];
           $query=$this->db->insert('po_pline',$data1);
           $i++;
         }
        }else{
          $this->db->WHERE('po_id',$po_id);
          $query=$this->db->UPDATE('po_master',$data);
          $this->db->WHERE('po_id',$po_id);
          $this->db->delete('po_pline');
          $info=$this->get_info($po_id);
          $i=0;
          foreach ($product_id as $value) {
           $data1['product_id']=$value;
           $data1['po_id']=$po_id;
           $data1['po_number']=$info->po_number;
           $data1['supplier_id']=$data['supplier_id'];
           $data1['product_code']=$product_code[$i];
           $data1['product_name']=str_replace('"',"Inch",$product_name[$i]); 
           $data1['specification']=str_replace('"',"Inch",$specification[$i]);
           $data1['pi_no']=$pi_no[$i];
           $chkpi_no=$pi_no[$i];
           $dd=array();
           $dd=$this->db->query("SELECT IFNULL(pi_id,0) as pi_id
               FROM pi_master 
               WHERE pi_no='$chkpi_no' 
               ORDER BY pi_id ASC")->row();
           if(count($dd)>0)
           $data1['pi_id']=$dd->pi_id;
           $data1['quantity']=$quantity[$i];
           $data1['unit_name']=$unit_name[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['sub_total_amount']=$sub_total_amount[$i];
           $data1['remarks']=$remarks[$i];
           $query=$this->db->insert('po_pline',$data1);
           $i++;
         }
      } 
      return $query;
    }
    function savediscount($po_id) {
        $data=array();
        $data['subtotal']=$this->input->post('subtotal');
        $data['discount_amount']=$this->input->post('discount_amount');
        $data['total_amount']=$this->input->post('total_amount');
        $this->db->WHERE('po_id',$po_id);
        $query=$this->db->UPDATE('po_master',$data);
      return $query;
    }
  
    function delete($po_id) {
      $this->db->WHERE('po_id',$po_id);
      $query=$this->db->delete('po_pline');
      $this->db->WHERE('po_id',$po_id);
      $query=$this->db->delete('po_master');
      return $query;
     }
    function approved($po_id) {
      $this->db->WHERE('po_id',$po_id);
      $query=$this->db->Update('po_master',array('po_status'=>2));
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
  function submit($po_id) {
    $this->db->WHERE('po_id',$po_id);
    $query=$this->db->Update('po_master',array('po_status'=>2));
    return $query;
  }
  function aknoledgements($po_id) {
    $data=array();
    $data['acknow_status']='YES';
    $data['acknow_date']=date('Y-m-d');
    $data['acknow_date_time']=date('Y-m-d H:i:s');
    $this->db->WHERE('po_id',$po_id);
    $query=$this->db->update('po_master',$data);
    return $query;
  }
 function returns($po_id) {
    $data=array();
    $data['po_status']=1;
    $this->db->WHERE('po_id',$po_id);
    $query=$this->db->Update('po_master',$data);
    return $query;
  }

  
}
