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
        <li class="active">Kategori Direktori Informasi</li>
      </ol>
      <h1 class="page-title">Daftar Kategori Direktori Informasi</h1>
			 <div class="page-header-actions">
        <button onclick="CategoryCreate();" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" <?=$RoleCategoryCreate;?> 
        data-original-title="Kategori Baru">
          <i class="icon wb-plus-circle" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
        data-original-title="Refresh" id="Refresh">
          <i class="icon wb-refresh" aria-hidden="true"></i>
        </button>        
      </div>
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">	
					<?php if($role['RoleCategoryView'] == 'yes'){ ;?>					
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>								
									<th class="col-md-3">NAMA KATEGORI</th>	
									<th>KETERANGAN</th>							
									<th class="text-center">PUBLISH</th>															
									<th class="text-center col-md-2">OPSI</th>															
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th class="col-md-3">NAMA KATEGORI</th>	
									<th>KETERANGAN</th>							
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
								<input type="hidden" id="IdCategory" name="IdCategory"/>
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
				"url": "<?=base_url();?>backend/category_directory_information/CategoryList",
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
				{"data": 'NameCategory'}, 
				{"data": 'NoteCategory'}, 
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
				 { "orderable": true, "targets": 2, 'sClass': 'text-center' },
				 { "orderable": false, "targets": 3, 'sClass': 'text-center' }
						
			],
			"order": [
				[0, "asc"]
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
									var form = $("#FormCategoryCreate").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/category_directory_information/ajax',
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
										url: '<?=base_url();?>backend/category_directory_information/ajax',
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
							url: '<?=base_url();?>backend/category_directory_information/ajax',
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
								if(respon.status=='halaman ada'){									
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
			url: '<?=base_url();?>backend/category_directory_information/ajax',
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



