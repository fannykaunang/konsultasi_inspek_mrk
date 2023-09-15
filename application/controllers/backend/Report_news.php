<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_news extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Report Berita - Inspektorat Kabupaten Merauke';
			$data['reportmenu'] = 'active';
			$data['reportnewssubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$RoleReportCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'ReportCreate');
			if ($RoleReportCreate == 'no') {
				$RoleReportCreate = 'disabled';
			}
			$data['RoleReportCreate'] = $RoleReportCreate;
			/*role*/
			$this->load->view("backend/report-news", $data);

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
						case "ShowReport":
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
									'status' => 'notfound',
									'message' => 'Grafik tidak tersedia'
								);
							}
							echo json_encode($respon);
							break;
						case "ShowReportPerPeriode":
							$StartPeriode = $this->input->post('StartPeriode');
							$EndPeriode = $this->input->post('EndPeriode');

							$Start = DateSlashMysql($StartPeriode);
							$End = DateSlashMysql($EndPeriode);

							$query = $this->db->query("
													SELECT COUNT(*) as News, DATE_FORMAT(CreatedNews,'%b %Y') as Month from news 
													WHERE CreatedNews BETWEEN '$Start' AND '$End'
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
														WHERE CreatedNews BETWEEN '$Start' AND '$End'
													");
								$row = $query->row();
								$Total = $row->Total;

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik Berita',
									'label' => "(Dalam periode $StartPeriode - $EndPeriode, Total: $Total)",
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
							break;
						case "CategoryEdit":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('category');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get category data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "CategoryUpdate":
							$IdCategory = $this->input->post('IdCategory');
							$NameCategoryOld = $this->back->GetNameCategory($IdCategory);
							$NameCategory = $this->input->post('NameCategory');
							$NoteCategory = $this->input->post('NoteCategory');
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'NameCategory' => $NameCategory,
								'NoteCategory' => $NoteCategory,
								'FlagPublish' => $FlagPublish
							);

							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->update('category', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update kategori'
								);
								/*update all news*/
								$query = $this->db->where('CategoryNews', $NameCategoryOld);
								$query = $this->db->update('news', array('CategoryNews' => $NameCategory));
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