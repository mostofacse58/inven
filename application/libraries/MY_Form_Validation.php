<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MY_Form_Validation extends CI_Form_validation
{
	
	function valid_url($field)
	{
		$FW =& get_instance();
		
		$FW->form_validation->set_message('valid_url', 'The %s field must contain a valid url.');
		
		return (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $field)) ? FALSE : TRUE;
	}
	
	function valid_option($field)
	{
		$FW =& get_instance();
		
		$FW->form_validation->set_message('valid_option', 'A valid option in the %s field must be selected.');
		
		if (empty($field))
			return FALSE;
		else
			return TRUE;
	}
	
	function valid_username($field)
	{
		$FW =& get_instance();
		
		$FW->load->model('login_mdl');
		
		$FW->form_validation->set_message('valid_username', 'Another user exists with the some username.');
		
		if ($FW->login_mdl->check_username($field))
			return FALSE;
		else
			return TRUE;
	}
	
	function is_unique_update($string, $field)
	{
		$FW =& get_instance();
		list($table, $id_column, $data_column, $data_id) = explode('.', $field, 4);

		$FW->form_validation->set_message('is_unique_update', 'The %s that you entered is already in use.');

		$FW->db->from($table)->where($data_column, $string)->where($id_column.' !=', $data_id);
		$duplicate_query = $FW->db->get();
		
		if ($duplicate_query->num_rows() > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	/* public function is_unique_update($str, $field)
   {
      $FW =& get_instance();
	  if (substr_count($field, '.')==3)
      {
         list($table,$field,$id_field,$id_val) = explode('.', $field);
         $query = $FW->db->limit(1)->where($field,$str)->where($id_field.' != ',$id_val)->get($table);
      } else {
         list($table, $field)=explode('.', $field);
         $query = $FW->db->limit(1)->get_where($table, array($field => $str));
      }
      
      return $query->num_rows() === 0;
    } */
	
	function valid_date($string) 
	{
		$FW =& get_instance();
		$FW->form_validation->set_message('valid_date', 'The %s field must be entered in YYYY-MM-DD format.');

		if (ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $string)) {
			$arr = split("-", $string);
			$yyyy = $arr[0];
			$mm = $arr[1];
			$dd = $arr[2];
			if (is_numeric($yyyy) && is_numeric($mm) && is_numeric($dd)) 
			{
				return checkdate($mm, $dd, $yyyy);
			} 
				
			else {	
				return false;
			}
		} 
			else {
				return false;
			}
	} 
	
}

/* End of file MY_Form_Validation.php */
/* Location: ./cmv/libraries/MY_Form_Validation.php */