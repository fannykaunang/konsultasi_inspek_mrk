<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_modules_produk_hukum extends CI_Model {
	
	function GetProdukHukumCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('produk_hukum_category');
		$row = $query->row();
		return $row->NameCategory;
	}
	function GetTotalProdukHukumInCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('produk_hukum');
		return $query->num_rows();
	}
	
}

/* End of file Backend_modules_produk_hukum.php */
/* Location: ./application/models/Backend_modules_produk_hukum.php */