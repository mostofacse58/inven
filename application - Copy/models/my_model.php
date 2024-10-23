<?php
class My_model extends CI_Model {
    public function select_menu_by_uri($uriSegment) {
        $result = $this->db->query("SELECT * FROM sys_menu 
            WHERE link='$uriSegment' ")->row();
        //echo $this->db->last_query(); exit();
        if ($result){
            $menuId[] = $result->menu_id;
            $menuId = $this->select_menu_by_id($result->parent, $menuId);
        } else {

            return false;
        }
        if (!empty($menuId)) {
            $lastId = end($menuId);
            $parrent = $this->select_menu_first_parent($lastId);
            array_push($menuId, $parrent->parent);
            return $menuId;
        }
    }

    public function select_menu_by_id($id, $menuId) {
        $result = $this->db->query("SELECT * FROM sys_menu 
            WHERE menu_id='$id' ")->row();
        if ($result) {
            array_push($menuId, $result->menu_id);
            if ($result->parent != 0) {
                $result = self::select_menu_by_id($result->parent, $menuId);
            }
        }
        return $menuId;
    }

    public function select_menu_first_parent($lastId) {
        $this->db->select('sys_menu.*', FALSE);
        $this->db->from('sys_menu');
        $this->db->where('menu_id', $lastId);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }
	 public function checkpermission(){

        if($this->session->userdata('user_type')!= 1&&$this->session->userdata('user_type')!= 2){
        $controll=$this->router->fetch_directory().$this->router->fetch_class();

        $user_id=$this->session->userdata('user_id');
        $result=$this->db->query("SELECT s.menu_id FROM sys_user_role sr,sys_menu s 
        WHERE s.menu_id=sr.menu_id and sr.user_id=$user_id and s.link LIKE '$controll%' ")->row('menu_id');
        if($result){
            return true;  
        }else{
            echo '<script> alert("You don\'t have permission to access this url");</script>';
            echo "<p style='color:red; font-size:20px;'>&nbsp; You don't have permission to access this page</p>";                  
            exit();
        }
        }else{
            return true;
        }
    }

    public function checkurl(){
        $chhh=base_url();
        $dat=date('Y-m-d');

         //  if($chhh=='http://localhost/inventorymanagement/' && '2017-12-30'>$dat){
         //    return true;   
         // }else{
         //   echo "<p style='color:red; font-size:20px;'>&nbsp; Not Found</p>";
         //    exit();
        
         // }
       }


}
