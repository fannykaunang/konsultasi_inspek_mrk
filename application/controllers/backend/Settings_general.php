<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings_general extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'General Settings - Inspektorat Kabupaten Merauke';
			$data['settingsmenu'] = 'active';
			$data['settingsbackendmenu'] = 'active';
			$data['settingsbackendmenuopen'] = 'open';
			$data['settingsgeneralsubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$RoleSettingsView = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'SettingsView');
			if ($RoleSettingsView == 'no') {
				$RoleSettingsView = 'disabled';
			}
			$data['RoleSettingsView'] = $RoleSettingsView;
			/*role*/

			$query = $this->db->select('SiteMode');
			$query = $this->db->get('settings');
			$row = $query->row();
			$data['sitemode'] = $row->SiteMode;

			$query = $this->db->select('Email');
			$query = $this->db->get('settings');
			$row = $query->row();
			$data['email'] = $row->Email;

			// Email settings			
			$query = $this->db->get('emailsettings');
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$data['emailsettings'] = $query->result();
			} else {
				$data['emailsettings'] = null;
			}

			$query = $this->db->select('MaxLogs');
			$query = $this->db->get('settings');
			$row = $query->row();
			$data['maxlogs'] = $row->MaxLogs;

			$this->load->view("backend/settings-general", $data);
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
						case "SiteMode":
							$SiteMode = $this->input->post('SiteMode');
							$query = $this->db->update('settings', array('SiteMode' => $SiteMode));
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Ubah pengaturan mode situs berhasil'
								);
							} else {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ubah pengaturan mode situs gagal'
								);
							}
							echo json_encode($respon);
							break;
						case "Email":
							$Email = $this->input->post('Email');
							$query = $this->db->update('settings', array('Email' => $Email));
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Ubah pengaturan email berhasil'
								);
							} else {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ubah pengaturan email gagal'
								);
							}
							echo json_encode($respon);
							break;
						case "MaxLogs":
							$MaxLogs = $this->input->post('MaxLogs');
							$query = $this->db->update('settings', array('MaxLogs' => $MaxLogs));
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Ubah pengaturan maksimal logs berhasil'
								);
							} else {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ubah pengaturan maksimal logs gagal'
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
						// Email Settings 
						case "EmailSettingsUpdate":
							$smtp_pass = $this->input->post('smtp_pass');
							$data = array(
								'smtp_host' => $this->input->post('smtp_host'),
								'smtp_port' => $this->input->post('smtp_port'),
								'smtp_user' => $this->input->post('smtp_user'),
								'smtp_pass' => $this->input->post('smtp_pass'),
								'smtp_crypto' => $this->input->post('smtp_crypto'),
								'charset' => $this->input->post('charset'),
								'mailtype' => $this->input->post('mailtype')
							);
							if ($smtp_pass == null) {
								unset($data['smtp_pass']);
							}
							$query = $this->db->update('emailsettings', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update email settings berhasil'
								);
							} else {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Update email settings gagal'
								);
							}
							echo json_encode($respon);
							break;
						case "EmailSendTest":
							$Tujuan = $this->input->post('Tujuan');
							$Subyek = $this->input->post('Subyek');
							$IsiEmail = $this->input->post('IsiEmail');

							$query = $this->db->get("emailsettings");
							foreach ($query->result() as $row) {
								$config = array(
									'smtp_host' => $row->smtp_host,
									'smtp_port' => $row->smtp_port,
									'smtp_user' => $row->smtp_user,
									'smtp_pass' => $row->smtp_pass,
									'mailtype' => $row->mailtype,
									'wordwrap' => $row->wordwrap,
									'charset' => $row->charset,
									'smtp_timeout' => 300,
									'useragent' => 'CodeIgniter',
									'protocol' => $row->protocol
								);
							}

							$this->load->library('email', $config);
							$this->email->initialize($config);

							$this->email->set_newline("\r\n");
							//$this->email->clear();

							$this->email->from($row->smtp_user, $row->smtp_user);
							$this->email->to($Tujuan);
							$this->email->subject($Subyek);
							$this->email->message($IsiEmail);

							$result = $this->email->send(false);

							$dbg = $this->email->print_debugger(array('headers'));

							if (!$result) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Sending email ' . $dbg
								);
							} else {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Sending email'
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