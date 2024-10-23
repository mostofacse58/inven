<?php
class Spurchase_model extends CI_Model {
    function lists() {
        $department_id=$this->session->userdata('department_id');
        $condition='';
        if($this->session->userdata('user_type')==1){
          $condition.=" 1 ";
        }else{
          $condition.=" pm.department_id=$department_id ";
        }
        $result=$this->db->query("SELECT pm.*,pi.pi_no,s.company_name,u.user_name,
          (SELECT SUM(pud.quantity) FROM purchase_detail pud 
          WHERE pm.purchase_id=pud.purchase_id) as totalquantity
          FROM  purchase_master pm 
          LEFT JOIN pi_master pi ON(pm.pi_id=pi.pi_id)
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE  $condition
          ORDER BY pm.purchase_id DESC")->result();
        return $result;
    }
    function get_info($purchase_id){
         $result=$this->db->query("SELECT pm.*,pi.pi_no,s.company_name,u.user_name,
          (SELECT SUM(pud.quantity) FROM purchase_detail pud 
          WHERE pm.purchase_id=pud.purchase_id) as totalquantity
          FROM  purchase_master pm 
          LEFT JOIN pi_master pi ON(pm.pi_id=pi.pi_id)
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.purchase_id=$purchase_id")->row();
        return $result;
    }
    function save($purchase_id) {
        $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['pi_id']=$this->input->post('pi_id');
        //$data['sub_total']=$this->input->post('sub_total');
        //$data['tax_total']=$this->input->post('tax_total');
       // $data['shipping_cost']=$this->input->post('shipping_cost');
        $data['grand_total']=$this->input->post('grand_total');
        $data['purchase_date']=alterDateFormat($this->input->post('purchase_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $data['reference_no']=$this->input->post('reference_no');
        ////////////////////////////////////////
        $product_id=$this->input->post('product_id');
        $quantity=$this->input->post('quantity');
        $unit_price=$this->input->post('unit_price');
        $amount=$this->input->post('amount');
        $i=0;
        if($purchase_id==FALSE){
          // $reference_no=$this->db->query("SELECT MAX(purchase_id) as reference_no
          //    FROM purchase_master WHERE department_id=$department_id")->row('reference_no');
          // $reference_no ='ME'.str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
          // $data['reference_no']=$reference_no;
        $query=$this->db->insert('purchase_master',$data);
        $purchase_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('purchase_id',$purchase_id);
          $query=$this->db->UPDATE('purchase_master',$data);
          $this->db->WHERE('purchase_id',$purchase_id);
          $this->db->delete('purchase_detail');
        } 
        foreach ($product_id as $value) {
           $data1['product_id']=$value;
           $data1['purchase_id']=$purchase_id;
           $data1['quantity']=$quantity[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['amount']=$amount[$i];
           $data1['department_id']=$department_id;
           $query=$this->db->insert('purchase_detail',$data1);
           $i++;
         }
        return $query;
    }
  
    function delete($purchase_id) {
        $this->db->WHERE('purchase_id',$purchase_id);
        $query=$this->db->delete('purchase_detail');
        $this->db->WHERE('purchase_id',$purchase_id);
        $query=$this->db->delete('purchase_master');
        return $query;
  }
  public function getDetails($purchase_id='')
  {
   $result=$this->db->query("SELECT pud.*,p.*,c.category_name,u.unit_name,m.mtype_name
        FROM purchase_detail pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
        WHERE pud.purchase_id=$purchase_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  
    
  
}
