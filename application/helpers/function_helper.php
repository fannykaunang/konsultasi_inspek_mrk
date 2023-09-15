<?php
	function DateToMysql($Param){
		//param : 20/08/2011
		$date = explode('/', $Param);		
		return $date[2].'-'.$date[1].'-'.$date[0];
	}
	
	/*convert datemysql to indo*/
	function DateIndo($Param){		
		// 2011-08-20 12:11:10 output 20/08/2011
		$Param = substr($Param, 0, -9); //buang jam
		$date = explode('-', $Param);		
		return $DateIndo = $date[2].'/'.$date[1].'/'.$date[0];		
	}
	function DateTimeIndo($DateTimeMysql){		
		//2013-12-01 12:12:01 ubah ke indonesia 01/12/2013 12:12:01
		/*
		$DateTimeMysql = date_create($DateTimeMysql);
		$date = date_format($DateTimeMysql, 'd F Y H:i:s');

		$x = explode(' ',$date); // [03] [December] [2013] [12:12:01];
		return $x[0].' '.MonthIndo($x[1]).' '.$x[2].' '.$x[3];
		*
		*/
		if($DateTimeMysql==null || $DateTimeMysql=='0'){
			return '0';
		}else{

			$x = explode(' ', $DateTimeMysql); //[2013-12-01] [12:12:01]
			$y = explode('-', $x[0]); //[2013] [12] [01]

			return $y[2].' '.MonthIndo($y[1]).' '.$y[0].' '.$x[1];
		}
	}
	function DateSlashMysql($DateSlash){
		//17/12/2013 ubah ke mysql 2013/12/07
		$x = explode('/', $DateSlash); //[17] [12] [2013]
		return $x[2].'-'.$x[1].'-'.$x[0];
	}
	function MonthSlashMysql($MonthSlash){
		//03/2016 ubah ke 2016-03
		$x = explode('/', $MonthSlash); //[17] [12] [2013]
		return $x[1].'-'.$x[0];
	}
	function MonthIndo($MonthName){
		if($MonthName=="January" || $MonthName=="jan" || $MonthName=="01") $MonthName="Januari";
		elseif($MonthName=="February" || $MonthName=="feb" || $MonthName=="02") $MonthName="Februari";
		elseif($MonthName=="March" || $MonthName=="mar" || $MonthName=="03") $MonthName="Maret";
		elseif($MonthName=="April" || $MonthName=="apr" || $MonthName=="04") $MonthName="April";
		elseif($MonthName=="May"|| $MonthName=="may" || $MonthName=="05") $MonthName="Mei";
		elseif($MonthName=="June" || $MonthName=="jun" || $MonthName=="06") $MonthName="Juni";
		elseif($MonthName=="July" || $MonthName=="jul" || $MonthName=="07") $MonthName="Juli";
		elseif($MonthName=="August" || $MonthName=="aug" || $MonthName=="08") $MonthName="Agustus";
		elseif($MonthName=="September" || $MonthName=="sep" || $MonthName=="09") $MonthName="September";
		elseif($MonthName=="October" || $MonthName=="oct" || $MonthName=="10") $MonthName="Oktober";
		elseif($MonthName=="November" || $MonthName=="nov" || $MonthName=="11") $MonthName="Nopember";
		elseif($MonthName=="December" || $MonthName=="dec" || $MonthName=="12") $MonthName="Desember";
		return $MonthName;
	}

	

	/*convert dateindo to mysql*/
	function DateMysql($Param){
		//$DateIndo = explode(' ', $Param);
		//$DateIndoDate = $DateIndo[0]; //date mysql
		$DateNow = date('Y-m-d h:m:s');		
		$exp = explode('-',$Param);
		return $DateMysql = $exp[2].'-'.$exp[1].'-'.$exp[0];
	}
	/*convert date time mysql*/
	function DateTimeMysql($Param){		
		//27/06/2013
		$t = date("H:i:s");
		
		$d = explode("/",$Param);
		return $newd = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
		
		
	}
	function DateTimeMysql2($date,$minute){
		$exp = explode('-',$date);
		return $DateMysql = $exp[2].'-'.$exp[1].'-'.$exp[0].' '.$minute;
	}
	/*get Time*/
	function GetTime($Param){
		$slice = explode(" ",$Param);
		return $slice[1];
	}
	function GetTimeX($Param){
		$slice = explode(" ",$Param);
		return substr($slice[1],0,-3);
	}
	function DayIndo($DayName){
		if($DayName=="Sunday") $DayName="Minggu";
		elseif($DayName=="Monday") $DayName="Senin";
		elseif($DayName=="Tuesday") $DayName="Selasa";
		elseif($DayName=="Wednesday") $DayName="Rabu";
		elseif($DayName=="Thursday") $DayName="Kamis";
		elseif($DayName=="Friday") $DayName="Jumat";
		elseif($DayName=="Saturday") $DayName="Sabtu";
		echo $DayName;
		
	}
	
	function BulanIndo($MonthName){
		if($MonthName=="January") $MonthName="Januari";
		elseif($MonthName=="February") $MonthName="Februari";
		elseif($MonthName=="March") $MonthName="Maret";
		elseif($MonthName=="April") $MonthName="April";
		elseif($MonthName=="May") $MonthName="Mei";
		elseif($MonthName=="June") $MonthName="Juni";
		elseif($MonthName=="July") $MonthName="Juli";
		elseif($MonthName=="August") $MonthName="Agustus";
		elseif($MonthName=="September") $MonthName="September";
		elseif($MonthName=="October") $MonthName="Oktober";
		elseif($MonthName=="November") $MonthName="Nop";
		elseif($MonthName=="December") $MonthName="Desember";
		return $MonthName;
	}
	
	//DateTimeMonthIndo(date('l, d M Y H:i:s'));
	
	function DateTimeMonthIndo($param){
		$param = explode(',',$param);
		$day = DayIndo($param[0]);
		
		$slice2 = explode(' ',BulanIndo($param[1]));
		$Month = BulanIndo($slice2[2]);
		return $day.', '.$slice2[1].' '.$Month.' '.$slice2[3];
	}
	
	/*function create url-friendly*/
	function CreateUrl($id,$title){
		$search = array(' ','"');
		$x = str_replace($search,'-',$title);
		return 'news/view/'.$id.'-'.$x.'.html';
	}	
	/*category url*/
	
	/*function get extract id*/
	function GetId($str){		
		$str = explode('-',$str);
		$id = $str[0];		
		if($id=='0'|| is_numeric($id)==false){
			return header("location:".base_url());
		}else{
			return $id;
		}
	}
	function AddStrip($str){
		return $str = str_replace(' ','-',$str);
	}
	function RemoveStrip($str){
		return $str = str_replace('-',' ',$str);
	}
	function GetName($str){
		if($str=='0'|| is_numeric($str)==true || $str<0){
			return header("location:".base_url());
		}else{
			return $str;
		}
	}
	function PreviewNews($ContentNews,$length){
		$slice = explode(" ",$ContentNews);
		if(count($slice) > $length){
			$PreviewNews = '';
			for($a = 0; $a < $length; $a++){
				$PreviewNews .= $slice[$a].' ';
			}
			return strip_tags($PreviewNews,'<b>').' ';
		}else{
			return $ContentNews;
		}
	}
	
	
	function ShowThumbnail($thumbnail){
		if($thumbnail==''){
			return false;
		}else{
			echo "<img src=".$thumbnail." style='width:150px;height:100px; float:left; margin:4px 10px 5px 0px; border:1px solid #ccc; padding:4px;'/>";
		}
	}
	function get_image($string){
		preg_match('/<img([ alt="alt"]*?) src="([a-zA-Z0-9._:\-\/]+)"([ alt="alt"]*?)(\/?)>/i',$string,$matches);
		
		foreach($matches AS $match){
			if(preg_match('/(.jpg|jpeg|.gif|.png)$/i',$match)){
				return $match;
				break;
			}
		}
	}
	function FindImage($ContentNews){
		$slice = explode("<img",$ContentNews);
		echo $slice[0];
	}
	function Flag($flag){
		if($flag == '1'){
			echo "<img src='".base_url()."assets/backend/img/check_list.png"."'/>";
		}else{
			echo "<img src='".base_url()."assets/backend/img/cross.png"."'/>";
		}
	}
	function Approve($flag){
		if($flag == '1'){
			echo "<img src='".base_url()."assets/backend/img/thumb_up.png"."'/>";
		}else{
			echo "<img src='".base_url()."assets/backend/img/thumb_down.png"."'/>";
		}
	}
	/*file manager*/
	function DisplayFileSize($filesize){   
		if(is_numeric($filesize)){
		$decr = 1024; $step = 0;
		$prefix = array('Byte','KB','MB','GB','TB','PB');
		   
		while(($filesize / $decr) > 0.9){
			$filesize = $filesize / $decr;
			$step++;
		}
		return round($filesize,1).' '.$prefix[$step];
		} else {
			return '0'; //nan
		}   
	}
	
	/*get title news*/
	function GetTitleNews($Id,$TitleNews){
		return $Url = base_url().'news/view/'.$Id.'-'.$TitleNews.'.html';
	}
	/*random string*/
	
	function RandString($length){
		$str = '';
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
		$size = strlen($chars);
		for($i=0; $i<$length;$i++){
			$str .= $chars[rand(0,$size-1)];
		}
		return $str;
	}
	function GetUrl() {
		  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
		  $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
		  $url .= $_SERVER["REQUEST_URI"];
		  return $url;
	}
	function getTwitterStatus($userid){
	$url = "http://twitter.com/statuses/user_timeline/$userid.xml?count=1";

	$xml = simplexml_load_file($url) or die("could not connect");

		   foreach($xml->status as $status){
		   $text = $status->text;
		   }
		   echo $text;
	}
	function CheckEmail($email) {
		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
			return true;
		}
			return false;
	}

	function copyright($year = 'auto'){ 
		if(intval($year) == 'auto'){ $year = date('Y'); } 
		if(intval($year) == date('Y')){ echo intval($year); } 
		if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); } 
		if(intval($year) > date('Y')){ echo date('Y'); } 
	}
	function FlagComment($value){
		if($value == 1){
			echo "<img src='".base_url()."assets/frontend/icons/comment.png"."'/>";
		}
	}
	function GetPathRoot(){
		$path = base_url();
		$expl = explode('/',$path);
		return $expl[0].$expl[1].'//'.$expl[2].'/'.$expl[3];
	}
	function GetPathInfo(){
		if(!isset($_SERVER['PATH_INFO'])){
			return false;
		}else{
			return GetPathRoot().$_SERVER['PATH_INFO'];
		}
	}
	
	function GetSafe($param){
		$param = stripslashes($param);
		$param = mysql_real_escape_string($param);
		return $param;
	}
	function EscapeQuote($param){
		$char = array('/"/',"/'/");
		$replacement = '"';
		$str = preg_replace($char,$replacement,$param);
		return $str;
	}
	function GetEncrypt($param){
		
	}
	function GetDecrypt($param){
		
	}
	function GetHeadTitle(){
		if(GetPathInfo() ==''){
			echo "Portal Informasi Pemerintah Daerah Kabupaten Merauke";
		}
	}
	function CheckSession($NamaUser,$LevelUser){
		if($NamaUser =='' || $LevelUser ==''){
			return false;
		}else{
			return true;
		}
	}
	function RemoveAreaCode($NoTelp){
		if(preg_match("/^[+]/",$NoTelp)){
			return '0'.substr($NoTelp,3);
		}else{
			return $NoTelp;
		}
	}
	function rand_string( $length ) {
		$chars = "#$%@*&^+-=abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	function generate_random_user(){
	
		
		//generate random user
		$consts='bcdhgklmnprstvwxyz';
        $vowels='aeiou';
        
		$num= (mt_rand(5, 15));
		
		for ($x=0; $x < 6; $x++) {
			$const[$x] = substr($consts,mt_rand(0,strlen($consts)-1),1);
            $vow[$x] = substr($vowels,mt_rand(0,strlen($vowels)-1),1);
		}
	
		$username = ($const[0] . $vow[0] .$const[2] . $const[1] . $vow[1] . $const[3] . $num);
		
		
		//generate random password
		$consts='bcdgklmnprst';
		$vowels='aeiou';

		for ($x=0; $x < 6; $x++) {
		//	mt_srand ((double) microtime() * 1000000); // no longer required
		$const[$x] = substr($consts,mt_rand(0,strlen($consts)-1),1);
		$vow[$x] = substr($vowels,mt_rand(0,strlen($vowels)-1),1);
		}
		
		$password = ($const[0] . $vow[0] .$const[2] . $const[1] . $vow[1] . $const[3] . $vow[3] . $const[4]);
		
		$user['username'] = $username;
		$user['password'] = $password;
		
	
	
		return $user;
	}

?>