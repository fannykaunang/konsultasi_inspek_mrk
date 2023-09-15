<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend_news_model extends CI_Model
{

	function ViewNews()
	{
		$query = $this->db->query("
																SELECT news.IdNews,
																			news.TitleNews, 
																			news.CreatedNews,
																			news.Thumbnail,
																			user.NameUser 
																FROM news 
																JOIN user ON news.IdUser = user.IdUser 
																WHERE news.FlagPublish = 1 
																ORDER BY CreatedNews DESC 
																LIMIT 1
															");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	function LatestNews($Record)
	{
		$query = $this->db->query("
																SELECT news.IdNews,
																			news.TitleNews, 
																			news.CreatedNews,
																			news.Thumbnail,
																			user.NameUser 
																FROM news 
																JOIN user ON news.IdUser = user.IdUser 
																WHERE news.FlagPublish = 1 
																ORDER BY CreatedNews DESC 
																LIMIT $Record
															");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}

/* End of file Frontend_news_model.php */
/* Location: ./application/models/Frontend_news_model.php */