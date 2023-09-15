<?php
class Dashboard extends CI_Controller
{
	function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Dashboard - Inspektorat Kabupaten Merauke';
			$data['dashboardmenu'] = 'active';

			$data['RoleNewsCreate'] = $RoleNewsCreate;

			$data['authorpage'] = $this->user_model->GetNameUser();

			$query = $this->db->order_by('NameCategory', 'ASC');
			$query = $this->db->get('category');
			$row = $query->row();
			$data['category'] = $query->result();

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

			$query = $this->db->query("SELECT * FROM quote ORDER BY RAND() LIMIT 0,1");
			if ($query->num_rows() > 0) {
				$data['randomquote'] = $query->result();
			} else {
				$data['randomquote'] = null;
			}

			$query = $this->db->query("
					SELECT
						AuthorNews, IdUser,
						COUNT(TitleNews) AS Total
					FROM
						news
					GROUP BY
						AuthorNews
					ORDER BY
						Total DESC
					");
			if ($query->num_rows() > 0) {
				$data['newsauthor'] = $query->result();
				$data['newstotal'] = $this->db->count_all('news');

			} else {
				$data['newsauthor'] = null;
			}
			/*most author news*/
			$this->load->view('backend/dashboard', $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function KonsultasiListAll()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'konsultasi';
				$Author = $this->user_model->GetIdUser();
				$columns = array(
					'0' => 'Time',
					'1' => 'Title',
					'2' => 'Category',
					'3' => 'Author',
					'4' => 'FlagPublish',
					'5' => 'FlagPublishInspektur'
				);

				$query = $this->db->query("SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
				skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
				INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.IdUser = '$Author'");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.IdUser = '$Author' ";
					$sql .= " WHERE Time LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Title LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Category LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Author LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.IdUser = '$Author' ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = array(
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'Title' => '<label id="' . $row->IdKonsultasi . '" onmouseover="ShowMenu(' . $row->IdKonsultasi . ')">' . word_limiter($row->Title, 8) . '</label>',
							'Category' => $row->Category,
							'Author' => $row->Author,
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'FlagPublishInspektur' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublishInspektur),
							'Option' => '	<a href="' . base_url() . 'backend/dashboard/edit/' . $row->IdKonsultasi . '" class="btn btn-icon btn-sm btn-warning btn-round" title="Edit">
												<i class="icon wb-edit"></i>
											</a> &nbsp;
											<a href="' . base_url() . 'backend/dashboard/detail/' . $row->IdKonsultasi . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Detail">
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
			if ($this->input->is_ajax_request() == true) {
				if ($do = $this->input->post('do')) {
					$Author = $this->user_model->GetNameUser();
					$IdUser = $this->user_model->GetIdUser();
					switch ($do) {
						case "NewsChart":
							$this->backend_news_chart_model->NewsChart();
							break;
						case "PelaporChart":
							$this->backend_news_chart_model->PelaporChart();
							break;
						case "PageCreate":
							$IdCategory = $this->input->post('IdCategory');
							$Time = $this->input->post('Time');
							$Time = DateSlashMysql($Time) . ' ' . date('H:i:s');
							$data = array(
								'IdUser' => $IdUser,
								'Author' => $Author,
								'Title' => $this->input->post('Title'),
								'Time' => $Time,
								'IdCategory' => $IdCategory,
								'Category' => $this->backend_konsultasi_model->GetNameCategory($IdCategory),
								'Content' => $this->input->post('ContentPage')
							);
							$query = $this->db->insert('konsultasi', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Pesan Anda Berhasil Terkirim'
								);
							}

							echo json_encode($respon);
							break;
						case "konsultasi":
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
						case "konsultasiUpdate":
							$IdKonsultasi = $this->input->post('IdKonsultasi');
							$Content = $this->input->post('Content');
							$IdCategory = $this->input->post('IdCategory');
							$Time = $this->input->post('Time');
							$Time = DateSlashMysql($Time) . ' ' . date('H:i:s'); /* 2013/12/11 06:01:01 */

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'IdCategory' => $IdCategory,
								'Time' => $Time,
								'Content' => $Content,
								'FlagPublishInspektur' => $FlagPublish
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
						case "KonsulUpdateInspektur":
							$IdKonsultasi = $this->input->post('IdKonsultasi');
							$Catatan = $this->input->post('Keterangan');

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'FlagAcceptInspektur' => $FlagPublish,
								'CatatanInspektur' => $Catatan
							);

							$query = $this->db->where('IdKonsultasi', $IdKonsultasi);
							$query = $this->db->update('konsultasi', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update Konsultasi berhasil'
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
										'message' => 'Hapus pesan'
									);
								}
							}
							echo json_encode($respon);
							break;

						// -----------------------------------------//
					}
				}
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function proses()
	{
		if ($this->user_model->CheckSession() == 1) {
			$Filename = url_title($this->input->post('Filename'));
			$config['upload_path'] = 'files';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 5000;
			$config['max_width'] = 4000;
			$config['max_height'] = 4000;
			$config['encrypt_name'] = true;

			$this->load->library('upload', $config);

			$jumlah_berkas = count($_FILES['userfile']['name']);
			for ($i = 0; $i < $jumlah_berkas; $i++) {
				if (!empty($_FILES['userfile']['name'][$i])) {

					$_FILES['file']['name'] = $_FILES['userfile']['name'][$i];
					$_FILES['file']['type'] = $_FILES['userfile']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['userfile']['error'][$i];
					$_FILES['file']['size'] = $_FILES['userfile']['size'][$i];

					if (!$this->upload->do_upload('file')) {
						$message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ", "</span>");
						$status = 'gagal';
					} else {
						$uploadData = $this->upload->data();
						$filename = $uploadData["file_name"];
						$fileext = pathinfo($filename, PATHINFO_EXTENSION);
						$filepath = $uploadData['full_path'];
						$filesize = $uploadData['file_size'];

						/*resize*/
						$config['image_library'] = 'gd2';
						$config['source_image'] = $filepath;
						$config['create_thumb'] = FALSE;
						$config['thumb_marker'] = '_thumb';
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 640;
						$config['height'] = 480;

						$this->load->library('image_lib', $config);

						$this->image_lib->clear();
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						/*resize*/

						$fileinfo = get_file_info($filepath);
						$file_size_actual = $fileinfo['size']; //re-read file actual size after resize;

						$data = array(
							'Filename' => $filename,
							'Basename' => $filename,
							'Dirname' => str_replace($filename, "", $filepath),
							'Extension' => str_replace(".", "", $fileext),
							'Fullpath' => base_url() . 'files' . '/' . $filename,
							'Filesize' => $file_size_actual,
							'Status' => '',
							'Time' => date('Y-m-d H:i:s'),
							'IdUser' => $this->user_model->GetIdUser()
						);
						$this->db->insert('filemanager', $data);

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
				}
			}
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	// public function upload_multiple()
	// {
	// 	$user_id = 1234; // session or user_id       
	// 	if (isset($_FILES['userfile'])):
	// 		$files = $_FILES;
	// 		$count = count($_FILES['userfile']['name']); // count element 
	// 		for ($i = 0; $i < $count; $i++):
	// 			$_FILES['userfile']['name'] = $files['userfile']['name'][$i];
	// 			$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
	// 			$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
	// 			$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
	// 			$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
	// 			$config['upload_path'] = 'files';
	// 			$target_path = 'files';
	// 			$config['allowed_types'] = 'gif|jpg|png|jpeg';
	// 			$config['max_size'] = '10000'; //limit 1 mb
	// 			$config['remove_spaces'] = true;
	// 			$config['overwrite'] = false;
	// 			$config['max_width'] = '4000'; // image max width 
	// 			$config['max_height'] = '4000';
	// 			$this->load->library('upload', $config);
	// 			$this->upload->initialize($config);
	// 			$this->upload->do_upload('userfile');
	// 			$fileName = $_FILES['userfile']['name'];
	// 			$data = array('upload_data' => $this->upload->data());
	// 			if (!$this->upload->do_upload('userfile')) {
	// 				$error = array('upload_error' => $this->upload->display_errors());
	// 				$this->session->set_flashdata('error', $error['upload_error']);
	// 				echo $files['userfile']['name'][$i] . ' ' . $error['upload_error'];
	// 				exit;

	// 			} // resize code
	// 			// $path = $data['upload_data']['full_path'];
	// 			// $q['name'] = $data['upload_data']['file_name'];
	// 			// $configi['image_library'] = 'gd2';
	// 			// $configi['create_thumb'] = TRUE;
	// 			// $configi['thumb_marker'] = '_thumb';
	// 			// $configi['source_image'] = $path;
	// 			// $configi['new_image'] = $target_path;
	// 			// $configi['maintain_ratio'] = TRUE;
	// 			// $configi['width'] = 640; // new size
	// 			// $configi['height'] = 480;
	// 			// $this->load->library('image_lib');
	// 			// $this->image_lib->initialize($configi);
	// 			// $this->image_lib->resize();
	// 			// $images[] = $fileName;
	// 			// $image_upload = array('user_id' => $user_id, 'image' => $fileName);
	// 			// $this->db->insert('gallery', $image_upload);

	// 		endfor;
	// 	endif;
	// }

	function UploadThumbnail()
	{
		if ($this->user_model->CheckSession() == 1) {
			$Path = 'files';
			$Filename = url_title($this->input->post('Filename'));

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '5000';
			$config['max_width'] = '4000';
			$config['max_height'] = '4000';
			$config['file_name'] = $Filename;

			$this->load->library('upload', $config);
			$this->load->library('image_lib', $config);

			if (!$this->upload->do_upload('file')) {
				$message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ", "</span>");
				$status = 'gagal';
			} else {
				$result = array('upload_data' => $this->upload->data());
				foreach ($result as $row) {
					$files = $_FILES;
					$cpt = count($_FILES['userfile']['name']);
					for ($i = 0; $i < $cpt; $i++) {
						// $_FILES['userfile']['name'] = $files['files']['name'][$i];
						// $_FILES['userfile']['type'] = $files['files']['type'][$i];
						// $_FILES['userfile']['tmp_name'] = $files['files']['tmp_name'][$i];
						// $_FILES['userfile']['error'] = $files['files']['error'][$i];
						// $_FILES['userfile']['size'] = $files['files']['size'][$i];

						$_FILES['file']['name'] = $_FILES['userfile']['name'][$i];
						$_FILES['file']['type'] = $_FILES['userfile']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['userfile']['error'][$i];
						$_FILES['file']['size'] = $_FILES['userfile']['size'][$i];

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
							'Extension' => str_replace(".", "", $file_extension),
							'Fullpath' => base_url() . $Path . '/' . $file_name,
							'Filesize' => $file_size,
							'Status' => '',
							'Time' => date('Y-m-d H:i:s'),
							'IdUser' => $this->user_model->GetIdUser()
						);
						$query = $this->db->insert('filemanager', $data);
					}
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

	// function UploadThumbnail()
	// {
	// 	if ($this->user_model->CheckSession() == 1) {
	// 		$Path = 'files';
	// 		$Filename = url_title($this->input->post('Filename'));

	// 		// $config['upload_path'] = 'files';
	// 		// $config['allowed_types'] = 'gif|jpg|png';
	// 		// $config['max_size'] = 1024 * 8;
	// 		// $config['encrypt_name'] = FALSE;

	// 		$config['upload_path'] = $Path;
	// 		$config['allowed_types'] = 'gif|jpg|jpeg|png';
	// 		$config['max_size'] = '5000';
	// 		$config['max_width'] = '4000';
	// 		$config['max_height'] = '4000';
	// 		$config['file_name'] = $Filename;

	// 		$this->load->library('upload');

	// 		$files = $_FILES;
	// 		$cpt = count($_FILES['userfile']['name']);
	// 		for ($i = 0; $i < $cpt; $i++) {
	// 			$_FILES['userfile']['name'] = $files['files']['name'][$i];
	// 			$_FILES['userfile']['type'] = $files['files']['type'][$i];
	// 			$_FILES['userfile']['tmp_name'] = $files['files']['tmp_name'][$i];
	// 			$_FILES['userfile']['error'] = $files['files']['error'][$i];
	// 			$_FILES['userfile']['size'] = $files['files']['size'][$i];

	// 			$this->upload->initialize($config);
	// 			$this->upload->do_upload('userfile');
	// 			$tmp = $this->upload->data();

	// 			/*resize*/
	// 			$config['image_library'] = 'gd2';
	// 			$config['source_image'] = $file_path . $file_name;
	// 			$config['create_thumb'] = TRUE;
	// 			$config['thumb_marker'] = '_thumb';
	// 			$config['maintain_ratio'] = FALSE;
	// 			$config['width'] = 640;
	// 			$config['height'] = 480;

	// 			$this->image_lib->clear();
	// 			$this->image_lib->initialize($config);
	// 			$this->image_lib->resize();
	// 			/*resize*/

	// 			$this->load->library('image_lib', $config);
	// 			$this->image_lib->initialize($config);
	// 			if (!$this->image_lib->resize()) {
	// 				echo "Failed." . $this->image_lib->display_errors();
	// 			} else {
	// 				$result = array('upload_data' => $this->upload->data());
	// 				foreach ($result as $row) {
	// 					$full_path = $row['full_path'];
	// 					$file_path = $row['file_path'];
	// 					$file_name = $row['file_name'];
	// 					$raw_name = $row['raw_name'];
	// 					$file_extension = $row['file_ext'];
	// 					$file_size = $row['file_size'];

	// 					/*resize*/
	// 					// $config['image_library'] = 'gd2';
	// 					// $config['source_image'] = $file_path . $file_name;
	// 					// $config['create_thumb'] = TRUE;
	// 					// $config['thumb_marker'] = '_thumb';
	// 					// $config['maintain_ratio'] = FALSE;
	// 					// $config['width'] = 640;
	// 					// $config['height'] = 480;

	// 					// $this->image_lib->clear();
	// 					// $this->image_lib->initialize($config);
	// 					// $this->image_lib->resize();
	// 					/*resize*/

	// 					$fileinfo = get_file_info($file_path . $file_name);
	// 					$file_size = $fileinfo['size']; //re-read file actual size after resize;

	// 					$data = array(
	// 						'Filename' => $Filename,
	// 						'Basename' => $raw_name,
	// 						'Dirname' => $file_path,
	// 						'Extension' => str_replace(".", "", $file_extension),
	// 						'Fullpath' => base_url() . $Path . '/' . $file_name,
	// 						'Filesize' => $file_size,
	// 						'Status' => '',
	// 						'Time' => date('Y-m-d H:i:s'),
	// 						'IdUser' => $this->user_model->GetIdUser()
	// 					);
	// 					$query = $this->db->insert('filemanager', $data);
	// 				}
	// 			}



	// 		}


	// 		// $count = count($_FILES['userfile']['name']);

	// 		// for ($i = 0; $i < $count; $i++) {
	// 		// 	if (!empty($_FILES['userfile']['name'][$i])) {
	// 		// 		$_FILES['userfile']['name'] = $_FILES['files']['name'][$i];
	// 		// 		$_FILES['userfile']['type'] = $_FILES['files']['type'][$i];
	// 		// 		$_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
	// 		// 		$_FILES['userfile']['error'] = $_FILES['files']['error'][$i];
	// 		// 		$_FILES['userfile']['size'] = $_FILES['files']['size'][$i];

	// 		// 		$Path = 'files';
	// 		// 		$Filename = url_title($this->input->post('Filename'));

	// 		// 		$config['upload_path'] = $Path;
	// 		// 		$config['allowed_types'] = 'gif|jpg|jpeg|png';
	// 		// 		$config['max_size'] = '5000';
	// 		// 		$config['max_width'] = '4000';
	// 		// 		$config['max_height'] = '4000';
	// 		// 		$config['file_name'] = $Filename;

	// 		// 		$this->load->library('upload', $config);
	// 		// 		$this->load->library('image_lib', $config);

	// 		// 		if (!$this->upload->do_upload('userfile')) {
	// 		// 			$message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ", "</span>");
	// 		// 			$status = 'gagal';
	// 		// 		} else {
	// 		// 			$result = array('upload_data' => $this->upload->data());
	// 		// 			foreach ($result as $row) {
	// 		// 				$full_path = $row['full_path'];
	// 		// 				$file_path = $row['file_path'];
	// 		// 				$file_name = $row['file_name'];
	// 		// 				$raw_name = $row['raw_name'];
	// 		// 				$file_extension = $row['file_ext'];
	// 		// 				$file_size = $row['file_size'];

	// 		// 				/*resize*/
	// 		// 				$config['image_library'] = 'gd2';
	// 		// 				$config['source_image'] = $file_path . $file_name;
	// 		// 				$config['create_thumb'] = TRUE;
	// 		// 				$config['thumb_marker'] = '_thumb';
	// 		// 				$config['maintain_ratio'] = FALSE;
	// 		// 				$config['width'] = 640;
	// 		// 				$config['height'] = 480;

	// 		// 				$this->image_lib->clear();
	// 		// 				$this->image_lib->initialize($config);
	// 		// 				$this->image_lib->resize();
	// 		// 				/*resize*/

	// 		// 				$fileinfo = get_file_info($file_path . $file_name);
	// 		// 				$file_size = $fileinfo['size']; //re-read file actual size after resize;

	// 		// 				$data = array(
	// 		// 					'Filename' => $Filename,
	// 		// 					'Basename' => $raw_name,
	// 		// 					'Dirname' => $file_path,
	// 		// 					'Extension' => str_replace(".", "", $file_extension),
	// 		// 					'Fullpath' => base_url() . $Path . '/' . $file_name,
	// 		// 					'Filesize' => $file_size,
	// 		// 					'Status' => '',
	// 		// 					'Time' => date('Y-m-d H:i:s'),
	// 		// 					'IdUser' => $this->user_model->GetIdUser()
	// 		// 				);
	// 		// 				$query = $this->db->insert('filemanager', $data);
	// 		// 			}

	// 		// 			/*resize*/
	// 		// 			$message = "";
	// 		// 			$status = 'sukses';
	// 		// 		}

	// 		// 		if ($status == 'sukses') {
	// 		// 			//parent.document.getElementById("ImageContainer").innerHTML="<img src='.base_url().$Path.'/'.$file_name.' width=120 height=120 class=img-rounded>";														
	// 		// 			echo '<script>						
	// 		// 				parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";	
	// 		// 				parent.document.getElementById("Thumbnail").setAttribute("value", "' . base_url() . $Path . '/' . $file_name . '");							
	// 		// 				</script>';
	// 		// 		} else {
	// 		// 			echo '<script>parent.document.getElementById("ResponUpload").innerHTML="' . $message . '";
	// 		// 				parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
	// 		// 			</script>';
	// 		// 		}
	// 		// 	}
	// 		// }
	// 	} else {
	// 		redirect(base_url() . 'backend/login');
	// 	}
	// }

	function GalleryList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$Author = $this->user_model->GetIdUser();
				$table = 'filemanager';
				$columns = array(
					'0' => 'Time',
					'1' => 'Fullpath',
					'2' => 'Basename',
					'3' => 'Filesize',
				);

				$query = $this->db->query("
						SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize, IdUser
						FROM $table
						WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif' OR Extension = 'jpeg')
						AND IdUser = '$Author' ");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize ";
					$sql .= " FROM $table ";
					$sql .= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif' OR Extension = 'jpeg') AND IdUser = '$Author'  ";
					$sql .= " AND Filename LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize ";
					$sql .= " FROM $table ";
					$sql .= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif' OR Extension = 'jpeg') AND IdUser = '$Author'  ";
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
							'Option' => '
											<button onclick="InsertIntoEditor(\'' . $row->Fullpath . '\');" class="btn btn-icon btn-sm btn-warning btn-round" title="Masukkan ke isi">
											<i class="icon wb-link"></i>
											</button>'
							// <button onclick="SelectImage(\'' . 'files/' . $row->Basename . '\');" class="btn btn-icon btn-sm btn-primary btn-round" title="Masukkan ke thumbnail">
							// <i class="icon wb-link"></i>
							// </button> &nbsp;
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
			$data['page_title'] = 'Tambah Pelaporan - SIPUT ANGGUN';
			$data['dashboardmenutambah'] = 'active';
			$data['dashboardaddmenu'] = 'active';
			$data['newssubmenu'] = 'active';

			$data['authorpage'] = $this->user_model->GetNameUser();
			$data['iduser'] = $this->user_model->GetIdUser();

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
				if ($this->user_model->GetLevelUser() == 'IRBAN') {
					$data['flagpublish'] = '';
					$data['flagdate'] = '';
					$data['flagcomment'] = '';
				}
				if ($this->user_model->GetLevelUser() == 'SKPD') {
					$data['flagpublish'] = 'disabled';
					$data['flagdate'] = 'disabled';
					$data['flagcomment'] = 'disabled';
				}
			}
			/*flag*/
			$this->load->view("backend/dashboard-add", $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function edit($IdKonsultasi)
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Ubah Konsultasi - Inspektorat Kabupaten Merauke';
			$Author = $this->user_model->GetIdUser();

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
				if ($this->user_model->GetLevelUser() == 'SKPD') {
					if ($Role['RoleNewsUpdate'] == 'yes') {

						$query = $this->db->query("
						SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
						skpd.NamaSkpd FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
						INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.IdKonsultasi='$IdKonsultasi'
														AND konsultasi.IdUser='$Author' AND konsultasi.FlagPublish='0'
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
			$this->load->view('backend/dashboard-edit', $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function KonsultasiListIrban()
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
					'5' => 'FlagPublishInspektur'
				);

				if (!$this->input->post('FlagPublish')) {
					$FlagPublish = '1';
				} else {
					$FlagPublish = '0';
				}

				$query = $this->db->query("SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
				skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
				INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.FlagPublish = '$FlagPublish'");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd ";
					$sql .= " WHERE Time LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Title LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Category LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Author LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR skpd.NamaSkpd LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.FlagPublish = '$FlagPublish'";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = array(
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'Title' => '<label id="' . $row->IdKonsultasi . '" onmouseover="ShowMenu(' . $row->IdKonsultasi . ')">' . word_limiter($row->Title, 8) . '</label>',
							'Category' => $row->Category,
							'Author' => $row->Author,
							'NamaSkpd' => $row->NamaSkpd,
							'FlagPublishInspektur' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublishInspektur),
							'Option' => '	<a href="' . base_url() . 'backend/dashboard/lihat/' . $row->IdKonsultasi . '" class="btn btn-icon btn-sm btn-warning btn-round" title="Lihat">
												<i class="icon wb-eye"></i>
											</a>'
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

	function lihat($IdKonsultasi)
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Edit Konsultasi - Inspektorat Kabupaten Merauke';
			$data['dashboardmenu'] = 'active';

			$Author = $this->user_model->GetNameUser();

			/*role*/
			$Role = $this->role_model->LoadRole();

			if ($this->user_model->GetLevelUser() == 'IRBAN') {
				$query = $this->db->query("SELECT * FROM konsultasi WHERE IdKonsultasi='$IdKonsultasi'");
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
			}

			/*role*/
			$this->load->view('backend/dashboard-lihat', $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

	function KonsultasiListInspektur()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$columns = array(
					'0' => 'Time',
					'1' => 'Title',
					'2' => 'Category',
					'3' => 'Author',
					'4' => 'NamaSkpd'
				);

				$query = $this->db->query("SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
				skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
				INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.FlagPublish = 1");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd ";
					$sql .= " WHERE Time LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Title LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Category LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR Author LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR skpd.NamaSkpd LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdKonsultasi, Time, Title, Category, konsultasi.FlagPublish, konsultasi.Author, 
					skpd.NamaSkpd, FlagPublishInspektur FROM konsultasi INNER JOIN user ON user.IdUser = konsultasi.IdUser 
					INNER JOIN skpd ON skpd.IdSkpd = user.IdSkpd WHERE konsultasi.FlagPublish = 1";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = array(
							'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
							'Title' => '<label id="' . $row->IdKonsultasi . '" onmouseover="ShowMenu(' . $row->IdKonsultasi . ')">' . word_limiter($row->Title, 8) . '</label>',
							'Category' => $row->Category,
							'Author' => $row->Author,
							'NamaSkpd' => $row->NamaSkpd,
							'Option' => '	<a href="' . base_url() . 'backend/dashboard/detail/' . $row->IdKonsultasi . '" class="btn btn-icon btn-sm btn-warning btn-round" title="Lihat">
												<i class="icon wb-eye"></i>
											</a>'
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

	function detail($IdKonsultasi)
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Detail Konsultasi - Inspektorat Kabupaten Merauke';
			$data['dashboardmenu'] = 'active';

			if ($this->user_model->GetLevelUser() == 'Inspektur') {
				$query = $this->db->query("SELECT * FROM konsultasi WHERE IdKonsultasi='$IdKonsultasi'");
				if ($query->num_rows() > 0) {
					$data['editnews'] = $query->result();
					$querycategory = $this->db->order_by('NameCategory', 'ASC');
					$querycategory = $this->db->get('category');
					$data['categorynews'] = $querycategory->result();
				} else {
					$data['editnews'] = null;
				}
				$data['RoleNewsUpdate'] = 'yes';
			} elseif ($this->user_model->GetLevelUser() == 'SKPD') {
				$query = $this->db->query("SELECT * FROM konsultasi WHERE IdKonsultasi='$IdKonsultasi'");
				if ($query->num_rows() > 0) {
					$data['editnews'] = $query->result();
					$querycategory = $this->db->order_by('NameCategory', 'ASC');
					$querycategory = $this->db->get('category');
					$data['categorynews'] = $querycategory->result();
				} else {
					$data['editnews'] = null;
				}
				$data['RoleNewsUpdate'] = 'no';
			}

			$this->load->view('backend/dashboard-detail', $data);
		} else {
			redirect(base_url() . 'backend/login');
		}
	}

}