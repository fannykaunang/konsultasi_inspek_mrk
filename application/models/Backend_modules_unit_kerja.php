<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_modules_unit_kerja extends CI_Model {
	
	function GetUnitKerjaCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('dok_unit_kerja_category');
		$row = $query->row();
		return $row->NameCategory;
	}

	function GetTotal($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('dok_unit_kerja');
		return $query->num_rows();
	}

}

/* End of file Backend_modules_produk_hukum.php */
/* Location: ./application/models/Backend_modules_produk_hukum.php */