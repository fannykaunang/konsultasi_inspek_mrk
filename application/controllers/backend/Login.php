<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function index(){
		$this->user_model->Login();
	}

	/*
	function index__(){

		$Email = $this->input->post('Email');
		$Password = $this->input->post('Password');
		if(!empty($Email) && !empty($Password)){
			$query = $this->db->where('EmailUser', $Email);
			$query = $this->db->where('PasswordUser', $Password);				
			$query = $this->db->get('user');
			if($query->num_rows()>0){
				$row = $query->row();
				$PasswordOnDB = $row->Password;
				if(password_veriy($Password, $PasswordOnDB)){
					$session = array(
						'uname' => $this->encryption->encrypt($row->NameUser),
						'ulevel' => $this->encryption->encrypt($row->LevelUser),			
						'uid' => $this->encryption->encrypt($row->IdUser),
						'ilogin' => true
					);
					$this->session->set_userdata($session);	
					//$this->secure_model->InsertUserLog('UserLog', $this->encrypt->decode($session['uname']).' login','sukses');
					$data = array(
						'LastLogin' => date('Y-m-d H:i:s')
					);
					$this->db->where('IdUser', $row->IdUser);
					$this->db->update('user', $data);
					//insert user log
					$this->secure->Redirect('backend/dashboard');
				}
				
				
				
			}else{
					$data['errorlogin'] = '<div class="alert alert-danger">LOGIN GAGAL. PERIKSA EMAIL ATAU PASSWORD</div>';
					$this->load->view('backend/login',$data);
					$this->secure_model->InsertUserLog('UserLog',$Email.' login','gagal');
			}	
		}else{
			$data['errorlogin'] = '<div class="alert alert-danger">MASUKKAN EMAIL DAN PASSWORD ANDA</div>';
			$this->load->view('backend/login', $data);
		}
			
	}
	*/


}

/* End of file Login.php */
/* Location: ./application/controllers/backend/Login.php */
