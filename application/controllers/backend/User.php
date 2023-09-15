<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Daftar Pengguna - Inspektorat Kabupaten Merauke';
			$data['settingsmenu'] = 'active';
			$data['settingsbackendmenu'] = 'active';
			$data['settingsbackendmenuopen'] = 'open';
			$data['usersubmenu'] = 'active';

			$data['theme'] = $this->user_model->GetUserTheme();
			/*role*/
			$data['role'] = $this->role_model->LoadRole();

			$RoleUserCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'UserCreate');
			if ($RoleUserCreate == 'no') {
				$RoleUserCreate = 'disabled';
			}
			$data['RoleUserCreate'] = $RoleUserCreate;

			$this->db->where('LevelUser', 'contributor');
			$this->db->or_where('LevelUser', 'moderator');
			$this->db->order_by('NameUser', 'DESC');
			$query = $this->db->get('user');
			if ($query->num_rows() > 0) {
				$data['user'] = $query->result();
			} else {
				$data['user'] = null;
			}
			/*role*/
			$query = $this->db->get('skpd');
			$data['skpd'] = $query->result();
			$this->load->view("backend/user", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}

	}

	function UserList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'user';
				$columns = array(
					'0' => 'NameUser',
					'1' => 'LevelUser',
					'2' => 'EmailUser',
					'3' => 'PhoneUser',
					'4' => 'LastLogin'
				);

				$query = $this->db->query("
						SELECT IdUser, NameUser, LevelUser, EmailUser, PhoneUser, AddressUser, LastLogin, FullName
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdUser, NameUser, LevelUser, EmailUser, PhoneUser, AddressUser, LastLogin, FullName ";
					$sql .= " FROM $table ";
					$sql .= " WHERE NameUser LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR LevelUser LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR EmailUser LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR PhoneUser LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR AddressUser LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR LastLogin LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FullName LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdUser, NameUser, LevelUser, EmailUser, PhoneUser, AddressUser, LastLogin, FullName ";
					$sql .= " FROM $table ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					/*role*/
					$RoleUserUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'UserUpdate');
					if ($RoleUserUpdate == 'no') {
						$RoleUserUpdate = 'disabled';
					}
					$RoleUserDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'UserDelete');
					if ($RoleUserDelete == 'no') {
						$RoleUserDelete = 'disabled';
					}
					/*role*/

					foreach ($query->result() as $row) {
						$data[] = array(
							'NameUser' => $row->NameUser,
							'LevelUser' => $row->LevelUser,
							'EmailUser' => $row->EmailUser,
							'PhoneUser' => $row->PhoneUser,
							'LastLogin' => substr(DateTimeIndo($row->LastLogin), 0, -3),
							'Option' => '<button onclick="UserEdit(' . $row->IdUser . ');" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleUserDelete . '>
											<i class="icon wb-pencil"></i>
											</button> &nbsp;  
											<button onclick="UserDelete(' . $row->IdUser . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleUserDelete . '>
												<i class="icon wb-trash"></i>
											</button>'
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
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				if ($do = $this->input->post('do')) {
					switch ($do) {
						case "UserCreate":
							$NameUser = $this->input->post('NameUser');
							$FullName = $this->input->post('FullName');
							$EmailUser = $this->input->post('EmailUser');
							$AddressUser = $this->input->post('AddressUser');
							$PhoneUser = $this->input->post('PhoneUser');
							$StatusUser = $this->input->post('StatusUser');
							$LevelUser = $this->input->post('LevelUser');
							$PasswordUser = $this->input->post('PasswordUser');
							$Theme = $this->input->post('Theme');
							$IdSkpd = $this->input->post('Skpd');

							/*check email*/
							$query = $this->db->where('EmailUser', $EmailUser);
							$query = $this->db->get('user');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'email ada',
									'message' => 'Gagal, email sudah ada'
								);
							} else {
								$data = array(
									'NameUser' => $NameUser,
									'FullName' => $FullName,
									'EmailUser' => $EmailUser,
									'AddressUser' => $AddressUser,
									'PhoneUser' => $PhoneUser,
									'StatusUser' => $StatusUser,
									'LevelUser' => $LevelUser,
									'PasswordUser' => password_hash($PasswordUser, PASSWORD_DEFAULT),
									'Theme' => $Theme,
									'IdSkpd' => $IdSkpd
								);
								$query = $this->db->insert('user', $data);
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'User baru ditambahkan'
									);
								}
							}
							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);
							break;
						case "UserDelete":
							$IdUser = $this->input->post('IdUser');
							$query = $this->db->where('IdUser', $IdUser);
							$query = $this->db->delete('user');
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Hapus user'
								);
							}
							echo json_encode($respon);
							break;
						case "UserEdit":
							$IdUser = $this->input->post('IdUser');

							$sql = "SELECT `IdUser`, `NameUser`, `PasswordUser`, `EmailUser`, `PhoneUser`, `LevelUser`, `RecordPerPage`, 
							`LandingPage`, `AddressUser`, `PictureUser`, `StatusUser`, `AboutMe`, `Theme`, `FullName`, `LastSeen`, 
							`LastLogin`, skpd.`IdSkpd`, skpd.NamaSkpd FROM `user` INNER JOIN skpd ON user.IdSkpd = skpd.IdSkpd 
							WHERE user.IdUser = '$IdUser' ";

							$query = $this->db->query($sql);

							// $query = $this->db->where('IdUser', $IdUser);
							// $query = $this->db->get('user');
							foreach ($query->result() as $row) {
								if ($row->PictureUser == null) {
									$PictureUser = '<img src="' . base_url() . 'assets/backend/portraits/1.jpg" class="img-thumbnail">';
								} else {
									$PictureUser = '<img src="' . base_url() . $row->PictureUser . '" class="img-circle"  width="100" height="100">';
								}
								$data[] = array(
									'IdUser' => $row->IdUser,
									'NameUser' => $row->NameUser,
									'EmailUser' => $row->EmailUser,
									'PhoneUser' => $row->PhoneUser,
									'LevelUser' => $row->LevelUser,
									'StatusUser' => $row->StatusUser,
									'AboutMe' => $row->AboutMe,
									'PictureUser' => $PictureUser,
									'AddressUser' => $row->AddressUser,
									'Theme' => $row->Theme,
									'FullName' => $row->FullName,
									'IdSkpd' => $row->IdSkpd,
									'NamaSkpd' => $row->NamaSkpd
								);
							}
							//$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get user data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "UserUpdate":
							$IdUser = $this->input->post('IdUser');
							$NameUser = $this->input->post('NameUser');
							$FullName = $this->input->post('FullName');
							$EmailUser = $this->input->post('EmailUser');
							$AddressUser = $this->input->post('AddressUser');
							$PhoneUser = $this->input->post('PhoneUser');
							$StatusUser = $this->input->post('StatusUser');
							$LevelUser = $this->input->post('LevelUser');
							$PasswordUser = $this->input->post('PasswordUser');
							$Theme = $this->input->post('Theme');
							$AboutMe = $this->input->post('AboutMe');
							$NameUserOld = $this->input->post('NameUserOld');

							$data = array(
								'NameUser' => $NameUser,
								'FullName' => $FullName,
								'EmailUser' => $EmailUser,
								'AddressUser' => $AddressUser,
								'PhoneUser' => $PhoneUser,
								'StatusUser' => $StatusUser,
								'LevelUser' => $LevelUser,
								'PasswordUser' => password_hash($PasswordUser, PASSWORD_DEFAULT),
								'Theme' => $Theme,
								'AboutMe' => $AboutMe
							);

							if ($PasswordUser == null) {
								unset($data['PasswordUser']);
							}

							$query = $this->db->where('IdUser', $IdUser);
							$query = $this->db->update('user', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'User diupdate'
								);
								/*update post*//*
																																																																																																		$data = array(
																																																																																																			'AuthorNews' => $NameUser
																																																																																																		);
																																																																																																		$query = $this->db->where('AuthorNews', $NameUserOld);
																																																																																																		$query = $this->db->update('news', $data);
																																																																																																		*/
							}

							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);
							break;
						case "LoginAsContributor":
							$IdUser = $this->input->post('IdUser');
							$query = $this->db->where('IdUser', $IdUser);
							$query = $this->db->where('StatusUser', 'aktif');
							$query = $this->db->get('user');
							if ($query->num_rows() > 0) {
								$row = $query->row();

								$session = array(
									$this->user_model->UserFullName() => $this->encryption->encrypt($row->NameUser),
									$this->user_model->UserID() => $this->encryption->encrypt($row->IdUser),
									$this->user_model->UserLevel() => $this->encryption->encrypt($row->LevelUser),
									$this->user_model->UserIsLogin() => true,
									$this->user_model->UserIsActive() => $this->encryption->encrypt('aktif')
								);
								$this->session->set_userdata($session);

								$respon = array(
									'status' => 'sukses',
									'message' => 'Login sebagai operator atau editor berhasil'
								);

							} else {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Login sebagai operator atau editor gagal'
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