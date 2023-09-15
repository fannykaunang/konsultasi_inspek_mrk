<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend_model extends CI_Model
{

	/*navbar*/
	function GetTitlePageByIdCategory($IdCategoryPage)
	{
		$query = $this->db->where('IdCategoryPage', $IdCategoryPage);
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->get('pages');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	/*navbar*/
	function GetEventStory()
	{
		return $this->db->query("SELECT * FROM eventstory WHERE FlagPublish='1'")->result();
	}

	/*SiteMode*/
	function ModePerawatan()
	{
		$query = $this->db->select('SiteMode');
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->SiteMode;
		} else {
			return null;
		}
	}

	/*cuplikan*/
	function CuplikanX($param, $panjang)
	{
		$text = '';
		$max = '250';

		$expl = explode(" ", $param);
		$awal = '10';

		for ($i = $awal; $i <= $panjang; $i++) {
			//$text .= preg_replace('/^style=[^A-Za-z0-9]/', '-', $expl[$i]);
			if ($i == $awal) {
				$text = ucfirst($expl[0]) . ' ';
			}
			$text .= $expl[$i] . ' ';
		}
		$panjangtext = strlen($text);

		if ($panjangtext > $max) {
			$selisihtext = $panjangtext - $max;
			$text = substr($text, 0, -$selisihtext);
			return $text;
		} else if ($panjangtext < $max) {
			return $text;
		}
	}
	function Cuplikan($ContentNews)
	{
		$pagebreak = '<!-- pagebreak -->';
		$expl = explode($pagebreak, $ContentNews);

		if (count($expl) > 1) {
			return $expl[0] . ' ..... ';
		} else {
			$slice = explode(" ", $ContentNews);
			$length = 20;
			if (count($slice) > $length) {
				$PreviewNews = '';
				for ($a = 0; $a < $length; $a++) {
					$PreviewNews .= $slice[$a] . ' ';
				}
				return strip_tags($PreviewNews, '<b>') . ' ..... ';
			} else {
				return $ContentNews;
			}
		}
	}
	function GetNewsByIdNews($IdNews)
	{
		$query = $this->db->where('IdNews', $IdNews);
		$query = $this->db->get('news');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}
	function AddReadRating($IdNews)
	{
		$query = $this->db->query("SELECT ReadRating FROM news WHERE IdNews='$IdNews'");
		$row = $query->row();
		$ReadRating = $row->ReadRating;

		$data = array(
			'ReadRating' => $ReadRating + 1
		);
		$query = $this->db->where('IdNews', $IdNews);
		$query = $this->db->update('news', $data);
	}
	function PreviewNews($ContentNews, $length)
	{
		$slice = explode(" ", $ContentNews);
		if (count($slice) > $length) {
			$PreviewNews = '';
			for ($a = 0; $a < $length; $a++) {
				$PreviewNews .= $slice[$a] . ' ';
			}
			return strip_tags($PreviewNews, '<b>') . '...';
		} else {
			return $ContentNews . '...';
		}
	}
	function GetDateNews($IdNews)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(CreatedNews,'%d') as CreatedNews FROM news WHERE IdNews='$IdNews'");
		$row = $query->row();
		return $row->CreatedNews;
	}
	function GetMonthNews($IdNews)
	{
		$query = $this->db->query("SELECT DATE_FORMAT(CreatedNews,'%b') as CreatedNews FROM news WHERE IdNews='$IdNews'");
		$row = $query->row();
		return $row->CreatedNews;
	}
	function GetTitleNewsById($IdNews)
	{
		$query = $this->db->query("SELECT TitleNews FROM news WHERE IdNews='$IdNews'");
		$row = $query->row();
		return $row->TitleNews;
	}
	/*cuplikan*/
	/*thumbnail*/
	function GetThumbnail($IdNews, $Size)
	{

		$query = $this->db->select('Thumbnail');
		$query = $this->db->where("IdNews", $IdNews);
		$query = $this->db->get("news");

		$row = $query->row();
		$thumbnail = $row->Thumbnail;
		if ($thumbnail !== '') {
			return '<img src="' . base_url() . $row->Thumbnail . '" ' . $Size . ' />';
		} else {

			return '<img src="' . base_url() . 'assets/frontend/themes/2017/images/post-1/img-01.jpg" alt="">';
		}
		//echo base_url().'assets/frontend/images/logo.png'; tidak ditampilkan

	}

	function GetProfilePicture($AuthorNews, $Size)
	{

		$query = $this->db->where('NameUser', $AuthorNews);
		$query = $this->db->get('user');
		$row = $query->row();

		$picture = $row->PictureUser;
		if ($picture !== null) {
			return '<img style="margin-bottom: 20px;" src="' . base_url() . $row->PictureUser . '" ' . $Size . ' />';
		} else {
			return '<img src="' . base_url() . 'assets/frontend/themes/2017/images/post-1/img-01.jpg" alt="" width="233" height="173">';
		}
		//echo base_url().'assets/frontend/images/logo.png'; tidak ditampilkan

	}
	/*thumbnail*/
	/*news*/
	function GetNewNews($jumlah)
	{
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->order_by('CreatedNews', 'DESC');
		$query = $this->db->limit($jumlah);
		return $this->db->get('news')->result();
	}

	function GetNewsByCategory($param, $jumlah)
	{
		return $this->db->query("SELECT * FROM news WHERE CategoryNews='$param' AND FlagPublish='1' ORDER BY CreatedNews DESC LIMIT 0,$jumlah")->result();
	}
	function GetTitleNews($IdNews)
	{
		/*$query = $this->db->query("SELECT TitleNews FROM news WHERE IdNews='$IdNews'");
			$row = $query->row();
			return $row->TitleNews;
			*/
		return $this->db->query("SELECT TitleNews FROM news WHERE IdNews='$IdNews'")->result();
	}
	function GetRelatedNews($IdNews, $Limit)
	{
		$query = $this->db->where('IdNews', $IdNews);
		$query = $this->db->get('news');
		if ($query->num_rows() > 0) {
			$row = $query->row();

			$TitleNews = $row->TitleNews;
			$slice = explode(" ", $TitleNews);
			if (count($slice) > 1) {
				$keyword1 = $slice[0];
				$keyword2 = $slice[1];

				$sql = " SELECT * FROM news ";
				$sql .= " WHERE (ContentNews LIKE '%$keyword1%' OR ContentNews LIKE '%$keyword2%') AND FlagPublish = 1 ";
				//$sql .= " AND FlagPublish = 1 ";
				$sql .= " ORDER BY CreatedNews DESC LIMIT 0, $Limit ";

				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					return $query->result();
				} else {
					return null;
				}
			} else {
				$sql = " SELECT * FROM news ";
				$sql .= " WHERE (ContentNews LIKE '%$TitleNews%') AND FlagPublish = 1 ";
				//$sql .= " AND FlagPublish = 1 ";
				$sql .= " ORDER BY CreatedNews DESC LIMIT 0, $Limit ";

				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					return $query->result();
				} else {
					return null;
				}
			}
		}
	}

	function GetNewsTerkait($kategori, $jumlah)
	{

		$query = $this->db->where('CategoryNews', $kategori);
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->order_by('CreatedNews', 'DESC');
		$query = $this->db->limit($jumlah);
		return $this->db->get('news')->result();
	}
	function GetTrendingNews($Limit)
	{
		$query = $this->db->query("SELECT * FROM news ORDER BY ReadRating DESC LIMIT $Limit");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	function GetRandomNews($Limit)
	{
		$query = $this->db->query("
																	SELECT IdNews, TitleNews, CategoryNews, FlagPublish 
																	FROM news 
																	WHERE FlagPublish = 1
																	ORDER BY RAND() DESC LIMIT $Limit
																	");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	function GetNewsMonth()
	{
		$Year = date('Y');
		$query = $this->db->query("
																	SELECT DISTINCT(DATE_FORMAT(CreatedNews, '%M')) AS Month 
																	FROM news 
																	WHERE YEAR(CreatedNews) = $Year 
																	ORDER BY CreatedNews ASC");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	function GetNewsByMonth($Month)
	{
		$Year = date('Y');
		$MonthYear = $Month . ' ' . $Year;
		$query = $this->db->query("
																SELECT * FROM news 
																WHERE DATE_FORMAT(CreatedNews, '%M %Y') = '$MonthYear' AND FlagPublish = 1 
																ORDER BY CreatedNews ASC LIMIT 7
																");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	function GetLatestNews($Limit)
	{
		$query = $this->db->order_by('CreatedNews', 'DESC');
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->limit($Limit);
		$query = $this->db->get('news');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	function GetTopNews($Periode, $Limit)
	{
		if ($Periode == 'week') {
			$query = $this->db->query("
																		SELECT * 
																		FROM news 
																		WHERE YEARWEEK(CreatedNews) = YEARWEEK(NOW()) AND FlagPublish = 1
																		ORDER BY ReadRating DESC LIMIT 0, $Limit
																		");
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}
		}
		if ($Periode == 'month') {
			$query = $this->db->query("
																		SELECT * FROM news 
																		WHERE YEAR(CreatedNews) = YEAR(NOW()) AND MONTH(CreatedNews) = MONTH(NOW()) AND FlagPublish = 1
																		ORDER BY ReadRating DESC LIMIT 0, $Limit
																	");
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}
		}
		if ($Periode == 'all') {
			$query = $this->db->query("
																			SELECT * FROM news 
																			ORDER BY ReadRating DESC LIMIT 0, $Limit
																		");
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}
		}
	}
	/*news*/
	/*comment*/
	function GetComment($jumlah)
	{
		return $this->db->query("SELECT * FROM comment WHERE FlagPublish='1' ORDER BY DateComment DESC LIMIT 0, $jumlah")->result();
	}
	function GetFlagCommentByIdNews($IdNews)
	{
		$query = $this->db->query("SELECT FlagComment FROM news WHERE IdNews='$IdNews'");
		$row = $query->row();
		return $row->FlagComment;
	}
	function GetCommentByIdNews($IdNews)
	{
		return $this->db->query("SELECT * FROM comment WHERE IdNews='$IdNews' AND FlagPublish='1' ORDER BY DateComment DESC ")->result();
	}
	/*comment*/
	/*category*/
	function GetNewsByNameCategory($NameCategory, $Limit, $Offset)
	{
		$this->db->from('news');
		$this->db->where('CategoryNews', $NameCategory);
		$this->db->where('FlagPublish', 1);
		$this->db->order_by("CreatedNews", "DESC");
		$this->db->limit($Limit, $Offset);
		// if ($Limit != '' && $Offset != '') {
		// 	$this->db->limit($Limit, $Offset);
		// }
		$query  = $this->db->get();

		return $query->result();

		// $query = $this->db->where('CategoryNews', $NameCategory);
		// $query = $this->db->where('FlagPublish', 1);
		// $query = $this->db->order_by('CreatedNews', 'DESC');
		// $this->db->limit($Limit, $Offset);
		// $query = $this->db->get('news');
		// return $query->result();

		// $query = $this->db->where('CategoryNews', $NameCategory);
		// $query = $this->db->where('FlagPublish', 1);
		// $query = $this->db->order_by('CreatedNews', 'DESC');
		// $query = $this->db->limit($Limit, $Offset);
		// $query = $this->db->get('news');
		// if ($query->num_rows() > 0) {
		// 	foreach ($query->result() as $row) {
		// 		$data[] = $row;
		// 	}
		// 	return $data;
		// 	//return $query->result();
		// } else {
		// 	return null;
		// }
	}
	function GetSearchNews($s = NULL, $limit, $start)
	{
		$query = $this->db->like('TitleNews', $s);
		$query = $this->db->or_like('ContentNews', $s);
		$query = $this->db->order_by('CreatedNews', 'DESC');
		$query = $this->db->limit($limit, $start);
		$query = $this->db->get('news');
		return $query->result();
	}
	function GetNameCategory()
	{
		return $this->db->query("SELECT NameCategory FROM category WHERE FlagPublish='1' ORDER BY NameCategory ASC")->result();
	}
	function GetTotalNewsByCategory($NameCategory)
	{
		$query = $this->db->query("SELECT COUNT(TitleNews) AS TotalNews FROM news WHERE CategoryNews='$NameCategory'");
		$row = $query->row();
		return $row->TotalNews;
	}
	/*category*/
	/*captcha-comment*/
	function GetRandomCaptcha()
	{
		return $this->db->query("SELECT * FROM captcha ORDER BY rand() LIMIT 1")->result();
	}
	function GetAnswerCaptcha($IdCaptcha)
	{
		$query = $this->db->query("SELECT Answer FROM captcha WHERE IdCaptcha='$IdCaptcha'");
		$row = $query->row();
		return $AnswerTrue = $row->Answer;
	}
	/*captcha-comment*/
	/*comment*/
	function AddComment()
	{

		$IdNews = $this->input->post('IdNews');
		$IdCaptcha = $this->input->post('IdCaptcha');
		$NameComment = $this->input->post('name');
		$EmailComment = $this->input->post('email');
		$ContentComment = $this->input->post('comment');
		$DateComment = date('Y-m-d H:i:s');
		$IPComment = $_SERVER['REMOTE_ADDR'];
		$RefererComment = $_SERVER['HTTP_REFERER'];
		$UserAgentComment = $_SERVER['HTTP_USER_AGENT'];
		$FlagPublish = '0';
		$FlagSpam = '0';
		$TitleNews = $this->GetTitleNewsById($IdNews);

		$Answer = strtolower($this->input->post('answer'));

		$AnswerTrue = strtolower($this->GetAnswerCaptcha($IdCaptcha));
		if ($Answer !== $AnswerTrue) {
			$respon = array(
				'status' => 'jawabansalah',
				'message' => 'Jawaban anda salah'
			);
		} else {
			$data = array(
				'IdNews' => $IdNews,
				'NameComment' => $NameComment,
				'EmailComment' => $EmailComment,
				'ContentComment' => $ContentComment,
				'DateComment' => $DateComment,
				'IPComment' => $IPComment,
				'RefererComment' => $RefererComment,
				'UserAgentComment' => $UserAgentComment,
				'FlagPublish' => $FlagPublish,
				'FlagSpam' => $FlagSpam,
				'TitleNews' => $TitleNews
			);
			$query = $this->db->insert('comment', $data);
			if ($query) {
				$respon = array(
					'status' => 'sukses',
					'message' => 'Terima kasih telah memberikan komentar, kami akan mereview komentar anda'
				);
			} else {
				$respon = array(
					'status' => 'gagal',
					'message' => 'Komentar anda gagal diterima, periksa kembali komentar anda'
				);
			}
		}
		echo json_encode($respon);
	}
	/*comment*/

	/*slider*/
	function GetSlider()
	{
		return $this->db->query("SELECT * FROM settingsfrontslider WHERE FlagPublish = 1 ")->result();
	}
	/*slider*/

	/*statistik/log*/
	function InsertVisitorLog()
	{
		$this->load->library('user_agent');

		$UserAgent = $_SERVER['HTTP_USER_AGENT'];
		$UserAgent = $this->seo_model->ParserUserAgent($UserAgent);

		if ($UserAgent['platform'] !== NULL && $UserAgent['browser'] !== NULL && $UserAgent['version'] !== NULL) {
			$query = $this->db->get('settings');
			$row = $query->row();
			$MaxLogs = $row->MaxLogs;

			$Total = $this->db->count_all_results('logsvisitor');

			if ($Total >= $MaxLogs) {
				//reset to 0;
				$this->db->truncate('logsvisitor');
			} else {
				if (empty($RefererLog) == true ? $RefererLog = '' : $RefererLog = $_SERVER['HTTP_REFERER']);

				foreach ($this->seo_model->ParserUserAgent() as $key => $value) {
					if ($key == 'platform') {
						$platform = $value;
					}
					if ($key == 'browser') {
						$agent = $value;
					}
					if ($key == 'version') {
						$version = $value;
					}
				};


				$Browser = $agent;
				$Version = $version;
				$Platform = $platform;


				$data = array(
					'IPAddress' => $_SERVER['REMOTE_ADDR'],
					'TimeStamp' => date('Y-m-d H:i:s'),
					'Url' => current_url(),
					'Browser' => $Browser,
					'Mobile' => $this->agent->mobile(),
					'Platform' => $Platform,
					'Version' => $Version,
					'Robot' => $this->agent->robot(),
					'AgentString' => $this->agent->agent_string(),
					'IsMobile' => $this->agent->is_mobile(),
					'IsBrowser' => $this->agent->is_browser(),
					'IsRobot' => $this->agent->is_robot()
				);
				$this->db->insert('logsvisitor', $data);
			}
		}
	}
	function GetVisitorToday()
	{
		$query = $this->db->query("SELECT COUNT(*) AS Total FROM logsvisitor WHERE DATE(TimeStamp) = CURDATE()");
		$row = $query->row();
		return $row->Total;
	}
	function GetVisitorWeek()
	{
		$query = $this->db->query("SELECT COUNT(*) AS Total FROM logsvisitor WHERE YEARWEEK(TimeStamp)=YEARWEEK(NOW())");
		$row = $query->row();
		return $row->Total;
	}
	function GetVisitorMonth()
	{
		$query = $this->db->query("SELECT COUNT(*) AS Total FROM logsvisitor WHERE MONTH(TimeStamp)=MONTH(CURDATE())");
		$row = $query->row();
		return $row->Total;
	}
	function GetVisitorTahunIni()
	{
		$query = $this->db->query("SELECT COUNT(*) AS Total FROM logsvisitor WHERE YEAR(TimeStamp)=YEAR(CURDATE())");
		$row = $query->row();
		return $row->Total;
	}
	/*end statistik/log*/
	/*count news by category*/
	function CountNewsByCategory($NameCategory)
	{
		$query = $this->db->where('CategoryNews', $NameCategory);
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->get('news');
		return $query->num_rows();
	}

	/*count directory by category*/
	function GetDirectoryByNameCategory($NameCategory, $Start, $Limit)
	{

		$query = $this->db->where('CategoryDirectory', $NameCategory);
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->order_by('CreatedDirectory', 'DESC');
		$query = $this->db->limit($Limit, $Start);
		$query = $this->db->get('directory');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	function CountDirectoryByCategory($NameCategory)
	{
		$query = $this->db->where('CategoryDirectory', $NameCategory);
		$query = $this->db->get('directory');
		return $query->num_rows();
	}
	function GetThumbnailDirectory($IdDirectory, $Size)
	{

		$query = $this->db->select('Thumbnail');
		$query = $this->db->where("IdDirectory", $IdDirectory);
		$query = $this->db->get("directory");

		$row = $query->row();
		$thumbnail = $row->Thumbnail;
		if ($thumbnail !== '') {

			return '<img src="' . $row->Thumbnail . '" ' . $Size . ' />';
		} else {

			return '<img src="' . base_url() . 'assets/frontend/themes/2017/images/post-1/img-01.jpg" alt="">';
		}
		//echo base_url().'assets/frontend/images/logo.png'; tidak ditampilkan

	}
	/*modules*/
	function GetGalleryCategoryThumbnail($IdCategory)
	{

		$query = $this->db->query("
											SELECT Fullpath FROM gallery 
											WHERE IdCategory='$IdCategory' AND FlagPublish=1
											ORDER BY RAND() LIMIT 1
											");
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->Fullpath;
		} else {
			return null;
		}
	}
	function GetTotalGalleryInCategory($IdCategory)
	{
		$query = $this->db->where('FlagPublish', 1);
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->Get('gallery');
		return $query->num_rows();
	}
	/*modules*/
	/*weather*/
	function GetWeather()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.openweathermap.org/data/2.5/weather?q=merauke,id&appid=0032843a04419a2be3d04296f6723c18');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPGET, true);

		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json'
		));

		$Weather = curl_exec($ch);
		$Weather = json_decode($Weather, true);
		curl_close($ch);
	}
}

/* End of file Frontend_model.php */
/* Location: ./application/models/Frontend_model.php */