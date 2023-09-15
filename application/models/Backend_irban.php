<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_irban extends CI_Model {
	
	function GetIrbanCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('irban_category');
		$row = $query->row();
		return $row->NameCategory;
	}

	function GetTotal($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('irban');
		return $query->num_rows();
	}

}

/* End of file Backend_modules_produk_hukum.php */
/* Location: ./application/models/Backend_modules_produk_hukum.php */