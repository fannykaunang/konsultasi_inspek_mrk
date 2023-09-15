<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modules_telepon_penting extends CI_Controller
{

	function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['modulesmenu'] = 'active';
			$data['modulesteleponpenting'] = 'active';

			$query = $this->db->get('telepon_penting_category');
			$data['teleponpentingcategory'] = $query->result();


			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			/*
					 $RoleFileCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileCreate');
						 if($RoleFileCreate=='no'){$RoleFileCreate='disabled';}
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
			$this->load->view("backend/modules-produk-hukum", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function ajax()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				if ($do = $this->input->post('do')) {

					$IdUser = $this->user_model->GetIdUser();

					switch ($do) {
						case "CategoryCreate":
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}
							$data = array(
								'NameCategory' => $this->input->post('NameCategory'),
								'Description' => $this->input->post('Description'),
								'FlagPublish' => $FlagPublish,
								'Time' => date('Y-m-d H:i:s')
							);

							$query = $this->db->where('NameCategory', $this->input->post('NameCategory'));
							$query = $this->db->get('telepon_penting_category');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Kategori ini sudah ada'
								);
							} else {
								$query = $this->db->insert('telepon_penting_category', $data);
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Kategori baru ditambahkan'
									);
								}
							}

							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);

							break;
						case "CategoryEdit":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('telepon_penting_category');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get telepon_penting data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "CategoryDelete":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('telepon_penting');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ada file di kategori ini'
								);
							} else {
								$query = $this->db->where('IdCategory', $IdCategory);
								$query = $this->db->delete('telepon_penting_category');
								$respon = array(
									'status' => 'sukses',
									'message' => 'Hapus kategori'
								);
							}
							echo json_encode($respon);
							break;
						case "CategoryUpdate":
							$IdCategory = $this->input->post('IdCategory');
							$NameCategory = $this->input->post('NameCategory');
							$Description = $this->input->post('Description');
							$IdCategory = $this->input->post('IdCategory');

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'NameCategory' => $NameCategory,
								'Description' => $Description,
								'FlagPublish' => $FlagPublish,
								'IdCategory' => $IdCategory
							);

							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->update('telepon_penting_category', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update kategori'
								);

							}
							echo json_encode($respon);
							break;

						case "TeleponPentingCreate";
							$Name = $this->input->post('Name');
							$Address = $this->input->post('Address');
							$NoTelp = $this->input->post('NoTelp');
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}
							$IdCategory = $this->input->post('IdCategory');

							$Time = date('Y-m-d H:i:s');

							$data = array(
								'Name' => $Name,
								'Address' => $Address,
								'NoTelp' => $NoTelp,
								'FlagPublish' => $FlagPublish,
								'Time' => $Time,
								'TglInput' => date('Y-m-d H:i:s'),
								'TglUpdate' => date('Y-m-d H:i:s'),
								'IdCategory' => $IdCategory,
								'IdUser' => $IdUser
							);

							$query = $this->db->insert('telepon_penting', $data);

							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Telepon penting ditambahkan'
								);
							} else {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Telepon penting ditambahkan'
								);
							}
							echo json_encode($respon);

							break;
						case "TeleponPentingEdit":
							$IdFile = $this->input->post('IdFile');
							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->get('telepon_penting');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get telepon_penting data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "TeleponPentingDelete":
							$IdFile = $this->input->post('IdFile');
							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->delete('telepon_penting');
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'File penting dihapus'
								);
							} else {
								$respon = array(
									'status' => 'gagal',
									'message' => 'File penting dihapus'
								);
							}
							echo json_encode($respon);
							break;
						case "TeleponPentingUpdate":
							$IdFile = $this->input->post('IdFile');
							$Name = $this->input->post('Name');
							$Address = $this->input->post('Address');
							$NoTelp = $this->input->post('NoTelp');
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}
							$IdCategory = $this->input->post('IdCategory');
							$IdUser = $this->user_model->GetIdUser();
							$Time = date('Y-m-d H:i:s');

							$data = array(
								'Name' => $Name,
								'Address' => $Address,
								'NoTelp' => $NoTelp,
								'FlagPublish' => $FlagPublish,
								'Time' => $Time,
								'TglUpdate' => date('Y-m-d H:i:s'),
								'IdCategory' => $IdCategory,
								'IdUser' => $IdUser
							);

							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->update('telepon_penting', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update telepon penting'
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

	function TeleponPentingCategoryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {

				$requestData = $this->input->post();
				$table = 'telepon_penting_category';
				$columns = array(
					'0' => 'NameCategory',
					'1' => 'Description',
					'2' => 'Time',
					'3' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdCategory, NameCategory, Description, Time, FlagPublish
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdCategory, NameCategory, Description, Time, FlagPublish";
					$sql .= " FROM $table ";
					$sql .= " WHERE NameCategory LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Description LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Time LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdCategory, NameCategory, Description, Time, FlagPublish";
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
							'NameCategory' => '<a href="' . base_url() . 'backend/modules_telepon_penting/detail/' . $row->IdCategory . '">' . $row->NameCategory . '</a>' . '<br/><small>(' . $this->backend_modules_telepon_penting->GetTotalTeleponPentingInCategory($row->IdCategory) . ' nomor)</small>',
							'Description' => word_limiter($row->Description, 4),
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'Option' => '<button onclick="CategoryEdit(' . $row->IdCategory . ')" class="btn btn-sm btn-icon btn-primary btn-round" ' . $RoleFileUpdate . '>
												<i class="icon wb-pencil"></i>
											</button>
											<button onclick="CategoryDelete(' . $row->IdCategory . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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


	function TeleponPentingList()
	{
		if ($this->user_model->CheckSession() == 1) {

			$requestData = $this->input->post();
			//var_dump($requestData);			
			$IdCategory = $this->input->post('IdCategory');

			$table = 'telepon_penting';
			$columns = array(
				'0' => 'Name',
				'1' => 'Address',
				'2' => 'NoteTelp',
				'3' => 'IdCategory',
				'4' => 'FlagPublish',
				'5' => 'Time',

			);

			$query = $this->db->query("
						SELECT IdFile, IdCategory, Name, Address, NoTelp, FlagPublish, Time 
						FROM $table
						");
			$recordsTotal = $query->num_rows();
			$recordsFiltered = $recordsTotal;

			if (!empty($requestData['search']['value'])) {
				//receive search value;
				$sql = " SELECT IdFile, IdCategory, Name, Address, NoTelp, FlagPublish, Time ";
				$sql .= " FROM $table ";
				$sql .= " WHERE Name LIKE'%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR Address LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR NoTelp LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";


				$query = $this->db->query($sql);
				$recordsFiltered = $query->num_rows();
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
				$query = $this->db->query($sql);
			} else {
				$sql = " SELECT IdFile, IdCategory, Name, Address, NoTelp, FlagPublish, Time ";
				$sql .= " FROM $table ";
				$sql .= " WHERE IdCategory='$IdCategory' ";
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
						'Name' => $row->Name,
						'Address' => $row->Address,
						'NoTelp' => $row->NoTelp,
						'Category' => $this->backend_modules_telepon_penting->GetTeleponPentingCategory($row->IdCategory),
						'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
						'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
						'Option' => '<button onclick="TeleponPentingEdit(' . $row->IdFile . ')" class="btn btn-sm btn-icon btn-primary btn-round" ' . $RoleFileUpdate . '>
												<i class="icon wb-pencil"></i>
											</button>
											<button onclick="TeleponPentingDelete(' . $row->IdFile . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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
	}

	function detail($IdCategory = null)
	{
		if ($this->user_model->CheckSession() == 1) {
			if (isset($IdCategory)) {
				$data['modulesmenu'] = 'active';
				$data['modulesteleponpenting'] = 'active';
				$data['idteleponpentingcategorylist'] = $IdCategory;

				/*category exist*/
				//	$query = $this->db->where('FlagPublish', 1);
				$query = $this->db->where('IdCategory', $IdCategory);
				$query = $this->db->get('telepon_penting_category');
				if ($query->num_rows() > 0) {
					$row = $query->row(); //category//
					$data['idcategory'] = $row->IdCategory;
					$data['namecategory'] = $row->NameCategory;
					/*telepon_penting*/
					$query = $this->db->where('IdCategory', $IdCategory);
					$query = $this->db->get('telepon_penting');
					$data['totalteleponpenting'] = $query->num_rows();

					/*category*/
					$query = $this->db->order_by('NameCategory', 'ASC');
					$query = $this->db->get('telepon_penting_category');
					$data['teleponpentingcategory'] = $query->result();
				} else {
					$this->user_model->Redirect('404');
				}
				$this->load->view('backend/modules-telepon-penting-detail', $data);
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}
	}


}

/* End of file Modules_telepon_penting.php */
/* Location: ./application/controllers/backend/Modules_telepon_penting.php */