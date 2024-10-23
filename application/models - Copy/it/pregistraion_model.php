<?php
class Pregistraion_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if(isset($_POST)){
      if($this->input->post('asset_encoding')!=''){
        $asset_encoding=$this->input->post('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE'%$asset_encoding%') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM product_detail_info pd
        WHERE pd.machine_other=2 AND pd.department_id=$department_id $condition");
      $data = count($query->result());
      return $data;
    }

  public  function lists($limit,$start){
   $condition=' ';
    if(isset($_POST)){
      if($this->input->post('asset_encoding')!=''){
        $asset_encoding=$this->input->post('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE'%$asset_encoding%') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,
          c.category_name,b.brand_name
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=pd.user_id) 
          WHERE  pd.machine_other=2 
          AND pd.department_id=$department_id $condition
          ORDER BY pd.ventura_code DESC LIMIT $start,$limit")->result();
    return $result;
  }


  function get_info($product_detail_id){
    $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pd.*,p.product_name,p.china_name,p.product_code,
          p.product_image,c.category_name,b.brand_name,s.supplier_name,e.employee_name,aim.employee_id
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          LEFT JOIN asset_issue_master aim ON(pd.product_detail_id=aim.product_detail_id)
          LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
          WHERE pd.department_id=$department_id 
          AND pd.product_detail_id=$product_detail_id")->row();
        return $result;
    }

   
    function save($product_detail_id) {
      $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['product_id']=$this->input->post('product_id');
        $data['invoice_no']=$this->input->post('invoice_no');
        $data['machine_price']=$this->input->post('machine_price');
        $data['amount_hkd']=$this->input->post('machine_price')*0.088;
        $data['purchase_date']=alterDateFormat($this->input->post('purchase_date'));
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['pi_no']=$this->input->post('pi_no');
        if($this->session->userdata('department_id')==1){
          $data['proccessor_id']=$this->input->post('proccessor_id');
          $data['ram_id']=$this->input->post('ram_id');
        }
        $data['proccessor_id']=$this->input->post('proccessor_id');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $asset_encoding=$this->input->post('asset_encoding');
        $other_description=$this->input->post('other_description');
        $forpurchase_department_id=$this->input->post('forpurchase_department_id');
        if($this->input->post('it_status')>3){
          $data['detail_status']=4;
          $data['despose_date']=date('Y-m-d');
          
          $data['despose_note']=$this->input->post('despose_note');
        }else{
          $data['detail_status']=1;
        }      
        $i=0;
        foreach ($asset_encoding as $value) {
          $data['asset_encoding']=$value;
          $data['forpurchase_department_id']=$forpurchase_department_id[$i];
          $data['other_description']=$other_description[$i];
          $data['remarks']=$other_description[$i];
        if($product_detail_id==FALSE){
          $data['it_status']=$this->input->post('it_status');
          $data['machine_other']=2;
          $code_count=$this->db->query("SELECT max(code_count) as counts 
            FROM product_detail_info 
            WHERE department_id=$department_id 
            AND machine_other=2")->row('counts');
          $data['ventura_code']=$this->session->userdata('department_name').str_pad($code_count + 1, 6, '0', STR_PAD_LEFT);
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
      $this->db->WHERE('product_detail_id',$product_detail_id);
      $query=$this->db->delete('asset_issue_master');
      return $query;
    }
  

  
}
