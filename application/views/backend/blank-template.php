<?=$this->load->view('backend/header');?>
<body class="site-menubar-unfold site-menubar-keep">
		<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<?=$this->load->view('backend/navbar');?>
	<?=$this->load->view('backend/sidebar');?> 
  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
			<ol class="breadcrumb">
        <li><a href="<?=base_url();?>backend">Dasbor</a></li>
        <li class="active">Berita</li>
      </ol>
      <h1 class="page-title">Daftar Berita</h1>
			 <div class="page-header-actions">
        <a href="<?=base_url();?>backend/news/add" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
        data-original-title="Berita Baru" id="AddNews">
          <i class="icon wb-plus-circle" aria-hidden="true"></i>
        </a>
        <button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
        data-original-title="Refresh" id="Refresh">
          <i class="icon wb-refresh" aria-hidden="true"></i>
        </button>        
      </div>
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">	
					
				</div>
			</div>
			<div class="panel">			
				<div class="panel-body">
								
				</div>
			</div>
    </div>
  </div>
  <!-- End Page -->
 <?=$this->load->view('backend/footer');?>
 <script>
	//------------------------------------------------------------------------------------//
	$(function(){
		//------------------------------------------------------------------------------------//
		
		//------------------------------------------------------------------------------------//
	});
	//------------------------------------------------------------------------------------//
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

