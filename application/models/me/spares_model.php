<?php
class Spares_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
        if($this->input->get('product_code')!=''){
          $product_code=$this->input->get('product_code');
          $condition=$condition."  AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%') ";
        }
      }     
      $department_id=$this->session->userdata('department_id');
        $query=$this->db->query("SELECT * FROM product_info p
          WHERE p.department_id=12 
          AND p.product_type=2 
          AND p.machine_other=1 $condition");
        $data = count($query->result());
        return $data;
      }
    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_GET){
        if($this->input->get('product_code')!=''){
          $product_code=$this->input->get('product_code');
          $condition=$condition."  AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%') ";
        }
      }
    
       $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,bo.box_name,ra.rack_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN rack_info ra ON(bo.rack_id=ra.rack_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=12 and p.product_type=2 AND p.machine_other=1
          $condition
          ORDER BY p.product_id DESC LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($product_id){
        $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,bo.box_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=12 and p.product_type=2 and
           p.product_id=$product_id")->row();
        return $result;
    }
   
    function save($product_id) {
        $data=array();
        if($_FILES['product_image']['name']!=""){
        $config1['upload_path'] = './product/';
        $config1['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG';
        $config1['max_size'] = '500';
        $this->load->library('upload', $config1);
        if ($this->upload->do_upload("product_image")){
            $upload_info1 = $this->upload->data();
            // $config1['image_library'] = 'gd2';
            // $config1['source_image'] = './product/' . $upload_info1['file_name'];
            // $config1['maintain_ratio'] = FALSE;
            // $config1['width'] = '200';
            // $config1['height'] = '200';
            // $this->load->library('image_lib', $config1);
            // $this->image_lib->resize();
            $data['product_image']=$upload_info1['file_name'];
        }}
        
        $hkdrate=getHKDRate($this->input->post('currency'));
        $data['product_model']=$this->input->post('product_model');
        $data['lead_time']=$this->input->post('lead_time');
        $data['product_name']=$this->input->post('product_name');
        $data['china_name']=$this->input->post('china_name');
        $data['currency']=$this->input->post('currency');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['mtype_id']=$this->input->post('mtype_id');
        $data['stock_quantity']=$this->input->post('stock_quantity');
        $data['minimum_stock']=$this->input->post('minimum_stock');
        $data['safety_stock_qty']=$this->input->post('safety_stock_qty');
        $data['usage_category']=$this->input->post('usage_category');
        $data['unit_id']=$this->input->post('unit_id');
        $data['unit_price']=$this->input->post('unit_price');
        $data['department_id']=12;
        $data['product_type']=2;
        $data['machine_other']=1;
        $data['reorder_level']=$this->input->post('reorder_level');
        $data['re_order_qty']=$this->input->post('re_order_qty');
        $data['product_description']=$this->input->post('product_description');
        $data['mdiameter']=$this->input->post('mdiameter');
        $data['mthread_count']=$this->input->post('mthread_count');
        $data['mlength']=$this->input->post('mlength');
        $data['box_id']=$this->input->post('box_id');
        $data['bd_or_cn']=$this->input->post('bd_or_cn');
        $data['head_id']=$this->input->post('head_id');
        $data['user_id']=$this->session->userdata('user_id');

        if($product_id==FALSE){
          $data['entry_date']=date('Y-m-d'); 
          if($data['product_code']==''){
               $product_code_count=$this->db->query("SELECT max(product_code_count) as counts FROM product_info 
          WHERE department_id=12 and product_type=2")->row('counts');
          $data['product_code']='SP-VL'.str_pad($product_code_count + 1, 8, '0', STR_PAD_LEFT);
          $data['product_code_count']=$product_code_count + 1;
          }
        $query=$this->db->insert('product_info',$data);
          $product_id=$this->db->insert_id();
        }else{
          $data['entry_date']=date('Y-m-d'); 
          $this->db->WHERE('product_id',$product_id);
          $query=$this->db->update('product_info',$data);
        }
        $check=$this->db->query("SELECT * FROM stock_master_detail WHERE  product_id=$product_id AND TRX_TYPE='OPENING'")->row();
        if(count($check)>0){
          // $datas['TRX_TYPE']="OPENING";
          // $datas['department_id']=12;
          // $datas['LOCATION']="BHRO1";
          // //$datas['CRRNCY']=$this->input->post('currency');
          // if($this->input->post('currency')=="BDT")
          //   $datas['EXCH_RATE']=0.092;
          // else
          //   $datas['EXCH_RATE']=1;
          // $datas['QUANTITY']=$this->input->post('stock_quantity');
          // $datas['UPRICE']=$check->unit_price;
          // $datas['TOTALAMT']$check->unit_price*$this->input->post('stock_quantity');
          // $datas['TOTALAMT_HKD']=$check->unit_price*$this->input->post('stock_quantity')*$hkdrate;
          // $datas['CRT_USER']=$this->session->userdata('user_name');
          // $this->db->WHERE('TRX_TYPE','OPENING');
          // $this->db->WHERE('product_id',$product_id);
          // $this->db->update('stock_master_detail',$datas);
        }else{
          $year=date('y');
          $month=date('m');
          $day=date('d');
          $ymd="$year$month$day";
          $counts=$this->db->query("SELECT count(*) as counts FROM stock_master_detail 
            WHERE FIFO_CODE LIKE '$ymd%' ")->row('counts');

          $datas['FIFO_CODE']=$ymd.str_pad($counts + 1, 4, '0', STR_PAD_LEFT);

          $datas['TRX_TYPE']="OPENING";
          $datas['department_id']=12;
          $datas['product_id']=$product_id;
          $datas['INDATE']=date('Y-m-d');
          $datas['ITEM_CODE']=$this->db->query("SELECT product_code FROM product_info 
          WHERE product_id=$product_id")->row('product_code');
          $datas['LOCATION']="BHRO1";
          $datas['CRRNCY']=$this->input->post('currency');
          if($this->input->post('currency')=="BDT")
            $datas['EXCH_RATE']=0.092;
          else
            $datas['EXCH_RATE']=1;
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
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->delete('product_info');
        return $query;
  }


  
}
