<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Help extends CI_Controller
{
	function about()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['page_title'] = 'About - Inspektorat Kabupaten Merauke';
			$data['helpmenu'] = 'active';
			$data['helpaboutsubmenu'] = 'active';

			$this->load->view("backend/help-about", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}

	}
}
?>