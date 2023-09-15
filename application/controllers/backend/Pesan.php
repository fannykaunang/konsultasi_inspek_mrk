<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Pelaporan Masuk- Inspektorat Kabupaten Merauke';
			$data['pesanmenu'] = 'active';
			$data['pesansubmenu'] = 'active';

			$data['author'] = $this->backend_konsultasi_model->GetAuthorNews($IdKonsultasi);

			$this->load->view("backend/pesan", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function NewsList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'konsultasi';
				$columns = array(
					'0' => 'Time',
					'1' => 'Title',
					'2' => 'Category',
					'3' => 'Author',
					'4' => 'NamaSkpd',
					'5' => 'FlagPublish',
					'6' => 'FlagPublishInspektur'
				);

				$query = $this->db->query("
				SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
				skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
				INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd ";
					$sql .= " WHERE Time LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Title LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Category LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR konsultasi.Author LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR konsultasi.FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = array(
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'Title' => '<label id="' . $row->IdKonsultasi . '" onmouseover="ShowMenu(' . $row->IdKonsultasi . ')">' . word_limiter($row->Title, 8) . '</label> 
								<br/>',
							'Category' => $row->Category,
							'Author' => $row->Author,
							'NamaSkpd' => $row->NamaSkpd,
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'FlagPublishInspektur' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublishInspektur),
							'Option' => '	<a href="' . base_url() . 'backend/pesan/edit/' . $row->IdKonsultasi . '" class="btn btn-icon btn-sm btn-warning btn-round" title="Edit">
												<i class="icon wb-eye"></i>
											</a> &nbsp;
											<button onclick="NewsDelete(' . $row->IdKonsultasi . ')" class="btn btn-sm btn-icon btn-danger btn-round" title="Hapus">
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
			if ($this->user_model->CheckSession() == 1) {
				if ($do = $this->input->post('do')) {

					$author = $this->user_model->GetNameUser();
					$IdUser = $this->user_model->GetIdUser();

					switch ($do) {

						case "pesan":
							$IdKonsultasi = $this->input->post('IdKonsultasi');
							$query = $this->db->where('IdKonsultasi', $IdKonsultasi);
							$query = $this->db->get('konsultasi');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get data isi',
								'data' => $data
							);
							echo json_encode($respon);
							break;
						case "pesanUpdate":

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$IdKonsultasi = $this->input->post('IdKonsultasi');
							$Content = $this->input->post('Content');

							$data = array(
								'Content' => $Content,
								'FlagPublish' => $FlagPublish
							);

							$query = $this->db->where('IdKonsultasi', $IdKonsultasi);
							$query = $this->db->update('konsultasi', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update Konsultasi'
								);
							}
							echo json_encode($respon);
							break;
						case "NewsDelete":

							$ulevel = $this->user_model->GetLevelUser();

							if ($ulevel == 'contributor') {
								$respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus berita ini');
							} else {
								$IdKonsultasi = $this->input->post('IdKonsultasi');
								$query = $this->db->where('IdKonsultasi', $IdKonsultasi);
								$query = $this->db->delete('konsultasi');
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Hapus Konsultasi'
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

	function edit($IdKonsultasi)
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Ubah Pesan - Inspektorat Kabupaten Merauke';
			$data['pesanmenu'] = 'active';
			$data['pesansubmenu'] = 'active';

			$Author = $this->user_model->GetNameUser();

			/*role*/
			$Role = $this->role_model->LoadRole();

			if ($this->user_model->GetLevelUser() == 'superadmin') {
				$query = $this->db->query("
												SELECT * FROM konsultasi 
												WHERE IdKonsultasi='$IdKonsultasi'
											");
				if ($query->num_rows() > 0) {
					$data['editnews'] = $query->result();
					$querycategory = $this->db->order_by('NameCategory', 'ASC');
					$querycategory = $this->db->get('category');
					$data['categorynews'] = $querycategory->result();
				} else {
					$data['editnews'] = null;
				}
				$data['RoleNewsUpdate'] = 'yes';
			} else {
				if ($this->user_model->GetLevelUser() == 'IRBAN') {
					if ($Role['RoleNewsUpdate'] == 'yes') {
						$query = $this->db->query("
														SELECT * FROM konsultasi 
														WHERE IdKonsultasi='$IdKonsultasi'
													");
						if ($query->num_rows() > 0) {
							$data['editnews'] = $query->result();
							$querycategory = $this->db->order_by('NameCategory', 'ASC');
							$querycategory = $this->db->get('category');
							$data['categorynews'] = $querycategory->result();
						} else {
							$data['editnews'] = null;
						}
						$data['RoleNewsUpdate'] = 'yes';
					} else {
						$data['RoleNewsUpdate'] = 'no';
					}
				}
				if ($this->user_model->GetLevelUser() == 'SKPD') {
					if ($Role['RoleNewsUpdate'] == 'yes') {
						$Author = $this->user_model->GetNameUser();

						$query = $this->db->query("
														SELECT * FROM konsultasi 
														WHERE IdKonsultasi='$IdKonsultasi'
														AND Author='$Author' AND FlagPublish='0'
													");
						if ($query->num_rows() > 0) {
							$data['editnews'] = $query->result();
							$querycategory = $this->db->order_by('NameCategory', 'ASC');
							$querycategory = $this->db->get('category');
							$data['categorynews'] = $querycategory->result();
						} else {
							$data['editnews'] = null;
							$data['prohibitupdate'] = 'yes';
						}
						$data['RoleNewsUpdate'] = 'yes';
					} else {
						$data['RoleNewsUpdate'] = 'no';
					}
				}
			}

			/*role*/
			$this->load->view('backend/pesan-edit', $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

}