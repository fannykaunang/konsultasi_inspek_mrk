<?php
defined('BASEPATH') or exit('No direct script access allowed');

class backend_konsultasi_model extends CI_Model
{

	function GetFullNameAuthor($IdUser)
	{
		$query = $this->db->where('IdUser', $IdUser);
		$query = $this->db->get('user');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->NameUser;
		} else {
			return null;
		}
	}

	function FlagPublishIndicator($Param)
	{
		if ($Param == 0) {
			return '<img src="' . base_url() . 'assets/backend/images/draft.png"/>';
		}
		if ($Param == 1) {
			return '<img src="' . base_url() . 'assets/backend/images/publish.png"/>';
		}
	}

	function CountRecordNews($param)
	{
		if ($param == 'all') {
			//$this->db->where('TitleNews',$param);
			return $this->db->count_all('news');
		} else {
			$this->db->like('TitleNews', $param);
			$this->db->from('news');
			return $this->db->count_all_results();
		}
	}

	function CountTotalSKPD()
	{
		return $this->db->count_all('skpd');
	}

	function CountTotalKonsultasi()
	{
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->get('konsultasi');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return null;
		}
	}

	function CountTotalKonsultasiDraft()
	{
		$query = $this->db->where('FlagPublish', 0);
		$query = $this->db->get('konsultasi');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return null;
		}
	}

	function GetAuthorNews($IdNews)
	{
		$query = $this->db->select('AuthorNews');
		$query = $this->db->where('IdNews', $IdNews);
		$query = $this->db->get('news');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->AuthorNews;
		} else {
			return null;
		}
	}

	function GetNameCategory($IdCategory)
	{
		$query = $this->db->select('NameCategory');
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('category');
		$row = $query->row();
		return $row->NameCategory;
	}

	function GetAuthorTupoksi($IDTupoksi)
	{
		$query = $this->db->select('Author');
		$query = $this->db->where('IDTupoksi', $IDTupoksi);
		$query = $this->db->get('skpdtupoksi ');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->Author;
		} else {
			return null;
		}
	}

}

/* End of file backend_konsultasi_model.php */
/* Location: ./application/models/backend_konsultasi_model.php */