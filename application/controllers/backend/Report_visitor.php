<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_visitor extends CI_Controller
{
	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Report Visitor - Inspektorat Kabupaten Merauke';
			$data['reportmenu'] = 'active';
			$data['reportvisitorsubmenu'] = 'active';

			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$RoleReportCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'ReportCreate');
			if ($RoleReportCreate == 'no') {
				$RoleReportCreate = 'disabled';
			}
			$data['RoleReportCreate'] = $RoleReportCreate;
			/*role*/


			// $ulevel = $this->user_model->GetLevelUser();
			// if ($ulevel == 'contributor' || $ulevel == 'moderator') {
			// 	$respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak mengedit struktur ini');
			// } else {
			// 	$this->load->view("backend/report-visitor", $data);
			// }
			$this->load->view("backend/report-visitor", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}

	}

	function ReportVisitorList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'logsvisitor';
				$columns = array(
					'0' => 'IPAddress',
					'1' => 'TimeStamp',
					'2' => 'Browser',
					'3' => 'AgentString'
				);

				$query = $this->db->query("
						SELECT IdLog, IPAddress, TimeStamp, Browser, AgentString
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdLog, IPAddress, TimeStamp, Browser, AgentString ";
					$sql .= " FROM $table ";
					$sql .= " WHERE IPAddress LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Browser LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR TimeStamp LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdLog, IPAddress, TimeStamp, Browser, AgentString ";
					$sql .= " FROM $table ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					/*role*/
					/*$RoleCategoryUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryUpdate');
													  if($RoleCategoryUpdate=='no'){$RoleCategoryUpdate='disabled';}
												  $RoleCategoryDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryDelete');
													  if($RoleCategoryDelete=='no'){$RoleCategoryDelete='disabled';}
												  /*role*/

					foreach ($query->result() as $row) {
						$data[] = array(

							'IPAddress' => $row->IPAddress,
							'TimeStamp' => substr(DateTimeIndo($row->TimeStamp), 0, -3),
							'Browser' => $row->Browser,
							'AgentString' => $row->AgentString
						);
						$respon = array(
							'draw' => intval($requestData['draw']),
							'recordsTotal' => intval($recordsTotal),
							'recordsFiltered' => intval($recordsFiltered),
							'data' => $data
						);

					}
				} else {
					$respon = array(
						'draw' => intval($requestData['draw']),
						'recordsTotal' => intval($recordsTotal),
						'recordsFiltered' => intval($recordsFiltered),
						'data' => array()
					);
				}
				echo json_encode($respon);

			} else {
				$this->load->view('404');
			}
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
						case "ShowGraphVisitor":
							$query = $this->db->query("
													SELECT COUNT(*) as Visitor, DATE_FORMAT(TimeStamp,'%d %b %Y') as Days from logsvisitor 
													WHERE (CURDATE() - INTERVAL 1 WEEK)  
													GROUP BY DATE_FORMAT(TimeStamp, '%d %b %Y') 
													ORDER BY TimeStamp ASC
												");
							if ($query->num_rows() > 0) {
								$Days = array();
								$Visitor = array();
								foreach ($query->result() as $row) {
									$Days[] = $row->Days;
									$Visitor[] = intval($row->Visitor);
								}
								$query = $this->db->query("
														SELECT COUNT(*) AS Total 
														FROM logsvisitor 
														WHERE (CURDATE() - INTERVAL 1 WEEK)  									
													");
								$row = $query->row();
								$Total = $row->Total;

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik Pengunjung Harian',
									'title' => 'Grafik Pengunjung',
									'subtitle' => 'Dalam 1 minggu terakhir',
									'xtitle' => 'Hari',
									'ytitle' => 'Jumlah Pengunjung',
									'visitor' => $Visitor,
									'seriestitle' => 'Pengunjung',
									'days' => $Days
								);
							} else {
								$respon = array(
									'status' => 'tidak tersedia',
									'message' => 'Grafik tidak tersedia'
								);
							}
							echo json_encode($respon);
							break;
						case "ShowGraphVisitorByPeriode":
							$StartDays = $this->input->post('StartDays');
							$EndDays = $this->input->post('EndDays');

							$Start = DateSlashMysql($StartDays);
							$End = DateSlashMysql($EndDays);

							$query = $this->db->query("
													SELECT COUNT(*) as Visitor, DATE_FORMAT(TimeStamp,'%d %b %Y') as Days from logsvisitor 
													WHERE TimeStamp BETWEEN '$Start' AND '$End'
													GROUP BY DATE_FORMAT(TimeStamp, '%d %b %Y') 
													ORDER BY TimeStamp ASC
												");
							if ($query->num_rows() > 0) {
								$Days = array();
								$Visitor = array();
								foreach ($query->result() as $row) {
									$Days[] = $row->Days;
									$Visitor[] = intval($row->Visitor);
								}
								$query = $this->db->query("
														SELECT COUNT(*) AS Total 
														FROM logsvisitor 
														WHERE TimeStamp BETWEEN '$Start' AND '$End'														
													");
								$row = $query->row();
								$Total = $row->Total;

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik Pengunjung',
									'title' => 'Grafik Pengunjung',
									'subtitle' => "(Dalam periode $StartDays - $EndDays, Total: $Total)",
									'xtitle' => 'Hari',
									'ytitle' => 'Jumlah Pengunjung',
									'seriestitle' => 'Pengunjung',
									'visitor' => $Visitor,
									'days' => $Days
								);
							} else {
								$respon = array(
									'status' => 'tidak tersedia',
									'message' => 'Grafik tidak tersedia'
								);
							}
							echo json_encode($respon);
							break;
						case "ShowGraphVisitorBrowser":

							$query = $this->db->query("
									SELECT COUNT(*) AS Total, Browser 
									FROM logsvisitor 
									WHERE Browser != ''
									GROUP BY Browser 
								");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$data[] = array(
										'name' => ucwords($row->Browser),
										'y' => intval($row->Total),
										'sliced' => true,
										'selected' => true
									);
								}

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik Browser Pengunjung',
									'title' => 'Grafik Browser Pengunjung',
									'subtitle' => 'Grafik Total Browser Pengunjung',
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
						case "ShowGraphVisitorPlatform":

							$query = $this->db->query("
									SELECT COUNT(*) AS Total, Platform 
									FROM logsvisitor 
									WHERE Browser != ''
									GROUP BY Platform 
								");
							if ($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$data[] = array(
										'name' => ucwords($row->Platform),
										'y' => intval($row->Total),
										'sliced' => true,
										'selected' => true
									);
								}

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik Platform Pengunjung',
									'title' => 'Grafik Platform Pengunjung',
									'subtitle' => 'Grafik Total Platform Pengunjung',
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