<?php
class Items_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_POST){
        if($this->input->post('product_code')!=''){
          $product_code=$this->input->post('product_code');
          $condition=$condition."  AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%') ";
        }
      }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM product_info p
        WHERE p.department_id=$department_id AND p.product_type=2 
        AND p.medical_yes=2 AND p.machine_other=2  $condition");
      $data = count($query->result());
      return $data;
    }

    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_POST){
        if($this->input->post('product_code')!=''){
          $product_code=$this->input->post('product_code');
          $condition=$condition."  AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%') ";
        }
      // $this->session->set_userdata('itemsSearch',$condition);
      }
    if($this->session->userdata('itemsSearch')!=' '){
      //$condition=$this->session->userdata('itemsSearch');
    }

    $result=$this->db->query("SELECT p.*,c.category_name,
      b.brand_name
      FROM  product_info p
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
      LEFT JOIN user u ON(u.id=p.user_id) 
      WHERE p.department_id=$department_id AND p.product_type=2 
      AND p.medical_yes=2 AND p.machine_other=2  $condition
      ORDER BY p.product_id DESC LIMIT $start,$limit")->result();
    return $result;
  }
    ///////////
    function lists2() {
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT p.*,c.category_name,
          b.brand_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=$department_id AND p.product_type=2 
          AND p.medical_yes=2 p.machine_other=2 AND
          ORDER BY p.product_id ASC")->result();
        return $result;
    }
    function get_info($product_id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*,c.category_name,
          b.brand_name,bo.box_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=$department_id and p.product_type=2 AND p.machine_other=2 AND
           p.product_id=$product_id")->row();
        return $result;
    }
   
    function save($product_id) {
        $hkdrate=getHKDRate($this->input->post('currency'));
        $department_id=$this->session->userdata('department_id');
        $data=array();
        if($_FILES['product_image']['name']!=""){
        $config1['upload_path'] = './product/';
        $config1['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG';
        $config1['max_size'] = '1500';
        $this->load->library('upload', $config1);
        if ($this->upload->do_upload("product_image")){
          $upload_info1 = $this->upload->data();
          $data['product_image']=$upload_info1['file_name'];
        } }
        $data['product_model']=$this->input->post('product_model');
        $data['product_name']=$this->input->post('product_name');
        $data['china_name']=$this->input->post('china_name');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['stock_quantity']=$this->input->post('stock_quantity');
        $data['re_order_qty']=$this->input->post('re_order_qty');
        $data['minimum_stock']=$this->input->post('minimum_stock');
        $data['lead_time']=$this->input->post('lead_time');
        $data['unit_id']=$this->input->post('unit_id');
        $data['unit_price']=$this->input->post('unit_price');
        $data['currency']=$this->input->post('currency');
        $data['amount']=$this->input->post('unit_price')*$this->input->post('stock_quantity');
        $data['amount_hkd']=$this->input->post('unit_price')*$this->input->post('stock_quantity')*$hkdrate;
        $data['department_id']=$department_id;
        $data['product_type']=2;
        $data['machine_other']=2;
        $data['entry_date']=date('Y-m-d');
        $data['product_description']=$this->input->post('product_description');
        $data['box_id']=$this->input->post('box_id');
        $data['brand_id']=$this->input->post('brand_id');
        $data['bd_or_cn']=$this->input->post('bd_or_cn');
        $data['head_id']=$this->input->post('head_id');
        $data['user_id']=$this->session->userdata('user_id');
        if($product_id==FALSE){
          if($data['product_code']==''){
            $product_code_count=$this->db->query("SELECT max(product_code_count) as counts 
              FROM product_info 
          WHERE department_id=$department_id and product_type=2")->row('counts');
          $random=strtoupper(substr(md5('ABCDSTSHJUHUHUHUIHUIHIU5454L'.mt_rand(0,1005)),0,4));

        $data['product_code']='BD'.$random.str_pad($product_code_count + 1, 10, '0', STR_PAD_LEFT);
        $data['product_code_count']=$product_code_count + 1;
        }
        $query=$this->db->insert('product_info',$data);
          $product_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('product_id',$product_id);
          $query=$this->db->update('product_info',$data);
        }

        ////////////////////All Code Update ////////////////////////////////
        $alldata['product_code']=$this->input->post('product_code');
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->update('purchase_detail',$alldata);
        ////////////////////////////
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->update('item_issue_detail',$alldata);
        ////////////////////////////
        $alldata['product_name']=$this->input->post('product_name');
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->update('pi_item_details',$alldata);
        /////////////////////////
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->update('po_pline',$alldata);
        ////////////////////////////////////////////////
        $alldata2['ITEM_CODE']=$this->input->post('product_code');
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->update('stock_master_detail',$alldata2);
        ///////////////////////////////
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->update('stock_adjustment_details',$alldata2);
        //////////////////////////////////////////////////////
        
        $check=$this->db->query("SELECT * FROM stock_master_detail 
          WHERE product_id=$product_id AND TRX_TYPE='OPENING'")->row();
        $datas=array();
        if(count($check)<1){
          $year=date('y');
          $month=date('m');
          $day=date('d');
          $ymd="$year$month$day";
          $counts=$this->db->query("SELECT count(*) as counts FROM stock_master_detail 
            WHERE FIFO_CODE LIKE '$ymd%' ")->row('counts');
          $datas['FIFO_CODE']=$ymd.str_pad($counts + 1, 4, '0', STR_PAD_LEFT);
          $datas['TRX_TYPE']="OPENING";
          $datas['department_id']=$this->session->userdata('department_id');
          $datas['product_id']=$product_id;
          $datas['INDATE']=date('Y-m-d');
          $datas['ITEM_CODE']=$this->db->query("SELECT product_code FROM product_info 
                  WHERE product_id=$product_id")->row('product_code');
          $datas['LOCATION']="BHRO1";
          $datas['CRRNCY']=$this->input->post('currency');
          $datas['QUANTITY']=$this->input->post('stock_quantity');
          $datas['UPRICE']=$this->input->post('unit_price');
          $datas['TOTALAMT']=$this->input->post('unit_price')*$this->input->post('stock_quantity');
          $datas['TOTALAMT_HKD']=$this->input->post('unit_price')*$this->input->post('stock_quantity')*$hkdrate;
          $datas['CRT_USER']=$this->session->userdata('user_name');
          $datas['CRT_DATE']=date('Y-m-d');
          $this->db->insert('stock_master_detail',$datas);
        }
      return $product_id;
    }


  
    function delete($product_id) {
        // $this->db->WHERE('product_id',$product_id);
        // $query=$this->db->delete('product_info');
        // $this->db->WHERE('product_id',$product_id);
        // $query=$this->db->delete('stock_master_detail');
        //return $query;
      return true;
    }
    function deactivated($product_id) {
        $data['product_status']=2;
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->Update('product_info',$data);
        return $query;
    }
    function activated($product_id) {
        $data['product_status']=1;
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->Update('product_info',$data);
        return $query;
    }


  
}
