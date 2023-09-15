<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Irban extends CI_Controller
{
	function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Kelola IRBAN - Inspektorat Kabupaten Merauke';
			$data['irban_menu'] = 'active';
			$data['irban_submenu'] = 'active';

			$query = $this->db->where('LevelUser', 'IRBAN');
			$query = $this->db->get('user');
			$data['user_irban'] = $query->result();

			$this->load->view("backend/irban", $data);

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
						case "CategoryCreate":
							$data = array(
								'NameCategory' => $this->input->post('NameCategory'),
								'Description' => $this->input->post('Description'),
								'Time' => date('Y-m-d H:i:s'),
								'IdUser' => $this->input->post('UserIrban')
							);

							$query = $this->db->where('NameCategory', $this->input->post('NameCategory'));
							$query = $this->db->get('irban_category');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Irban ini sudah ada'
								);
							} else {
								$query = $this->db->insert('irban_category', $data);
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Irban baru ditambahkan'
									);
								}
							}

							echo json_encode($respon);

							break;
						case "CategoryEdit":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('irban_category');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get irban data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "CategoryDelete":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('irban');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ada data di IRBAN ini'
								);
							} else {
								$query = $this->db->where('IdCategory', $IdCategory);
								$query = $this->db->delete('irban_category');
								$respon = array(
									'status' => 'sukses',
									'message' => 'Hapus IRBAN'
								);
							}
							echo json_encode($respon);
							break;
						case "CategoryUpdate":
							$IdCategory = $this->input->post('IdCategory');
							$NameCategory = $this->input->post('NameCategory');
							$Description = $this->input->post('Description');
							$IdCategory = $this->input->post('IdCategory');
							$data = array(
								'NameCategory' => $NameCategory,
								'Description' => $Description,
								'IdCategory' => $IdCategory
							);

							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->update('irban_category', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update IRBAN'
								);
							}
							echo json_encode($respon);
							break;

						case "FileEdit":
							$IdIrban = $this->input->post('IdIrban');
							$query = $this->db->query("SELECT IdIrban, irban.Time, NamaPegawai, irban.NoTelp, irban_category.IdCategory, 
							irban_category.NameCategory, skpd.IdSkpd, skpd.NamaSkpd FROM irban 
							INNER JOIN irban_category ON irban.IdCategory = irban_category.IdCategory 
							INNER JOIN skpd ON irban.IdSkpd = skpd.IdSkpd WHERE IdIrban='$IdIrban' ");
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "FileDelete":
							$IdIrban = $this->input->post('IdIrban');

							$query = $this->db->where('IdIrban', $IdIrban);
							$query = $this->db->delete('irban');
							$respon = array(
								'status' => 'sukses',
								'message' => 'Hapus file'
							);
							echo json_encode($respon);
							break;
						case "FileUpdate":
							$IdIrban = $this->input->post('IdIrban');
							$IdCategory = $this->input->post('IdCategory');
							$NoTelp = $this->input->post('NoTelp');
							$NamaPegawai = $this->input->post('NamaPegawai');
							$Fullpath = $this->input->post('Fullpath');
							$IdSkpd = $this->input->post('NamaSkpd');

							$data = array(
								'IdSkpd' => $IdSkpd,
								'NamaPegawai' => $NamaPegawai,
								'NoTelp' => $NoTelp,
								'IdCategory' => $IdCategory
							);

							$query = $this->db->where('IdSkpd', $this->input->post('NamaSkpd'));
							$query = $this->db->get('irban');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'data ini sudah ada'
								);
							} else {
								$query = $this->db->where('IdCategory', $IdCategory);
								$query = $this->db->update('irban', $data);
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Update berhasil'
									);
								}
							}

							echo json_encode($respon);
							break;
						case "FileCreate":
							$data = array(
								'NamaPegawai' => $this->input->post('NamaPegawai'),
								'NoTelp' => $this->input->post('NoTelp'),
								'IdCategory' => $this->input->post('IdCategory'),
								'IdSkpd' => $this->input->post('NamaSkpd'),
								'Time' => date('Y-m-d H:i:s')
							);

							$query = $this->db->where('IdSkpd', $this->input->post('NamaSkpd'));
							$query = $this->db->get('irban');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'data ini sudah ada'
								);
							} else {
								$query = $this->db->insert('irban', $data);
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'data berhasil ditambahkan'
									);
								}
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

	function IrbanCategoryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			$requestData = $this->input->post();
			$table = 'irban_category';
			$columns = array(
				'0' => 'NameCategory',
				'1' => 'Description',
				'2' => 'NameUser',
			);

			$query = $this->db->query("SELECT IdCategory, NameCategory, Description, Time, user.IdUser, user.NameUser FROM irban_category INNER JOIN user ON user.IdUser = irban_category.IdUser");
			$recordsTotal = $query->num_rows();
			$recordsFiltered = $recordsTotal;

			if (!empty($requestData['search']['value'])) {
				//receive search value;
				$sql = " SELECT IdCategory, NameCategory, Description, Time, user.IdUser, user.NameUser FROM irban_category INNER JOIN user ON user.IdUser = irban_category.IdUser ";
				$sql .= " WHERE NameCategory LIKE'%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR Description LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR Time LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR user.NameUser LIKE '%" . $requestData['search']['value'] . "%' ";

				$query = $this->db->query($sql);
				$recordsFiltered = $query->num_rows();
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
				$query = $this->db->query($sql);
			} else {
				$sql = " SELECT IdCategory, NameCategory, Description, Time, user.IdUser, user.NameUser FROM irban_category INNER JOIN user ON user.IdUser = irban_category.IdUser ";
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
				$query = $this->db->query($sql);
			}

			if ($query->num_rows() > 0) {

				foreach ($query->result() as $row) {
					$data[] = array(
						'NameCategory' => '<a href="' . base_url() . 'backend/irban/detail/' . $row->IdCategory . '">' . $row->NameCategory . '</a>' . '<br/><small>(' . $this->backend_irban->GetTotal($row->IdCategory) . ' data)</small>',
						'Description' => word_limiter($row->Description, 4),
						'NameUser' => $row->NameUser,
						'Option' => '<button onclick="CategoryEdit(' . $row->IdCategory . ')" class="btn btn-sm btn-icon btn-primary btn-round" >
												<i class="icon wb-pencil"></i>
											</button>
											<button onclick="CategoryDelete(' . $row->IdCategory . ')" class="btn btn-sm btn-icon btn-danger btn-round" >
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
				$data['page_title'] = 'Detail Irban - Inspektorat Kabupaten Merauke';
				$data['irban_menu'] = 'active';
				$data['irban_submenu'] = 'active';
				$data['idirbanlist'] = $IdCategory;

				$query = $this->db->get('skpd');
				if ($query->num_rows() > 0) {
					$data['skpd'] = $query->result();
				} else {
					$data['skpd'] = null;
				}

				$query = $this->db->get('irban_category');
				if ($query->num_rows() > 0) {
					$data['irban'] = $query->result();
				} else {
					$data['irban'] = null;
				}

				$query = $this->db->where('IdCategory', $IdCategory);
				$query = $this->db->get('irban_category');
				if ($query->num_rows() > 0) {
					$row = $query->row();
					$data['idcategory'] = $row->IdCategory;
					$data['namecategory'] = $row->NameCategory;

					$query = $this->db->where('IdCategory', $IdCategory);
					$query = $this->db->get('irban');
					$data['totalirban'] = $query->num_rows();

					$query = $this->db->order_by('NameCategory', 'ASC');
					$query = $this->db->get('irban_category');
					$data['irbancategory'] = $query->result();
				} else {
					$this->load->view('404');
				}
				$this->load->view('backend/irban-detail', $data);
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}

	}

	function IrbanList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();

				$IdCategory = $this->input->post('IdCategory');
				$columns = array(
					'0' => 'NamaSkpd',
					'1' => 'IdCategory',
					'2' => 'NamaPegawai',
					'3' => 'NoTelp'
				);

				$query = $this->db->query("SELECT IdIrban, irban.Time, NamaPegawai, irban.NoTelp, irban_category.IdCategory, 
											irban_category.NameCategory, skpd.IdSkpd, skpd.NamaSkpd FROM irban 
											INNER JOIN irban_category ON irban.IdCategory = irban_category.IdCategory 
											INNER JOIN skpd ON irban.IdSkpd = skpd.IdSkpd WHERE irban_category.IdCategory='$IdCategory' ");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					$sql = " SELECT IdIrban, irban.Time, NamaPegawai, irban.NoTelp, irban_category.IdCategory, 
					irban_category.NameCategory, skpd.IdSkpd, skpd.NamaSkpd FROM irban 
					INNER JOIN irban_category ON irban.IdCategory = irban_category.IdCategory 
					INNER JOIN skpd ON irban.IdSkpd = skpd.IdSkpd ";
					$sql .= " WHERE irban_category.IdCategory='$IdCategory' AND NamaPegawai LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR NoTelp LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR NameCategory LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR NamaSkpd LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdIrban, irban.Time, NamaPegawai, irban.NoTelp, irban_category.IdCategory, 
					irban_category.NameCategory, skpd.IdSkpd, skpd.NamaSkpd FROM irban 
					INNER JOIN irban_category ON irban.IdCategory = irban_category.IdCategory 
					INNER JOIN skpd ON irban.IdSkpd = skpd.IdSkpd ";
					$sql .= " WHERE irban_category.IdCategory='$IdCategory' ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {

					foreach ($query->result() as $row) {
						$data[] = array(
							'NamaSkpd' => $row->NamaSkpd,
							'NoTelp' => word_limiter($row->NoTelp, 2),
							'Category' => $row->NameCategory,
							'NamaPegawai' => $row->NamaPegawai,
							'Option' => '   <button onclick="FileEdit(' . $row->IdIrban . ')" class="btn btn-sm btn-icon btn-primary btn-round">
												<i class="icon wb-pencil"></i>
											</button>
											<button onclick="FileDelete(' . $row->IdIrban . ')" class="btn btn-sm btn-icon btn-danger btn-round">
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
}