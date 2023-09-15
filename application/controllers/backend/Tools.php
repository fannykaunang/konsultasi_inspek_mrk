<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller{

	function backup_database(){
		if($this->user_model->CheckSession()==1){
			$data['toolsmenu'] = 'active';
			$data['toolsbackupdatabasesubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();			
		
			$RoleToolsBackupDatabase = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'ToolsBackupDatabase');
				if($RoleToolsBackupDatabase=='no'){$RoleToolsBackupDatabase='disabled';}
				$data['RoleToolsBackupDatabase'] = $RoleToolsBackupDatabase;
			
			
			/*role*/
			$this->load->view("backend/tools-backup-database", $data);
			
		}else{
			redirect(base_url().'backend/login');
		}		
		
	}

	function CategoryList(){		
		if($this->user_model->CheckSession()==1){
			if($this->input->is_ajax_request()==true){		
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
						case "BackupDatabase":							
							$respon = array(
								'status' => 'requestbackup',
								'message' => 'Request backup database'
							);
							
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
	
	function request_backup_database(){
		if($this->user_model->CheckSession()==1){
			$this->load->dbutil();		
			/*$prefs = array(
				'tables'      => array(),  // Array of tables to backup.
				'ignore'      => array(),           // List of tables to omit from the backup
				'format'      => 'gzip',             // gzip, zip, txt
				'filename'    => 'mybackup.sql',    // File name - NEEDED ONLY WITH ZIP FILES
				'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
				'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
				'newline'     => "\n"               // Newline character used in backup file
			);
			*/
			$backup = &$this->dbutil->backup(); 
			$t = date('Y-m-d H:i:s');
			$f = $t.'-backup-db.gz';		
			force_download($f,$backup);			
		}else{
			redirect(base_url().'backend/login');
		}		
	}
}
?>