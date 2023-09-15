<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{
	////////////////////////////

	function GetChecked($param)
	{
		if ($param == 'yes') {
			echo 'checked';
		} else {
			echo '';
		}
	}

	function GetRole($LevelUser, $ColumnName)
	{
		$query = $this->db->select($ColumnName);
		$query = $this->db->where('LevelUser', $LevelUser);
		$query = $this->db->get('userrole');
		$row = $query->row();
		return $row->$ColumnName;
	}

	function SetRole($Param)
	{
		$LevelUser = $this->user_model->GetLevelUser();

		if ($LevelUser == 'superadmin' || $LevelUser == 'IRBAN' || $LevelUser == 'SKPD' || $LevelUser == 'INSPEKTUR') {
			/*news*/
			if ($Param == 'RoleNewsView') {
				return $this->role_model->GetRole($LevelUser, 'NewsView');
			}
			if ($Param == 'RoleNewsCreate') {
				return $this->role_model->GetRole($LevelUser, 'NewsCreate');
			}
			if ($Param == 'RoleNewsUpdate') {
				return $this->role_model->GetRole($LevelUser, 'NewsUpdate');
			}
			if ($Param == 'RoleNewsDelete') {
				return $this->role_model->GetRole($LevelUser, 'NewsDelete');
			}
			/*news*/
			/*category*/
			if ($Param == 'RoleCategoryView') {
				return $this->role_model->GetRole($LevelUser, 'CategoryView');
			}
			if ($Param == 'RoleCategoryCreate') {
				return $this->role_model->GetRole($LevelUser, 'CategoryCreate');
			}
			if ($Param == 'RoleCategoryUpdate') {
				return $this->role_model->GetRole($LevelUser, 'CategoryUpdate');
			}
			if ($Param == 'RoleCategoryDelete') {
				return $this->role_model->GetRole($LevelUser, 'CategoryDelete');
			}
			/*category*/
			/*comment*/
			if ($Param == 'RoleCommentView') {
				return $this->role_model->GetRole($LevelUser, 'CommentView');
			}
			if ($Param == 'RoleCommentCreate') {
				return $this->role_model->GetRole($LevelUser, 'CommentCreate');
			}
			if ($Param == 'RoleCommentUpdate') {
				return $this->role_model->GetRole($LevelUser, 'CommentUpdate');
			}
			if ($Param == 'RoleCommentDelete') {
				return $this->role_model->GetRole($LevelUser, 'CommentDelete');
			}
			/*comment*/
			/*captcha*/
			if ($Param == 'RoleCaptchaView') {
				return $this->role_model->GetRole($LevelUser, 'CaptchaView');
			}
			if ($Param == 'RoleCaptchaCreate') {
				return $this->role_model->GetRole($LevelUser, 'CaptchaCreate');
			}
			if ($Param == 'RolCaptchaUpdate') {
				return $this->role_model->GetRole($LevelUser, 'CaptchaUpdate');
			}
			if ($Param == 'RoleCaptchaDelete') {
				return $this->role_model->GetRole($LevelUser, 'CaptchaDelete');
			}
			/*captcha*/
			/*file*/
			if ($Param == 'RoleFileView') {
				return $this->role_model->GetRole($LevelUser, 'FileView');
			}
			if ($Param == 'RoleFileCreate') {
				return $this->role_model->GetRole($LevelUser, 'FileCreate');
			}
			if ($Param == 'RolFileUpdate') {
				return $this->role_model->GetRole($LevelUser, 'FileUpdate');
			}
			if ($Param == 'RoleFileDelete') {
				return $this->role_model->GetRole($LevelUser, 'FileDelete');
			}
			/*file*/
			/*user*/
			if ($Param == 'RoleUserView') {
				return $this->role_model->GetRole($LevelUser, 'UserView');
			}
			if ($Param == 'RoleUserCreate') {
				return $this->role_model->GetRole($LevelUser, 'UserCreate');
			}
			if ($Param == 'RolUserUpdate') {
				return $this->role_model->GetRole($LevelUser, 'UserUpdate');
			}
			if ($Param == 'RoleUserDelete') {
				return $this->role_model->GetRole($LevelUser, 'UserDelete');
			}
			/*user*/
			/*userrole*/
			if ($Param == 'RoleUserRoleView') {
				return $this->role_model->GetRole($LevelUser, 'UserRoleView');
			}
			if ($Param == 'RoleUserRoleCreate') {
				return $this->role_model->GetRole($LevelUser, 'UserRoleCreate');
			}
			if ($Param == 'RolUserRoleUpdate') {
				return $this->role_model->GetRole($LevelUser, 'UserRoleUpdate');
			}
			if ($Param == 'RoleUserRoleDelete') {
				return $this->role_model->GetRole($LevelUser, 'UserRoleDelete');
			}
			/*userrole*/
			/*tools*/
			if ($Param == 'RoleToolsBackupDatabase') {
				return $this->role_model->GetRole($LevelUser, 'ToolsBackupDatabase');
			}
			/*tools*/
			/*settings*/
			if ($Param == 'RoleSettingsCreate') {
				return $this->role_model->GetRole($LevelUser, 'SettingsCreate');
			}
			if ($Param == 'RoleSettingsView') {
				return $this->role_model->GetRole($LevelUser, 'SettingsView');
			}
			if ($Param == 'RoleSettingsUpdate') {
				return $this->role_model->GetRole($LevelUser, 'SettingsUpdate');
			}
			if ($Param == 'RoleSettingsDelete') {
				return $this->role_model->GetRole($LevelUser, 'SettingsDelete');
			}
			/*settings*/
			/*report*/
			if ($Param == 'RoleReportCreate') {
				return $this->role_model->GetRole($LevelUser, 'ReportCreate');
			}
			if ($Param == 'RoleReportView') {
				return $this->role_model->GetRole($LevelUser, 'ReportView');
			}
			if ($Param == 'RoleReportUpdate') {
				return $this->role_model->GetRole($LevelUser, 'ReportUpdate');
			}
			if ($Param == 'RoleReportDelete') {
				return $this->role_model->GetRole($LevelUser, 'ReportDelete');
			}
			/*report*/
			/*logs*/
			if ($Param == 'RoleLogsCreate') {
				return $this->role_model->GetRole($LevelUser, 'LogsCreate');
			}
			if ($Param == 'RoleLogsView') {
				return $this->role_model->GetRole($LevelUser, 'LogsView');
			}
			if ($Param == 'RoleLogsUpdate') {
				return $this->role_model->GetRole($LevelUser, 'LogsUpdate');
			}
			if ($Param == 'RoleLogsDelete') {
				return $this->role_model->GetRole($LevelUser, 'LogsDelete');
			}
			/*logs*/
		}
	}
	function LoadRole()
	{
		/*news*/
		$data['RoleNewsView'] = $this->role_model->SetRole('RoleNewsView');
		$data['RoleNewsCreate'] = $this->role_model->SetRole('RoleNewsCreate');
		$data['RoleNewsUpdate'] = $this->role_model->SetRole('RoleNewsUpdate');
		$data['RoleNewsDelete'] = $this->role_model->SetRole('RoleNewsDelete');
		/*news*/
		/*category*/
		$data['RoleCategoryView'] = $this->role_model->SetRole('RoleCategoryView');
		$data['RoleCategoryCreate'] = $this->role_model->SetRole('RoleCategoryCreate');
		$data['RoleCategoryUpdate'] = $this->role_model->SetRole('RoleCategoryUpdate');
		$data['RoleCategoryDelete'] = $this->role_model->SetRole('RoleCategoryDelete');
		/*category*/
		/*comment*/
		$data['RoleCommentView'] = $this->role_model->SetRole('RoleCommentView');
		$data['RoleCommentCreate'] = $this->role_model->SetRole('RoleCommentCreate');
		$data['RoleCommentUpdate'] = $this->role_model->SetRole('RoleCommentUpdate');
		$data['RoleCommentDelete'] = $this->role_model->SetRole('RoleCommentDelete');
		/*comment*/
		/*captcha*/
		$data['RoleCaptchaView'] = $this->role_model->SetRole('RoleCaptchaView');
		$data['RoleCaptchaCreate'] = $this->role_model->SetRole('RoleCaptchaCreate');
		$data['RoleCaptchaUpdate'] = $this->role_model->SetRole('RoleCaptchaUpdate');
		$data['RoleCaptchaDelete'] = $this->role_model->SetRole('RoleCaptchaDelete');
		/*captcha*/
		/*file*/
		$data['RoleFileView'] = $this->role_model->SetRole('RoleFileView');
		$data['RoleFileCreate'] = $this->role_model->SetRole('RoleFileCreate');
		$data['RoleFileUpdate'] = $this->role_model->SetRole('RoleFileUpdate');
		$data['RoleFileDelete'] = $this->role_model->SetRole('RoleFileDelete');
		/*file*/
		/*user*/
		$data['RoleUserView'] = $this->role_model->SetRole('RoleUserView');
		$data['RoleUserCreate'] = $this->role_model->SetRole('RoleUserCreate');
		$data['RoleUserUpdate'] = $this->role_model->SetRole('RoleUserUpdate');
		$data['RoleUserDelete'] = $this->role_model->SetRole('RoleUserDelete');
		/*user*/
		/*userrole*/
		$data['RoleUserRoleView'] = $this->role_model->SetRole('RoleUserRoleView');
		$data['RoleUserRoleCreate'] = $this->role_model->SetRole('RoleUserRoleCreate');
		$data['RoleUserRoleUpdate'] = $this->role_model->SetRole('RoleUserRoleUpdate');
		$data['RoleUserRoleDelete'] = $this->role_model->SetRole('RoleUserRoleDelete');
		/*userrole*/
		/*tools*/
		$data['RoleToolsBackupDatabase'] = $this->role_model->SetRole('RoleToolsBackupDatabase');
		/*tools*/
		/*settings*/
		$data['RoleSettingsView'] = $this->role_model->SetRole('RoleSettingsView');
		$data['RoleSettingsCreate'] = $this->role_model->SetRole('RoleSettingsCreate');
		$data['RoleSettingsUpdate'] = $this->role_model->SetRole('RoleSettingsUpdate');
		$data['RoleSettingsDelete'] = $this->role_model->SetRole('RoleSettingsDelete');
		/*settings*/
		/*report*/
		$data['RoleReportView'] = $this->role_model->SetRole('RoleReportView');
		$data['RoleReportCreate'] = $this->role_model->SetRole('RoleReportCreate');
		$data['RoleReportUpdate'] = $this->role_model->SetRole('RoleReportUpdate');
		$data['RoleReportDelete'] = $this->role_model->SetRole('RoleReportDelete');
		/*report*/
		/*report*/
		$data['RoleLogsView'] = $this->role_model->SetRole('RoleLogsView');
		$data['RoleLogsCreate'] = $this->role_model->SetRole('RoleLogsCreate');
		$data['RoleLogsUpdate'] = $this->role_model->SetRole('RoleLogsUpdate');
		$data['RoleLogsDelete'] = $this->role_model->SetRole('RoleLogsDelete');
		/*report*/
		return $data;
	}

	function CheckAttr($LevelUser)
	{
		$query = $this->db->where('LevelUser', $LevelUser);
		$query = $this->db->get('userrole');
		$row = $query->row();
		if (
			$row->NewsView == 'yes' &&
			$row->NewsCreate == 'yes' &&
			$row->NewsUpdate == 'yes' &&
			$row->NewsDelete == 'yes'
		) {
			return 'checked';
		}
	}

	////////////////////////////


}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */