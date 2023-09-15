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
        <li class="active">Kategori Telepon Penting</li>
      </ol>
      <h1 class="page-title">Kategori Telepon Penting</h1>
			 <div class="page-header-actions">
			  <button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" 
        data-original-title="Kategori baru" onclick="CategoryCreate();">
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
				
						
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>KATEGORI</th>	
									<th>DESKRIPSI</th>		
									<th>TANGGAL</th>				
									<th class="text-center">PUBLISH</th>
									<th class="text-center col-md-2">OPSI</th>															
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th>KATEGORI</th>	
									<th>DESKRIPSI</th>		
									<th>TANGGAL</th>				
									<th class="text-center">PUBLISH</th>
									<th class="text-center col-md-2">OPSI</th>																	
								</tr>
							</tfoot>
						</table>
				
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
				<h4 class="modal-title" id="myModalLabel">Kategori Baru</h4>
				</div>
				<div class="modal-body">					
					
						<form class="form-horizontal" name="FormCategoryCreate" id="FormCategoryCreate" method="POST">
						
							<div class="form-group">
								<label class="col-sm-3 control-label">Kategori</label>
								<div class="col-sm-9">
									<input type="text" name="NameCategory" id="NameCategory" placeholder="Nama kategori" class="form-control tooltip-right" title="Nama kategori"/>					
								</div>
							</div>
								<div class="form-group">
								<label class="col-sm-3 control-label">Deskripsi</label>
								<div class="col-sm-9">
									<textarea type="text" name="Description" id="Description" placeholder="Deskripsi" class="form-control tooltip-right" title="Deskripsi"/></textarea>					
								</div>
							</div>
						
							<div class="form-group">
								<label for="Pilihan"  class="col-sm-3 control-label">Opsi</label>
								<div class="col-sm-5">
									<div class="form-control no-line no-left-padding">
										<input type='checkbox' class="form-inline uniformcheckbox" autocomplete="off" id="FlagPublish" name="FlagPublish"> Publish &nbsp;
								  	
									</div>
								</div>				
							</div>
						 
							
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
				
				
				</div>
				 <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
					<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
					</div>
			</form>	  		
			</div>
		</div>
	</div>
	
	<div class="modal fade modal-fade-in-scale-up" id="DialogCategoryEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Update Kategori</h4>
				</div>
				<div class="modal-body">
					
					
						<form class="form-horizontal" name="FormCategoryEdit" id="FormCategoryEdit" method="POST">
						
						
						
							<div class="form-group">
								<label class="col-sm-3 control-label">Kategori</label>
								<div class="col-sm-9">
									<input type="text" name="NameCategory" id="NameCategory" placeholder="Nama kategori" class="form-control tooltip-right" title="Judul slide"/>					
								</div>
							</div>
								<div class="form-group">
								<label class="col-sm-3 control-label">Deskripsi</label>
								<div class="col-sm-9">
									<textarea type="text" name="Description" id="Description" placeholder="Deskripsi" class="form-control tooltip-right" title="Deskripsi"/></textarea>					
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
						
					<input type="hidden" id="IdCategory" name="IdCategory"/>		
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
				
				
				</div>
				 <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
					<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
					</div>
			</form>	  		
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
				"url": "<?=base_url();?>backend/modules_telepon_penting/TeleponPentingCategoryList",
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
				{"data": 'Description'}, 				
				{"data": 'Time'}, 				
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
				 { "orderable": true, "targets": 3, 'sClass': 'text-center' },
				 { "orderable": true, "targets": 4, 'sClass': 'text-center' }
						
			],
			"order": [
				[2, "desc"]
			] 
		});				
		//------------------------------------------------------------------------------------//
		$("#FormCategoryCreate").validate({			
			rules: {
				NameCategory: {
					'required': true						
				},
				Description: {
					'required': true						
				}
			},
			messages: {
				NameCategory: {
					required: 'Nama kategori harus diisi'
				},
				Description: {
						required: 'Deskripsi harus diisi'		
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
										url: '<?=base_url();?>backend/modules_telepon_penting/ajax',
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
											if(respon.status=='gagal'){
												$.growl.warning({title:respon.status,message: respon.message});
												$("#FormCategoryCreate").find("#NameCategory").focus();												
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
		$("#Refresh").click(function(){MyTable.fnDraw();});
		//------------------------------------------------------------------------------------//
		$("#FormCategoryEdit").validate({			
			rules: {
				NameCategory: {
					'required': true						
				},
				Description: {
					'required': true						
				}
			},
			messages: {
				NameCategory: {
					required: 'Judul harus diisi'
				},
				Description: {
						required: 'Deskripsi harus diisi'		
				}
			}			
		});
		$("#FormCategoryEdit").submit(function(e){
			e.preventDefault();
			if($("#FormCategoryEdit").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin akan menyimpan galeri ini?",
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
										url: '<?=base_url();?>backend/modules_telepon_penting/ajax',
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
		$("#DialogUploadFile").on('shown.bs.modal',function(){
			$("#DialogUploadFile").find("#NameCategory").focus();
		});
		$("#DialogUploadFile").modal('show');
	}
	//------------------------------------------------------------------------------------//
	$("#FormUploadFile").validate({			
		rules: {
			NameCategory: {
				'required': true						
			},
			Description: {
				'required': true						
			}
		},
		messages: {
			NameCategory: {
				required: 'Judul slide harus diisi'
			},
			Description: {
				required: 'Deskripsi slide harus diisi'
			}
		}			
	});	
	$('#FormUploadFile').submit(function(){
			if($("#FormUploadFile").valid()){				
				myLoader.show();
				UploadProcess();
			}
	});
	
	function UploadProcess(){
		var timeout = setTimeout(function(){
			var status = $("#StatusUpload").html();
			var response = $("#ResponUpload").html();							
			var timeout = 5000;

			if(status=='process'){
				UploadProcess();
			}
			if(status=='sukses'){
				myLoader.hide();
				$("#ResponUpload").fadeIn();
				$("#ResponUpload").fadeOut();					
				$("#FormUploadFile").trigger("reset");
				$("#DialogUploadFile").modal('hide');								
				$.growl({title:'sukses',message:'Upload file'});
				$("#MyTable").dataTable().fnDraw();
				$("#FormUploadFile").trigger("reset");
				$("#StatusUpload").html('process');
			}
			if(status=='gagal'){
				myLoader.hide();
				$("#ResponUpload").fadeIn();								
				$("#UploadFile").val('');
				$.growl.error({title:'gagal',message:'Upload file gagal'});
				$("#StatusUpload").html('process');
			}							
		},timeout);
	}
	//------------------------------------------------------------------------------------//
	//------------------------------------------------------------------------------------//	
	function CategoryDelete(IdCategory){		
		bootbox.dialog({
			message: "Anda yakin akan menghapus file ini?",
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
							url: '<?=base_url();?>backend/modules_telepon_penting/ajax',
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
								if(respon.status=='gagal'){									
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
	function CategoryCreate(){
		$("#DialogCategoryCreate").on('shown.bs.modal', function(){
			$("#DialogCategoryCreate").find("#NameCategory").focus();
		});
		$("#DialogCategoryCreate").modal('show');
	}
	//------------------------------------------------------------------------------------//
	function CategoryEdit(IdCategory){		
		$.ajax({
			url: '<?=base_url();?>backend/modules_telepon_penting/ajax',
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
						$("#FormCategoryEdit").find("#Description").val(element.Description);
						$("#FormCategoryEdit").find("#IdCategory").val(element.IdCategory);
						var FlagPublish = element.FlagPublish;
						if(FlagPublish == 1){
							$("#FormCategoryEdit").find("#FlagPublish").prop("checked", true).change();
							$.uniform.update();
						}
					
					});
					$("#FormCategoryEdit").on('shown.bs.modal', function(){
						$("#FormCategoryEdit").find("#NameCategory").focus();
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
	//------------------------------------------------------------------------------------//
	
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

