<?php

class Navigation extends My_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('model_navigation');
    }
    
  ////////////////////////////////////////
    ////////////// Manu List
    ////////////////////////////////////////
    public  function lists(){
        if($this->session->userdata('user_id')){
        $data['heading'] = "Navigation List";
        
        $data['list']=$this->model_navigation->lists();
        $data['display']='navigation/list';
        $this->load->view('admin/master',$data);
     }else{
        redirect("admin/index");
    }
}
 
  ////////////////////////////////////////
    ////////////// ADD Manu
    ////////////////////////////////////////
    public function add(){
        if($this->session->userdata('user_id')){
            $data['heading'] = "Add Menu";
            $data['dlist']=$this->look_up_model->departmentList();
            $data['mlist'] = $this->model_navigation->get_menu();
            $data['display']='navigation/add';
            $this->load->view('admin/master',$data);
         

        }else{
            redirect("admin/index");
        }
    }
     ////////////////////////////////////////
    ////////////// Edit Manu
    ////////////////////////////////////////
    public  function edit($menu_id=''){
        if($this->session->userdata('user_id')){
            $data['heading'] = "Add Menu";
            $data['info']=$this->db->get_where('sys_menu',array('menu_id'=>$menu_id))->row();
            $data['dlist']=$this->look_up_model->departmentList();
            $data['mlist'] = $this->model_navigation->get_menu();
            $data['display']='navigation/add';
            $this->load->view('admin/master',$data);
        
           

        }else{
            redirect("admin/index");
        }
    }
      ////////////////////////////////////////
    ////////////// DELETE Manu
    ////////////////////////////////////////
    function delete($menu_id){
        $this->db->delete('sys_menu',['menu_id'=>$menu_id]);
        $this->session->set_userdata('exception','Deleted successfully');
        redirect("navigation/lists");
    }


    ////////////////////////////////////////
    ////////////// SAVE Manu
    ////////////////////////////////////////
    public function  save($menu_id=FALSE){
        if($this->session->userdata('user_id')){
        	if($menu_id==FALSE)
            $this->form_validation->set_rules('menu_label','Menu Label','trim|required');
            else
           $this->form_validation->set_rules('link','Menu Link','trim|required');
            $this->form_validation->set_rules('icon','Icon','trim|required|max_length[100]');
            $this->form_validation->set_rules('parent','Parent','trim|xss_clean');
            $this->form_validation->set_rules('sort','Sort','trim|required');
            if ($this->form_validation->run() == TRUE) {
                $data=array();
                $data['menu_label']=$this->input->post('menu_label');
                $data['link']=$this->input->post('link');
                $data['icon']=$this->input->post('icon');
                $data['parent']=$this->input->post('parent');
                $data['sort']=$this->input->post('sort');
                $data['department_id']=$this->input->post('department_id');
                if($menu_id==FALSE){
                 $this->db->insert('sys_menu',$data);
                 $this->session->set_userdata('exception','Saved successfully');
                }else{
                 $this->db->WHERE('menu_id',$menu_id);
                 $this->db->update('sys_menu',$data);
                 $this->session->set_userdata('exception','Updated successfully');
                }
                redirect("navigation/lists");
            }else{
            $data['heading']="Add Menu";
            if($menu_id){
              $data['heading']="Edit Menu";
              $data['info']=$this->db->get_where('sys_menu',array('menu_id'=>$menu_id))->row();
            }
            
            $data['mlist'] = $this->model_navigation->get_menu();
            $data['display']='navigation/add';
            $this->load->view('admin/master',$data);
            }
        }else{
            redirect(site_url("admin/index"));
        }
    }



}  