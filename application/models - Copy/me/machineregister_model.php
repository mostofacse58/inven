<?php
class Machineregister_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if(isset($_POST)){
      if($this->input->post('tpm_serial_code')!=''){
        $tpm_serial_code=$this->input->post('tpm_serial_code');
        $condition=$condition."  AND (pd.tpm_serial_code='$tpm_serial_code' OR pd.ventura_code='$tpm_serial_code') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM product_detail_info pd
        WHERE pd.department_id=12 AND pd.machine_other=1 $condition");
      $data = count($query->result());
      return $data;
    }

  public  function lists2($limit,$start){
       $condition=' ';
        if(isset($_POST)){
          if($this->input->post('tpm_serial_code')!=''){
            $tpm_serial_code=$this->input->post('tpm_serial_code');
            $condition=$condition."  AND (pd.tpm_serial_code='$tpm_serial_code' OR pd.ventura_code='$tpm_serial_code') ";
          }
         }
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,
          c.category_name,mt.machine_type_name,b.brand_name
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=pd.user_id) 
          WHERE pd.department_id=12 AND pd.machine_other=1 $condition
          ORDER BY pd.ventura_code ASC LIMIT $start,$limit")->result();
    return $result;

 }


  function get_info($product_detail_id){
        $result=$this->db->query("SELECT pd.*,p.product_name,p.china_name,p.product_code,
          p.product_image,c.category_name,mt.machine_type_name,b.brand_name,s.supplier_name
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE pd.department_id=12 and 
           pd.product_detail_id=$product_detail_id")->row();
        return $result;
    }

   
    function save($product_detail_id) {
        $data=array();
        $data['product_id']=$this->input->post('product_id');
        $data['invoice_no']=$this->input->post('invoice_no');
        $data['machine_price']=$this->input->post('machine_price');
        $data['amount_hkd']=$this->input->post('machine_price')*7.750;
        $data['purchase_date']=alterDateFormat($this->input->post('purchase_date'));
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['pi_no']=$this->input->post('pi_no');
        $data['user_id']=$this->session->userdata('user_id');
        $data['forpurchase_department_id']=$this->input->post('forpurchase_department_id');
        $data['department_id']=12;
        $data['machine_other']=1;
        $tpm_serial_code=$this->input->post('tpm_serial_code');
        $other_description=$this->input->post('other_description');
        $i=0;

        foreach ($tpm_serial_code as $value) {
          $data['tpm_serial_code']=$value;
          $data['other_description']=$other_description[$i];
        if($product_detail_id==FALSE){
          $code_count=$this->db->query("SELECT max(code_count) as counts FROM product_detail_info 
          WHERE department_id=12 AND machine_other=1")->row('counts');
          $data['ventura_code']='VL'.str_pad($code_count + 1, 6, '0', STR_PAD_LEFT);
          $data['code_count']=$code_count + 1;
          $query=$this->db->insert('product_detail_info',$data);
        }else{
          $this->db->WHERE('product_detail_id',$product_detail_id);
          $query=$this->db->update('product_detail_info',$data);
        }
        $i++;
        }
        return $query;
    }
  
    function delete($product_detail_id) {
      $this->db->WHERE('product_detail_id',$product_detail_id);
      $query=$this->db->delete('product_detail_info');
      return $query;
  }
  

  
}
