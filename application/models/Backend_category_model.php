<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_category_model extends CI_Model {

	public function index(){
		if($this->user_model->CheckSession()==1){
			$data['newsmenu'] = 'active';
			$data['categorysubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();			
			
			$RoleCategoryCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryCreate');
				if($RoleCategoryCreate=='no'){$RoleCategoryCreate='disabled';}
				$data['RoleCategoryCreate'] = $RoleCategoryCreate;
			/*
			$RoleCategoryUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryUpdate');
				if($RoleCategoryUpdate=='no'){$RoleCategoryUpdate='disabled';}
				$data['RoleCategoryUpdate'] = $RoleCategoryUpdate;
			$RoleCategoryDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryDelete');
				if($RoleCategoryDelete=='no'){$RoleCategoryDelete='disabled';}
				$data['RoleCategoryDelete'] = $RoleCategoryDelete;
			*/
			/*role*/
			$this->load->view("backend/category", $data);
			
		}else{
			redirect(base_url().'backend/login');
		}		
		
	}
	function CategoryList(){		
		if($this->user_model->AjaxAccess()==true){
			if($this->user_model->CheckSession()==1){		
				$requestData = $this->input->post();			
				$table = 'category';
				$columns = array(	
					'0' => 'NameCategory', 
					'1' => 'NoteCategory',
					'2' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdCategory, NameCategory, NoteCategory, FlagPublish
						FROM $table
						");	
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if(!empty($requestData['search']['value'])){
					//receive search value;
					$sql = " SELECT IdCategory, NameCategory, NoteCategory, FlagPublish ";
					$sql.= " FROM $table ";					
					$sql.= " WHERE NameCategory LIKE'%".$requestData['search']['value']."%' ";
					$sql.= " OR NoteCategory LIKE '%".$requestData['search']['value']."%' ";
					$sql.= " OR FlagPublish LIKE '%".$requestData['search']['value']."%' ";
					
					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query = $this->db->query($sql);
				}else{
					$sql =" SELECT IdCategory, NameCategory, NoteCategory, FlagPublish ";					
					$sql.=" FROM $table ";
					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query = $this->db->query($sql);	
				}

				if($query->num_rows()>0){
					/*role*/
					$RoleCategoryUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryUpdate');
						if($RoleCategoryUpdate=='no'){$RoleCategoryUpdate='disabled';}
					$RoleCategoryDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CategoryDelete');
						if($RoleCategoryDelete=='no'){$RoleCategoryDelete='disabled';}
					/*role*/
					
					foreach($query->result() as $row){						
						$data[] = array(						
							
							'NameCategory' => $row->NameCategory,						
							'NoteCategory' => $row->NoteCategory,
							'FlagPublish' => $this->back->FlagPublishIndicator($row->FlagPublish),
							'Option' => '<button onclick="CategoryEdit('.$row->IdCategory.');" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" '.$RoleCategoryDelete.'>
											<i class="icon wb-pencil"></i>
											</button> &nbsp;  
											<button onclick="CategoryDelete('.$row->IdCategory.')" class="btn btn-sm btn-icon btn-danger btn-round" '.$RoleCategoryDelete.'>
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
				redirect(base_url().'backend/login');
			}
		}else{
			$this->load->view('404');
		}		
	}

	
	function ajax(){
		if($this->user_model->AjaxAccess()==true){
			if($this->user_model->CheckSession()==1){
				if($do = $this->input->post('do')){
					switch($do){
						case "CategoryCreate":							
						
							if(!$this->input->post('FlagPublish')){$FlagPublish='0';}else{$FlagPublish='1';}
							$author = $this->encrypt->decode($this->session->userdata('uname'));;

							$data = array(
								'NameCategory' => $this->input->post('NameCategory'),
								'NoteCategory' => $this->input->post('NoteCategory'),
								'FlagPublish' => $FlagPublish
							);	
							$query = $this->db->insert('category',$data);
							if($query){
								
								$respon = array(
									'status'=>'sukses',
									'message'=>'Kategori baru ditambahkan'
								);
							}
							//$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

							echo json_encode($respon);
						break;	
						case "CategoryDelete":												
								$IdCategory = $this->input->post('IdCategory');
								$NameCategory = $this->back->GetNameCategory($IdCategory);
								$query = $this->db->where('CategoryNews', $NameCategory);
								$query = $this->db->get('news');
								if($query->num_rows()>0){
									$respon = array(
										'status'=>'berita ada',
										'message'=>'Hapus kategori gagal, ada berita di kategori ini'
									);
								}else{
									$query = $this->db->where('IdCategory',$IdCategory);
									$query = $this->db->delete('category');
									if($query){					
										$respon = array(
											'status'=>'sukses',
											'message'=>'Hapus kategori'
										);
									}				
								}											
							echo json_encode($respon);
						break;
						case "CategoryEdit":
							$IdCategory = $this->input->post('IdCategory');							
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->get('category');
							$data = $query->result();
							$respon = array(
									'status'=>'sukses',
									'message'=>'Get category data',
									'data' => $data
							);
							
							echo json_encode($respon);
						break;
						case "CategoryUpdate":
							$IdCategory = $this->input->post('IdCategory');							
							$NameCategoryOld = $this->back->GetNameCategory($IdCategory);
							$NameCategory = $this->input->post('NameCategory');
							$NoteCategory = $this->input->post('NoteCategory');
							if(!$this->input->post('FlagPublish')){$FlagPublish='0';}else{$FlagPublish='1';}
							
							$data = array(
								'NameCategory' => $NameCategory,
								'NoteCategory' => $NoteCategory,
								'FlagPublish' => $FlagPublish
							);	
							
							$query = $this->db->where('IdCategory', $IdCategory);
							$query = $this->db->update('category', $data);
							if($query){
								$respon = array(
										'status'=>'sukses',
										'message'=>'Update kategori'
								);					
								/*update all news*/
								$query = $this->db->where('CategoryNews', $NameCategoryOld);
								$query = $this->db->update('news', array('CategoryNews' => $NameCategory));
																
							}
							echo json_encode($respon);
						break;
					}
				}
			}else{
				$this->backend->Redirect('backend/login');
			}
		}else{
			$this->load->view('404');
		}
	}
	

}

/* End of file Backend_category_model.php */
/* Location: ./application/models/Backend_category_model.php */