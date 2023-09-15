<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blank_controller extends CI_Controller {

	function index(){
		if($this->user_model->CheckSession()==1){
			
			$this->load->view('backend/dashboard', $data);
		}else{
			redirect(base_url().'backend/login');
		}		
	}	


	function ajax(){
		if($this->user_model->CheckSession()==1){
			if($this->input->is_ajax_request()==true){				
				if($do = $this->input->post('do')){
					switch($do){
						case "NewsChart":
							
						break;
						
					}
				}
			}else{
				$this->load->view('404');
			}
		}else{
			redirect(base_url().'backend/login');
		}
	}


	function xxxxx(){
		if($this->user_model->CheckSession()==1){
			if($this->input->is_ajax_request()==true){				
				

			}else{
				$this->load->view('404');
			}
		}else{
			redirect(base_url().'backend/login');
		}
	}

	function yyyyy(){
		if($this->user_model->CheckSession()==1){
		
		}else{
			redirect(base_url().'backend/login');
		}
	}




}

/* End of file blank_controller.php */
/* Location: ./application/controllers/backend/blank_controller.php */