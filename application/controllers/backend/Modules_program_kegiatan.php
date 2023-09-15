<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modules_program_kegiatan extends CI_Controller
{

	function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Program Kegiatan - Inspektorat Kabupaten Merauke';
			$data['dokumen_menu'] = 'active';
			$data['program_kegiatan_submenu'] = 'active';

			$query = $this->db->get('program_kegiatan_category');
			$data['programkegiatancategory'] = $query->result();


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
			$this->load->view("backend/modules-program-kegiatan", $data);

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
						/*case "CategoryCreate":	
																									if(!$this->input->post('FlagPublish')){$FlagPublish='0';}else{$FlagPublish='1';}
																									$data = array(
																										'NameCategory' => $this->input->post('NameCategory'),
																										'Description' => $this->input->post('Description'),
																										'FlagPublish' => $FlagPublish,
																										'Time' => date('Y-m-d H:i:s')
																									);
																									
																									$query = $this->db->where('NameCategory', $this->input->post('NameCategory'));
																									$query = $this->db->get('program_kegiatan_category');
																									if($query->num_rows()>0){
																										$respon = array(
																												'status'=>'gagal',
																												'message'=>'Kategori ini sudah ada'
																											);
																									}else{
																										$query = $this->db->insert('program_kegiatan_category',$data);
																										if($query){
																											$respon = array(
																												'status'=>'sukses',
																												'message'=>'Kategori baru ditambahkan'
																											);
																										}
																									}						
																									
																									//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

																									echo json_encode($respon);
																								
																								break;		*/
						case "CategoryEdit":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('program_kegiatan_category');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get program_kegiatan data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "CategoryDelete":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('program_kegiatan');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ada file di kategori ini'
								);
							} else {
								$query = $this->db->where('IdCategory', $IdCategory);
								$query = $this->db->delete('program_kegiatan_category');
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
							$query = $this->db->update('program_kegiatan_category', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update kategori'
								);

							}
							echo json_encode($respon);
							break;

						case "FileEdit":
							$IdProgram = $this->input->post('IdProgram');
							$query = $this->db->where('IdProgram', $IdProgram);
							$query = $this->db->get('program_kegiatan');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get program_kegiatan data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "FileDelete":
							$IdProgram = $this->input->post('IdProgram');
							$query = $this->db->where('IdProgram', $IdProgram);
							$query = $this->db->get('program_kegiatan');
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
									$query = $this->db->where('IdProgram', $IdProgram);
									$query = $this->db->delete('program_kegiatan');
									$respon = array(
										'status' => 'sukses',
										'message' => 'Hapus file'
									);
								}
							}
							echo json_encode($respon);
							break;
						case "FileUpdate":
							$IdProgram = $this->input->post('IdProgram');
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

							$query = $this->db->where('IdProgram', $IdProgram);
							$query = $this->db->update('program_kegiatan', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update program kegiatan'
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

	function ProgramKegiatanCategoryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			$requestData = $this->input->post();
			$table = 'program_kegiatan_category';
			$columns = array(
				'0' => 'NameCategory',
				'1' => 'Description',
				'2' => 'Time',
				'3' => 'FlagPublish',
				'4' => 'Filename'

			);

			$query = $this->db->query("
						SELECT IdCategory, NameCategory, Description, Time, FlagPublish, Filename, Basename
						FROM $table
						");
			$recordsTotal = $query->num_rows();
			$recordsFiltered = $recordsTotal;

			if (!empty($requestData['search']['value'])) {
				//receive search value;
				$sql = " SELECT IdCategory, NameCategory, Description, Time, FlagPublish, Filename";
				$sql .= " FROM $table ";
				$sql .= " WHERE NameCategory LIKE'%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR Description LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR Time LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";
				$sql .= " OR Filename LIKE '%" . $requestData['search']['value'] . "%' ";

				$query = $this->db->query($sql);
				$recordsFiltered = $query->num_rows();
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
				$query = $this->db->query($sql);
			} else {
				$sql = " SELECT IdCategory, NameCategory, Description, Time, FlagPublish, Filename, Basename";
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
						'NameCategory' => '<a href="' . base_url() . 'backend/modules_program_kegiatan/detail/' . $row->IdCategory . '">' . $row->NameCategory . '</a>' . '<br/><small>(' . $this->backend_modules_program_kegiatan->GetTotalProgramKegiatanInCategory($row->IdCategory) . ' file)</small>',
						'Description' => word_limiter($row->Description, 4),
						'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
						'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
						'Filename' => '<img src="' . base_url() . 'program_kegiatan/' . $row->Basename . '" class="img-thumbnail" width="150" height="150"/>',
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
				$data['modulesprogramkegiatan'] = 'active';
				$data['idprogramkegiatancategorylist'] = $IdCategory;

				/*category exist*/
				//	$query = $this->db->where('FlagPublish', 1);
				$query = $this->db->where('IdCategory', $IdCategory);
				$query = $this->db->get('program_kegiatan_category');
				if ($query->num_rows() > 0) {
					$row = $query->row(); //category//
					$data['idcategory'] = $row->IdCategory;
					$data['namecategory'] = $row->NameCategory;
					/*program_kegiatan*/
					$query = $this->db->where('IdCategory', $IdCategory);
					$query = $this->db->get('program_kegiatan');
					$data['totalprogramkegiatan'] = $query->num_rows();

					/*category*/
					$query = $this->db->order_by('NameCategory', 'ASC');
					$query = $this->db->get('program_kegiatan_category');
					$data['programkegiatancategory'] = $query->result();
				} else {
					$this->load->view('404');
				}
				$this->load->view('backend/modules-program-kegiatan-detail', $data);
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function ProgramKegiatanList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				//var_dump($requestData);
				$IdCategory = $this->input->post('IdCategory');

				$table = 'program_kegiatan';
				$columns = array(
					'0' => 'Filename',
					'1' => 'Tentang',
					'2' => 'IdCategory',
					'3' => 'Filesize',
					'4' => 'Time',
					'5' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdProgram, Tentang, Filename, Basename, Filesize, Time, Fullpath, Extension, IdCategory, FlagPublish
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdProgram, Tentang, Filename, Basename, Filesize, Time, Fullpath, Extension, IdCategory, FlagPublish";
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
					$sql = " SELECT IdProgram, Tentang, Filename, Basename, Filesize, Time, Fullpath, Extension, IdCategory, FlagPublish";
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
							'Filename' => '<img src="' . base_url() . 'program_kegiatan/' . $row->Basename . '" class="img-thumbnail" width="150" height="150"/>',
							'Tentang' => word_limiter($row->Tentang, 2),
							'Category' => $this->backend_modules_program_kegiatan->GetProgramKegiatanCategory($row->IdCategory),
							'Filesize' => byte_format($row->Filesize),
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'Option' => '
											<button onclick="FileDelete(' . $row->IdProgram . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
												<i class="icon wb-trash"></i>
											</button>'
							// <button onclick="FileEdit('.$row->IdProgram.')" class="btn btn-sm btn-icon btn-primary btn-round" '.$RoleFileUpdate.'>
							// 	<i class="icon wb-pencil"></i>
							// </button>	
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

			$Path = 'program_kegiatan';
			$IdUser = $this->user_model->GetIdUser();
			$Tentang = $this->input->post('Tentang');
			$FlagPublish = $this->input->post('FlagPublish');
			$IdCategory = $this->input->post('IdCategory');

			$Filename = url_title($this->input->post('Filename'));

			if (!$this->input->post('FlagPublish')) {
				$FlagPublish = '0';
			} else {
				$FlagPublish = '1';
			}

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'jpg|jpeg|png';
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
																				$query = $this->db->get('program_kegiatan');
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
						//'Nomor' => $Nomor,
						'Tentang' => $Tentang,
						//'Tahun' => $Tahun,
						//'TglInput' => date('Y-m-d H:i:s'),
						//'TglUpdate' => date('Y-m-d H:i:s'),
						'FlagPublish' => $FlagPublish,
						'IdCategory' => $IdCategory
						//'FileAlias' => $FileAliasRandom
					);
					$query = $this->db->insert('program_kegiatan', $data);
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

	function UploadCategory()
	{
		if ($this->user_model->CheckSession() == 1) {

			$Path = 'program_kegiatan';
			$NameCategory = $this->input->post('NameCategory');
			$Description = $this->input->post('Description');
			$FlagPublish = $this->input->post('FlagPublish');

			$FileName = url_title($NameCategory - Category - Files);

			if (!$this->input->post('FlagPublish')) {
				$FlagPublish = '0';
			} else {
				$FlagPublish = '1';
			}

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'jpg|jpeg|png';
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
																				$query = $this->db->get('program_kegiatan');
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
						'NameCategory' => $NameCategory,
						'Description' => $Description
					);

					$query = $this->db->where('NameCategory', $this->input->post('NameCategory'));
					$query = $this->db->get('program_kegiatan_category');
					if ($query->num_rows() > 0) {
						$respon = array(
							'status' => 'gagal',
							'message' => 'Kategori ini sudah ada'
						);
					} else {
						$query = $this->db->insert('program_kegiatan_category', $data);
						if ($query) {
							$respon = array(
								'status' => 'sukses',
								'message' => 'Kategori baru ditambahkan'
							);
						}
					}

					//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

					echo json_encode($respon);
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

/* End of file Modules_program_kegiatan.php */
/* Location: ./application/controllers/backend/Modules_program_kegiatan.php */