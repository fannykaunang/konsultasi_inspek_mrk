<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index(){
		$data = [
			$this->user_model->UserFullName() => '',
			$this->user_model->UserID() => '',
			$this->user_model->UserIsLogin() => ''
		];
		$this->session->set_userdata($data);
		//$this->logging_model->WriteLog('system', 'User logout');
		redirect(base_url().'backend/login');
	}

}

/* End of file Logout.php */
/* Location: ./application/controllers/backend/Logout.php */