<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_profile extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'Profile - Inspektorat Kabupaten Merauke';
			$data['settingsmenu'] = 'active';
			$data['settingsbackendmenu'] = 'active';
			$data['settinguserrole'] = 'active';

			$IdUser = $this->user_model->GetIdUser();

			$query = $this->db->where('IdUser', $IdUser);
			$query = $this->db->get('user');
			$data['user'] = $query->result();


			$this->load->view('backend/user-profile', $data);
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
					$LevelUser = $this->user_model->GetLevelUser();

					switch ($do) {
						case "SetTheme":

							$data = array(
								'Theme' => $this->input->post('Theme')
							);
							$query = $this->db->where('IdUser', $IdUser);
							$query = $this->db->update('user', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Ubah tema'
								);

							}
							echo json_encode($respon);
							break;
						case "ChangeLanguage":
							$LevelUser = $this->input->post('LevelUser');
							$attr = $this->input->Post('attr');
							$name = $this->input->post('name');
							$data = array(
								'NewsView' => $attr,
								'NewsCreate' => $attr,
								'NewsUpdate' => $attr,
								'NewsDelete' => $attr,

								'CommentView' => $attr,
								'CommentCreate' => $attr,
								'CommentUpdate' => $attr,
								'CommentDelete' => $attr,

								'CategoryView' => $attr,
								'CategoryCreate' => $attr,
								'CategoryUpdate' => $attr,
								'CategoryDelete' => $attr,

								'CaptchaView' => $attr,
								'CaptchaCreate' => $attr,
								'CaptchaUpdate' => $attr,
								'CaptchaDelete' => $attr,

								'UserView' => $attr,
								'UserCreate' => $attr,
								'UserUpdate' => $attr,
								'UserDelete' => $attr,

								'FileView' => $attr,
								'FileCreate' => $attr,
								'FileUpdate' => $attr,
								'FileDelete' => $attr

							);

							$query = $this->db->where('LevelUser', $LevelUser);
							$query = $this->db->update('userrole', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Set semua hak akses'
								);
							}
							echo json_encode($respon);
							break;
						case "UpdatePassword":

							$CurrentPassword = $this->input->post('CurrentPassword');
							$NewPassword = $this->input->post('NewPassword');
							$NewPasswordRepeat = $this->input->post('NewPasswordRepeat');
							//check current password//
							$query = $this->db->select('PasswordUser');
							$query = $this->db->where('IdUser', $IdUser);
							$query = $this->db->get('user');
							$row = $query->row();
							$OldPassword = $row->PasswordUser;

							if (password_verify($CurrentPassword, $OldPassword)) {
								if ($NewPassword == $NewPasswordRepeat) {

									$query = $this->db->where('IdUser', $IdUser);
									$query = $this->db->update('user', array('PasswordUser' => password_hash($NewPassword, PASSWORD_DEFAULT)));
									if ($query) {
										$respon = array(
											'status' => 'sukses',
											'message' => 'Password diubah, silahkan login kembali'
										);
									}
								} else {
									$respon = array(
										'status' => 'Tidak sesuai',
										'message' => 'Password baru tidak sesuai'
									);
								}

							} else {
								$respon = array(
									'status' => 'Password salah',
									'message' => 'Password saat ini tidak sama'
								);
							}
							echo json_encode($respon);
							break;
						case "UpdateProfile":


							$FullName = $this->input->post('FullName');
							$PhoneUser = $this->input->post('PhoneUser');
							$AddressUser = $this->input->post('AddressUser');
							$AboutMe = $this->input->post('AboutMe');

							$data = array(
								'FullName' => $FullName,
								'PhoneUser' => $PhoneUser,
								'AddressUser' => $AddressUser,
								'AboutMe' => $AboutMe
							);
							$query = $this->db->where('IdUser', $IdUser);
							$query = $this->db->update('user', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Profil anda sudah diupdate'
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


	function UploadPictureUser()
	{
		if ($this->user_model->CheckSession() == 1) {
			$Path = 'user';

			$Filename = $this->user_model->GetNameUser();
			$IdUser = $this->user_model->GetIdUser();

			$Filename = url_title(strtolower($SysUserFullname));

			$config['upload_path'] = $Path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '10000';
			$config['max_width'] = '10000';
			$config['max_height'] = '10000';
			$config['file_name'] = $Filename;

			$this->load->library('upload', $config);
			$this->load->library('image_lib', $config);

			if (!$this->upload->do_upload()) {
				$message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ", "</span>");
				$status = 'gagal';

			} else {
				$result = array('upload_data' => $this->upload->data());
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
					$config['width'] = 200;
					$config['height'] = 200;

					$this->image_lib->clear();
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					/*resize*/

					// $fileinfo = get_file_info($file_path.$file_name);
					// $file_size = $fileinfo['size']; 
					$fileinfo = get_file_info($file_path . $file_name);
					$file_size = $fileinfo['size']; //re-read file actual size after resize;

					$config['image_library'] = 'gd2';
					$config['source_image'] = $file_path . $file_name;
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 500;
					$config['height'] = 500;

					// $data = array(
					// 	'Filename' => $raw_name,
					// 	'Dirname' => $file_path,
					// 	'Basename' => $file_name,
					// 	'Extension' => str_replace(".","",$file_extension),
					// 	'Fullpath' => base_url().$Path.'/'.$file_name,
					// 	'Filesize' => $file_size,
					// 	'Status' => '',
					// 	'Time' => date('Y-m-d H:i:s'),
					// 	'IdUser' => $this->user_model->GetIdUser()
					// );
					// $query = $this->db->insert('filemanager', $data);

					/*update picture user*/
					$data = array(
						'PictureUser' => $Path . '/' . $file_name
					);
					$query = $this->db->where('IdUser', $IdUser);
					$query = $this->db->update('user', $data);
				}
				/*resize*/
				$message = "berhto";
				$status = 'sukses';
			}
			if ($status == 'sukses') {
				echo '<script>						
					parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
					parent.document.getElementById("picture-user").src="' . base_url() . $Path . '/' . $file_name . '";
					parent.document.getElementById("picture-user-navbar").src="' . base_url() . $Path . '/' . $file_name . '";
					</script>';
			} else {
				echo '<script>parent.document.getElementById("ResponUpload").innerHTML="' . $message . '";
						parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
				</script>';
			}
			echo json_encode($status);

		} else {
			redirect(base_url() . 'backend/login');
		}
	}














	// function UploadPictureUser(){
	// 	if($this->user_model->CheckSession()==1){
	// 		$Path = 'files';

	// 		$Filename = $this->user_model->GetNameUser();
	// 		$IdUser = $this->user_model->GetIdUser();

	// 		$config['upload_path'] = $Path;
	// 		$config['allowed_types'] = 'gif|jpg|jpeg|png';
	// 		$config['max_size']	= '4000';
	// 		$config['max_width']  = '4000';
	// 		$config['max_height']  = '4000';
	// 		$config['file_name'] = $Filename;


	// 		$this->load->library('upload', $config);
	// 		$this->load->library('image_lib', $config);



	// 		if(!$this->upload->do_upload()){
	// 			//$err = array('error' => $this->upload->display_errors());
	// 			//$this->load->view('backend/settings-perusahaan', $error);
	// 			$message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ","</span>");
	// 			$status = 'gagal';
	// 		}else{
	// 			$result = array('upload_data' => $this->upload->data());
	// 			foreach($result as $row){
	// 				$full_path = $row['full_path'];
	// 				$file_path = $row['file_path'];
	// 				$file_name = $row['file_name'];	
	// 				$raw_name = $row['raw_name'];
	// 				$file_extension = $row['file_ext'];
	// 				$file_size = $row['file_size'];

	// 				/*resize*/
	// 					$config['image_library'] = 'gd2';
	// 					$config['source_image'] = $file_path.$file_name;
	// 					$config['create_thumb'] = FALSE;
	// 					$config['maintain_ratio'] = TRUE;
	// 					$config['width'] = 200;
	// 					$config['height'] = 200;

	// 					$this->image_lib->clear();
	// 					$this->image_lib->initialize($config);
	// 					$this->image_lib->resize();
	// 				/*resize*/

	// 				$fileinfo = get_file_info($file_path.$file_name);
	// 				$file_size = $fileinfo['size']; //re-read file actual size after resize;

	// 				$data = array(
	// 					'Filename' => $raw_name,
	// 					'Dirname' => $file_path,
	// 					'Basename' => $file_name,
	// 					'Extension' => str_replace(".","",$file_extension),
	// 					'Fullpath' => base_url().$Path.'/'.$file_name,
	// 					'Filesize' => $file_size,
	// 					'Status' => '',
	// 					'Time' => date('Y-m-d H:i:s'),
	// 					'IdUser' => $this->user_model->GetIdUser()
	// 				);
	// 				$query = $this->db->insert('filemanager', $data);

	// 				/*update picture user*/
	// 				$data = array(
	// 					'PictureUser' => $Path.'/'.$file_name
	// 				);
	// 				$query = $this->db->where('IdUser', $IdUser);
	// 				$query = $this->db->update('user', $data);

	// 			}


	// 			/*resize*/
	// 			$message = "";
	// 			$status = 'sukses';
	// 		}

	// 		if($status=='sukses'){
	// 			echo '<script>						
	// 				parent.document.getElementById("StatusUpload").innerHTML="'.$status.'";	
	// 				parent.document.getElementById("picture-user").src="'.base_url().$Path.'/'.$file_name.'";				
	// 				parent.document.getElementById("picture-user-navbar").src="'.base_url().$Path.'/'.$file_name.'";				
	// 				</script>';
	// 		}else{
	// 			echo '<script>parent.document.getElementById("ResponUpload").innerHTML="'.$message.'";
	// 				parent.document.getElementById("StatusUpload").innerHTML="'.$status.'";
	// 			</script>';
	// 		}
	// 		$this->load->view('backend/dashboard', $data);

	// 	}else{
	// 		redirect(base_url().'backend/login');
	// 	}		


	// }

















}

/* End of file User_profile.php */
/* Location: ./application/controllers/backend/User_profile.php */