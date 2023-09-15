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
        <li class="active">Backup Database</li>
      </ol>
      <h1 class="page-title">Backup Database</h1>
			
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">	
					<dl class="dl-horizontal">							
						<dt>Backup database</dt>
						<dd>									
								<button class="btn btn-primary" onclick="BackupDatabase();" <?php if($role['RoleToolsBackupDatabase']=='no'){echo 'disabled';}?>><i class="fa fa-database"></i> Backup Sekarang</button>																		
						</dd>
					</dl>
				</div>
			</div>
			
    </div>
  </div>
  <!-- End Page -->
 <?php $this->load->view('backend/footer');?>
 <script>
	//------------------------------------------------------------------------------------//
	$(function(){
		//------------------------------------------------------------------------------------//
		
		//------------------------------------------------------------------------------------//
	});
	//------------------------------------------------------------------------------------//
	function BackupDatabase(){
		bootbox.dialog({
			message: "Apakah anda yakin akan membackup database ini?",
			title: "Konfirmasi",
			buttons: {				
				danger: {
					label: "No",
					className: "btn-default",
					callback: function(){
						
					}
				},
				main: {
					label: "Yes",
					className: "btn-primary",
					callback: function() {							
							$.ajax({
								url: '<?=base_url();?>backend/tools/ajax',
								type: 'POST',
								dataType: 'json',
								data:{
									'do':'BackupDatabase',
									'<?=$this->security->get_csrf_token_name();?>' : '<?=$this->security->get_csrf_hash();?>'	
								},
								success: function(respon){
									if(respon.status=='requestbackup'){																			
										$.growl({title:respon.status,message: respon.message});
										setTimeout(function(){
											window.location='<?=base_url();?>backend/tools/request_backup_database';
										},1000);	
									}											
								},
								timeout: 20000,
								error: function(){
									myLoader.hide();
									$.growl.error({title: 'Error',message: 'Ajax request'});
								}
							});								
					}
				}
			}				
		});	
	}
	//------------------------------------------------------------------------------------//
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

