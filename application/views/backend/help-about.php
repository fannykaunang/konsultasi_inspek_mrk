<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header');?>
<body class="site-menubar-unfold site-menubar-keep">
		<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<?php $this->load->view('backend/navbar');?>
	<?php $this->load->view('backend/sidebar');?> 
  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
			<ol class="breadcrumb">
        <li><a href="<?=base_url();?>backend">Dasbor</a></li>
        <li class="active">Bantuan</li>
      </ol>
      <h1 class="page-title">Tentang Aplikasi</h1>
			 
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">	
					<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<center>
									<!--<img src="<?=base_url();?>assets/admin/layout4/img/jageradius100.png" alt=""/>-->
									<h2><?=$this->app_info_model->AppName();?> <?=$this->app_info_model->AppVersion();?> </h2> <span><a href="#changelog" id="changelog">changelog</a></span>
									<h4> &copy <?=$this->app_info_model->AppYear();?> <?=$this->app_info_model->AppCopyright();?></h4>
								</center>
							</div>
							<div class="col-md-4"></div>
						</div>
				</div>
			</div>
			
    </div>
  </div>
  <!-- End Page -->
	<div class="modal fade" id="DialogChangelog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Changelog</h4>
		  </div>
		  <div class="modal-body">
				<?php $this->load->view('backend/changelog');?>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
		  </div>
		 
		</div>
	  </div>
	</div>
 <?php $this->load->view('backend/footer');?>
 <script>
	//------------------------------------------------------------------------------------//
	$(function(){
		//------------------------------------------------------------------------------------//
			$("#changelog").click(function(){
				$("#DialogChangelog").modal('show');
			});
		//------------------------------------------------------------------------------------//
	});
	//------------------------------------------------------------------------------------//
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->