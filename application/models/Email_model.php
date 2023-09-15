<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

	function SendEmail($Destination, $Subject, $Body){					
			$query = $this->db->get("emailsettings");
			foreach($query->result() as $row){
				$config = array(				
						'smtp_host' => $row->smtp_host,
						'smtp_port' => $row->smtp_port,
						'smtp_user' => $row->smtp_user,
						'smtp_pass' => $row->smtp_pass,
						'mailtype' => $row->mailtype,
						'wordwrap' => $row->wordwrap,									
						'charset'   => $row->charset,
						'smtp_timeout' => 300,
						'useragent' => 'CodeIgniter',
						'protocol' => $row->protocol					
				);
			}							
			
			$this->load->library('email', $config);
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");		 

			$this->email->from($row->smtp_user, $row->smtp_user);
			$this->email->to($Destination);		 
			$this->email->subject($Subject);		 
			$this->email->message($Body);		 
			$result = $this->email->send();

			if(!$result){
				/*
				$respon = array(
					'status' => 'gagal',
					'message' => 'Kirim email gagal',
					'debug' => show_error($this->email->print_debugger())
				);
				*/			
				return 'gagal';
			}else{
				/*
				$respon = array(
					'status'=> 'sukses',
					'message' => 'Kirim email berhasil, periksa email anda'
				);
				*/
				return null;
				
			}
			//echo json_encode($respon);
		}
	

}

/* End of file Email_model.php */
/* Location: ./application/models/Email_model.php */