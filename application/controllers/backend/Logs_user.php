<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs_user extends CI_Controller
{
	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Logs Pengguna - Inspektorat Kabupaten Merauke';
			$data['logsmenu'] = 'active';
			$data['logsusersubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();

			$RoleLogsView = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'LogsView');
			if ($RoleLogsView == 'no') {
				$RoleLogsView = 'disabled';
			}
			$data['RoleLogsView'] = $RoleLogsView;
			/*role*/
			$this->load->view("backend/logs-user", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}

	}

	function LogsUserList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'logsuser';
				$columns = array(
					'0' => 'IPAddress',
					'1' => 'TimeStamp',
					'2' => 'Browser',
					'3' => 'AgentString',
					'4' => 'Platform',
					'5' => 'ContentLog',
					'6' => 'StatusLog',
					'7' => 'IdUser',
					'8' => 'Url'
				);

				$query = $this->db->query("
						SELECT IdLog, IPAddress, TimeStamp, Browser, AgentString, Platform, ContentLog, StatusLog, IdUser, Url
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					$Search = $this->db->escape_str($requestData['search']['value']);

					$sql = " SELECT IdLog, IPAddress, TimeStamp, Browser, AgentString, Platform, ContentLog, StatusLog, IdUser, Url ";
					$sql .= " FROM $table ";
					$sql .= " WHERE IPAddress LIKE '%" . $Search . "%' ";
					$sql .= " OR Browser LIKE '%" . $Search . "%' ";
					$sql .= " OR TimeStamp LIKE '%" . $Search . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdLog, IPAddress, TimeStamp, Browser, AgentString, Platform, ContentLog, StatusLog, IdUser, Url ";
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
							'AgentString' => $row->AgentString,
							'Platform' => $row->Platform,
							'ContentLog' => $row->ContentLog,
							'StatusLog' => $row->StatusLog,
							'IdUser' => $row->IdUser,
							'Url' => $row->Url
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
				redirect(base_url() . 'backend/login');
			}
		} else {
			$this->load->view('404');
		}
	}
	function ajax()
	{
		if ($this->user_model->AjaxAccess() == true) {
			if ($this->user_model->CheckSession() == 1) {
				if ($do = $this->input->post('do')) {
					switch ($do) {
						case "ShowReportPerPeriode":
							$StartPeriode = $this->input->post('StartPeriode');
							$EndPeriode = $this->input->post('EndPeriode');

							$Start = DateSlashMysql($StartPeriode);
							$End = DateSlashMysql($EndPeriode);

							$query = $this->db->query("
													SELECT COUNT(*) as Visitor, DATE_FORMAT(TimeStamp,'%b %Y') as Month from logsvisitor 
													WHERE TimeStamp BETWEEN '$Start' AND '$End'
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
														WHERE TimeStamp BETWEEN '$Start' AND '$End'
													");
								$row = $query->row();
								$Total = $row->Total;

								$respon = array(
									'status' => 'sukses',
									'message' => 'Grafik Pengunjung',
									'label' => "(Dalam periode $StartPeriode - $EndPeriode, Total: $Total)",
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