<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skpd extends CI_Controller
{

	function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Kelola SKPD - Inspektorat Kabupaten Merauke';
			$data['skpd_menu'] = 'active';
			$data['skpd_submenu'] = 'active';
			$this->load->view("backend/skpd", $data);

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
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}
							$data = array(
								'NamaSkpd' => $this->input->post('NamaSkpd'),
								'SkpdAlias' => $this->input->post('SkpdAlias'),
								'NoTelp' => $this->input->post('NoTelp'),
								'Email' => $this->input->post('Email'),
								'Alamat' => $this->input->post('Alamat'),
								'FlagPublish' => $FlagPublish,
								'DateCreated' => date('Y-m-d H:i:s')
							);

							$query = $this->db->where('NamaSkpd', $this->input->post('NamaSkpd'));
							$query = $this->db->get('skpd');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Skpd ini sudah ada'
								);
							} else {
								$query = $this->db->insert('skpd', $data);
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'skpd baru ditambahkan'
									);
								}
							}

							echo json_encode($respon);

							break;
						case "CategoryEdit":
							$IdSkpd = $this->input->post('IdSkpd');
							$query = $this->db->where('IdSkpd', $IdSkpd);
							$query = $this->db->get('skpd');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get skpd data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "CategoryDelete":
							$IdSkpd = $this->input->post('IdSkpd');
							$query = $this->db->where('IdSkpd', $IdSkpd);
							$query = $this->db->delete('skpd');
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Hapus SKPD'
								);
							}
							echo json_encode($respon);
							break;
						case "CategoryUpdate":
							$IdSkpd = $this->input->post('IdSkpd');
							$NamaSkpd = $this->input->post('NamaSkpd');
							$SkpdAlias = $this->input->post('SkpdAlias');
							$NoTelp = $this->input->post('NoTelp');
							$Email = $this->input->post('Email');
							$Alamat = $this->input->post('Alamat');
							$IdSkpd = $this->input->post('IdSkpd');

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'NamaSkpd' => $NamaSkpd,
								'SkpdAlias' => $SkpdAlias,
								'NoTelp' => $NoTelp,
								'Email' => $Email,
								'Alamat' => $Alamat,
								'FlagPublish' => $FlagPublish,
								'IdSkpd' => $IdSkpd
							);

							$query = $this->db->where('IdSkpd', $IdSkpd);
							$query = $this->db->update('skpd', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update kategori'
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

	function SkpdList()
	{
		if ($this->user_model->CheckSession() == 1) {
			$requestData = $this->input->post();
			$table = 'skpd';
			$columns = array(
				'0' => 'NamaSkpd',
				'1' => 'SkpdAlias',
				'2' => 'NoTelp',
				'3' => 'Email',
				'4' => 'Alamat',
				//'5' => 'FlagPublish'
			);

			$query = $this->db->query("
						SELECT IdSkpd, NamaSkpd, SkpdAlias, NoTelp, Email, Alamat
						FROM $table
						");
			$recordsTotal = $query->num_rows();
			$recordsFiltered = $recordsTotal;

			if (!empty($requestData['search']['value'])) {
				//receive search value;
				$sql = " SELECT IdSkpd, NamaSkpd, SkpdAlias, NoTelp, Email, Alamat";
				$sql .= " FROM $table ";
				$sql .= " WHERE NamaSkpd LIKE'%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR SkpdAlias LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR Email LIKE '%" . $requestData['search']['value'] . "%' ";
				//$sql.= " OR FlagPublish LIKE '%".$requestData['search']['value']."%' ";

				$query = $this->db->query($sql);
				$recordsFiltered = $query->num_rows();
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
				$query = $this->db->query($sql);
			} else {
				$sql = " SELECT IdSkpd, NamaSkpd, SkpdAlias, NoTelp, Email, Alamat";
				$sql .= " FROM $table ";
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
				$query = $this->db->query($sql);
			}

			if ($query->num_rows() > 0) {

				foreach ($query->result() as $row) {
					$data[] = array(
						'NamaSkpd' => $row->NamaSkpd,
						'SkpdAlias' => $row->SkpdAlias,
						'NoTelp' => $row->NoTelp,
						'Email' => $row->Email,
						'Alamat' => word_limiter($row->Alamat, 4),
						//'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
						'Option' => '<button onclick="CategoryEdit(' . $row->IdSkpd . ')" class="btn btn-sm btn-icon btn-primary btn-round" ' . $RoleFileUpdate . '>
												<i class="icon wb-pencil"></i>
											</button>
											<button onclick="CategoryDelete(' . $row->IdSkpd . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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

}