<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_modules_telepon_penting extends CI_Model {
	function GetTeleponPentingCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('telepon_penting_category');
		$row = $query->row();
		return $row->NameCategory;
	}
	
	function GetTotalTeleponPentingInCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('telepon_penting');
		return $query->num_rows();
	}
	

}

/* End of file Backend_modules_telepon_penting.php */
/* Location: ./application/models/Backend_modules_telepon_penting.php */