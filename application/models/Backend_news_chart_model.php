<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backend_news_chart_model extends CI_Model
{

	function NewsChart()
	{
		$query = $this->db->query("
								SELECT COUNT(*) as News, DATE_FORMAT(CreatedNews,'%b %Y') as Month from news 
								WHERE CreatedNews >= (CURDATE() - INTERVAL 1 YEAR)
								GROUP BY DATE_FORMAT(CreatedNews, '%b %Y') 
								ORDER BY CreatedNews ASC
							");
		if ($query->num_rows() > 0) {
			$Month = array();
			$News = array();
			foreach ($query->result() as $row) {
				$Month[] = $row->Month;
				$News[] = intval($row->News);
			}
			$query = $this->db->query("
								SELECT COUNT(*) AS Total 
								FROM news 
								WHERE CreatedNews >= (CURDATE() - INTERVAL 1 YEAR)
							");
			$row = $query->row();
			$Total = $row->Total;

			$respon = array(
				'status' => 'sukses',
				'message' => 'Graifk Berita',
				'label' => '(Dalam 1 tahun, total: ' . $Total . ')',
				'news' => $News,
				'month' => $Month
			);
		} else {
			$respon = array(
				'status' => 'tidak tersedia',
				'message' => 'Grafik tidak tersedia'
			);
		}

		echo json_encode($respon);
	}

	function VisitorChart()
	{
		$query = $this->db->query("
								SELECT COUNT(*) AS Visitor, DATE_FORMAT(TimeStamp,'%b %Y') AS Month 
								FROM logsvisitor 
								WHERE TimeStamp >= (CURDATE() - INTERVAL 1 YEAR)
								GROUP BY DATE_FORMAT(TimeStamp, '%b %Y')
								ORDER BY TimeStamp ASC
							");
		if ($query->num_rows() > 0) {
			$Month = array();
			$Visitor = array();
			foreach ($query->result() as $row) {
				$Month[] = $row->Month;
				$Visitor[] = intval($row->Visitor);
			}
			$query = $this->db->query("
								SELECT COUNT(*) AS Total 
								FROM logsvisitor 
								WHERE TimeStamp >= (CURDATE() - INTERVAL 1 YEAR)
								GROUP BY DATE_FORMAT(TimeStamp, '%b %Y') AND IPAddress
							");
			$row = $query->row();
			$Total = $row->Total;

			$respon = array(
				'status' => 'sukses',
				'message' => 'Grafik Pengunjung',
				'label' => '(Dalam 1 tahun, total: ' . $Total . ')',
				'visitor' => $Visitor,
				'month' => $Month
			);
		} else {
			$respon = array(
				'status' => 'tidak tersedia',
				'message' => 'Grafik tidak tersedia'
			);
		}

		echo json_encode($respon);
	}

	function PelaporChart()
	{
		$query = $this->db->query("
								SELECT COUNT(*) AS Laporan, DATE_FORMAT(Time,'%b %Y') AS Month 
								FROM konsultasi 
								WHERE Time >= (CURDATE() - INTERVAL 1 YEAR)
								AND FlagPublish = 1
								GROUP BY DATE_FORMAT(Time, '%b %Y')
								ORDER BY Time ASC
							");
		if ($query->num_rows() > 0) {
			$Month = array();
			$Laporan = array();
			foreach ($query->result() as $row) {
				$Month[] = $row->Month;
				$Laporan[] = intval($row->Laporan);
			}
			$query = $this->db->query("
								SELECT COUNT(*) AS Total 
								FROM konsultasi 
								WHERE Time >= (CURDATE() - INTERVAL 1 YEAR)
								GROUP BY DATE_FORMAT(Time, '%b %Y')
							");
			$row = $query->row();
			$Total = $row->Total;

			$respon = array(
				'status' => 'sukses',
				'message' => 'Grafik Pelaporan',
				'label' => '(Dalam 1 tahun, total: ' . $Total . ')',
				'Laporan' => $Laporan,
				'month' => $Month
			);
		} else {
			$respon = array(
				'status' => 'tidak tersedia',
				'message' => 'Grafik tidak tersedia'
			);
		}

		echo json_encode($respon);
	}
}

/* End of file Backend_news_chart_model.php */
/* Location: ./application/models/Backend_news_chart_model.php */