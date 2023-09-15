<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_page {
	
    function CreatePage($NoPage,$TotalData,$TotalPage,$RecordPerPage,$Perintah){
		//$NoPage = 5;
		//$TotalPage = 10;
		$ShowPage = 0;
		?>
		<ul class="pagination">
		
		<?php
		if($NoPage>1){
			$prev = $NoPage - 1;
			?>	
			<li><a href="javascript:<?=$Perintah;?>('<?=$prev;?>','<?=$RecordPerPage;?>');" title="sebelum">&#171; sebelum</a></li>
			<?php
		}
		//render no urut page
		for($pages =1; $pages <=$TotalPage; $pages++){
			if((($pages >= $NoPage - 1) && ($pages <= $NoPage + 5)) || ($pages == 1) || ($pages == $TotalPage)){									
				//if(($ShowPage == 1) && ($pages != 2)) echo ' ... ';
				if(($ShowPage != ($TotalPage - 1)) && ($pages == $TotalPage)) echo ' <li> <a href="#">...</a></li>';
				//currentpage
				if($pages == $NoPage) echo '<li class="active" ><a href="#">'.$pages.'</a> </li>';
				//regularpage
				else{
				?>		
				<li> <a href="javascript: <?=$Perintah;?>('<?=$pages;?>','<?=$RecordPerPage;?>');" title="go to page <?=$pages;?>"><?=$pages;?></a></li>
				<?php
				}
			}								
		}
		//next
		if($NoPage < $TotalPage){
			$next = $NoPage + 1;
		?>
			<li> <a href="javascript: <?=$Perintah;?>('<?=$next;?>','<?=$RecordPerPage;?>');" title="sesudah">sesudah &#187; </a></li>
			
		<?php
		}	
		?>
		</ul>
		<?php
    }
	
}

?>