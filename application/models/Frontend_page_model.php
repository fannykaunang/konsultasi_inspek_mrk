<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_page_model extends CI_Model {

	function GetThumbnailByIdPage($IdPage){
		$query = $this->db->select('Thumbnail');
		$query = $this->db->where('IdPage', $IdPage);
		$query = $this->db->get('pages');
		if($query->num_rows()>0){
			$row = $query->row();
			$Thumbnail = $row->Thumbnail;
			if($Thumbnail !== ''){
				return $Thumbnail;
			}else{
				return null;
			}
		}else{
			return null;
		}

	}
	

}

/* End of file Frontend_category_news.php */
/* Location: ./application/models/Frontend_category_news.php */