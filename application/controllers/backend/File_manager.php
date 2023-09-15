<?php
defined('BASEPATH') or exit('No direct script access allowed');

class File_manager extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'File Pelaporan - Inspektorat Kabupaten Merauke';
			$data['pesanmenu'] = 'active';
			$data['filemanagersubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();

			$RoleFileCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileCreate');
			if ($RoleFileCreate == 'no') {
				$RoleFileCreate = 'disabled';
			}
			$data['RoleFileCreate'] = $RoleFileCreate;
			/*
																									  $RoleFileUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryUpdate');
																										  if($RoleFileUpdate=='no'){$RoleFileUpdate='disabled';}
																										  $data['RoleFileUpdate'] = $RoleFileUpdate;
																									  $RoleFileDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileDelete');
																										  if($RoleFileDelete=='no'){$RoleFileDelete='disabled';}
																										  $data['RoleFileDelete'] = $RoleFileDelete;
																									  */
			/*role*/
			$this->load->view("backend/file-manager", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function FileManagerList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'filemanager';
				$columns = array(
					'0' => 'Filename',
					'1' => 'Filename',
					'2' => 'Filesize',
					'3' => 'Time',
					'4' => 'NamaSkpd',
					'5' => 'NameUser'
				);

				$query = $this->db->query("SELECT `IdFile`, `Filename`, `Dirname`, `Extension`, `Basename`, `Fullpath`, `Filesize`, `Status`, 
										`Time`, user.`IdUser`, user.NameUser, skpd.NamaSkpd FROM $table 
										INNER JOIN user ON filemanager.IdUser = user.IdUser 
										INNER JOIN skpd ON user.IdSkpd = skpd.IdSkpd");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = "SELECT `IdFile`, `Filename`, `Dirname`, `Extension`, `Basename`, `Fullpath`, `Filesize`, `Status`, 
					`Time`, user.`IdUser`, user.NameUser, skpd.NamaSkpd ";
					$sql .= " FROM $table INNER JOIN user ON filemanager.IdUser = user.IdUser INNER JOIN skpd ON user.IdSkpd = skpd.IdSkpd";
					$sql .= " WHERE Filename LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Fullpath LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Extension LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR user.NameUser LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR skpd.NamaSkpd LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT `IdFile`, `Filename`, `Dirname`, `Extension`, `Basename`, `Fullpath`, `Filesize`, `Status`, 
					`Time`, user.`IdUser`, user.NameUser, skpd.NamaSkpd ";
					$sql .= " FROM $table INNER JOIN user ON filemanager.IdUser = user.IdUser INNER JOIN skpd ON user.IdSkpd = skpd.IdSkpd";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					/*role*/
					$RoleFileUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileUpdate');
					if ($RoleFileUpdate == 'no') {
						$RoleFileUpdate = 'disabled';
					}
					$RoleFileDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileDelete');
					if ($RoleFileDelete == 'no') {
						$RoleFileDelete = 'disabled';
					}
					/*role*/

					foreach ($query->result() as $row) {
						if (strtolower($row->Extension) == 'png' || strtolower($row->Extension) == 'jpg' || strtolower($row->Extension) == 'jpeg' || strtolower($row->Extension == 'gif')) {
							$Image = '<a href="' . $row->Fullpath . '" target="_blank"><img src="' . $row->Fullpath . '" width="100" height="100" class="img-rounded"/></img></a>';
						} else {
							$Image = word_limiter($row->Filename, 20);
						}

						$data[] = array(
							'Filename' => $Image,
							'FilenameStr' => $row->Filename,
							'Filesize' => byte_format($row->Filesize),
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'NamaSkpd' => $row->NamaSkpd,
							'NameUser' => $row->NameUser,
							'Option' => '<button onclick="FileDelete(' . $row->IdFile . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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
						case "FileDelete":
							$IdFile = $this->input->post('IdFile');
							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->get('filemanager');
							if ($query->num_rows() > 0) {
								$row = $query->row();
								$Filename = $row->Filename;
								$Fullpath = $row->Fullpath;
								$Basename = $row->Basename;
								$Dirname = $row->Dirname;
								$Extension = $row->Extension;

								!unlink("$Dirname/$Basename");
								$query = $this->db->where('IdFile', $IdFile);
								$query = $this->db->delete('filemanager');
								$respon = array(
									'status' => 'sukses',
									'message' => 'Hapus file'
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

	function UploadFile()
	{
		if ($this->user_model->CheckSession() == 1) {

			$Path = 'files';
			$IdUser = $this->user_model->GetIdUser();
			$Filename = url_title($this->input->post('Filename'));

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|zip|rar|7zip|gif|jpg|jpeg|png';
			$config['max_size'] = '4000';
			$config['max_width'] = '4000';
			$config['max_height'] = '4000';
			$config['file_name'] = $Filename;

			$this->load->library('upload', $config);
			$this->load->library('image_lib', $config);


			if (!$this->upload->do_upload()) {

				$message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ", "</span>");
				$status = 'gagal';
			} else {
				$result = array('upload_data' => $this->upload->data());
				foreach ($result as $row) {
					$full_path = $row['full_path'];
					$file_path = $row['file_path'];
					$file_name = $row['file_name'];
					$raw_name = $row['raw_name'];
					$file_extension = $row['file_ext'];
					$file_size = $row['file_size'];

					$data = array(
						'Filename' => $raw_name,
						'Dirname' => $file_path,
						'Basename' => $file_name,
						'Extension' => str_replace(".", "", $file_extension),
						'Fullpath' => base_url() . $Path . '/' . $file_name,
						'Filesize' => $file_size,
						'Status' => '',
						'Time' => date('Y-m-d H:i:s'),
						'IdUser' => $IdUser
					);
					$query = $this->db->insert('filemanager', $data);
				}

				$message = "";
				$status = 'sukses';
			}

			if ($status == 'sukses') {
				echo '<script>						
					parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";	
							
					</script>';
			} else {
				echo '<script>parent.document.getElementById("ResponUpload").innerHTML="' . $message . '";
					parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
				</script>';
			}
		} else {
			redirect(base_url() . 'backend/login');
		}
	}
}

/* End of file File_manager.php */
/* Location: ./application/controllers/backend/File_manager.php */