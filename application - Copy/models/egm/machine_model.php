<?php
class Machine_model extends CI_Model {
    function lists() {
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          mt.machine_type_name,b.brand_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=$department_id and p.product_type=1
          ORDER BY p.product_id DESC")->result();
        return $result;
    }
    function get_info($product_id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          mt.machine_type_name,b.brand_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=$department_id and p.product_type=1 and
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
        $data['product_code']=$this->input->post('product_model');
        $data['product_name']=$this->input->post('product_name');
        $data['china_name']=$this->input->post('china_name');
        $data['category_id']=$this->input->post('category_id');
        $data['machine_type_id']=$this->input->post('machine_type_id');
        $data['brand_id']=$this->input->post('brand_id');
        $data['mtype_id']=$this->input->post('mtype_id');
        $data['minimum_stock']=$this->input->post('minimum_stock');
        $data['unit_id']=$this->input->post('unit_id');
        $data['department_id']=$department_id;
        $data['product_type']=1;
        $data['entry_date']=date('Y-m-d');
        $data['product_description']=$this->input->post('product_description');
        $data['user_id']=$this->session->userdata('user_id');
        if($product_id==FALSE){
        $query=$this->db->insert('product_info',$data);
          $product_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('product_id',$product_id);
          $query=$this->db->update('product_info',$data);
        }
      return $product_id;
    }
  
    function delete($product_id) {
      $department_id=$this->session->userdata('department_id');
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->delete('product_info');
        return $query;
  }
  
}
