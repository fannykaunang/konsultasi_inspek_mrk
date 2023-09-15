<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_modules_gallery extends CI_Model {

	function GetGalleryCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('gallery_category');
		$row = $query->row();
		return $row->NameCategory;
	}
	
	function GetTotalGalleryInCategory($IdCategory){
		$query = $this->db->where('IdCategory', $IdCategory);
		$query = $this->db->get('gallery');
		return $query->num_rows();
	}

	function GalleryList(){		
		
		$requestData = $this->input->post();			
		$table = 'filemanager';
		$columns = array(	
			'0' => 'Time',
			'1' => 'Fullpath', 
			'2' => 'Basename',
			'3' => 'Filesize',
		
		);

		$query = $this->db->query("
				SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize
				FROM $table
				WHERE Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif'
				");	
		$recordsTotal = $query->num_rows();
		$recordsFiltered = $recordsTotal;

		if(!empty($requestData['search']['value'])){
			//receive search value;
			$sql = " SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize ";
			$sql.= " FROM $table ";					
			/*
			$sql.= " WHERE Fullpath LIKE'%".$requestData['search']['value']."%' ";
			$sql.= " OR Filename LIKE '%".$requestData['search']['value']."%' ";
			$sql.= " OR Time LIKE '%".$requestData['search']['value']."%' ";
			*/
			$sql.= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif') ";
			$sql.= " AND Filename LIKE '%".$requestData['search']['value']."%' ";
			
			$query = $this->db->query($sql);
			$recordsFiltered = $query->num_rows();
			$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$query = $this->db->query($sql);
		}else{
			$sql =" SELECT IdFile, Filename, Fullpath, Basename, Time, Extension, Filesize ";					
			$sql.=" FROM $table ";
			/*
			$sql.= " WHERE Fullpath LIKE'%".$requestData['search']['value']."%' ";
			$sql.= " OR Filename LIKE '%".$requestData['search']['value']."%' ";
			$sql.= " OR Time LIKE '%".$requestData['search']['value']."%' ";
			*/
			$sql.= " WHERE (Extension = 'png' OR Extension = 'jpg' OR Extension = 'gif') ";
			$sql.= " AND Filename LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			$query = $this->db->query($sql);	
		}

		if($query->num_rows()>0){					
			
			foreach($query->result() as $row){		
				if(strtolower($row->Extension) == 'png' || strtolower($row->Extension) == 'jpg' || strtolower($row->Extension) == 'gif'){							
					$Fullpath = '<img src="'.$row->Fullpath.'" width="100" height="100" class="img-rounded"/></img>';
				}else{
					$Fullpath = '-';							
				}					
			
				$data[] = array(						
					'Time' => substr(DateTimeIndo($row->Time),0,-3),
					'Fullpath' => $Fullpath,
					'Basename' => character_limiter($row->Basename,20),	
					'Filesize' => byte_format($row->Filesize),				
					'Option' => '<button onclick="SelectImage(\''.$row->Fullpath.'\');" class="btn btn-icon btn-sm btn-primary btn-round" title="Masukkan ke thumbnail">
									<i class="icon wb-link"></i>
									</button> &nbsp;
									<button onclick="InsertIntoEditor(\''.$row->Fullpath.'\');" class="btn btn-icon btn-sm btn-warning btn-round" title="Masukkan ke berita">
									<i class="icon wb-link"></i>
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
		
	}
	
	

}

/* End of file Backend_modules_gallery.php */
/* Location: ./application/models/Backend_modules_gallery.php */