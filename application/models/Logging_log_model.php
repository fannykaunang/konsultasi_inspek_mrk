<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logging_log_model extends CI_Model
{

	function InsertSystemLog($TypeLog, $ContentLog, $StatusLog)
	{
		$this->load->library('user_agent');
		$query = $this->db->get('settings');
		$row = $query->row();
		$MaxLogs = $row->MaxLogs;

		$Total = $this->db->count_all_results('logssystem');

		if ($Total >= $MaxLogs) {
			//reset to 0;
			$this->db->truncate('logssystem');
		} else {
			if (empty($Referer) == true ? $Referer = '' : $Referer = $_SERVER['HTTP_REFERER'])
				;
			$IdUser = $this->user_model->GetIdUser();

			$data = array(
				'IdUser' => $IdUser,
				'IPAddress' => $_SERVER['REMOTE_ADDR'],
				'TimeStamp' => date('Y-m-d H:i:s'),
				'Url' => current_url(),
				'Browser' => $this->agent->browser(),
				'Platform' => $this->agent->platform(),
				'ContentLog' => $ContentLog,
				'StatusLog' => $StatusLog,
				'TypeLog' => $TypeLog
			);

			$this->db->insert('logssystem', $data);
		}
	}

	function InsertUserLog($TypeLog, $ContentLog, $StatusLog)
	{
		$this->load->library('user_agent');
		$query = $this->db->get('settings');
		$row = $query->row();
		$MaxLogs = $row->MaxLogs;

		$Total = $this->db->count_all_results('logsuser');

		if ($Total >= $MaxLogs) {
			//reset to 0;
			$this->db->truncate('logsuser');
		} else {
			if (empty($Referer) == true ? $Referer = '' : $Referer = $_SERVER['HTTP_REFERER'])
				;
			$IdUser = $this->user_model->GetIdUser();

			$data = array(
				'IdUser' => $IdUser,
				'IPAddress' => $_SERVER['REMOTE_ADDR'],
				'TimeStamp' => date('Y-m-d H:i:s'),
				'Url' => current_url(),
				'Browser' => $this->agent->browser(),
				'AgentString' => $this->agent->agent_string(),
				'Platform' => $this->agent->platform(),
				'ContentLog' => $ContentLog,
				'StatusLog' => $StatusLog,
				'TypeLog' => $TypeLog
			);

			$this->db->insert('logsuser', $data);
		}
	}
	function UpdateUserLastLogin($IdUser)
	{
		$data = array(
			'IdUser' => $IdUser,
			'LastLogin' => date('Y-m-d H:i:s')
		);

		$this->db->where('IdUser', $IdUser);
		$this->db->update('user', $data);
	}
}

/* End of file Logging_log.php */
/* Location: ./application/models/Logging_log.php */