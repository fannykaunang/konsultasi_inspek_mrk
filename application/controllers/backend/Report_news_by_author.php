<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_news_by_author extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Report penulis - Inspektorat Kabupaten Merauke';
			$data['reportmenu'] = 'active';
			$data['reportnewsbyauthorsubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$RoleReportCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'ReportCreate');
			if ($RoleReportCreate == 'no') {
				$RoleReportCreate = 'disabled';
			}
			$data['RoleReportCreate'] = $RoleReportCreate;
			/*role*/
			$query = $this->db->order_by('FullName', 'ASC');
			$query = $this->db->get('user');
			$data['authornews'] = $query->result();

			$this->load->view("backend/report-news-by-author", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}

	}

	function ajax()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				if ($do = $this->input->post('do')) {
					switch ($do) {
						case "ReportNewsByAuthor":

							$query = $this->db->query("
									SELECT COUNT(*) AS Total, IdUser, AuthorNews
									FROM news
									GROUP BY IdUser
									ORDER BY Total DESC				
									LIMIT 21									
									");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$categories[] = $this->backend_konsultasi_model->GetFullNameAuthor($row->IdUser);
									$Total[] = intval($row->Total);
								}
								$data[] = array(
									'name' => 'Berita',
									'data' => $Total
								);
								//var_dump($categories);
								//var_dump($Total);

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik berita',
									'title' => 'Grafik Total Berita',
									'subtitle' => 'Oleh semua penulis',
									'ytitle' => 'Jumlah Berita',
									'xtitle' => 'Penulis',
									'categories' => $categories,
									'data' => $data
								);
							} else {
								$respon = array(
									'status' => 'notfound',
									'message' => 'Grafik tidak tersedia'
								);
							}
							echo json_encode($respon);
							break;
						case "ReportNewsByAuthor_BACKUP":
							$query = $this->db->query("
									SELECT COUNT(*) AS Total, IdUser
									FROM news
									GROUP BY IdUser
									ORDER BY Total DESC 										
									");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$data[] = array($this->back->GetFullNameAuthor($row->IdUser), intval($row->Total));
								}

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik berita',
									'title' => 'Grafik Total Berita',
									'subtitle' => 'Oleh semua penulis',
									'ytitle' => 'Jumlah Berita',
									'xtitle' => 'Penulis',
									'data' => $data
								);
							} else {
								$respon = array(
									'status' => 'notfound',
									'message' => 'Grafik tidak tersedia'
								);
							}
							echo json_encode($respon);
							break;
						case "GraphByPeriode":
							$StartPeriode = $this->input->post('StartPeriode');
							$EndPeriode = $this->input->post('EndPeriode');

							$Start = DateSlashMysql($StartPeriode);
							$End = DateSlashMysql($EndPeriode);

							$StartTitle = new DateTime($Start);
							$StartTitle = $StartTitle->Format('d M Y');

							$EndTitle = new DateTime($End);
							$EndTitle = $EndTitle->Format('d M Y');


							$query = $this->db->query("
									SELECT COUNT(*) AS Total, IdUser, AuthorNews
									FROM news
									WHERE CreatedNews BETWEEN '$Start' AND '$End'
									GROUP BY IdUser
									ORDER BY Total DESC
									LIMIT 21					
									");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$categories[] = $this->backend_konsultasi_model->GetFullNameAuthor($row->IdUser);
									$Total[] = intval($row->Total);
								}
								$data[] = array(
									'name' => 'Berita',
									'data' => $Total
								);

								//var_dump($Total);

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik berita',
									'title' => 'Grafik Total Berita',
									'subtitle' => 'Oleh semua penulis, periode: ' . $StartTitle . ' - ' . $EndTitle,
									'ytitle' => 'Jumlah Berita',
									'xtitle' => 'Penulis',
									'categories' => $categories,
									'data' => $data
								);
							} else {
								$respon = array(
									'status' => 'notfound',
									'message' => 'Grafik tidak tersedia'
								);
							}
							echo json_encode($respon);
							break;
						case "GraphByAuthorPerPeriode":
							$IdUser = $this->input->post('IdUser');

							$StartPeriode = $this->input->post('StartPeriode');
							$EndPeriode = $this->input->post('EndPeriode');

							$Start = DateSlashMysql($StartPeriode);
							$End = DateSlashMysql($EndPeriode);

							$StartTitle = new DateTime($Start);
							$StartTitle = $StartTitle->Format('d M Y');

							$EndTitle = new DateTime($End);
							$EndTitle = $EndTitle->Format('d M Y');


							$query = $this->db->query("
										SELECT COUNT(*) AS Total, DATE_FORMAT(CreatedNews, '%M %Y') AS Days
										FROM news										
										WHERE CreatedNews BETWEEN '$Start' AND '$End' AND IdUser='$IdUser'
										GROUP BY DATE_FORMAT(CreatedNews, '%M %Y')
										ORDER BY CreatedNews DESC 										
									");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$data[] = array($row->Days, intval($row->Total));
								}

								$respon = array(
									'status' => 'sukses',
									'message' => 'Graifk berita',
									'title' => 'Grafik Total Berita',
									'subtitle' => 'Oleh penulis: ' . $this->back->GetFullNameAuthor($IdUser) . ', periode: ' . $StartTitle . ' - ' . $EndTitle,
									'ytitle' => 'Jumlah Berita',
									'xtitle' => 'Penulis',
									'author' => $this->back->GetFullNameAuthor($IdUser),
									'data' => $data
								);
							} else {
								$respon = array(
									'status' => 'tidak tersedia',
									'message' => 'Grafik tidak tersedia'
								);
							}
							echo json_encode($respon);
							break;
					}
				}
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}
	}
}
?>