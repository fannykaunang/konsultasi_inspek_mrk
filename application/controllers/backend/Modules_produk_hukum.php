<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modules_produk_hukum extends CI_Controller
{

	function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['dokumen_menu'] = 'active';
			$data['modulesprodukhukum'] = 'active';

			$query = $this->db->get('produk_hukum_category');
			$data['produkhukumcategory'] = $query->result();


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
							$query = $this->db->get('produk_hukum_category');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Kategori ini sudah ada'
								);
							} else {
								$query = $this->db->insert('produk_hukum_category', $data);
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
							$query = $this->db->get('produk_hukum_category');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get produk_hukum data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "CategoryDelete":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('produk_hukum');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ada file di kategori ini'
								);
							} else {
								$query = $this->db->where('IdCategory', $IdCategory);
								$query = $this->db->delete('produk_hukum_category');
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
							$query = $this->db->update('produk_hukum_category', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update kategori'
								);

							}
							echo json_encode($respon);
							break;

						case "FileEdit":
							$IdFile = $this->input->post('IdFile');
							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->get('produk_hukum');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get produk_hukum data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "FileDelete":
							$IdFile = $this->input->post('IdFile');
							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->get('produk_hukum');
							if ($query->num_rows() > 0) {
								$row = $query->row();
								$Filename = $row->Filename;
								$Fullpath = $row->Fullpath;
								$Basename = $row->Basename;
								$Dirname = $row->Dirname;
								$Extension = $row->Extension;


								if (!unlink("$Dirname/$Basename")) {
									$respon = array(
										'status' => 'gagal',
										'message' => 'Hapus file'
									);
								} else {
									$query = $this->db->where('IdFile', $IdFile);
									$query = $this->db->delete('produk_hukum');
									$respon = array(
										'status' => 'sukses',
										'message' => 'Hapus file'
									);
								}
							}
							echo json_encode($respon);
							break;
						case "FileUpdate":
							$IdFile = $this->input->post('IdFile');
							$IdCategory = $this->input->post('IdCategory');
							$Nomor = $this->input->post('Nomor');
							$Tentang = $this->input->post('Tentang');
							$Tahun = $this->input->post('Tahun');
							$Fullpath = $this->input->post('Fullpath');

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'Nomor' => $Nomor,
								'Tentang' => $Tentang,
								'FlagPublish' => $FlagPublish,
								'IdCategory' => $IdCategory,
								'TglUpdate' => date('Y-m-d H:i:s'),
								'Fullpath' => $Fullpath
							);

							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->update('produk_hukum', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update produk hukum'
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

	function ProdukHukumCategoryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			$requestData = $this->input->post();
			$table = 'produk_hukum_category';
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
						'NameCategory' => '<a href="' . base_url() . 'backend/modules_produk_hukum/detail/' . $row->IdCategory . '">' . $row->NameCategory . '</a>' . '<br/><small>(' . $this->backend_modules_produk_hukum->GetTotalProdukHukumInCategory($row->IdCategory) . ' file)</small>',
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
			redirect(base_url() . 'backend/login');
		}
	}

	function detail($IdCategory = null)
	{
		if ($this->user_model->CheckSession() == 1) {
			if (isset($IdCategory)) {
				$data['modulesmenu'] = 'active';
				$data['modulesprodukhukum'] = 'active';
				$data['idprodukhukumcategorylist'] = $IdCategory;

				/*category exist*/
				//	$query = $this->db->where('FlagPublish', 1);
				$query = $this->db->where('IdCategory', $IdCategory);
				$query = $this->db->get('produk_hukum_category');
				if ($query->num_rows() > 0) {
					$row = $query->row(); //category//
					$data['idcategory'] = $row->IdCategory;
					$data['namecategory'] = $row->NameCategory;
					/*produk_hukum*/
					$query = $this->db->where('IdCategory', $IdCategory);
					$query = $this->db->get('produk_hukum');
					$data['totalprodukhukum'] = $query->num_rows();

					/*category*/
					$query = $this->db->order_by('NameCategory', 'ASC');
					$query = $this->db->get('produk_hukum_category');
					$data['produkhukumcategory'] = $query->result();
				} else {
					$this->load->view('404');
				}
				$this->load->view('backend/modules-produk-hukum-detail', $data);
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}

	}

	function ProdukHukumList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				//var_dump($requestData);			
				$IdCategory = $this->input->post('IdCategory');

				$table = 'produk_hukum';
				$columns = array(
					'0' => 'Nomor',
					'1' => 'Tahun',
					'2' => 'Tentang',
					'3' => 'Filename',
					'4' => 'IdCategory',
					'5' => 'Filesize',
					'6' => 'Time',
					'7' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdFile, Nomor, Tahun, Tentang, Filename, Basename, Filesize, Time, Fullpath, Extension, IdCategory, FlagPublish
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdFile, Nomor, Tahun, Tentang, Filename, Basename, Filesize, Time, Fullpath, Extension, IdCategory, FlagPublish";
					$sql .= " FROM $table ";
					$sql .= " WHERE Filename LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Fullpath LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Extension LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";


					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdFile, Nomor, Tahun, Tentang, Filename, Basename, Filesize, Time, Fullpath, Extension, IdCategory, FlagPublish";
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
							'Nomor' => $row->Nomor,
							'Tahun' => $row->Tahun,
							'Tentang' => word_limiter($row->Tentang, 2),
							'Filename' => '<a href="' . $row->Fullpath . '">' . $row->Basename . '</a>',
							'Category' => $this->backend_modules_produk_hukum->GetProdukHukumCategory($row->IdCategory),
							'Filesize' => byte_format($row->Filesize),
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'Option' => '<button onclick="FileEdit(' . $row->IdFile . ')" class="btn btn-sm btn-icon btn-primary btn-round" ' . $RoleFileUpdate . '>
												<i class="icon wb-pencil"></i>
											</button>
											<button onclick="FileDelete(' . $row->IdFile . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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

	function UploadFile()
	{
		if ($this->user_model->CheckSession() == 1) {

			$Path = 'produk_hukum';
			$IdUser = $this->user_model->GetIdUser();
			$Tahun = $this->input->post('Tahun');
			$Nomor = $this->input->post('Nomor');
			$Tentang = $this->input->post('Tentang');
			$FlagPublish = $this->input->post('FlagPublish');
			$IdCategory = $this->input->post('IdCategory');

			$FileName = url_title($Nomor . ' ' . $Tahun);

			if (!$this->input->post('FlagPublish')) {
				$FlagPublish = '0';
			} else {
				$FlagPublish = '1';
			}

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|zip|rar|7zip|gif|jpg|jpeg|png';
			$config['max_size'] = '150000';
			$config['max_width'] = '4000';
			$config['max_height'] = '4000';
			$config['file_name'] = $FileName;

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


					/*resize*//*
									   $config['image_library'] = 'gd2';
									   $config['source_image'] = $file_path.$file_name;
									   $config['create_thumb'] = FALSE;
									   $config['maintain_ratio'] = TRUE;
									   $config['width'] = 1024;
									   $config['height'] = 1024;
									   
									   $this->image_lib->clear();
									   $this->image_lib->initialize($config);
									   $this->image_lib->resize();
								   /*resize*/

					$fileinfo = get_file_info($file_path . $file_name);
					$file_size = $fileinfo['size']; //re-read file actual size after resize;

					$length = 6;
					$FileAliasRandom = date('ymdhis') . rand(99999, 111111);

					/*
								   $query = $this->db->select('FileAlias');
								   $query = $this->db->where('FileAlias', $FileAliasRandom);
								   $query = $this->db->get('produk_hukum');
								   if($query->num_rows()>0){
									   $FileAliasRandom = random_string('alnum', $length+1);
								   }
								   */


					$data = array(
						'Filename' => $raw_name,
						'Dirname' => $file_path,
						'Basename' => $file_name,
						'Extension' => str_replace(".", "", $file_extension),
						'Fullpath' => base_url() . $Path . '/' . $file_name,
						'Filesize' => $file_size,
						'Time' => date('Y-m-d H:i:s'),
						'IdUser' => $IdUser,
						'Nomor' => $Nomor,
						'Tentang' => $Tentang,
						'Tahun' => $Tahun,
						'TglInput' => date('Y-m-d H:i:s'),
						'TglUpdate' => date('Y-m-d H:i:s'),
						'FlagPublish' => $FlagPublish,
						'IdCategory' => $IdCategory,
						'FileAlias' => $FileAliasRandom
					);
					$query = $this->db->insert('produk_hukum', $data);



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

/* End of file Modules_produk_hukum.php */
/* Location: ./application/controllers/backend/Modules_produk_hukum.php */