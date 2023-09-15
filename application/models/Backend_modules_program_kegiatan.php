<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_modules_program_kegiatan extends CI_Model {
	
	function GetProgramKegiatanCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('program_kegiatan_category');
		$row = $query->row();
		return $row->NameCategory;
	}
	function GetTotalProgramKegiatanInCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('program_kegiatan');
		return $query->num_rows();
	}
	

}

/* End of file Backend_modules_program_kegiatan.php */
/* Location: ./application/models/Backend_modules_program_kegiatan.php */