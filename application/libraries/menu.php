<?php

class Menu {
    public function dynamicMenu() {
       $CI = & get_instance();
       $user_id = $CI->session->userdata('user_id');
       $department_id = $CI->session->userdata('department_id');
        $user_type = $CI->session->userdata('user_type');
        if($user_type== 1){ //get all menu for Super admin 
        $user_menu = $CI->db->query("SELECT menu_id, menu_label, link, icon, parent 
                FROM sys_menu ORDER BY sort")->result(); 
        }else {// query for employee user role    
            $user_menu = $CI->db->query("SELECT sys_user_role.*,sys_menu.*
                FROM sys_user_role
                INNER JOIN sys_menu
                ON sys_user_role.menu_id=sys_menu.menu_id
                WHERE sys_user_role.user_id=$user_id AND sys_menu.menu_indicator='Inventory'
                ORDER BY sys_menu.sort")->result();
         }

        // }elseif($user_type== 2){ //  get all menu  for department wise              
        //     $user_menu = mysql_query("SELECT menu_id, menu_label, link, icon, parent 
        //         FROM sys_menu 
        //         WHERE department_id=$department_id OR department_id=0 ORDER BY sort");
        // }elseif ($user_type= 3) {// query for employee user role    
        //     $user_menu = mysql_query("SELECT sys_user_role.*,sys_menu.*
        //         FROM sys_user_role
        //         INNER JOIN sys_menu
        //         ON sys_user_role.menu_id=sys_menu.menu_id
        //         WHERE sys_user_role.user_id=$user_id
        //         ORDER BY sys_menu.sort;");
        //  }

        $menu = array(
            'items' => array(),
            'parents' => array()
        );

        // Builds the array lists with data from the menu table
        foreach ($user_menu as  $value) {
                
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$value->menu_id] = $value;

            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$value->parent][] = $value->menu_id;
        }
        return $output = $this->buildMenu(0, $menu);
    }

    public function buildMenu($parent, $menu, $sub = NULL) {

        $html = "";

        if (isset($menu['parents'][$parent])) {
            if (!empty($sub)) {
                $html .= "<ul class='treeview-menu'>\n";
            } else {
                $html .= "<ul class='sidebar-menu'>\n";
            }
            foreach ($menu['parents'][$parent] as $itemId) {
                $result = $this->active_menu_id($menu['items'][$itemId]->menu_id);
                if ($result) {
                    $active = 'active';
                } else {
                    $active = '';
                }

                if (!isset($menu['parents'][$itemId])) { //if condition is false only view menu
                    $html .= "<li class='" . $active . "' >\n  <a href='" . base_url() . $menu['items'][$itemId]->link . "'> <i class='" . $menu['items'][$itemId]->icon . "'></i><span>" . $menu['items'][$itemId]->menu_label . "</span></a>\n</li> \n";
                }

                if (isset($menu['parents'][$itemId])) { //if condition is true show with submenu
                    $html .= "<li class='treeview " . $active . "'>\n  <a href='" . base_url() . $menu['items'][$itemId]->link. "'> <i class='" . $menu['items'][$itemId]->icon . "'></i><span>" . $menu['items'][$itemId]->menu_label . "</span><i class='fa fa-angle-left pull-right'></i></a>\n";
                    $html .= self::buildMenu($itemId, $menu, true);
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }

    public function active_menu_id($id) {
        $CI = & get_instance();
       $activeId = $CI->session->userdata('menu_active_id');

         if (!empty($activeId)) {
            foreach ($activeId as $v_activeId) {
                if ($id == $v_activeId) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

}
