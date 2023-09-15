<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

	public function index(){
		if($this->user_model->CheckSession()==1){
			$data['newsmenu'] = 'active';
			$data['captchasubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();		
			$RoleCaptchaCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CaptchaCreate');
				if($RoleCaptchaCreate=='no'){$RoleCaptchaCreate='disabled';}
				$data['RoleCaptchaCreate'] = $RoleCaptchaCreate;
			/*role*/
			$this->load->view("backend/captcha", $data);
			
		}else{
			redirect(base_url().'backend/login');
		}		
		
	}

	function CaptchaList(){		
		if($this->user_model->CheckSession()==1){
			if($this->input->is_ajax_request()==true){		
				$requestData = $this->input->post();			
				$table = 'captcha';
				$columns = array(	
					'0' => 'Question', 
					'1' => 'Answer'
				);

				$query = $this->db->query("
						SELECT IdCaptcha, Question, Answer
						FROM $table
						");	
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if(!empty($requestData['search']['value'])){
					//receive search value;
					$sql = " SELECT IdCaptcha, Question, Answer ";
					$sql.= " FROM $table ";					
					$sql.= " WHERE Question LIKE'%".$requestData['search']['value']."%' ";
					$sql.= " OR Answer LIKE '%".$requestData['search']['value']."%' ";
					
					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query = $this->db->query($sql);
				}else{
					$sql =" SELECT IdCaptcha, Question, Answer ";					
					$sql.=" FROM $table ";
					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query = $this->db->query($sql);	
				}

				if($query->num_rows()>0){
					/*role*/
					$RoleCaptchaUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CaptchaUpdate');
						if($RoleCaptchaUpdate=='no'){$RoleCaptchaUpdate='disabled';}
					$RoleCaptchaDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CaptchaDelete');
						if($RoleCaptchaDelete=='no'){$RoleCaptchaDelete='disabled';}
					/*role*/
					
					foreach($query->result() as $row){						
						
						$data[] = array(							
							'Question' => $row->Question,
							'Answer' => $row->Answer,
							'Option' => '<button onclick="CaptchaEdit('.$row->IdCaptcha.')" class="btn btn-sm btn-icon btn-primary btn-round" '.$RoleCaptchaUpdate.'>
												<i class="icon wb-pencil"></i>
												</button> &nbsp;
												<button onclick="CaptchaDelete('.$row->IdCaptcha.')" class="btn btn-sm btn-icon btn-danger btn-round" '.$RoleCaptchaDelete.'>
												<i class="icon wb-trash"></i>
											</button>'		
						);
						$respon = array(
							'draw' 				=> intval($requestData['draw']),
							'recordsTotal'		=> intval($recordsTotal),
							'recordsFiltered' 	=> intval($recordsFiltered),
							'data' 				=> $data
						);

					}
				}else{
					$respon = array(
							'draw' 				=> intval($requestData['draw']),
							'recordsTotal'		=> intval($recordsTotal),
							'recordsFiltered' 	=> intval($recordsFiltered),
							'data' 				=> array()
						);
				}
				echo json_encode($respon);
			
			}else{
				$this->load->view('404');	
			}
		}else{			
			redirect(base_url().'backend/login');
		}		
	}

	function ajax(){
		if($this->user_model->CheckSession()==1){
			if($this->input->is_ajax_request()==true){
				if($do = $this->input->post('do')){

					switch($do){						
						case "CaptchaCreate":
							$data = array(
								'Question' => $this->input->post('Question'),
								'Answer' => $this->input->post('Answer')
							);
							$query = $this->db->insert('captcha', $data);
							if($query){					
								$respon = array(
									'status'=>'sukses',
									'message'=>'Simpan captcha'
								);
							}		
							echo json_encode($respon);
						break;
						case "CaptchaDelete":												
								$IdCaptcha = $this->input->post('IdCaptcha');							
								$query = $this->db->where('IdCaptcha',$IdCaptcha);
								$query = $this->db->delete('captcha');
								if($query){					
									$respon = array(
										'status'=>'sukses',
										'message'=>'Hapus captcha'
									);
								}																					
							echo json_encode($respon);
						break;	
					case "CaptchaEdit":
							$IdCaptcha = $this->input->post('IdCaptcha');							
							$query = $this->db->where('IdCaptcha', $IdCaptcha);
							$query = $this->db->get('captcha');
							$data = $query->result();
							$respon = array(
									'status'=>'sukses',
									'message'=>'Get captcha data',
									'data' => $data
							);
							
							echo json_encode($respon);
						break;						
						case "CaptchaUpdate":
							$IdCaptcha = $this->input->post('IdCaptcha');							
							$Question = $this->input->post('Question');
							$Answer = $this->input->post('Answer');
							
							$data = array(
								'Question' => $Question,
								'Answer' => $Answer
							);	
							
							$query = $this->db->where('IdCaptcha', $IdCaptcha);
							$query = $this->db->update('captcha', $data);
							if($query){
								$respon = array(
										'status'=>'sukses',
										'message'=>'Update captcha'
								);													
							}
							echo json_encode($respon);
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

	

}

/* End of file Captcha.php */
/* Location: ./application/controllers/backend/Captcha.php */