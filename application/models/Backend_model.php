<?php
	class Backend_model extends CI_Model{
		function __construct(){
			// Call the Model constructor
			parent::__construct();
		}
		// ---------- APPLICATION IDENTITY --------- //
		function AppName(){
			return 'WebPortal';
		}
		function AppNameTitleDashboard(){
			return 'Manajemen website';
		}
		function AppNameTitleClient(){
			return 'Manajemen website';
		}
		function AppNameCompany(){
			return 'Dinas Kominfo Merauke';
		}
		function AppVersion(){
			return 'v2.12';
		}
		function AppCopyright(){
			return 'Jippro Network';
		}
		function LinkCopyright(){
			return 'http://jippronetwork.com';
		}
		function AppYear(){
			return '2015 - '.date('Y');
		}
		// ---------- END APPLICATION IDENTITY --------- //	
		
		/*news*/
		function GetFullNameAuthor($IdUser){
			$query = $this->db->where('IdUser', $IdUser);
			$query = $this->db->get('user');
			if($query->num_rows()>0){
				$row = $query->row();
				return $row->FullName;
			}else{
				return null;
			}
		}
		function GetFullNameAuthorByNameUser($NameUser){
			$query = $this->db->where('NameUser', $NameUser);
			$query = $this->db->get('user');
			if($query->num_rows()>0){
				$row = $query->row();
				return $row->FullName;
			}else{
				return null;
			}
		}
		function CheckFlagPublish($IdNews){
			$query = $this->db->select('FlagPublish');
			$query = $this->db->where('IdNews', $IdNews);
			$query = $this->db->get('news');
			$row = $query->row();
			if($row->FlagPublish==1){	return true;}else{return null;}
		}
		function GetAuthorNews($IdNews){
			$query = $this->db->select('AuthorNews');
			$query = $this->db->where('IdNews', $IdNews);
			$query = $this->db->get('news');
			if($query->num_rows()>0){
				$row = $query->row();
				return $row->AuthorNews;
			}else{
				return null;
			}
		}
		function FlagPublishIndicator($Param){
			if($Param==0){return '<img src="'.base_url().'assets/backend/images/draft.png"/>';}
			if($Param==1){return '<img src="'.base_url().'assets/backend/images/publish.png"/>';}
		}
		
		function CountRecordNewsx(){
			return $this->db->count_all("news");
		}
		function CountRecordNews($param){
			if($param=='all'){
				//$this->db->where('TitleNews',$param);
				return $this->db->count_all('news');
			}else{
				$this->db->like('TitleNews', $param);
				$this->db->from('news');
				return $this->db->count_all_results();
			}
		}
		function CountTotalNews(){
			return $this->db->count_all('news');
		}
		function CountTotalNewsPublish(){
			$query = $this->db->where('FlagPublish', 1);
			$query = $this->db->get('news');
			if($query->num_rows()>0){
				return $query->num_rows();
			}else{
				return null;
			}
		}
		function CountTotalNewsDraft(){
			$query = $this->db->where('FlagPublish', 0);
			$query = $this->db->get('news');
			if($query->num_rows()>0){
				return $query->num_rows();
			}else{
				return null;
			}
		}
		/*news*/
		/*category*/
		function CountRecordCategory(){
			return $this->db->count_all("category");
		}
	
		function GetCategory($limit,$start){
			//$this->db->limit($limit,$start);
			$query = $this->db->query("SELECT * FROM category ORDER BY NameCategory DESC LIMIT $start, $limit");
			if($query->num_rows()>0){
				foreach($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;		
		}
		function GetNameCategory($IdCategory){
			$query = $this->db->select('NameCategory');
			$query = $this->db->where('IdCategory', $IdCategory);
			$query = $this->db->get('category');
			$row = $query->row();
			return $row->NameCategory;
		}
	
		function CategoryAdd(){
			
				if(!$this->input->post('FlagPublish')){$FlagPublish='0';}else{$FlagPublish='1';}
			

				$NameCategory = $this->input->post('NameCategory');
				$NoteCategory = $this->input->post('NoteCategory');
				
				$query = $this->db->query("SELECT NameCategory FROM category WHERE NameCategory='$NameCategory'");
				if($query->num_rows()>0){
					$respon = array(
						'status'=>'nama kategori ada',
						'message'=>'Nama kategori ini sudah ada'
					);
				}else{
					$data = array(
						'NameCategory'=>$NameCategory,
						'NoteCategory'=>$NoteCategory,
						'FlagPublish'=>$FlagPublish
					);	
					$query = $this->db->insert('category',$data);
					if($query){						
						$respon = array(
							'status'=>'sukses',
							'message'=>'Tambah kategori sukses'
						);
					}
				}

				echo json_encode($respon);

			
		}
		function CategoryEdit(){
			
				if(!$this->input->post('FlagPublish')){$FlagPublish='0';}else{$FlagPublish='1';}			

				$NameCategory = $this->input->post('NameCategory');
				$NoteCategory = $this->input->post('NoteCategory');
				$IdCategory = $this->input->post('IdCategory');
				
				$query = $this->db->query("SELECT NameCategory FROM category WHERE NameCategory='$NameCategory'");
				if($query->num_rows()>0){
					$respon = array(
						'status'=>'nama kategori ada',
						'message'=>'Nama kategori ini sudah ada'
					);

				}else{
					$data = array(
						'NameCategory'=>$NameCategory,
						'NoteCategory'=>$NoteCategory,
						'FlagPublish'=>$FlagPublish
					);	
					

					$query = $this->db->where('IdCategory',$IdCategory);
					$query = $this->db->update('category',$data);
					//update dulu berita dengan kategori ini
					$dataNews = array(
						'CategoryNews'=>$NameCategory
						
					);	
					$query = $this->db->where('CategoryNews',$NameCategory);
					$query = $this->db->update('news',$dataNews);

					if($query){
						
						$respon = array(
							'status'=>'sukses',
							'message'=>'Update kategori sukses'
						);
					}
					
					
				}

				echo json_encode($respon);

			
		}
		function CategoryDelete(){
			$ulevel = $this->encrypt->decode($this->session->userdata('ulevel'));

			if($ulevel=='kontributor'){
				$respon  = array('status' => 'gagal', 'message'=>'Maaf anda tidak berhak  menghapus kategori ini' );
				
			}else{

				$NameCategory = $this->input->post('NameCategory');
				$query = $this->db->query("SELECT CategoryNews FROM news WHERE CategoryNews='$NameCategory'");
				if($query->num_rows()>0){
					$respon = array(
						'status'=>'sukses',
						'message'=>'Hapus kategori gagal, berita dalam kategori ini ada!.'
					);
				}else{
					$query = $this->db->where('NameCategory',$NameCategory);
					$query = $this->db->delete('category');
					if($query){					
						$respon = array(
							'status'=>'sukses',
							'message'=>'Hapus kategori sukses'
						);
					}
				}
			}
			echo json_encode($respon);
		}
		/*category*/
		/*user*/
		function CountRecordUser(){
			return $this->db->count_all("user");
		}
		
		function UserAdd(){
			
				$NameUser = $this->input->post('NameUser');
				$PasswordUser = $this->input->post('PasswordUser');
				$EmailUser = $this->input->post('EmailUser');
				$PhoneUser = $this->input->post('PhoneUser');
				$AddressUser = $this->input->post('AddressUser');
				$LevelUser = $this->input->post('LevelUser');
				$StatusUser = $this->input->post('StatusUser');
				$Tema = $this->input->post('Tema');
				$LandingPage = $this->input->post('LandingPage');

				$query = $this->db->query("SELECT EmailUser FROM user WHERE EmailUser='$EmailUser'");
				if($query->num_rows()>0){
					$respon = array(
						'status'=>'email sudah ada',
						'message'=>'Alamat email ini sudah digunakan'
					);
				}else{
					$data = array(
						'NameUser'=>$NameUser,
						'PasswordUser'=>md5($PasswordUser),
						'EmailUser'=>$EmailUser,
						'PhoneUser'=>$PhoneUser,
						'AddressUser'=>$AddressUser,
						'StatusUser'=>$StatusUser,
						'LevelUser'=>$LevelUser,
						'Tema' => $Tema,
						'LandingPage' => $LandingPage
					);	
					$query = $this->db->insert('user',$data);
					if($query){						
						$respon = array(
							'status'=>'sukses',
							'message'=>'Tambah pengguna sukses'
						);
					}
				}

				echo json_encode($respon);

			
		}
		function UserEdit(){
			/*
			AddressUser	Jl. Garuda Spadem Merauke
			EmailUser	calderamrk@gmail.com
			LandingPage	default
			LevelUser	superadmin
			StatusUser	aktif
			NameUser	admin
			PasswordUser	123
			PhoneUser	085244277399
			Tema	greensea
			aksi	UserEdit
			*/
			$NameUser = $this->input->post('NameUser');
			$PasswordUser = $this->input->post('PasswordUser');
			$EmailUser = $this->input->post('EmailUser');
			$PhoneUser = $this->input->post('PhoneUser');
			$AddressUser = $this->input->post('AddressUser');
			$StatusUser = $this->input->post('StatusUser');
			$LevelUser = $this->input->post('LevelUser');
			$LandingPage = $this->input->post('LandingPage');
			$Tema = $this->input->post('Tema');
			$IdUser = $this->input->post('IdUser');
			
			$data = array(
						'NameUser'=>$NameUser,
						'PasswordUser'=>md5($PasswordUser),
						'EmailUser'=>$EmailUser,
						'PhoneUser'=>$PhoneUser,
						'AddressUser'=>$AddressUser,
						'StatusUser'=>$StatusUser,
						'LevelUser'=>$LevelUser,
						'Tema'=>$Tema,
						'LandingPage' => $LandingPage
			);	
			if($PasswordUser==''){
				unset($data["PasswordUser"]);
			}
			
			$this->db->where('IdUser',$IdUser);
			$this->db->update('user',$data);
						
			$respon = array(
				'status' => 'sukses',
				'message' => 'Update user berhasil'
			);	
			echo json_encode($respon);
		}
		function UserDelete(){
			$ulevel = $this->encrypt->decode($this->session->userdata('ulevel'));

			if($ulevel=='kontributor' || $ulevel == 'moderator'){
				$respon  = array('status' => 'gagal', 'message'=>'Maaf anda tidak berhak  menghapus user ini' );
				
			}else{	
				$IdUser = $this->input->post('IdUser');

			
				$query = $this->db->where('IdUser',$IdUser);
				$query = $this->db->delete('user');
				if($query){					
					$respon = array(
						'status'=>'sukses',
						'message'=>'Hapus user sukses'
					);
				}
			}
			echo json_encode($respon);
		}
		
		
		/*user*/
		/*comment*/
		function TextSnippet($text, $maxchar, $end='...') {
			if(strlen($text) > $maxchar || $text == ''){
				$words = preg_split('/\s/', $text);      
				$output = '';
				$i      = 0;
				while (1) {
					$length = strlen($output)+strlen($words[$i]);
					if ($length > $maxchar) {
						break;
					}else {
						$output .= " " . $words[$i];
						++$i;
					}
				}
				$output .= $end;
			} 
			else {
				$output = $text;
			}
			return $output;
		}
		function TextLength($Param, $Length, $End='...'){
			$Text = strlen($Param);
			if($Text > $Length){
				return substr($Param, 0, $Length).$End;				
			}else{
				return $Param;
			}
		}
		function CountRecordComment(){
			return $this->db->count_all("comment");
		}
	
		function GetComment($limit,$start){
			//$this->db->limit($limit,$start);
			$query = $this->db->query("SELECT * FROM comment ORDER BY DateComment DESC LIMIT $start, $limit");
			if($query->num_rows()>0){
				foreach($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;		
		}
		function CommentEdit(){
			$NameComment = $this->input->post('NameComment');
			$ContentComment = $this->input->post('ContentComment');
			$EmailComment = $this->input->post('EmailComment');
			$IdComment = $this->input->post('IdComment');
			if(!$this->input->post('FlagPublish')){$FlagPublish='0';}else{$FlagPublish='1';}
			
			$data = array(
				'NameComment' => $NameComment,
				'ContentComment' => $ContentComment,
				'EmailComment' => $EmailComment,
				'FlagPublish' => $FlagPublish
			);
			$query = $this->db->where('IdComment',$IdComment);
			$query = $this->db->update('comment',$data);
			if($query){					
					$respon = array(
						'status'=>'sukses',
						'message'=>'Edit komentar sukses'
					);
			}
			echo json_encode($respon);
		
		}
		function CommentDelete(){
			$ulevel = $this->encrypt->decode($this->session->userdata('ulevel'));

			if($ulevel=='kontributor'){
				$respon  = array('status' => 'gagal', 'message'=>'Maaf anda tidak berhak  menghapus berita ini' );
				
			}else{
		
				$IdComment = $this->input->post('IdComment');
				$query = $this->db->where('IdComment',$IdComment);
				$query = $this->db->delete('comment');
				if($query){					
					$respon = array(
						'status'=>'sukses',
						'message'=>'Hapus komentar sukses!.'
					);
				}
			}
			echo json_encode($respon);

		}
		/*comment*/
		/*comment*/
		function CountRecordCaptcha(){
			return $this->db->count_all("captcha");
		}
	
		function GetCaptcha($limit,$start){
			//$this->db->limit($limit,$start);
			$query = $this->db->query("SELECT * FROM captcha LIMIT $start, $limit");
			if($query->num_rows()>0){
				foreach($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;		
		}
		function CaptchaAdd(){
			
			$data = array(
				'Question' => $this->input->post('Question'),
				'Answer' => $this->input->post('Answer')
			);
			$query = $this->db->insert('captcha',$data);
			if($query){
				$respon = array(
					'status' => 'sukses',
					'message' => 'Captcha berhasil ditambahkan.'
				);
			
			}
			echo json_encode($respon);
		}
		function CaptchaDelete(){
			$ulevel = $this->encrypt->decode($this->session->userdata('ulevel'));

			if($ulevel=='kontributor'){
				$respon  = array('status' => 'gagal', 'message'=>'Maaf anda tidak berhak  menghapus user ini' );
				
			}else{	
				$IdCaptcha = $this->input->post('IdCaptcha');

			
				$query = $this->db->where('IdCaptcha',$IdCaptcha);
				$query = $this->db->delete('captcha');
				if($query){					
					$respon = array(
						'status'=>'sukses',
						'message'=>'Hapus captcha sukses'
					);
				}
			}
			echo json_encode($respon);
		}
		
		/*comment*/
		/*laporan*/
		function GrafikLaporanBerita(){
			
		 	$TglAwal = DateSlashMysql($this->input->post('TglAwal'));
			$TglAkhir = DateSlashMysql($this->input->post('TglAkhir'));
			
			
			$query = $this->db->query("SELECT DATE_FORMAT(CreatedNews,'%M %Y') AS CreatedNews, COUNT(TitleNews) AS TotalNews FROM news WHERE CreatedNews BETWEEN '$TglAwal' AND '$TglAkhir' GROUP BY MONTH(CreatedNews)");
			if($query->num_rows()>0){
				$data = array();
				foreach($query->result() as $row){
					$data[] = array($row->CreatedNews, intval($row->TotalNews));
				}				
				$respon = array(
					'status' => 'sukses',
					'message' => 'Grafik digenerate',
					'label' => 'GRAFIK LAPORAN BERITA',
					'data' => $data
				);
			}else{
				$respon = array(
					'status' => 'datatidakada',
					'message' => 'Data tidak ada'
				);
			}
			
			//print_r($respon);
			
			echo json_encode($respon);
			
		}
		function GrafikLaporanBeritaByPeriodePerPenulis(){
			
		 	$AuthorNews = $this->input->post('AuthorNews');
		 	$TglAwal = DateSlashMysql($this->input->post('TglAwal'));
			$TglAkhir = DateSlashMysql($this->input->post('TglAkhir'));
			
			
			$query = $this->db->query("SELECT DATE_FORMAT(CreatedNews,'%M %Y') AS CreatedNews, COUNT(TitleNews) AS TotalNews FROM news WHERE CreatedNews BETWEEN '$TglAwal' AND '$TglAkhir' AND AuthorNews='$AuthorNews' GROUP BY MONTH(CreatedNews)");
			if($query->num_rows()>0){
				$data = array();
				foreach($query->result() as $row){
					$data[] = array($row->CreatedNews, intval($row->TotalNews));
				}				
				$respon = array(
					'status'=>'sukses',
					'message'=>'Data digenerate',
					'label' => 'GRAFIK LAPORAN BERITA OLEH '.$AuthorNews,
					'data' => $data
				);
			}else{
				$respon = array(
					'status'=>'datatidakada',
					'message'=>'Data tidak ada'
				);
			}
			
			//print_r($respon);
			
			echo json_encode($respon);
			
		}
		
		/*laporan*/
		/*dashboard*/
		function GrafikBeritaDashboard(){
			
			
		 	//$TglAwal = DateSlashMysql($this->input->post('TglAwal'));
		//	$TglAkhir = DateSlashMysql($this->input->post('TglAkhir'));
			
			
			$query = $this->db->query("SELECT DATE_FORMAT(CreatedNews,'%d-%b-%Y') AS CreatedNews, COUNT(TitleNews) AS TotalNews FROM news WHERE CreatedNews >= DATE_SUB(NOW(),INTERVAL 1 YEAR) GROUP BY MONTH(CreatedNews)");
			if($query->num_rows()>0){
				$data = array();
				foreach($query->result() as $row){
					$data[] = array($row->CreatedNews, intval($row->TotalNews));
				}				
				$respon = array(
					'status' => 'sukses',
					'message' => 'Grafik digenerate',
					'label' => 'GRAFIK BERITA DALAM 1 TAHUN',
					'data' => $data
				);
			}else{
				$respon = array(
					'status' => 'datatidakada',
					'message' => 'Data tidak ada'
				);
			}
			
			//print_r($respon);
			
			echo json_encode($respon);
			
		
		}
		function TotalJumlahBerita(){
			$query = $this->db->query("SELECT COUNT(TitleNews) AS TotalNews FROM news");
			$row = $query->row();
			return $TotalNews = $row->TotalNews;
		}
		function TotalJumlahKategori(){
			$query = $this->db->query("SELECT COUNT(NameCategory) AS TotalCategory FROM category");
			$row = $query->row();
			return $TotalCategory = $row->TotalCategory;
		}
		function TotalJumlahUser(){
			$query = $this->db->query("SELECT COUNT(NameUser) AS TotalUser FROM user");
			$row = $query->row();
			return $TotalUser = $row->TotalUser;
		}
		function TotalJumlahKomentar(){
			$query = $this->db->query("SELECT COUNT(NameComment) AS TotalComment FROM comment");
			$row = $query->row();
			return $TotalComment = $row->TotalComment;
		}
		function TotalJumlahLog(){
			$query = $this->db->query("SELECT COUNT(IdLog) AS TotalLogs FROM logs");
			$row = $query->row();
			return $TotalLogs = $row->TotalLogs;
		}
		function BeritaTerbaru(){
			return $this->db->query("SELECT TitleNews, CreatedNews, AuthorNews FROM news ORDER BY CreatedNews DESC LIMIT 0, 10")->result();
		}
		
		function BeritaTerbanyakDikunjungi(){
			return $this->db->query("SELECT TitleNews, ReadRating FROM news ORDER BY ReadRating DESC LIMIT 0, 4")->result();

		}
		function LoginPengguna(){
			return $this->db->query("SELECT * FROM logsuser ORDER BY TimeLog DESC LIMIT 0, 5")->result();

		}
		function SystemLog(){
			return $this->db->query("SELECT * FROM logssystem ORDER BY TimeLog DESC LIMIT 0, 5")->result();

		}
		function VisitorLog(){
			return $this->db->query("SELECT * FROM logsvisitor ORDER BY TimeLog DESC LIMIT 0, 5")->result();

		}
		/*dashboar*/
		/*privasi*/
		
		/*privasi*/
		function GetUserLogsByIdUser($IdUser){
			return $this->db->query("SELECT * FROM userlog WHERE IdUser='$IdUser' ORDER BY TimeStamp DESC LIMIT 0, 10")->result();
		}
		function GetNewsModerationByNameUser($NameUser){
			return $this->db->query("SELECT * FROM news WHERE AuthorNews = '$NameUser' AND FlagPublish='0' ORDER BY CreatedNews DESC")->result();
		}
		
		function GetProfilePicture($IdUser){
			$query = $this->db->query("SELECT PictureUser FROM user WHERE IdUser='$IdUser'");
			$row = $query->row();
			return $row->PictureUser;
		}
		function GetAboutUser($IdUser){
			$query = $this->db->query("SELECT AboutMe FROM user WHERE IdUser='$IdUser'");
			$row = $query->row();
			return $row->AboutMe;
		}
		function GantiPasswordUser(){
			$IdUser = $this->input->post('IdUser');
			$PassBaru = md5($this->input->post('PasswordBaru'));
			$PassLama = md5($this->input->post('PasswordLama'));

			$query = $this->db->query("SELECT PasswordUser FROM user WHERE IdUser='$IdUser'");
			$row = $query->row();
			$PassDB = $row->PasswordUser;

			if($PassLama !== $PassDB){
				$respon = array(
					'status' => 'tidak sama',
					'message' => 'Error, password lama tidak sama'
				);

			}else{
				$data = array(
					'PasswordUser' => $PassBaru
				);

				$query = $this->db->where('IdUser', $IdUser);
				$query = $this->db->update('user', $data);
				$respon = array(
					'status' => 'sukses',
					'message' => 'Ganti password berhasil'
				);
			}
			echo json_encode($respon);
		}
		/*privasi*/

		/*event-story*/
		function GetEventStory(){
			return $this->db->query("SELECT * FROM eventstory")->result();
		}
		function EventStoryAdd(){
			
			$EditByUser = $this->encrypt->decode($this->session->userdata('uname'));
			
			$uid = $this->encrypt->decode($this->session->userdata('uid'));
			$TitleEvent = $this->input->post('TitleEvent');
			
			$DateEvent = $this->input->post('DateEvent');
			$DateEvent = DateSlashMysql($DateEvent).' '.date('H:i:s'); /* 2013/12/11 06:01:01 */

			$ContentEvent = $this->input->post('ContentEvent');

			$DatePublish = date('d/m/Y');		
			$DatePublish = DateSlashMysql($DatePublish).' '.date('H:i:s'); /* 2013/12/11 06:01:01 */

			$DateUpdate = date('d/m/Y');
			$DateUpdate = DateSlashMysql($DateUpdate).' '.date('H:i:s'); /* 2013/12/11 06:01:01 */

			$IdEvent = $this->input->post('IdEvent');
			if(!$this->input->post('FlagPublish')){$FlagPublish='0';}else{$FlagPublish='1';}

			$data = array(
				'IdUser'=>$uid,
				'TitleEvent'=>$TitleEvent,
				'ContentEvent'=>$ContentEvent,
				'DateEvent'=>$DateEvent,
				'FlagPublish'=>$FlagPublish,
				'DateUpdate'=>$DateUpdate,
				'EditByUser'=>$EditByUser,
				'DatePublish'=>$DatePublish

			);

			$query = $this->db->where('IdEvent',$IdEvent);
			$query = $this->db->update('eventstory',$data);
			if($query){
				$respon = array(
					'status'=>'sukses',
					'message'=>'Update ucapan (event) sukses'
				);
			}
			echo json_encode($respon);
		}
		/*event-story*/
		/*setting*/
		function GetEmailSubscriber(){
				$this->db->order_by('TglSubscriber','DESC');
			return $this->db->get('emailsubscriber')->result();
		}
		function SettingFrontendVisitorLog(){
			return $this->db->query("SELECT VisitorLog FROM settingfrontend")->result();
			
		}
		function SettingFrontendShowMaxNews(){
			return $this->db->query("SELECT ShowMaxNews FROM settingfrontend")->result();
			
		}
		function SettingFrontendCommentModule(){
			return $this->db->query("SELECT CommentModule FROM settingfrontend")->result();
			
		}
		function SimpanSettingFrontend(){
			$VisitorLog = $this->input->post('VisitorLog');
			$ShowMaxNews = $this->input->post('ShowMaxNews');
			$CommentModule = $this->input->post('CommentModule');
			
			$data = array(
				'VisitorLog' => $VisitorLog,
				'ShowMaxNews' => $ShowMaxNews,
				'CommentModule' => $CommentModule
			);
			$query = $this->db->update('settingfrontend',$data);
			if($query){
				$respon = array(
					'status'=>'sukses',
					'message'=>'Update konfigurasi sukses'
				);
			}
			echo json_encode($respon);
		}
		function SettingBackendMaxDataPerPage(){
			return $this->db->query("SELECT MaxDataPerPage FROM settingbackend")->result();
		}
		function SimpanSettingBackend(){
			$MaxDataPerPage = $this->input->post('MaxDataPerPage');			
			
			$data = array(
				'MaxDataPerPage' => $MaxDataPerPage			
			);
			$query = $this->db->update('settingbackend',$data);
			if($query){
				$respon = array(
					'status'=>'sukses',
					'message'=>'Update konfigurasi sukses'
				);
			}
			echo json_encode($respon);
		}
		function GetMaxDataPerPage(){
			$query = $this->db->query("SELECT MaxDataPerPage FROM settingbackend");
			$row = $query->row();
			return $row->MaxDataPerPage;
		}
		function SettingGeneralWebStatus(){
			return $this->db->query("SELECT WebStatus FROM settinggeneral")->result();
		}
		function SimpanSettingGeneral(){
			$WebStatus = $this->input->post('WebStatus');			
			
			$data = array(
				'WebStatus' => $WebStatus			
			);
			$query = $this->db->update('settinggeneral',$data);
			if($query){
				$respon = array(
					'status'=>'sukses',
					'message'=>'Update konfigurasi sukses'
				);
			}
			echo json_encode($respon);
		}
		function SettingGeneralHapusSemuaLog(){
			$query = $this->db->empty_table('logs');
			if($query){
				$respon = array(
					'status'=>'sukses',
					'message'=>'Hapus semua log sukses'
				);
			}
			echo json_encode($respon);
		}
		function GetEmailSettings(){
			$query =  $this->db->query("SELECT * FROM emailsettings");
			foreach($query->result() as $row){
				$row = $query->row();
				$data[] = $row;
			}
			return $data;
		}
		
		function SendEmail($user,$tujuan,$subyek,$isiemail){					
			$query = $this->db->get("emailsettings");
			foreach($query->result() as $row){
				$config = array(
					'smtp_host' => $row->smtp_host,
					'smtp_port' => $row->smtp_port,
					'smtp_user' => $row->smtp_user,
					'smtp_pass' => $this->secure->EncryptDecrypt('decrypt',$row->smtp_pass),
					'mailtype' => $row->mailtype,
					'wordwrap' => $row->wordwrap,
					'useragent' => 'Mailer services',
					'charset' => 'utf-8'
				);
			}							
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");		 
			$this->email->from($row->smtp_user,$user);
			$this->email->to($tujuan);		 
			$this->email->subject($subyek);		 
			$this->email->message($isiemail);		 
						
			if (!$this->email->send()){
				/*
				$respon = array(
					'status' => 'error',
					'message' => 'Kirim email gagal',
					'debug' => show_error($this->email->print_debugger())
				);
				*/
				return 'gagal';
			}else{
				/*
				$respon = array(
					'status'=> 'sukses',
					'message' => 'Kirim email berhasil'
				);
				*/
				return null;
				
			}
			//echo json_encode($respon);
		}
		function EmailAktivasi($Key){
			$this->db->where('Key',$Key);
			$query = $this->db->get('emailsubscriber');
			if($query->num_rows()>0){
				$row = $query->row();
				$Email = $row->Email;
				$Status = $row->Status;
				
				if($Status == 'aktif'){
					return 'Status email sudah aktif';
				}else{
					$data = array(
						'Status' => 'aktif',
						'Key' => 0
					);
					$this->db->where('Email',$Email);
					$this->db->update('emailsubscriber',$data);
				
					return 'Berhasil, selamat! email anda telah aktif berlangganan berita dan informasi terbaru. merauke.go.id';
				}
				
								
			}else{
				return 'gagal';			
			}
			
			
		}
		/*setting*/
		/*profile*/
		function GetProfilUserByID($IdUser){
			return $this->db->query("SELECT * FROM user WHERE IdUser='$IdUser'")->result();
		}
		function GetProfileTema(){
			$IdUser = $this->encrypt->decode($this->session->userdata('uid'));
			if($IdUser==''){
				return 'belize';
			}else{
				$query = $this->db->query("SELECT Tema FROM user WHERE IdUser='$IdUser'");
				$row = $query->row();
				return $row->Tema;
			}
		}
		function SwitchTema(){
			$IdUser = $this->encrypt->decode($this->session->userdata('uid'));
		
			$Tema = $this->input->post('Tema');
			
			$data = array(
				'Tema' => $Tema
			);
			
			
			$query = $this->db->where('IdUser',$IdUser);
			$query = $this->db->update('user',$data);
			if($query){
			
					$respon = array(
						'status'=>'sukses',
						'message'=>'Ganti tema ke '.$Tema.' sukses'
					);
			}
			
			echo json_encode($respon);
			
		}
		function ProfilUserUpdate(){
			$IdUser = $this->encrypt->decode($this->session->userdata('uid'));
			$EmailUser = $this->input->post('EmailUser');
			$PhoneUser = $this->input->post('PhoneUser');
			$AddressUser = $this->input->post('AddressUser');
			$AboutMe = $this->input->post('AboutMe');
			
			$query = $this->db->where('EmailUser',$EmailUser);
			$query = $this->db->get('user');
			if($query->num_rows()>0){
				$respon = array(
					'status' => 'emailada',
					'message' => 'Gagal, email ini sudah ada'
				);
			
			}
			
			$data = array(
				'EmailUser' => $EmailUser,
				'PhoneUser' => $PhoneUser,
				'AddressUser' => $AddressUser,
				'AboutMe' => $AboutMe
			);
			
			$query2 = $this->db->where('IdUser',$IdUser);
			$query2 = $this->db->update('user',$data);
			if($query2){
				$respon = array(
					'status' => 'sukses',
					'message' => 'Update data anda berhasil'
				);
			}
			
			echo json_encode($respon);
		}
		function ProfilGetLandingPage(){
			$IdUser = $this->encrypt->decode($this->session->userdata('uid'));
			$query = $this->db->query("SELECT LandingPage FROM user WHERE IdUser='$IdUser'");
			$row = $query->row();
			return $row->LandingPage;
		}
		function ProfilLandingPage(){
			$IdUser = $this->encrypt->decode($this->session->userdata('uid'));
			$LandingPage = $this->input->post('LandingPage');
			$query = $this->db->where('IdUser',$IdUser);
			$query = $this->db->update('user',array('LandingPage'=>$LandingPage));
			if($query){
				$respon = array(
					'status' => 'sukses',
					'message' => 'Update landing page berhasil'
				);
			}
			echo json_encode($respon);
		}
		
		/*profile*/
		/*logs*/
		function CountRecordLogsUser(){
			return $this->db->count_all("logsuser");
		}
	
		function GetLogsUser($limit,$start){
			//$this->db->limit($limit,$start);
			$query = $this->db->query("SELECT * FROM logsuser ORDER BY TimeLog DESC LIMIT $start, $limit");
			if($query->num_rows()>0){
				foreach($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;		
		}
		function LogsUserDelete(){
			$query = $this->db->from('logsuser');
			$query = $this->db->truncate();
			
			if($query){
			
					$respon = array(
						'status'=>'sukses',
						'message'=>'Hapus logs user sukses'
					);
			}
			echo json_encode($respon);
		
		}
		function CountRecordLogsSystem(){
			return $this->db->count_all("logssystem");
		}
		function LogsSystemDelete(){
			$query = $this->db->from('logssystem');
			$query = $this->db->truncate();
			
			if($query){
			
					$respon = array(
						'status'=>'sukses',
						'message'=>'Hapus logs system sukses'
					);
			}
			echo json_encode($respon);
		
		}
		function GetLogsSystem($limit,$start){
			//$this->db->limit($limit,$start);
			$query = $this->db->query("SELECT * FROM logssystem ORDER BY TimeLog DESC LIMIT $start, $limit");
			if($query->num_rows()>0){
				foreach($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;		
		}
		function CountRecordLogsVisitor(){
			return $this->db->count_all("logsvisitor");
		}
		function LogsVisitorDelete(){
			$query = $this->db->from('logsvisitor');
			$query = $this->db->truncate();
			
			if($query){
			
					$respon = array(
						'status'=>'sukses',
						'message'=>'Hapus logs pengunjung sukses'
					);
			}
			echo json_encode($respon);
		
		}
		function GetLogsVisitor($limit,$start){
			//$this->db->limit($limit,$start);
			$query = $this->db->query("SELECT * FROM logsvisitor ORDER BY TimeLog DESC LIMIT $start, $limit");
			if($query->num_rows()>0){
				foreach($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;		
		}
		/*logs*/
		//--------------------------SETTINGS------------------------------//
		function GetFrontendSlider(){
			return $this->db->get("settingsfrontslider")->result();
		}
		function SliderAdd(){
			$Image = $this->input->post('Thumbnail');
			$Caption = $this->input->post('Caption');
			$Deskripsi = $this->input->post('Deskripsi');
			$Status = $this->input->post('Flag');
			$FirstSlide = $this->input->post('FirstSlide');
			
			if($FirstSlide=='1'){
				$this->db->update('settingsfrontslider',array('FirstSlide'=>'0'));
			}
			
			$data = array(
				'Image' => $Image,
				'Caption' => $Caption,
				'Deskripsi' => $Deskripsi,
				'Flag' => $Status,
				'FirstSlide' => $FirstSlide				
			);
			$query = $this->db->insert('settingsfrontslider',$data);
			if($query){
				$respon = array(
					'status' => 'sukses',
					'message' => 'Tambah slider berhasil'
				);
			}
			echo json_encode($respon);
			
		}
		function SliderEdit(){
			$IdSlide = $this->input->post('IdSlide');
			$query = $this->db->query("SELECT * FROM settingsfrontslider WHERE IdSlide='$IdSlide'");
			$row = $query->row();
			$respon = array(
				'data' => $row
			);
			echo json_encode($respon);
		}
		function SliderUpdate(){
			
			$Caption = $this->input->post('CaptionEdit');
			$Deskripsi = $this->input->post('DeskripsiEdit');
			$FirstSlide = $this->input->post('FirstSlideEdit');
			$Flag = $this->input->post('FlagEdit');
			$Image = $this->input->post('ThumbnailEdit');
			
			$IdSlide = $this->input->post('IdSlide');
			
			if($FirstSlide=='1'){
				$this->db->update('settingsfrontslider',array('FirstSlide'=>'0'));
			}
			
			$data = array(
				'Image' => $Image,
				'Caption' => $Caption,
				'Deskripsi' => $Deskripsi,
				'Flag' => $Flag,
				'FirstSlide' => $FirstSlide				
			);
			
			$query = $this->db->where('IdSlide',$IdSlide);
			$query = $this->db->update('settingsfrontslider',$data);
			if($query){
				$respon = array(
					'status' => 'sukses',
					'message' => 'Update slider berhasil'
				);
			}
			echo json_encode($respon);
		}
		function SliderDelete(){
			$ulevel = $this->encrypt->decode($this->session->userdata('ulevel'));

			if($ulevel=='kontributor'){
				$respon  = array('status' => 'gagal', 'message'=>'Maaf anda tidak berhak  menghapus slider ini' );
				
			}else{

				$IdSlider = $this->input->post('IdSlide');
				$query = $this->db->where('IdSlide',$IdSlider);
					$query = $this->db->delete('settingsfrontslider');
					if($query){					
						$respon = array(
							'status'=>'sukses',
							'message'=>'Hapus slider sukses'
						);
					}
				
			}
			echo json_encode($respon);
		}
		
		//--------------------------END SETTINGS------------------------------//
		//--------------------------USER PROFILE------------------------------//
		function GetUserTheme(){
			$query = $this->db->where('IdUser',$this->secure->GetIdUser());
			$query = $this->db->get('user');
			$row = $query->row();
			return $row->Theme;
		}	
		//--------------------------GALLERY------------------------------//
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
		//--------------------------END GALLERY------------------------------//
		//--------------------------PRODUK HUKUM------------------------------//
			function GetProdukHukumCategory($IdCategory){
			$query = $this->db->where('IdCategory', $IdCategory);
			$query = $this->db->get('produk_hukum_category');
			$row = $query->row();
			return $row->NameCategory;
		}
		function GetTotalProdukHukumInCategory($IdCategory){
			$query = $this->db->where('IdCategory', $IdCategory);
			$query = $this->db->get('produk_hukum');
			return $query->num_rows();
		}
		//--------------------------TELEPON PENTING------------------------------//
		function GetTeleponPentingCategory($IdCategory){
			$query = $this->db->where('IdCategory', $IdCategory);
			$query = $this->db->get('telepon_penting_category');
			$row = $query->row();
			return $row->NameCategory;
		}
		function GetTotalTeleponPentingInCategory($IdCategory){
			$query = $this->db->where('IdCategory', $IdCategory);
			$query = $this->db->get('telepon_penting');
			return $query->num_rows();
		}
		//--------------------------LOGS------------------------------//
		function GetMaxLogs(){
			$query = $this->db->select('MaxLogs');
			$query = $this->db->get('settings');
			$row = $query->row();
			return $row->MaxLogs;
		}
		//--------------------------LOGS------------------------------//
		#-------------------- USER AGENT -----------------------#
		function ParserUserAgent( $u_agent = null ) {
			if( is_null($u_agent) ) {
				if( isset($_SERVER['HTTP_USER_AGENT']) ) {
					$u_agent = $_SERVER['HTTP_USER_AGENT'];
				} else {
					throw new \InvalidArgumentException('parse_user_agent requires a user agent');
				}
			}
			$platform = null;
			$browser  = null;
			$version  = null;
			$empty = array( 'platform' => $platform, 'browser' => $browser, 'version' => $version );
			if( !$u_agent ) return $empty;
			if( preg_match('/\((.*?)\)/im', $u_agent, $parent_matches) ) {
				preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS)|Xbox(\ One)?)
						(?:\ [^;]*)?
						(?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
				$priority           = array( 'Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'CrOS', 'Linux', 'X11' );
				$result['platform'] = array_unique($result['platform']);
				if( count($result['platform']) > 1 ) {
					if( $keys = array_intersect($priority, $result['platform']) ) {
						$platform = reset($keys);
					} else {
						$platform = $result['platform'][0];
					}
				} elseif( isset($result['platform'][0]) ) {
					$platform = $result['platform'][0];
				}
			}
			if( $platform == 'linux-gnu' || $platform == 'X11' ) {
				$platform = 'Linux';
			} elseif( $platform == 'CrOS' ) {
				$platform = 'Chrome OS';
			}
			preg_match_all('%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|Safari|MSIE|Trident|AppleWebKit|TizenBrowser|Chrome|
						Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|
						Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
						Valve\ Steam\ Tenfoot|
						NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
						(?:\)?;?)
						(?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
				$u_agent, $result, PREG_PATTERN_ORDER);
			// If nothing matched, return null (to avoid undefined index errors)
			if( !isset($result['browser'][0]) || !isset($result['version'][0]) ) {
				if( preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result) ) {
					return array( 'platform' => $platform ?: null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ?: null : null );
				}
				return $empty;
			}
			if( preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $u_agent, $rv_result) ) {
				$rv_result = $rv_result['version'];
			}
			$browser = $result['browser'][0];
			$version = $result['version'][0];
			$lowerBrowser = array_map('strtolower', $result['browser']);
			$find = function ( $search, &$key ) use ( $lowerBrowser ) {
				$xkey = array_search(strtolower($search), $lowerBrowser);
				if( $xkey !== false ) {
					$key = $xkey;
					return true;
				}
				return false;
			};
			$key  = 0;
			$ekey = 0;
			if( $browser == 'Iceweasel' ) {
				$browser = 'Firefox';
			} elseif( $find('Playstation Vita', $key) ) {
				$platform = 'PlayStation Vita';
				$browser  = 'Browser';
			} elseif( $find('Kindle Fire', $key) || $find('Silk', $key) ) {
				$browser  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
				$platform = 'Kindle Fire';
				if( !($version = $result['version'][$key]) || !is_numeric($version[0]) ) {
					$version = $result['version'][array_search('Version', $result['browser'])];
				}
			} elseif( $find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS' ) {
				$browser = 'NintendoBrowser';
				$version = $result['version'][$key];
			} elseif( $find('Kindle', $key) ) {
				$browser  = $result['browser'][$key];
				$platform = 'Kindle';
				$version  = $result['version'][$key];
			} elseif( $find('OPR', $key) ) {
				$browser = 'Opera Next';
				$version = $result['version'][$key];
			} elseif( $find('Opera', $key) ) {
				$browser = 'Opera';
				$find('Version', $key);
				$version = $result['version'][$key];
			} elseif( $find('Midori', $key) ) {
				$browser = 'Midori';
				$version = $result['version'][$key];
			} elseif( $browser == 'MSIE' || ($rv_result && $find('Trident', $key)) || $find('Edge', $ekey) ) {
				$browser = 'MSIE';
				if( $find('IEMobile', $key) ) {
					$browser = 'IEMobile';
					$version = $result['version'][$key];
				} elseif( $ekey ) {
					$version = $result['version'][$ekey];
				} else {
					$version = $rv_result ?: $result['version'][$key];
				}
				if( version_compare($version, '12', '>=') ) {
					$browser = 'Edge';
				}
			} elseif( $find('Vivaldi', $key) ) {
				$browser = 'Vivaldi';
				$version = $result['version'][$key];
			} elseif( $find('Valve Steam Tenfoot', $key) ) {
				$browser = 'Valve Steam Tenfoot';
				$version = $result['version'][$key];
			} elseif( $find('Chrome', $key) || $find('CriOS', $key) ) {
				$browser = 'Chrome';
				$version = $result['version'][$key];
			} elseif( $browser == 'AppleWebKit' ) {
				if( ($platform == 'Android' && !($key = 0)) ) {
					$browser = 'Android Browser';
				} elseif( strpos($platform, 'BB') === 0 ) {
					$browser  = 'BlackBerry Browser';
					$platform = 'BlackBerry';
				} elseif( $platform == 'BlackBerry' || $platform == 'PlayBook' ) {
					$browser = 'BlackBerry Browser';
				} elseif( $find('Safari', $key) ) {
					$browser = 'Safari';
				} elseif( $find('TizenBrowser', $key) ) {
					$browser = 'TizenBrowser';
				}
				$find('Version', $key);
				$version = $result['version'][$key];
			} elseif( $key = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser'])) ) {
				$key = reset($key);
				$platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
				$browser  = 'NetFront';
			}
			return array( 'platform' => $platform ?: null, 'browser' => $browser ?: null, 'version' => $version ?: null );
		}
	}
	
?>