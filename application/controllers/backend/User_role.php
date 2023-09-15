<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_role extends CI_Controller
{

	function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'User Roles - Inspektorat Kabupaten Merauke';
			$data['settingsmenu'] = 'active';
			$data['settingsbackendmenu'] = 'active';
			$data['settingsbackendmenuopen'] = 'open';
			$data['userrolesubmenu'] = 'active';

			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$RoleUserRoleUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'UserRoleUpdate');
			if ($RoleUserRoleUpdate == 'no') {
				$RoleUserRoleUpdate = 'disabled';
			}
			$data['RoleUserRoleUpdate'] = $RoleUserRoleUpdate;

			/*LevelUser*/
			$query = $this->db->select('LevelUser');
			$query = $this->db->get('userrole');
			$data['leveluser'] = $query->result();
			/*LevelUser*/

			/*Column*/
			$query = $this->db->get('userrole');
			$data['column'] = $query->result();
			/*Column*/
			$this->load->view('backend/user-role', $data);
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
						case "RoleSet":
							$LevelUser = $this->input->post('LevelUser');
							$attr = $this->input->Post('attr');
							$name = $this->input->post('name');
							$data = array(
								$name => $attr
							);

							$query = $this->db->where('LevelUser', $LevelUser);
							$query = $this->db->update('userrole', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update hak akses'
								);
							}
							echo json_encode($respon);
							break;
						case "RoleSetAll":
							$LevelUser = $this->input->post('LevelUser');
							$attr = $this->input->Post('attr');
							$name = $this->input->post('name');
							$data = array(
								'NewsView' => $attr,
								'NewsCreate' => $attr,
								'NewsUpdate' => $attr,
								'NewsDelete' => $attr,

								'CommentView' => $attr,
								'CommentCreate' => $attr,
								'CommentUpdate' => $attr,
								'CommentDelete' => $attr,

								'CategoryView' => $attr,
								'CategoryCreate' => $attr,
								'CategoryUpdate' => $attr,
								'CategoryDelete' => $attr,

								'CaptchaView' => $attr,
								'CaptchaCreate' => $attr,
								'CaptchaUpdate' => $attr,
								'CaptchaDelete' => $attr,

								'UserView' => $attr,
								'UserCreate' => $attr,
								'UserUpdate' => $attr,
								'UserDelete' => $attr,

								'FileView' => $attr,
								'FileCreate' => $attr,
								'FileUpdate' => $attr,
								'FileDelete' => $attr,

								'ToolsBackupDatabase' => $attr,

								'SettingsView' => $attr,
								'SettingsCreate' => $attr,
								'SettingsUpdate' => $attr,
								'SettingsDelete' => $attr,

								'ReportView' => $attr,
								'ReportCreate' => $attr,
								'ReportUpdate' => $attr,
								'ReportDelete' => $attr,

								'LogsView' => $attr,
								'LogsCreate' => $attr,
								'LogsUpdate' => $attr,
								'LogsDelete' => $attr

							);

							$query = $this->db->where('LevelUser', $LevelUser);
							$query = $this->db->update('userrole', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Set semua hak akses'
								);
							}
							echo json_encode($respon);
							break;
						case "RoleSetDefault":
							$query = $this->db->select('LevelUser');
							$query = $this->db->get('userrole');
							foreach ($query->result() as $row) {
								$LevelUser = $row->LevelUser;
								// administrator//
								if ($LevelUser == 'superadmin') {
									$data = array(
										'NewsView' => 'yes',
										'NewsCreate' => 'yes',
										'NewsUpdate' => 'yes',
										'NewsDelete' => 'yes',

										'CommentView' => 'yes',
										'CommentCreate' => 'yes',
										'CommentUpdate' => 'yes',
										'CommentDelete' => 'yes',

										'CategoryView' => 'yes',
										'CategoryCreate' => 'yes',
										'CategoryUpdate' => 'yes',
										'CategoryDelete' => 'yes',

										'CaptchaView' => 'yes',
										'CaptchaCreate' => 'yes',
										'CaptchaUpdate' => 'yes',
										'CaptchaDelete' => 'yes',

										'UserView' => 'yes',
										'UserCreate' => 'yes',
										'UserUpdate' => 'yes',
										'UserDelete' => 'yes',

										'FileView' => 'yes',
										'FileCreate' => 'yes',
										'FileUpdate' => 'yes',
										'FileDelete' => 'yes',

										'UserRoleView' => 'yes',
										'UserRoleCreate' => 'yes',
										'UserRoleUpdate' => 'yes',
										'UserRoleDelete' => 'yes',

										'ToolsBackupDatabase' => 'yes',

										'SettingsView' => 'yes',
										'SettingsCreate' => 'yes',
										'SettingsUpdate' => 'yes',
										'SettingsDelete' => 'yes',

										'ReportView' => 'yes',
										'ReportCreate' => 'yes',
										'ReportUpdate' => 'yes',
										'ReportDelete' => 'yes',

										'LogsView' => 'yes',
										'LogsCreate' => 'yes',
										'LogsUpdate' => 'yes',
										'LogsDelete' => 'yes'

									);
									$query = $this->db->where('LevelUser', 'superadmin');
									$query = $this->db->update('userrole', $data);
								}
								if ($LevelUser == 'moderator') {
									$data = array(
										'NewsView' => 'yes',
										'NewsCreate' => 'yes',
										'NewsUpdate' => 'yes',
										'NewsDelete' => 'yes',

										'CommentView' => 'yes',
										'CommentCreate' => 'yes',
										'CommentUpdate' => 'yes',
										'CommentDelete' => 'yes',

										'CategoryView' => 'yes',
										'CategoryCreate' => 'yes',
										'CategoryUpdate' => 'yes',
										'CategoryDelete' => 'yes',

										'CaptchaView' => 'yes',
										'CaptchaCreate' => 'yes',
										'CaptchaUpdate' => 'yes',
										'CaptchaDelete' => 'yes',

										'UserView' => 'yes',
										'UserCreate' => 'no',
										'UserUpdate' => 'no',
										'UserDelete' => 'no',

										'FileView' => 'yes',
										'FileCreate' => 'yes',
										'FileUpdate' => 'yes',
										'FileDelete' => 'yes',

										'UserRoleView' => 'yes',
										'UserRoleCreate' => 'no',
										'UserRoleUpdate' => 'no',
										'UserRoleDelete' => 'no',

										'ToolsBackupDatabase' => 'no',

										'SettingsView' => 'yes',
										'SettingsCreate' => 'yes',
										'SettingsUpdate' => 'yes',
										'SettingsDelete' => 'yes',

										'ReportView' => 'yes',
										'ReportCreate' => 'yes',
										'ReportUpdate' => 'yes',
										'ReportDelete' => 'yes',

										'LogsView' => 'yes',
										'LogsCreate' => 'yes',
										'LogsUpdate' => 'yes',
										'LogsDelete' => 'yes'

									);
									$query = $this->db->where('LevelUser', 'moderator');
									$query = $this->db->update('userrole', $data);
								}
								if ($LevelUser == 'contributor') {
									$data = array(
										'NewsView' => 'yes',
										'NewsCreate' => 'yes',
										'NewsUpdate' => 'yes',
										'NewsDelete' => 'no',

										'CommentView' => 'yes',
										'CommentCreate' => 'no',
										'CommentUpdate' => 'no',
										'CommentDelete' => 'no',

										'CategoryView' => 'yes',
										'CategoryCreate' => 'no',
										'CategoryUpdate' => 'no',
										'CategoryDelete' => 'no',

										'CaptchaView' => 'yes',
										'CaptchaCreate' => 'no',
										'CaptchaUpdate' => 'no',
										'CaptchaDelete' => 'no',

										'UserView' => 'yes',
										'UserCreate' => 'no',
										'UserUpdate' => 'no',
										'UserDelete' => 'no',

										'FileView' => 'yes',
										'FileCreate' => 'yes',
										'FileUpdate' => 'no',
										'FileDelete' => 'no',

										'UserRoleView' => 'no',
										'UserRoleCreate' => 'no',
										'UserRoleUpdate' => 'no',
										'UserRoleDelete' => 'no',

										'ToolsBackupDatabase' => 'no',

										'SettingsView' => 'no',
										'SettingsCreate' => 'no',
										'SettingsUpdate' => 'no',
										'SettingsDelete' => 'no',

										'ReportView' => 'no',
										'ReportCreate' => 'no',
										'ReportUpdate' => 'no',
										'ReportDelete' => 'no',

										'LogsView' => 'no',
										'LogsCreate' => 'no',
										'LogsUpdate' => 'no',
										'LogsDelete' => 'no'

									);
									$query = $this->db->where('LevelUser', 'contributor');
									$query = $this->db->update('userrole', $data);
								}
								if ($LevelUser == 'guest') {
									$data = array(
										'NewsView' => 'no',
										'NewsCreate' => 'no',
										'NewsUpdate' => 'no',
										'NewsDelete' => 'no',

										'CommentView' => 'no',
										'CommentCreate' => 'no',
										'CommentUpdate' => 'no',
										'CommentDelete' => 'no',

										'CategoryView' => 'no',
										'CategoryCreate' => 'no',
										'CategoryUpdate' => 'no',
										'CategoryDelete' => 'no',

										'CaptchaView' => 'no',
										'CaptchaCreate' => 'no',
										'CaptchaUpdate' => 'no',
										'CaptchaDelete' => 'no',

										'UserView' => 'no',
										'UserCreate' => 'no',
										'UserUpdate' => 'no',
										'UserDelete' => 'no',

										'FileView' => 'no',
										'FileCreate' => 'no',
										'FileUpdate' => 'no',
										'FileDelete' => 'no',

										'UserRoleView' => 'no',
										'UserRoleCreate' => 'no',
										'UserRoleUpdate' => 'no',
										'UserRoleDelete' => 'no',

										'ToolsBackupDatabase' => 'no',

										'SettingsView' => 'no',
										'SettingsCreate' => 'no',
										'SettingsUpdate' => 'no',
										'SettingsDelete' => 'no',

										'ReportView' => 'no',
										'ReportCreate' => 'no',
										'ReportUpdate' => 'no',
										'ReportDelete' => 'no',

										'LogsView' => 'no',
										'LogsCreate' => 'no',
										'LogsUpdate' => 'no',
										'LogsDelete' => 'no'

									);
									$query = $this->db->where('LevelUser', 'guest');
									$query = $this->db->update('userrole', $data);
								}

								$respon = array(
									'status' => 'sukses',
									'message' => 'Set hak akses ke default'
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