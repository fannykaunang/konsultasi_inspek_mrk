<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Berita - Inspektorat Kabupaten Merauke';
			$data['newsmenu'] = 'active';
			$data['newssubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			/*role*/
			$data['totalnews'] = $this->db->count_all('news');

			$this->load->view("backend/news", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function NewsList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'news';
				$columns = array(
					'0' => 'CreatedNews',
					'1' => 'TitleNews',
					'2' => 'CategoryNews',
					'3' => 'AuthorNews',
					'4' => 'FlagPublish',
					'5' => 'ReadRating'
				);

				$query = $this->db->query("
						SELECT IdNews, CreatedNews, TitleNews, CategoryNews, UpdatedNews, FlagPublish, ReadRating, AuthorNews
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdNews, CreatedNews, TitleNews, CategoryNews, UpdatedNews, FlagPublish, ReadRating, AuthorNews ";
					$sql .= " FROM $table ";
					$sql .= " WHERE CreatedNews LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR TitleNews LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR CategoryNews LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR AuthorNews LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdNews, CreatedNews, TitleNews, CategoryNews, UpdatedNews, FlagPublish, ReadRating, AuthorNews ";
					$sql .= " FROM $table ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {

					/*role*/
					$RoleNewsUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsUpdate');
					if ($RoleNewsUpdate == 'no') {
						$RoleNewsUpdate = 'disabled';
					}
					$RoleNewsDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsDelete');
					if ($RoleNewsDelete == 'no') {
						$RoleNewsDelete = 'disabled';
					}
					/*role*/

					foreach ($query->result() as $row) {
						$data[] = array(
							'CreatedNews' => substr(DateTimeIndo($row->CreatedNews), 0, -3) . '<br/><i><small data-livestamp="' . $row->CreatedNews . '" class="livestamp"></small></i>',
							'TitleNews' => '<label id="' . $row->IdNews . '" onmouseover="ShowMenu(' . $row->IdNews . ')">' . word_limiter($row->TitleNews, 8) . '</label> 
								<br/><small style="display:none;" class="' . $row->IdNews . '" >
								<i><a href="' . site_url('news/' . $row->IdNews . '/' . url_title(strtolower($row->TitleNews))) . '" target="_blank">Lihat berita</a></i> &nbsp;									
								</small>',
							'CategoryNews' => $row->CategoryNews,
							'AuthorNews' => $row->AuthorNews,
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'ReadRating' => $row->ReadRating,
							'Option' => '<a href="' . base_url() . 'backend/news/edit/' . $row->IdNews . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleNewsUpdate . '>
											<i class="icon wb-pencil"></i>
											</a> &nbsp;  
											<button onclick="NewsDelete(' . $row->IdNews . ')" class="btn btn-sm btn-icon btn-danger btn-round" title="Hapus" ' . $RoleNewsDelete . '>
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

	function add()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Tambah Berita - Inspektorat Kabupaten Merauke';
			$data['newsmenu'] = 'active';
			$data['newssubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$RoleNewsCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsCreate');
			if ($RoleNewsCreate == 'no') {
				$RoleNewsCreate = 'disabled';
			}
			$data['RoleNewsCreate'] = $RoleNewsCreate;
			/*role*/
			$data['authornews'] = $this->user_model->GetNameUser();

			$query = $this->db->order_by('NameCategory', 'ASC');
			$query = $this->db->get('category');
			$row = $query->row();
			$data['category'] = $query->result();

			/*gallery*/
			$query = $this->db->query("SELECT * FROM filemanager WHERE Extension LIKE '%jpg%' OR Extension LIKE '%png%'");
			if ($query->num_rows() > 0) {
				$data['gallery'] = $query->result();
			} else {
				$data['gallery'] = null;
			}
			/*flag*/
			if ($this->user_model->GetLevelUser() == 'superadmin') {
				$data['flagpublish'] = '';
				$data['flagdate'] = '';
				$data['flagcomment'] = '';
			} else {
				if ($this->user_model->GetLevelUser() == 'moderator') {
					$data['flagpublish'] = '';
					$data['flagdate'] = '';
					$data['flagcomment'] = '';
				}
				if ($this->user_model->GetLevelUser() == 'contributor') {
					$data['flagpublish'] = 'disabled';
					$data['flagdate'] = 'disabled';
					$data['flagcomment'] = 'disabled';
				}
			}
			/*flag*/
			$this->load->view("backend/news-add", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function ajax()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->user_model->CheckSession() == 1) {
				if ($do = $this->input->post('do')) {

					$AuthorNews = $this->user_model->GetNameUser();
					$IdUser = $this->user_model->GetIdUser();

					switch ($do) {
						case "NewsCreate":
							if (!$this->input->post('FlagDate')) {
								$FlagDate = '0';
							} else {
								$FlagDate = '1';
							}
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}
							if (!$this->input->post('FlagComment')) {
								$FlagComment = '0';
							} else {
								$FlagComment = '1';
							}

							/* 11/12/2013 */

							$IdCategory = $this->input->post('IdCategory');
							$CreatedNews = $this->input->post('CreatedNews');
							$CreatedNews = DateSlashMysql($CreatedNews) . ' ' . date('H:i:s'); /* 2013/12/11 06:01:01 */



							$data = array(
								'IdUser' => $IdUser,
								'AuthorNews' => $AuthorNews,
								'TitleNews' => $this->input->post('TitleNews'),
								'CreatedNews' => $CreatedNews,
								'UpdatedNews' => date('Y-m-d H:i:s'),
								'IdCategory' => $IdCategory,
								'CategoryNews' => $this->backend_konsultasi_model->GetNameCategory($IdCategory),
								'ContentNews' => $this->input->post('ContentNews'),
								'FlagDate' => $FlagDate,
								'FlagPublish' => $FlagPublish,
								'FlagComment' => $FlagComment,
								'Thumbnail' => $this->input->post('Thumbnail'),
								'LastUpdate' => date('Y-m-d H:i:s'),
								'UpdatedBy' => $AuthorNews
							);
							$query = $this->db->insert('news', $data);
							if ($query) {

								$respon = array(
									'status' => 'sukses',
									'message' => 'Simpan berita baru'
								);
							}
							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);
							break;
						case "NewsUpdate":
							$IdNews = $this->input->post('IdNews');

							if (!$this->input->post('FlagDate')) {
								$FlagDate = '0';
							} else {
								$FlagDate = '1';
							}
							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}
							if (!$this->input->post('FlagComment')) {
								$FlagComment = '0';
							} else {
								$FlagComment = '1';
							}

							$IdCategory = $this->input->post('IdCategory');
							$CreatedNews = $this->input->post('CreatedNews');
							$CreatedNews = DateSlashMysql($CreatedNews) . ' ' . date('H:i:s'); /* 2013/12/11 06:01:01 */



							$Thumbnail = $this->input->post('Thumbnail');

							$data = array(

								'TitleNews' => $this->input->post('TitleNews'),
								'CreatedNews' => $CreatedNews,
								'UpdatedNews' => date('Y-m-d H:i:s'),
								'IdCategory' => $IdCategory,
								'CategoryNews' => $this->backend_konsultasi_model->GetNameCategory($IdCategory),
								'ContentNews' => $this->input->post('ContentNews'),
								'FlagDate' => $FlagDate,
								'FlagPublish' => $FlagPublish,
								'FlagComment' => $FlagComment,
								'Thumbnail' => $Thumbnail,
								'LastUpdate' => date('Y-m-d H:i:s'),
								'UpdatedBy' => $AuthorNews
							);

							$query = $this->db->where('IdNews', $IdNews);
							$query = $this->db->update('news', $data);
							if ($query) {

								$respon = array(
									'status' => 'sukses',
									'message' => 'Update berita'
								);
							}
							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);
							break;
						case "NewsDelete":
							$ulevel = $this->user_model->GetLevelUser();

							if ($ulevel == 'contributor') {
								$respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus berita ini');
							} else {
								$IdNews = $this->input->post('IdNews');
								$query = $this->db->where('IdNews', $IdNews);
								$query = $this->db->delete('news');
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Hapus berita'
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


	function UploadThumbnail()
	{
		if ($this->user_model->CheckSession() == 1) {

			$Path = 'files';
			$Filename = url_title($this->input->post('Filename'));

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '5000';
			$config['max_width'] = '4000';
			$config['max_height'] = '4000';
			$config['file_name'] = $Filename;


			$this->load->library('upload', $config);
			$this->load->library('image_lib', $config);



			if (!$this->upload->do_upload()) {
				//$err = array('error' => $this->upload->display_errors());
				//$this->load->view('backend/settings-perusahaan', $error);
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
					$config['create_thumb'] = TRUE;
					$config['thumb_marker'] = '_thumb';
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 640;
					$config['height'] = 480;

					$this->image_lib->clear();
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					/*resize*/

					$fileinfo = get_file_info($file_path . $file_name);
					$file_size = $fileinfo['size']; //re-read file actual size after resize;

					$data = array(
						'Filename' => $Filename,
						'Basename' => $raw_name,
						'Dirname' => $file_path,
						'Basename' => $file_name,
						'Extension' => str_replace(".", "", $file_extension),
						'Fullpath' => base_url() . $Path . '/' . $file_name,
						'Filesize' => $file_size,
						'Status' => '',
						'Time' => date('Y-m-d H:i:s'),
						'IdUser' => $this->user_model->GetIdUser()
					);
					$query = $this->db->insert('filemanager', $data);
				}


				/*resize*/
				$message = "";
				$status = 'sukses';
			}

			if ($status == 'sukses') {
				//parent.document.getElementById("ImageContainer").innerHTML="<img src='.base_url().$Path.'/'.$file_name.' width=120 height=120 class=img-rounded>";														
				echo '<script>						
					parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";	
					parent.document.getElementById("Thumbnail").setAttribute("value", "' . base_url() . $Path . '/' . $file_name . '");							
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

	function edit($IdNews)
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Ubah Berita - Inspektorat Kabupaten Merauke';
			$data['newsmenu'] = 'active';
			$data['newssubmenu'] = 'active';

			$data['authornews'] = $this->backend_konsultasi_model->GetAuthorNews($IdNews);

			/*role*/
			$Role = $this->role_model->LoadRole();

			if ($this->user_model->GetLevelUser() == 'superadmin') {
				$query = $this->db->query("
												SELECT * FROM news 
												WHERE IdNews='$IdNews'
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
				if ($this->user_model->GetLevelUser() == 'moderator') {
					if ($Role['RoleNewsUpdate'] == 'yes') {
						$query = $this->db->query("
														SELECT * FROM news 
														WHERE IdNews='$IdNews'
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
				if ($this->user_model->GetLevelUser() == 'contributor') {
					if ($Role['RoleNewsUpdate'] == 'yes') {
						$AuthorNews = $this->user_model->GetNameUser();

						$query = $this->db->query("
														SELECT * FROM news 
														WHERE IdNews='$IdNews'
														AND AuthorNews='$AuthorNews' AND FlagPublish='0'
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


			$this->load->view('backend/news-edit', $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function GalleryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'filemanager';
				$columns = array(
					'0' => 'Time',
					'1' => 'Fullpath',
					'2' => 'Basename',
					'3' => 'Filesize',
				);

				$query = $this->db->query("
						SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize
						FROM $table
						WHERE Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif' OR Extension = 'jpeg'
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize ";
					$sql .= " FROM $table ";
					/*
																 $sql.= " WHERE Fullpath LIKE'%".$requestData['search']['value']."%' ";
																 $sql.= " OR Filename LIKE '%".$requestData['search']['value']."%' ";
																 $sql.= " OR Time LIKE '%".$requestData['search']['value']."%' ";
																 */
					$sql .= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif' OR Extension = 'jpeg') ";
					$sql .= " AND Filename LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize ";
					$sql .= " FROM $table ";
					/*
																 $sql.= " WHERE Fullpath LIKE'%".$requestData['search']['value']."%' ";
																 $sql.= " OR Filename LIKE '%".$requestData['search']['value']."%' ";
																 $sql.= " OR Time LIKE '%".$requestData['search']['value']."%' ";
																 */
					$sql .= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif' OR Extension = 'jpeg') ";
					$sql .= " AND Filename LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {

					foreach ($query->result() as $row) {
						if (strtolower($row->Extension) == 'png' || strtolower($row->Extension) == 'jpg' || strtolower($row->Extension) == 'gif' || strtolower($row->Extension) == 'jpeg') {
							$Fullpath = '<img src="' . $row->Fullpath . '" width="100" height="100" class="img-rounded"/></img>';
						} else {
							$Fullpath = '-';
						}

						$data[] = array(
							'Time' => substr(DateTimeIndo($row->Time), 0, -3),
							'Fullpath' => $Fullpath,
							'Basename' => character_limiter($row->Basename, 20),
							'Filesize' => byte_format($row->Filesize),
							'Option' => '<button onclick="SelectImage(\'' . 'files/' . $row->Basename . '\');" class="btn btn-icon btn-sm btn-primary btn-round" title="Masukkan ke thumbnail">
											<i class="icon wb-link"></i>
											</button> &nbsp;
											<button onclick="InsertIntoEditor(\'' . $row->Fullpath . '\');" class="btn btn-icon btn-sm btn-warning btn-round" title="Masukkan ke berita">
											<i class="icon wb-link"></i>
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

/* End of file News.php */
/* Location: ./application/controllers/backend/News.php */