<?php
class Spares_model extends CI_Model {
  public function get_count(){
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_POST){
        if($this->input->post('product_code')!=''){
          $product_code=$this->input->post('product_code');
          $condition=$condition."  AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%') ";
        }
        //$this->session->set_userdata('sparesSearch',$condition);
      }
    if($this->session->userdata('sparesSearch')!=' '){
     // $condition=$this->session->userdata('sparesSearch');
    }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM product_info p
        WHERE p.department_id=$department_id AND p.product_type=2 $condition");
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
      // $this->session->set_userdata('sparesSearch',$condition);
      }
    if($this->session->userdata('sparesSearch')!=' '){
      //$condition=$this->session->userdata('sparesSearch');
    }

        $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=$department_id and p.product_type=2 $condition
          ORDER BY p.product_id DESC LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($product_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,bo.box_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=$department_id and p.product_type=2 and
           p.product_id=$product_id")->row();
        return $result;
    }
   
    function save($product_id) {
        $department_id=$this->session->userdata('department_id');
        $data=array();
        if($_FILES['product_image']['name']!=""){
        $config1['upload_path'] = './product/';
        $config1['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG';
        $config1['max_size'] = '3000';
        $this->load->library('upload', $config1);
        if ($this->upload->do_upload("product_image")){
            $upload_info1 = $this->upload->data();
            $config1['image_library'] = 'gd2';
            $config1['source_image'] = './product/' . $upload_info1['file_name'];
            $config1['maintain_ratio'] = FALSE;
            $config1['width'] = '200';
            $config1['height'] = '200';
            $this->load->library('image_lib', $config1);
            $this->image_lib->resize();
            $data['product_image']=$upload_info1['file_name'];
        }}
        $data['product_model']=$this->input->post('product_model');
        $data['product_name']=$this->input->post('product_name');
        $data['china_name']=$this->input->post('china_name');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['mtype_id']=$this->input->post('mtype_id');
        $data['stock_quantity']=$this->input->post('stock_quantity');
        $data['minimum_stock']=$this->input->post('minimum_stock');
        $data['unit_id']=$this->input->post('unit_id');
        $data['unit_price']=$this->input->post('unit_price');
        $data['department_id']=$department_id;
        $data['product_type']=2;
        $data['entry_date']=date('Y-m-d');
        $data['product_description']=$this->input->post('product_description');
        $data['mdiameter']=$this->input->post('mdiameter');
        $data['mthread_count']=$this->input->post('mthread_count');
        $data['mlength']=$this->input->post('mlength');
        $data['box_id']=$this->input->post('box_id');
        $data['user_id']=$this->session->userdata('user_id');
        if($product_id==FALSE){
          if($data['product_code']==''){
            $product_code_count=$this->db->query("SELECT max(product_code_count) as counts FROM product_info 
          WHERE department_id=$department_id and product_type=2")->row('counts');
          $data['product_code']='SP-VL'.str_pad($product_code_count + 1, 8, '0', STR_PAD_LEFT);
          $data['product_code_count']=$product_code_count + 1;
          }
        $query=$this->db->insert('product_info',$data);
          $product_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('product_id',$product_id);
          $query=$this->db->update('product_info',$data);
        }
      return $product_id;
    }
  
    function delete($product_id) {
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->delete('product_info');
        return $query;
  }


  
}
