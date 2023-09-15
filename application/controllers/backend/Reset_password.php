<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends CI_Controller {

	public function index(){
		$this->load->view('backend/reset-password');		
	}

	function RequestKey(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$EmailUser = $this->input->post('EmailUser');
			$query = $this->db->where('EmailUser', $EmailUser);
			$query = $this->db->get('user');
			if($query->num_rows()>0){
				/*$respon = [
					'status' => 'sukses',
					'message' => 'Ambil email'
				];
				*/
				///////////////////////////
				//delete record lama
				$this->db->where('Email', $EmailUser);
				$this->db->delete('emailresetpassword');
				
				//insert ke database
				$TglQueryReset = date('Y-m-d H:i:s');
				$TglExpired = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($TglQueryReset)));

				$Status = 'asktoreset';				
				$Key = rand(999999, 111111);
				
				$Browser = $_SERVER['HTTP_USER_AGENT'];
				$IPAddress =  $this->input->ip_address();
				
				$data = array(
					'Email' => $EmailUser,
					'TglQueryReset' => $TglQueryReset,
					'TglExpired' => $TglExpired,
					'Status' => $Status,
					'Key' => $Key,
					'Browser' => $Browser,
					'IPAddress'=>$IPAddress
				);
				$this->db->insert('emailresetpassword', $data);
				//end insert ke database
							
				$Destination = $EmailUser;
				$Subject = '[RESET-PASSWORD] '.$this->app_info_model->AppDomain();
				$Body = 'Kode Konfirmasi: '.$Key;
				
				///////////////////////////
				
				$Send = $this->email_model->SendEmail($Destination, $Subject, $Body);
				if($Send == null){
					$respon = [
						'status' => 'sukses',
						'message'=> 'Kirim kode konfirmasi berhasil, periksa email inbox anda',
						'email' => $EmailUser
					];	
				}else{
					$respon = [
						'status' => 'gagal',
						'message'=> 'Kirim email gagal'
					];	
				}

			}else{
				$respon = [
					'status' => 'gagal',
					'message'=> 'Email tidak terdaftar, hubungi Administrator'
				];
			}

			echo json_encode($respon);
		}else{
			$this->load->view('404');
		}

	}

	function SendCodeConfirmation(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$Key = $this->input->post('Key');
			$Email = $this->input->post('Email');

			$query = $this->db->where('Key', $Key);
			$query = $this->db->where('Email', $Email);
			$query = $this->db->get('emailresetpassword');

			if($query->num_rows()>0){
				$row = $query->row();
				$TglExpired = $row->TglExpired;
				$TglNow = date('Y-m-d H:i:s');

				if($TglExpired > $TglNow){
					$respon = [
						'status' => 'sukses',
						'message'=> 'Silahkan mengeset password baru',
						'Key' => $Key,
						'Email' => $Email
					];

				}else{
					$respon = [
						'status' => 'kadaluarsa',
						'message'=> 'Kode konfirmasi kadaluarsa, silahkan meminta kode konfirmasi baru'
					];
				}

			}else{
				$respon = [
					'status' => 'gagal',
					'message'=> 'Kode konfirmasi salah, periksa email inbox anda'
				];
			}

			echo json_encode($respon);

		}else{
			$this->load->view('404');
		}		

	}

	function SetNewPassword(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$NewPassword = $this->input->post('NewPassword');
			$Email = $this->input->post('Email');

			$data = [			
				'PasswordUser' => password_hash($NewPassword, PASSWORD_DEFAULT)			
			];

			$query = $this->db->where('EmailUser', $Email);
			$query = $this->db->update('user', $data);
			if($query){
				$respon = [
					'status' => 'sukses',
					'message'=> 'Password berhasil diubah, silahkan login kembali'
				];

				$Signature = $this->app_info_model->AppDomain();
				$Destination = $Email;
				$Subject = '[UPDATE-PASSWORD] '.$this->app_info_model->AppDomain();
				$Body = "
								============================================================================================ <br/>
								Selamat, password anda berhasil diubah. Bila anda tidak melakukan perubahan password segera hubungi Administrator <br/>
								============================================================================================ <br/>
								<br/>
								$Signature 
								";			
				///////////////////////////
				
				$Send = $this->email_model->SendEmail($Destination, $Subject, $Body);

			}else{
				$respon = [
					'status' => 'gagal',
					'message'=> 'Password gagal diubah, silahkan hubungi Administrator'
				];
			}

			echo json_encode($respon);
		}else{
			$this->load->view('404');
		}	
		

	}

}

/* End of file Reset_password.php */
/* Location: ./application/controllers/backend/Reset_password.php */