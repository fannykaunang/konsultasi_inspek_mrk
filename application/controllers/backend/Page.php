<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['pagemenu'] = 'active';
			$data['pagesubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			/*role*/

			$data['totalpage'] = $this->db->count_all('pages');

			$query = $this->db->where('FlagPublish', 1);
			$query = $this->db->get('pages');
			if ($query->num_rows() > 0) {
				$data['totalpagepublish'] = $query->num_rows();
			} else {
				$data['totalpagepublish'] = 0;
			}

			$query = $this->db->where('FlagPublish', 0);
			$query = $this->db->get('pages');
			if ($query->num_rows() > 0) {
				$data['totalpagedraft'] = $query->num_rows();
			} else {
				$data['totalpagedraft'] = 0;
			}


			$this->load->view("backend/page", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}
	function PageList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'pages';
				$columns = array(
					'0' => 'CreatedPage',
					'1' => 'TitlePage',
					'2' => 'CategoryPage',
					'3' => 'AuthorPage',
					'4' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdPage, CreatedPage, TitlePage, CategoryPage, UpdatedPage, FlagPublish, AuthorPage
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdPage, CreatedPage, TitlePage, CategoryPage, UpdatedPage, FlagPublish, AuthorPage ";
					$sql .= " FROM $table ";
					$sql .= " WHERE CreatedPage LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR TitlePage LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR CategoryPage LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR AuthorPage LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdPage, CreatedPage, TitlePage, CategoryPage, UpdatedPage, FlagPublish, AuthorPage ";
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
							'CreatedPage' => substr(DateTimeIndo($row->CreatedPage), 0, -3) . '<br/><i><small data-livestamp="' . $row->CreatedPage . '" class="livestamp"></small></i>',
							'TitlePage' => '<label id="' . $row->IdPage . '" onmouseover="ShowMenu(' . $row->IdPage . ')">' . word_limiter($row->TitlePage, 8) . '</label> 
								<br/><small style="display:none;" class="' . $row->IdPage . '" >
								<i><a href="' . base_url() . 'page/' . $row->IdPage . '/' . url_title($row->TitlePage) . '.html" target="_blank">Lihat berita</a></i> &nbsp;									
								</small>',
							'CategoryPage' => $row->CategoryPage,
							'AuthorPage' => $row->AuthorPage,
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'Option' => '<a href="' . base_url() . 'backend/page/edit/' . $row->IdPage . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleNewsUpdate . '>
											<i class="icon wb-pencil"></i>
											</a> &nbsp;  
											<button onclick="PageDelete(' . $row->IdPage . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleNewsDelete . '>
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
			$data['pagemenu'] = 'active';
			$data['pagesubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();
			$RoleNewsCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsCreate');
			if ($RoleNewsCreate == 'no') {
				$RoleNewsCreate = 'disabled';
			}
			$data['RoleNewsCreate'] = $RoleNewsCreate;
			/*role*/
			$data['authorpage'] = $this->user_model->GetNameUser();

			$query = $this->db->order_by('NameCategory', 'ASC');
			$query = $this->db->get('categorypage');
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
			$this->load->view("backend/page-add", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}
	function ajax()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				if ($do = $this->input->post('do')) {

					$AuthorPage = $this->user_model->GetNameUser();
					$IdUser = $this->user_model->GetIdUser();

					switch ($do) {
						case "PageCreate":
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

							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('categorypage');
							$row = $query->row();
							$CategoryPage = $row->NameCategory;

							$CreatedPage = $this->input->post('CreatedPage');
							$CreatedPage = DateSlashMysql($CreatedPage) . ' ' . date('H:i:s'); /* 2013/12/11 06:01:01 */


							$data = array(
								'IdUser' => $IdUser,
								'AuthorPage' => $AuthorPage,
								'TitlePage' => $this->input->post('TitlePage'),
								'CreatedPage' => $CreatedPage,
								'UpdatedPage' => date('Y-m-d H:i:s'),
								'IdCategoryPage' => $IdCategory,
								'CategoryPage' => $CategoryPage,
								'ContentPage' => $this->input->post('ContentPage'),
								'FlagDate' => $FlagDate,
								'FlagPublish' => $FlagPublish,
								'FlagComment' => $FlagComment,
								'Thumbnail' => $this->input->post('Thumbnail'),
								'LastUpdate' => date('Y-m-d H:i:s'),
								'UpdatedBy' => $AuthorPage
							);
							$query = $this->db->insert('pages', $data);
							if ($query) {

								$respon = array(
									'status' => 'sukses',
									'message' => 'Simpan halaman baru'
								);
							}
							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);
							break;
						case "PageUpdate":
							$IdPage = $this->input->post('IdPage');

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

							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('categorypage');
							$row = $query->row();
							$CategoryPage = $row->NameCategory;

							$CreatedPage = $this->input->post('CreatedPage');
							$CreatedPage = DateSlashMysql($CreatedPage) . ' ' . date('H:i:s'); /* 2013/12/11 06:01:01 */




							$data = array(

								'TitlePage' => $this->input->post('TitlePage'),
								'CreatedPage' => $CreatedPage,
								'UpdatedPage' => date('Y-m-d H:i:s'),
								'IdCategoryPage' => $IdCategory,
								'CategoryPage' => $CategoryPage,
								'ContentPage' => $this->input->post('ContentPage'),
								'FlagDate' => $FlagDate,
								'FlagPublish' => $FlagPublish,
								'FlagComment' => $FlagComment,
								'Thumbnail' => $this->input->post('Thumbnail'),
								'LastUpdate' => date('Y-m-d H:i:s'),
								'UpdatedBy' => $AuthorPage
							);
							$query = $this->db->where('IdPage', $IdPage);
							$query = $this->db->update('pages', $data);
							if ($query) {

								$respon = array(
									'status' => 'sukses',
									'message' => 'Update halaman'
								);
							}
							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);
							break;
						case "PageDelete":
							$ulevel = $this->user_model->GetLevelUser();
							if ($ulevel == 'contributor') {
								$respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus halaman ini');
							} else {
								$IdPage = $this->input->post('IdPage');
								$query = $this->db->where('IdPage', $IdPage);
								$query = $this->db->delete('pages');
								if ($query) {
									$respon = array(
										'status' => 'sukses',
										'message' => 'Hapus halaman'
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

	function edit($IdPage)
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['pagemenu'] = 'active';
			$data['pagesubmenu'] = 'active';

			$data['authorpage'] = $this->user_model->GetNameUser();

			/*role*/
			$Role = $this->role_model->LoadRole();

			if ($this->user_model->GetLevelUser() == 'superadmin') {
				$query = $this->db->query("
												SELECT * FROM pages 
												WHERE IdPage='$IdPage'
											");
				if ($query->num_rows() > 0) {
					$data['editpage'] = $query->result();
					$querycategory = $this->db->order_by('NameCategory', 'ASC');
					$querycategory = $this->db->get('categorypage');
					$data['categorypage'] = $querycategory->result();
				} else {
					$data['editpage'] = null;
				}
				$data['RoleNewsUpdate'] = 'yes';
			} else {
				if ($this->user_model->GetLevelUser() == 'moderator') {
					if ($Role['RoleNewsUpdate'] == 'yes') {
						$query = $this->db->query("
														SELECT * FROM news 
														WHERE IdPage='$IdPage'
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
						$AuthorPage = $this->user_model->GetNameUser();

						$query = $this->db->query("
														SELECT * FROM news 
														WHERE IdPage='$IdPage'
														AND AuthorPage='$AuthorPage' AND FlagPublish='0'
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


			$this->load->view('backend/page-edit', $data);
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
						WHERE Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif'
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
					$sql .= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif') ";
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
					$sql .= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif') ";
					$sql .= " AND Filename LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {

					foreach ($query->result() as $row) {
						if (strtolower($row->Extension) == 'png' || strtolower($row->Extension) == 'jpg' || strtolower($row->Extension) == 'gif') {
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