<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header');?>
<body class="site-menubar-unfold site-menubar-keep">
		<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<?php $this->load->view('backend/navbar');?>
	<?php $this->load->view('backend/sidebar');?> 
  <!-- Page -->
  <div class="page">
    <div class="page-header">
			<ol class="breadcrumb">
        <li><a href="<?=base_url();?>backend">Dasbor</a></li>
        <li class="active">Komentar</li>
      </ol>
      <h1 class="page-title">Daftar Komentar</h1>
			 <div class="page-header-actions">       
        <button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
        data-original-title="Refresh" id="Refresh">
          <i class="icon wb-refresh" aria-hidden="true"></i>
        </button>        
      </div>
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">	
					<?php if($role['RoleCommentView'] == 'yes'){ ;?>					
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>								
									<th class="col-md-2">TANGGAL</th>	
									<th>NAMA</th>							
									<th>EMAIL</th>							
									<th>KOMENTAR</th>							
									<th>JUDUL</th>							
									<th class="text-center">PUBLISH</th>															
									<th class="text-center col-md-2">OPSI</th>															
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th class="col-md-2">TANGGAL</th>	
									<th>NAMA</th>							
									<th>EMAIL</th>							
									<th>KOMENTAR</th>							
									<th>JUDUL</th>							
									<th class="text-center">PUBLISH</th>															
									<th class="text-center col-md-2">OPSI</th>															
								</tr>
							</tfoot>
						</table>
					<?php }else{
						$this->load->view('backend/no-access');
					}?>
				</div>
			</div>
				<div class="panel">			
				<div class="panel-body">
						<h4>Keterangan</h4>
						<div class="list-group">
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img src="<?=base_url();?>assets/backend/images/publish.png"/> Publish</h4>
								<p class="list-group-item-text">Komentar sudah dipublish</p>
							</a>
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img src="<?=base_url();?>assets/backend/images/draft.png"/> Draft</h4>
								<p class="list-group-item-text">Komentar masih draft</p>
							</a>							
						</div>				
				</div>
			</div>	
    </div>
  </div>
  <!-- End Page -->
	<div class="modal fade modal-fade-in-scale-up" id="DialogCategoryCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Kategori</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormCategoryCreate" id="FormCategoryCreate" method="POST">													
								<div class="form-group">
									<label class="col-sm-3 control-label">Nama Kategori</label>
									<div class="col-sm-9">
										<input type="text" name="NameCategory" id="NameCategory" placeholder="Nama kategori" class="form-control tooltip-right" title="Nama kategori"/>					
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Keterangan</label>
									<div class="col-sm-9">
										<textarea name="NoteCategory" id="NoteCategory" placeholder="Keterangan" class="form-control tooltip-right" title="Keterangan"/></textarea>					
									</div>
								</div>
								<div class="form-group">
									 <label class="col-sm-3 control-label">Opsi</label>
									 <div class="col-sm-9">
											<div class="form-control no-line no-left-padding">
												<input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish" name="FlagPublish"> Publish												
											</div>
									 </div>
								</div>								
								<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
									<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
								</div>
						</form>
					</div>	  		
			</div>
		</div>
	</div>
	
	<div class="modal fade modal-fade-in-scale-up" id="DialogCategoryEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Kategori</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormCategoryEdit" id="FormCategoryEdit" method="POST">													
								<div class="form-group">
									<label class="col-sm-3 control-label">Nama Kategori</label>
									<div class="col-sm-9">
										<input type="text" name="NameCategory" id="NameCategory" placeholder="Nama kategori" class="form-control tooltip-right" title="Nama kategori"/>					
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Keterangan</label>
									<div class="col-sm-9">
										<textarea name="NoteCategory" id="NoteCategory" placeholder="Keterangan" class="form-control tooltip-right" title="Keterangan"/></textarea>					
									</div>
								</div>
								<div class="form-group">
									 <label class="col-sm-3 control-label">Opsi</label>
									 <div class="col-sm-9">
											<div class="form-control no-line no-left-padding">
												<input type='checkbox' autocomplete="off" class="form-inline uniformcheckbox" id="FlagPublish" name="FlagPublish"> Publish												
											</div>
									 </div>
								</div>
								<input type="hidden" id="IdComment" name="IdComment"/>
								<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
									<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
								</div>
						</form>
					</div>	  		
			</div>
		</div>
	</div>
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
		$("#FormCategoryCreate").validate({			
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
		$("#FormCategoryCreate").submit(function(e){
			e.preventDefault();
			if($("#FormCategoryCreate").valid()){				
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
									var form = $("#FormCategoryCreate").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/comment/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=CategoryCreate&'+form,
										success: function(respon){
											if(respon.status=='sukses'){																			
												$.growl({title:respon.status,message: respon.message});
												$("#DialogCategoryCreate").modal('hide');
												$("#FormCategoryCreate").trigger("reset");	
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
									var form = $("#FormCategoryEdit").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/comment/ajax',
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
	function CommentDelete(IdComment){		
		bootbox.dialog({
			message: "Anda yakin akan menghapus komentar ini?",
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
							url: '<?=base_url();?>backend/comment/ajax',
							type: 'POST',
							data: {
								'do':'CommentDelete',
								'IdComment':IdComment,
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
	
 </script>
<!----------------------------------------------------------------------------------------------------------------------------------------->



