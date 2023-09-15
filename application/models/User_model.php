<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

	function UserFullName()
	{
		return 'webinspekmrkuser';
	}

	function UserLevel()
	{
		return 'webinspekmrkuserlevel';
	}

	function UserID()
	{
		return 'webinspekmrkuserid';
	}

	function UserIsLogin()
	{
		return 'webinspekmrkuserislogin';
	}

	function UserIsActive()
	{
		return 'webinspekmrkuserisactive';
	}

	function Login()
	{
		$EmailUser = $this->input->post('EmailUser');
		$PasswordUser = $this->input->post('PasswordUser');

		if (!empty($EmailUser) && !empty($PasswordUser)) {
			///////////////////////////////////
			$query = $this->db->where('EmailUser', $EmailUser);
			$query = $this->db->or_where('PhoneUser', $EmailUser);
			$query = $this->db->where('StatusUser', 'aktif');
			$query = $this->db->get('user');
			if ($query->num_rows() > 0) {
				$row = $query->row();
				if (password_verify($PasswordUser, $row->PasswordUser)) {
					$session = array(
						$this->user_model->UserFullName() => $this->encryption->encrypt($row->NameUser),
						$this->user_model->UserID() => $this->encryption->encrypt($row->IdUser),
						$this->user_model->UserLevel() => $this->encryption->encrypt($row->LevelUser),
						$this->user_model->UserIsLogin() => true,
						$this->user_model->UserIsActive() => $this->encryption->encrypt('aktif')
					);
					$this->session->set_userdata($session);

					$this->logging_log_model->InsertUserLog('system', 'User: ' . $row->FullName, 'login success');
					$this->logging_log_model->UpdateUserLastLogin($row->IdUser);

					// if ($row->LevelUser == "Inspektur") {
					// 	redirect(base_url() . 'backend/contact');
					// 	return;
					// }

					redirect(base_url() . 'backend/dashboard');
				} else {
					$data['errorlogin'] = '<div class="alert alert-danger">Ooops! login gagal</div>';
					$this->load->view('backend/login', $data);
					$this->logging_log_model->InsertUserLog('system', 'User: ' . $row->FullName, 'login failed');
				}
			} else {
				$this->logging_log_model->InsertUserLog('system', 'User: ' . $EmailUser, ' login failed');
				$data['errorlogin'] = '<div class="alert alert-danger">Ooops! login gagal</div>';
				$this->load->view('backend/login', $data);
			}
			///////////////////////////////////
		} else {
			$this->load->view('backend/login');
		}
	}

	function CheckSession()
	{
		$islogin = $this->session->userdata($this->user_model->UserIsLogin());
		$isactive = $this->encryption->decrypt($this->session->userdata($this->user_model->UserIsActive()));

		if ($islogin == true) {

			$IdUser = $this->encryption->decrypt($this->session->userdata($this->user_model->UserID()));

			$query = $this->db->select('StatusUser');
			$query = $this->db->where('IdUser', $IdUser);
			$query = $this->db->get('user');
			$row = $query->row();
			$StatusUser = $row->StatusUser;

			if ($StatusUser == $isactive) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	function GetUserTheme()
	{
		$IdUser = $this->encryption->decrypt($this->session->userdata($this->user_model->UserID()));
		$query = $this->db->where('IdUser', $IdUser);
		$query = $this->db->get('user');
		$row = $query->row();
		return $row->Theme;
	}

	function GetIdUser()
	{
		return $this->encryption->decrypt($this->session->userdata($this->user_model->UserID()));
	}

	function GetNameUser()
	{
		return $this->encryption->decrypt($this->session->userdata($this->user_model->UserFullName()));
	}

	function GetUserIrban()
	{
		$IdUser = $this->encryption->decrypt($this->session->userdata($this->user_model->UserID()));
		$query = $this->db->where('IdUser', $IdUser);
		$query = $this->db->get('irban_category');
		$row = $query->row();
		return $row->NameCategory;
	}

	function GetLevelUser()
	{
		return $this->encryption->decrypt($this->session->userdata($this->user_model->UserLevel()));
	}

	function GetPictureUser()
	{
		$IdUser = $this->encryption->decrypt($this->session->userdata($this->user_model->UserID()));
		$query = $this->db->select('PictureUser');
		$query = $this->db->where('IdUser', $IdUser);
		$query = $this->db->get('user');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->PictureUser;
		} else {
			return null;
		}
	}

	// public function getIdPegawai($IdPegawai) {
	// 	$query = $this->db->select('IdPegawai');
	// 	$query = $this->db->where('IdPegawai', $IdPegawai);
	// 	$query = $this->db->get('skpdpegawai');
	// 	return $row->IdPegawai;
	// }

}

/* End of file User_system_model.php */
/* Location: ./application/models/User_system_model.php */