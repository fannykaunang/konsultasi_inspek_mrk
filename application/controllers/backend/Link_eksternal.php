<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Link_eksternal extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Link Terkait - Inspektorat Kabupaten Merauke';
			$data['settingsmenu'] = 'active';
			$data['settingslinksubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$data['totalpage'] = $this->db->count_all('link_eksternal');

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
			$this->load->view("backend/link-eksternal", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function SliderList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'link_eksternal';
				$columns = array(
					'0' => 'Caption',
					'1' => 'Description',
					'2' => 'Time',
					'3' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdLink, Caption, Description, Time, FlagPublish
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdLink, Caption, Description, Time, FlagPublish ";
					$sql .= " FROM $table ";
					$sql .= " WHERE Caption LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Description LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdLink, Caption, Description, Time, FlagPublish ";
					$sql .= " FROM $table ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					/*role*/
					// $RoleFileUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileUpdate');
					// 	if($RoleFileUpdate=='no'){$RoleFileUpdate='disabled';}
					// $RoleFileDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileDelete');
					// 	if($RoleFileDelete=='no'){$RoleFileDelete='disabled';}
					/*role*/

					foreach ($query->result() as $row) {
						$data[] = array(
							'Caption' => $row->Caption,
							'Description' => '<a href="' . $row->Description . '" target="_blank">' . word_limiter($row->Description, 30) . '</a>',
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'Option' => '<button onclick="FileEdit(' . $row->IdLink . ')" class="btn btn-sm btn-icon btn-primary btn-round" ' . $RoleFileUpdate . '>
												<i class="icon wb-pencil"></i> 
											</button>
											<button onclick="FileDelete(' . $row->IdLink . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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
						case "FileCreate":
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'Caption' => $this->input->post('Caption'),
								'Description' => $this->input->post('Description'),
								'Time' => date('Y-m-d H:i:s'),
								'FlagPublish' => $FlagPublish
							);
							$query = $this->db->insert('link_eksternal ', $data);
							if ($query) {

								$respon = array(
									'status' => 'sukses',
									'message' => 'Simpan Link baru'
								);
							}

							echo json_encode($respon);
							break;
						case "FileDelete":
							$ulevel = $this->user_model->GetLevelUser();
							if ($ulevel == 'contributor') {
								$respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus link ini');
							} else {
								$IdLink = $this->input->post('IdLink');
								$query = $this->db->where('IdLink', $IdLink);
								$query = $this->db->delete('link_eksternal');
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Hapus Link'
									);
								}
							}
							echo json_encode($respon);
							break;
						case "FileEdit":
							$IdLink = $this->input->post('IdLink');
							$query = $this->db->where('IdLink', $IdLink);
							$query = $this->db->get('link_eksternal');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get Link data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "FileUpdate":
							$IdLink = $this->input->post('IdLink');
							$Caption = $this->input->post('Caption');
							$Description = $this->input->post('Description');

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'Caption' => $Caption,
								'Description' => $Description,
								'FlagPublish' => $FlagPublish,
								'Time' => date('Y-m-d H:i:s'),
							);

							$query = $this->db->where('IdLink', $IdLink);
							$query = $this->db->update('link_eksternal', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update Link'
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