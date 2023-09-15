<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modules_gallery extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Daftar Gallery & Videos - Inspektorat Kabupaten Merauke';
			$data['modulesmenu'] = 'active';
			$data['modulesgallery'] = 'active';

			$query = $this->db->get('gallery_category');
			$data['gallerycategory'] = $query->result();


			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			/*
									   $RoleFileCreate =$this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileCreate');
										   if($RoleFileCreate=='no'){$RoleFileCreate='disabled';}
										   $data['RoleFileCreate'] = $RoleFileCreate;
								   
									   /*
									   $RoleFileUpdate =$this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryUpdate');
										   if($RoleFileUpdate=='no'){$RoleFileUpdate='disabled';}
										   $data['RoleFileUpdate'] = $RoleFileUpdate;
									   $RoleFileDelete =$this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileDelete');
										   if($RoleFileDelete=='no'){$RoleFileDelete='disabled';}
										   $data['RoleFileDelete'] = $RoleFileDelete;
									   */
			/*role*/
			$this->load->view("backend/modules-gallery", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}

	}
	function CategoryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {

				$requestData = $this->input->post();
				$table = 'gallery_category';
				$columns = array(
					'0' => 'NameCategory',
					'1' => 'Description',
					'2' => 'MediaType',
					'3' => 'Time',
					'4' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdCategory, NameCategory, Description, MediaType, Time, FlagPublish
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdCategory, NameCategory, Description, MediaType, Time, FlagPublish";
					$sql .= " FROM $table ";
					$sql .= " WHERE NameCategory LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Description LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR MediaType LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Time LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdCategory, NameCategory, Description, MediaType, Time, FlagPublish";
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
							'NameCategory' => '<a href="' . base_url() . 'backend/modules_gallery/detail/' . $row->IdCategory . '">' . $row->NameCategory . '</a>' . '<br/><small>(' . $this->backend_modules_gallery->GetTotalGalleryInCategory($row->IdCategory) . ' file)</small>',
							'Description' => word_limiter($row->Description, 8),
							'MediaType' => $row->MediaType,
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
	function detail($IdCategory = null)
	{
		if ($this->user_model->CheckSession() == 1) {
			if (isset($IdCategory)) {

				$data['page_title'] = 'Detail Gallery & Videos - Inspektorat Kabupaten Merauke';
				$data['modulesmenu'] = 'active';
				$data['modulesgallery'] = 'active';
				$data['idcategorylist'] = $IdCategory;

				/*category exist*/
				$query = $this->db->where('FlagPublish', 1);
				$query = $this->db->where('IdCategory', $IdCategory);
				$query = $this->db->get('gallery_category');
				if ($query->num_rows() > 0) {
					$row = $query->row(); //category//
					$data['idcategory'] = $row->IdCategory;
					$data['namecategory'] = $row->NameCategory;
					/*gallery*/
					$query = $this->db->where('IdCategory', $IdCategory);
					$query = $this->db->get('gallery');
					$data['totalgallery'] = $query->num_rows();

					/*category*/
					$query = $this->db->order_by('NameCategory', 'ASC');
					$query = $this->db->get('gallery_category');
					$data['gallerycategory'] = $query->result();
				} else {
					$this->user_model->Redirect('404');
				}
				$this->load->view('backend/modules-gallery-detail', $data);
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function GalleryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {

				$requestData = $this->input->post();
				//var_dump($requestData);			
				$IdCategory = $this->input->post('IdCategory');

				$table = 'gallery';
				$columns = array(
					'0' => 'Filename',
					'1' => 'Fullpath',
					'2' => 'Extension',
					'3' => 'Filesize',
					'4' => 'Time',
					'5' => 'IdCategory',
					'6' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdFile, Filename, Fullpath, Extension, Filesize, Time, IdCategory, FlagPublish
						FROM $table
						WHERE IdCategory='$IdCategory' 
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdFile, Filename, Fullpath, Extension, Filesize, Time, IdCategory, FlagPublish";
					$sql .= " FROM $table ";
					$sql .= " WHERE IdCategory ='$IdCategory' ";
					$sql .= " OR Filename LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Fullpath LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Extension LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";


					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdFile, Filename, Fullpath, Extension, Filesize, Time, IdCategory, FlagPublish";
					$sql .= " FROM $table ";
					$sql .= " WHERE IdCategory='$IdCategory' ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					/*role*/
					// $RoleFileUpdate =$this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileUpdate');
					// 	if($RoleFileUpdate=='no'){$RoleFileUpdate='disabled';}
					// $RoleFileDelete =$this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileDelete');
					// 	if($RoleFileDelete=='no'){$RoleFileDelete='disabled';}
					/*role*/

					foreach ($query->result() as $row) {

						$data[] = array(

							'Filename' => '<img src="' . $row->Fullpath . '" class="img-thumbnail" width="150" height="150"/>',
							'Category' => $this->backend_modules_gallery->GetGalleryCategory($row->IdCategory),
							'Fullpath' => '<a href="' . $row->Fullpath . '" target="_blank">' . word_limiter($row->Fullpath, 20) . '</a>',
							'Extension' => $row->Extension,
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
								'MediaType' => $this->input->post('MediaType'),
								'Time' => date('Y-m-d H:i:s')
							);

							$query = $this->db->where('NameCategory', $this->input->post('NameCategory'));
							$query = $this->db->get('gallery_category');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Kategori ini sudah ada'
								);
							} else {
								$query = $this->db->insert('gallery_category', $data);
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
							$query = $this->db->get('gallery_category');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get gallery data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "CategoryDelete":
							$IdCategory = $this->input->post('IdCategory');
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('gallery');
							if ($query->num_rows() > 0) {
								$respon = array(
									'status' => 'gagal',
									'message' => 'Ada file di kategori/album ini'
								);
							} else {
								$query = $this->db->where('IdCategory', $IdCategory);
								$query = $this->db->delete('gallery_category');
								$respon = array(
									'status' => 'sukses',
									'message' => 'Hapus kategori/album'
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
							$query = $this->db->update('gallery_category', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update kategori/album'
								);

							}
							echo json_encode($respon);
							break;

						case "FileEdit":
							$IdFile = $this->input->post('IdFile');
							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->get('gallery');
							$data = $query->result();
							$respon = array(
								'status' => 'sukses',
								'message' => 'Get gallery data',
								'data' => $data
							);

							echo json_encode($respon);
							break;
						case "FileDelete":
							$IdFile = $this->input->post('IdFile');
							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->get('gallery');
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
									$query = $this->db->delete('gallery');
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
								'IdCategory' => $IdCategory,
								'Fullpath' => $Fullpath
							);

							$query = $this->db->where('IdFile', $IdFile);
							$query = $this->db->update('gallery', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update gallery'
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

			$Path = 'gallery';
			$IdUser = $this->user_model->GetIdUser();
			$Caption = $this->input->post('Caption');
			$Description = $this->input->post('Description');
			$FlagPublish = $this->input->post('FlagPublish');
			$IdCategory = $this->input->post('IdCategory');

			if (!$this->input->post('FlagPublish')) {
				$FlagPublish = '0';
			} else {
				$FlagPublish = '1';
			}

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
			$config['max_size'] = '50000';
			$config['max_width'] = '50000';
			$config['max_height'] = '50000';
			$config['file_name'] = url_title($Caption);

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


					/*resize*/
					$config['image_library'] = 'gd2';
					$config['source_image'] = $file_path . $file_name;
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
						'FlagPublish' => $FlagPublish,
						'IdCategory' => $IdCategory
					);
					$query = $this->db->insert('gallery', $data);
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

/* End of file Modules_gallery.php */
/* Location: ./application/controllers/backend/Modules_gallery.php */