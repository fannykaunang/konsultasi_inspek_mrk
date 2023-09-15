<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends CI_Controller
{

	public function index()
	{
		if ($this->frontend_model->ModePerawatan() == 'offline') {
			$this->load->view('frontend/maintenance');
		} else {
			$this->load->view('backend/login', $data);
		}
	}
}