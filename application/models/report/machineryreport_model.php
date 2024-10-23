<?php
class Machineryreport_model extends CI_Model {
   function getMachine($department_id){
    $result=$this->db->query("SELECT product_id,product_name,product_model 
      FROM product_info WHERE department_id=$department_id AND product_type=1
      AND machine_other=1")->result();
    return $result;
   }

  function reportResult($category_id,$product_id,$floor_id,$line_id,$detail_status,$tpm_status,$tpm_serial_code){
    $condition='';
    if($category_id!='All'){
      $condition.=" AND p.category_id=$category_id ";
    }
    if($product_id!='All'){
      $condition.=" AND p.product_id=$product_id ";
    }
    if($floor_id!='All'){
      $condition.=" AND f.floor_id=$floor_id ";
    }
    if($line_id!='All'){
      $condition.=" AND pd.line_id=$line_id ";
    }
    if($detail_status!='All'){
      $condition.=" AND pd.detail_status=$detail_status ";
    }
    if($tpm_status!='All'){
      $condition.=" AND pd.tpm_status=$tpm_status ";
    }
    if($tpm_serial_code!=''){
      $condition=$condition."  AND (pd.tpm_serial_code LIKE '%$tpm_serial_code%' OR pd.ventura_code LIKE '%$tpm_serial_code%') ";
    }
    /////////////////
    $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
        c.category_name,mt.machine_type_name,
        fl.line_no,pd.tpm_status as machine_status
        FROM  product_detail_info pd 
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
        LEFT JOIN floorline_info fl ON(pd.line_id=fl.line_id)
        LEFT JOIN floor_info f ON(fl.floor_id=f.floor_id)
        WHERE pd.department_id=12 AND pd.machine_other=1 $condition
        GROUP BY pd.product_detail_id 
        ORDER BY pd.ventura_code ASC")->result();
   // echo $this->db->last_query(); exit;
      return $result;
          
  }
  ///AND p.category_id!=1
  function reportResultold($category_id,$product_id,$floor_id,$tpm_serial_code){
    $condition='';
    if($category_id!='All'){
      $condition.=" AND p.category_id=$category_id";
    }
    if($product_id!='All'){
      $condition.=" AND p.product_id='$product_id'";
    }
    if($floor_id!='All'){
      $condition.=" AND f.floor_id='$floor_id'";
    }
    if($tpm_serial_code!=''){
      $condition=$condition."  AND (pd.tpm_serial_code LIKE '%$tpm_serial_code%' OR pd.ventura_code LIKE '%$tpm_serial_code%') ";
    }
    /////////////////
    $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
        c.category_name,mt.machine_type_name,
        b.brand_name,fl.line_no,s.supplier_name,pds.machine_status,
        pds.line_id,pds.assign_date,pds.takeover_date
        FROM  product_detail_info pd 
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
        LEFT JOIN product_status_info pds ON(pd.product_detail_id=pds.product_detail_id AND pds.take_over_status=1)
        LEFT JOIN floorline_info fl ON(pds.line_id=fl.line_id)
        LEFT JOIN floor_info f ON(fl.floor_id=f.floor_id)
        WHERE pd.department_id=12  $condition
        GROUP BY pd.product_detail_id 
        ORDER BY pd.ventura_code ASC")->result();
      return $result;
          
  }
  
}