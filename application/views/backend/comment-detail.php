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
        <li><a href="<?=base_url();?>backend/comment">Komentar</a></li>
        <li class="active">Detail</li>
      </ol>
      <h1 class="page-title">Detail Komentar</h1>
			 <div class="page-header-actions">       
             
      </div>
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">	
					<?php if($role['RoleCommentView'] == 'yes'){ ;?>		
						<?php
						if($comment !== null){
						?>
							<?php
							foreach($comment as $row){
							?>
								<form class="form-horizontal" name="FormCommentUpdate" id="FormCommentUpdate" method="POST">													
										<div class="form-group">
											<label for="CreatedNews" class="col-md-2 control-label">Judul</label>
											<div class="col-md-8">											
													<textarea class="form-control" readonly ><?=$row->TitleNews;?>	</textarea>
											</div>				
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Tanggal</label>
											<div class="col-md-4">
												<input type="text" name="DateComment" id="DateComment" placeholder="Tanggal" class="form-control tooltip-right" title="Tanggal" value="<?=DateTimeIndo($row->DateComment);?>" readonly />					
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Nama</label>
											<div class="col-md-4">
												<input type="text" name="NameComment" id="NameComment" placeholder="Nama" class="form-control tooltip-right" title="Nama" value="<?=$row->NameComment;?>"/>					
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Email</label>
											<div class="col-md-4">
												<input type="text" name="EmailComment" id="EmailComment" placeholder="Email" class="form-control tooltip-right" title="Email" value="<?=$row->EmailComment;?>"/>					
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Komentar</label>
											<div class="col-md-8">
												<textarea name="ContentComment" id="ContentComment" placeholder="Komentar" class="form-control tooltip-right" title="Komentar" rows="5"> <?=$row->ContentComment;?></textarea>
											</div>
										</div>
												<div class="form-group">
											<label for="CreatedNews" class="col-md-2 control-label">IP Address</label>
											<div class="col-md-4">											
													<input type='text' class="form-control" value="<?=$row->IpComment;?>" readonly >	
											</div>				
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Browser</label>
											<div class="col-md-8">
												<textarea class="form-control" readonly /> <?=$row->UserAgentComment;?></textarea>				
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Referer</label>
											<div class="col-md-8">
												<textarea class="form-control" readonly /> <?=$row->RefererComment;?></textarea>				
											</div>
										</div>	
										<div class="form-group">
											<label for="Pilihan"  class="col-md-2 control-label">Opsi</label>
											<div class="col-md-9">
													<?php											
														if($row->FlagPublish=='1'){$FlagPublish='checked';}else{$FlagPublish='';}										
													?>
													
													<div class="form-control no-line no-left-padding">
														<input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish" name="FlagPublish" <?=$FlagPublish;?> /> Publish &nbsp;											
													</div>
											</div>				
										</div>
										<input type="hidden" id="IdComment" name="IdComment" value="<?=$row->IdComment;?>"/>
										<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
																		
										<br/>
										<div class="form-group">
											<label class="col-md-2 control-label"></label>
											<div class="col-md-3">
												<button type="submit" class="btn btn-primary" id="okButton" <?=$RoleCommentUpdate;?> > Simpan </button>
												<a href="<?=base_url();?>backend/comment" class="btn btn-default"> Batal </a>
												
											</div>
										</div>
																			
									</form>
							<?php
							}
							?>
							
						<?php
						}else{
							$this->load->view('backend/no-data');
						}
						?>
					<?php }else{
						$this->load->view('backend/no-access');
					}?>
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
		var MyTable = $("#MyTable").dataTable({
			responsive: true,
			"language": {
				"aria": {
					"sortAscending": ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				},
				"emptyTable": "Tidak ada data di tabel",
				"info": "Tampilkan _START_ sampai _END_ dari _TOTAL_ data",
				"infoEmpty": "Tidak ada data ditemukan",
				"infoFiltered": "(filtered1 from _MAX_ total entries)",
				"lengthMenu": "Tampilkan _MENU_ data",		
				"zeroRecords": "Tidak ada data yang cocok",
				"search": "Cari: ",			
				"paginate": {
					"previous":"Sebelum",
					"next": "Berikut",
					"last": "Akhir",
					"first": "Awal"
				}
			},
			"bProcessing": true,
			"bServerSide": true,			
			"ajax": {
				"url": "<?=base_url();?>backend/comment/CommentList",
				"type": "POST",
				"data":{
					'<?=$this->security->get_csrf_token_name();?>' : '<?=$this->security->get_csrf_hash();?>'			
				},
				"error": function(){
					$.growl.error({title: 'Error', message: 'Ajax request'});
				}
			},
			"bStateSave": true, 	
			"fnDrawCallback": function( oSettings ) {
				//$("input:checkbox").uniform();
			},	
			"columns": [				
				{"data": 'DateComment'}, 
				{"data": 'NameComment'}, 
				{"data": 'EmailComment'},
				{"data": 'ContentComment'},
				{"data": 'TitleNews'},
				{"data": 'FlagPublish'},
				{"data": 'Option'}
			],			
			"lengthMenu": [
				[5, 10, 20, 50, 100],
				[5, 10, 20, 50, 100]
			],					
			"pageLength": 5,  
			
			"columnDefs": [
				 { "orderable": true, "targets": 0 },
				 { "orderable": true, "targets": 1 },
				 { "orderable": true, "targets": 2 },
				 { "orderable": true, "targets": 3 },
				 { "orderable": true, "targets": 4 },
				 { "orderable": true, "targets": 5, 'sClass': 'text-center' },
				 { "orderable": false, "targets": 6, 'sClass': 'text-center' }
						
			],
			"order": [
				[0, "desc"]
			] 
		});				
		//------------------------------------------------------------------------------------//
		$("#Refresh").click(function(){MyTable.fnDraw();});
		//------------------------------------------------------------------------------------//
		$("#FormCommentUpdate").validate({			
			rules: {
				NameComment: {
					'required': true						
				},
				Email: {
					'required': true,
					'email': true
				}
			},
			messages: {
				NameComment: {
					required: 'Nama harus diisi'
				},
				Email: {
						required: 'Email harus diisi',
						email: 'Email harus valid'
				}
			}			
		});
		$("#FormCommentUpdate").submit(function(e){
			e.preventDefault();
			if($("#FormCommentUpdate").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin akan menyimpan komentar ini?",
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
									var form = $("#FormCommentUpdate").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/comment/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=CommentUpdate&'+form,
										success: function(respon){
											if(respon.status=='sukses'){																		
												$.growl({title:respon.status,message: respon.message});
												setTimeout(function(){location.reload();},1000);
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
		});	
		//------------------------------------------------------------------------------------//		
		$("#FormCategoryEdit").validate({			
			rules: {
				NameCategory: {
					'required': true						
				},
				NoteCategory: {
					'required': true						
				}
			},
			messages: {
				NameCategory: {
					required: 'Nama kategori harus diisi'
				},
				NoteCategory: {
						required: 'Keterangan harus diisi'		
				}
			}			
		});
		$("#FormCategoryEdit").submit(function(e){
			e.preventDefault();
			if($("#FormCategoryEdit").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin akan menyimpan kategori ini?",
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
									var form = $("#FormCategoryEdit").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/category/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=CategoryUpdate&'+form,
										success: function(respon){
											if(respon.status=='sukses'){																			
												$.growl({title:respon.status,message: respon.message});
												$("#DialogCategoryEdit").modal('hide');												
												MyTable.fnDraw();
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
		});	
		//------------------------------------------------------------------------------------//
	});
	//------------------------------------------------------------------------------------//
	function CategoryCreate(){
		$("#DialogCategoryCreate").on('shown.bs.modal', function(){
			$("#FormCategoryCreate").find("#NameCategory").focus();
		});
		$("#DialogCategoryCreate").modal('show');			
	}
	//------------------------------------------------------------------------------------//	
	function CategoryDelete(IdCategory){		
		bootbox.dialog({
			message: "Anda yakin akan menghapus kategori ini?",
			title: "Konfirmasi",
			buttons: {				
				danger: {
					label: "No",
					className: "btn-default",
					callback: function(){}
				},
				main: {
					label: "Yes",
					className: "btn-primary",
					callback: function(){					
						$.ajax({
							url: '<?=base_url();?>backend/category/ajax',
							type: 'POST',
							data: {
								'do':'CategoryDelete',
								'IdCategory':IdCategory,
								'<?=$this->security->get_csrf_token_name();?>' : '<?=$this->security->get_csrf_hash();?>'			
							},
							dataType: 'json',					
							beforeSend: function(){
								//myLoader.show();
							},
							success: function(respon) {
								myLoader.hide();
								if(respon.status=='sukses'){
									$("#MyTable").dataTable().fnDraw();	
									$.growl({title:respon.status,message: respon.message});
								}
								if(respon.status=='berita ada'){									
									$.growl.warning({title:respon.status,message: respon.message});
								}
							},
							timeout: 20000,
							error:function(){
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
	function CategoryEdit(IdCategory){		
		$.ajax({
			url: '<?=base_url();?>backend/category/ajax',
			type: 'POST',
			data: {
				'do':'CategoryEdit',
				'IdCategory':IdCategory,
				'<?=$this->security->get_csrf_token_name();?>' : '<?=$this->security->get_csrf_hash();?>'			
			},
			dataType: 'json',					
			beforeSend: function(){
				//myLoader.show();
			},
			success: function(respon) {
				myLoader.hide();
				if(respon.status=='sukses'){
					$.each(respon.data, function(index, element){
						$("#FormCategoryEdit").find("#NameCategory").val(element.NameCategory);
						$("#FormCategoryEdit").find("#NoteCategory").val(element.NoteCategory);
						$("#FormCategoryEdit").find("#IdCategory").val(element.IdCategory);
						var FlagPublish = element.FlagPublish;
						if(FlagPublish == 1){
							$("#FormCategoryEdit").find("#FlagPublish").prop("checked", true).change();
							$.uniform.update();
						}
					});
					$("#DialogCategoryEdit").modal('show');
				}
				
			},
			timeout: 20000,
			error:function(){
				myLoader.hide();	
				$.growl.error({title: 'Error',message: 'Ajax request'});
			}	
		});						
	}
 </script>
<!----------------------------------------------------------------------------------------------------------------------------------------->



