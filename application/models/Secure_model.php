<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secure_model extends CI_Model {
	
		function EncryptDecrypt($action, $string) {
		   $output = false;
		   $key = $this->config->item('key');
		   // initialization vector 
		   $iv = md5(md5($key));
		   if( $action == 'encrypt' ) {
			   $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
			   $output = base64_encode($output);
		   }
		   else if( $action == 'decrypt' ){
			   $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
			   $output = rtrim($output, "");
		   }
		   return trim($output);
		}
		

		function AjaxAccess(){
			if (!$this->input->is_ajax_request()){
				return false;
			}
			return true;
		}
		function CekNumeric($param){
			if(is_numeric($param)){
				return true;
			}else{
				$this->load->view('404');
			}
			
		}
		function RoleSet(){
			//cek role			
			$data['ulevel'] = $this->encrypt->decode($this->session->userdata('ulevel'));
			$data['uid'] = $this->encrypt->decode($this->session->userdata('uid'));
			$data['uname'] = $this->encrypt->decode($this->session->userdata('uname'));
			
			if($data['ulevel'] == 'superadmin' || $data['ulevel'] == 'moderator'){				
				$data['message'] = '';
			}
			if($data['ulevel'] == 'kontributor'){				
				$data['message'] = 'Anda tidak mempunyai hak publish dan hapus, dapat mengedit berita (bila belum dipublish)';
			}
		}
		
		/*login*/
	
		function UpdateUserLastSeen(){
			$IdUser = $this->encrypt->decode($this->session->userdata('uid'));
			$query = $this->db->where('IdUser',$IdUser);
			$query = $this->db->update('user',array('LastSeen'=>date('Y-m-d H:i:s')));			
		}
		function GetIdUser(){
			return $this->encrypt->decode($this->session->userdata('uid'));
		}
		function GetNameUser(){
			return $this->encrypt->decode($this->session->userdata('uname'));
		}
		function GetLevelUser(){
			return $this->encrypt->decode($this->session->userdata('ulevel'));
		}
		function GetPictureUser(){
			$query = $this->db->select('PictureUser');
			$query = $this->db->where('IdUser', $this->encrypt->decode($this->session->userdata('uid')));
			$query = $this->db->get('user');
			if($query->num_rows()>0){
				$row = $query->row();			
					return $row->PictureUser;				
			}else{
				return null;
			}
		}
		function GetUserLastSeen(){
			//default 300 detik atau 5menit
			$query = $this->db->query("SELECT NameUser FROM user WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(LastSeen) < 300");
			if($query->num_rows()>0){
				return $query->result();		//return $row->LoginUser;
			}else{
				return null;
			}
		}
		function GetUserLastLogin(){
			$IdUser = $this->encrypt->decode($this->session->userdata('uid'));
			$query = $this->db->select('LastLogin');
			$query = $this->db->where('IdUser',$IdUser);
			$query = $this->db->get('user');
			if($query->num_rows()>0){
				$row = $query->row();
				return $row->LastLogin;
			}
		}
		function LupaPassword(){
		
			$Email = $this->input->post('Email');			
			$query = $this->db->where('EmailUser',$Email);		
			$query = $this->db->get('user');
			
			if($query->num_rows()>0){
				//delete record lama
				$this->db->where('Email',$Email);
				$this->db->delete('emailresetpassword');
				
				//insert ke database
				$TglQueryReset = date('Y-m-d H:i:s');
				$TglExpired = date("+3 days");
				$Status = 'asktoreset';				
				$Key = random_string('alnum', 16);
				
				$Browser = $_SERVER['HTTP_USER_AGENT'];
				$IPAddress =  $this->input->ip_address();
				
				$data = array(
					'Email' => $Email,
					'TglQueryReset' => $TglQueryReset,
					'TglExpired' => $TglExpired,
					'Status' => $Status,
					'Key' => $Key,
					'Browser' => $Browser,
					'IPAddress'=>$IPAddress
				);
				$this->db->insert('emailresetpassword',$data);
				//end insert ke database
				
				
				//kirim email
				$subyek = '[Reset password] user merauke.go.id';
				$isiemail = 'Anda atau orang lain melakukan reset password, bila memang anda ingin mereset password, 
							anda dapat mengklik <a href="'.base_url().'aplikasi/reset_password/'.$Key.'">link</a>';
				$this->back->SendEmail('subscribe@meraukego.id',$Email,$subyek,$isiemail);		
				$respon = array(
					'status'=> 'sukses',
					'message' => 'Email request reset password berhasil, periksa email anda'
				);
				
			}else{
				$respon = array(
					'status'=> 'gagal',
					'message' => 'Email tidak ada'
				);
			}
			echo json_encode($respon);

		}
		function ResetPassword($Key){
		
			$this->db->where('Key',$Key);
			$query = $this->db->get('emailresetpassword');
			
			if($query->num_rows()>0){
			
				$row = $query->row();
				$Email = $row->Email;
				$Status = $row->Status;
				
				if($Status == 'asktoreset'){
					
					$data = array(
						'Status' => 'resetted',
						'Key' => 0
					);
					$this->db->where('Email',$Email);
					$this->db->update('emailresetpassword',$data);
					
					//set passwd to user//
					$Key = random_string('alnum', 5);
					
					$data = array(
						'PasswordUser' => md5($Key)
					);
					
					$this->db->where('EmailUser',$Email);
					$this->db->update('user',$data);
					
					//end set passwd to user//
					//send email//
					$subyek = '[Password Baru] user merauke.go.id';
					$isiemail = 'Anda berhasil mereset password, password baru anda adalah '.$Key.' segera ganti password ini.';
					$this->back->SendEmail('subscribe@meraukego.id',$Email,$subyek,$isiemail);		
					//end send email//
					
					return 'Selamat!, anda telah berhasil mereset password, silahkan periksa email anda.';
				}		
								
			}else{
				return 'gagal';			
			}
		}
		function GetNamaLoginById(){
			$IdUser = $this->session->userdata('UserID');
			$query = $this->db->query("SELECT NamaLogin FROM user WHERE IdUser='$IdUser'");
			$row = $query->row();
			return $row->NamaLogin;
		}
		function GantiPasswordUser(){
			$UserID = $this->input->post('IdUser');
			$PasswordLama = md5($this->input->post('PasswordLama'));
			$PasswordBaru = md5($this->input->post('PasswordBaru'));
			
			$query = $this->db->query("SELECT PasswordUser FROM user WHERE IdUser='$UserID'");
			$row = $query->row();
			$PasswordUser = $row->PasswordUser;
			if($PasswordLama == $PasswordUser){
				//pass sama
				$data = array(
					'PasswordUser'=>$PasswordBaru
				);
				$query = $this->db->where('IdUser',$UserID);
				$query = $this->db->update('user',$data);
				if($query){
					$respon = array(
						'status'=>'sukses',
						'message'=>'Ubah password berhasil, silahkan login kembali'
					);
					
							
				}else{
					$respon = array(
						'status'=>'gagal',
						'message'=>'Ubah password gagal'
					);
				}
			}else{
				$respon = array(
					'status'=>'tidaksama',
					'message'=>'Password lama salah'
				);
				
					
			}
			echo json_encode($respon);
		}
		/*end login*/	
		/*logs*/
		
		function InsertSystemLog($TypeLog,$ContentLog,$StatusLog){
			$this->load->library('user_agent');		
			$query = $this->db->get('settings');
			$row = $query->row();
			$MaxLogs = $row->MaxLogs;
			
			$Total = $this->db->count_all_results('logssystem');
			
			if($Total >= $MaxLogs){
				//reset to 0;
				$this->db->truncate('logsystem');
			}else{
				if(empty($Referer)==true ? $Referer = '' : $Referer = $_SERVER['HTTP_REFERER']);
				$data = array(
					//'IdUser' => $this->encrypt->decode($this->session->userdata('uid')),
					'IDUser' => null,
					'IPAddress'=>$_SERVER['REMOTE_ADDR'],
					'TimeStamp'=>date('Y-m-d H:i:s'),
					'Url'=>current_url(),
					'Browser'=>$this->agent->browser(),
					'Platform'=>$this->agent->platform(),			
					'ContentLog'=>$ContentLog,
					'StatusLog'=>$StatusLog,
					'TypeLog'=>$TypeLog
				);
				
				$this->db->insert('logssystem',$data);
			}
		}
		function InsertUserLog($TypeLog,$ContentLog,$StatusLog){			
			$this->load->library('user_agent');		
			$query = $this->db->get('settings');
			$row = $query->row();
			$MaxLogs = $row->MaxLogs;
			
			$Total = $this->db->count_all_results('logsuser');
			
			if($Total >= $MaxLogs){
				//reset to 0;
				$this->db->truncate('logsuser');
			}else{
				if(empty($Referer)==true ? $Referer = '' : $Referer = $_SERVER['HTTP_REFERER']);
				$data = array(
					//'IdUser' => $this->encrypt->decode($this->session->userdata('uid')),
					'IDUser' => null,
					'IPAddress'=>$_SERVER['REMOTE_ADDR'],
					'TimeStamp'=>date('Y-m-d H:i:s'),
					'Url'=>current_url(),
					'Browser'=>$this->agent->browser(),
					'AgentString'=>$this->agent->agent_string(),
					'Platform'=>$this->agent->platform(),			
					'ContentLog'=>$ContentLog,
					'StatusLog'=>$StatusLog,
					'TypeLog'=>$TypeLog
				);
				
				$this->db->insert('logsuser',$data);
			}
		}
		/*logs*/
}
?>