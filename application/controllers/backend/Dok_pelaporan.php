<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dok_pelaporan extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Dokumen Pelaporan - Inspektorat Kabupaten Merauke';
			$data['dokumen_menu'] = 'active';
			$data['pelaporan_submenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			/*
									   $RoleFileCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileCreate');
										   if($RoleFileCreate=='no'){$RoleFileCreate='disabled';}
										   $data['RoleFileCreate'] = $RoleFileCreate;
									   */
			/*
									   $RoleFileUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryUpdate');
										   if($RoleFileUpdate=='no'){$RoleFileUpdate='disabled';}
										   $data['RoleFileUpdate'] = $RoleFileUpdate;
									   $RoleFileDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileDelete');
										   if($RoleFileDelete=='no'){$RoleFileDelete='disabled';}
										   $data['RoleFileDelete'] = $RoleFileDelete;
									   */
			/*role*/
			$this->load->view("backend/dok-pelaporan", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function SliderList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'dok_pelaporan';
				$columns = array(
					'0' => 'Caption',
					'1' => 'Fullpath',
					'2' => 'Extension',
					'3' => 'Filesize',
					'4' => 'Time',
					'5' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdPelaporan, Caption, Fullpath, Basename, Extension, Filesize, Time, FlagPublish
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdPelaporan, Caption, Fullpath, Basename, Extension, Filesize, Time, FlagPublish ";
					$sql .= " FROM $table ";
					$sql .= " WHERE Caption LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Fullpath LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Extension LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdPelaporan, Caption, Fullpath, Basename, Extension, Filesize, Time, FlagPublish ";
					$sql .= " FROM $table ";
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
						$data[] = array(
							'Caption' => $row->Caption,
							'Fullpath' => '<a href="' . $row->Fullpath . '" target="_blank">' . word_limiter($row->Fullpath, 30) . '</a>',
							'Extension' => $row->Extension,
							'Filesize' => byte_format($row->Filesize),
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'Option' => '<button onclick="FileEdit(' . $row->IdPelaporan . ')" class="btn btn-sm btn-icon btn-primary btn-round" ' . $RoleFileUpdate . '>
												<i class="icon wb-pencil"></i> 
											</button>
											<button onclick="FileDelete(' . $row->IdPelaporan . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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
							$IdPelaporan = $this->input->post('IdPelaporan');
							$query = $this->db->where('IdPelaporan', $IdPelaporan);
							$query = $this->db->get('dok_pelaporan');
							if ($query->num_rows() > 0) {
								$row = $query->row();
								$Filename = $row->Filename;
								$Fullpath = $row->Fullpath;
								$Basename = $row->Basename;
								$Dirname = $row->Dirname;
								$Extension = $row->Extension;

								$query = $this->db->where('IdPelaporan', $IdPelaporan);
								$query = $this->db->delete('dok_pelaporan');
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Hapus file'
									);
									unlink("$Dirname/$Basename");
								} else {
									$respon = array(
										'status' => 'gagal',
										'message' => 'Hapus file'
									);
								}

							}
							echo json_encode($respon);
							break;
						case "FileEdit":
							$IdPelaporan = $this->input->post('IdPelaporan');
							$query = $this->db->where('IdPelaporan', $IdPelaporan);
							$query = $this->db->get('dok_pelaporan');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get dokumen data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "FileUpdate":
							$IdPelaporan = $this->input->post('IdPelaporan');
							$Caption = $this->input->post('Caption');
							$Description = $this->input->post('Description');
							$Fullpath = $this->input->post('Fullpath');

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'Caption' => $Caption,
								'Description' => $Description,
								'FlagPublish' => $FlagPublish,
								'Fullpath' => $Fullpath
							);

							$query = $this->db->where('IdPelaporan', $IdPelaporan);
							$query = $this->db->update('dok_pelaporan', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update dokumen perencanaan'
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
			$Caption = $this->input->post('Caption');
			$Description = $this->input->post('Description');
			$FlagPublish = $this->input->post('FlagPublish');

			$file_name = rand(111111, 999999) . date('YmdHis');

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '4000';
			$config['max_width'] = '4000';
			$config['max_height'] = '4000';
			$config['file_name'] = $file_name;

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
						'Time' => date('Y-m-d H:i:s'),
						'IdUser' => $IdUser,
						'Caption' => $Caption,
						'Description' => $Description,
						'FlagPublish' => $FlagPublish
					);
					$query = $this->db->insert('dok_pelaporan', $data);

				}
				/*resize*/
				$config['image_library'] = 'gd2';
				$config['source_image'] = $file_path . $file_name;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 1140;
				$config['height'] = 560;

				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				/*resize*/
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