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
        <li><a href="<?=base_url();?>backend/modules_program_kegiatan">Program Kegiatan</a></li>
        <li class="active">Daftar Program Kegiatan </li>
      </ol>
      <h1 class="page-title">Program Kegiatan <a style="color:red;"><?=$namecategory;?></a></h1>
			 <div class="page-header-actions">
			 
        <button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" 
        data-original-title="Unggah file" onclick="ProgramKegiatanCreate();">
          <i class="icon wb-upload" aria-hidden="true"></i>
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
				
						<div class="alert alert-info">Ada (<?=$totalprogramkegiatan;?>) program kegiatan di kategori (<?=$namecategory;?>) ini </div>
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>								
									<th>FOTO</th>
									<th>TENTANG</th>
									<th>KATEGORI</th>
									<th>UKURAN</th>
									<th>TANGGAL</th>
									<th class="text-center">PUBLISH</th>
									<th class="text-center col-md-2">OPSI</th>
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th>FOTO</th>	
									<th>TENTANG</th>
									<th>KATEGORI</th>
									<th>UKURAN</th>
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

	<div class="modal fade modal-fade-in-scale-up" id="DialogUploadFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Unggah</h4>
				</div>
				<div class="modal-body">
					
					<iframe name="IFrameUploadFile" style="display:none;"></iframe>
						<form class="form-horizontal" name="FormUploadFile" id="FormUploadFile" method="POST" action="<?=base_url();?>backend/modules_program_kegiatan/UploadFile" enctype="multipart/form-data" target="IFrameUploadFile">
						
							
							<div class="form-group">
								<label class="col-sm-3 control-label"></label>
								<div class="col-sm-9">
									<div id="ResponUpload" style="display:none;"></div>
									<div id="StatusUpload" style="display:none;">process</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Kategori</label>
								<div class="col-sm-9">
									<input type="text" class="form-control tooltip-right" title="Kategori" value="<?=$namecategory;?>" readonly />					
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Tentang</label>
								<div class="col-sm-9">
									<textarea type="text" name="Tentang" id="Tentang" placeholder="Tentang" class="form-control tooltip-right" title="Tentang"/></textarea>					
								</div>
							</div>
							
							<div class="form-group">
								 <label class="col-sm-3 control-label">Opsi</label>
								 <div class="col-sm-9">
										<div class="form-control no-line no-left-padding">
											<input type='checkbox' class="form-inline uniformcheckbox" autocomplete="off" id="FlagPublish" name="FlagPublish" checked > Publish												
										</div>
								 </div>
							</div>	
							<div class="form-group">
								<label class="col-sm-3 control-label">Unggah File</label>
								<div class="col-sm-9">
									<input type="file" name="userfile" id="FileThumbnail" placeholder="Pilih file" class="form-control tooltip-right" title="Pilih file"/>					
								</div>
							</div>
						 
							<div class="form-group">
								 <label class="col-sm-3 control-label"></label>
								 <div class="col-sm-9">
										Format: .jpg, .jpeg, dan .png
								 </div>
							</div>
					<input type="hidden" name="IdCategory" id="IdCategory" value="<?=$idcategory;?>"/>
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
				
				
				</div>
				 <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
					<button type="submit" class="btn btn-primary" id="okButton"> Unggah </button>
					</div>
			</form>	  		
			</div>
		</div>
	</div>
	<div class="modal fade modal-fade-in-scale-up" id="DialogFileEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Update Program Kegiatan</h4>
				</div>
				<div class="modal-body">
					
					
						<form class="form-horizontal" name="FormFileEdit" id="FormFileEdit" method="POST">			
							
							<div class="form-group">
									<label for="kategori" class="col-sm-3 control-label">Kategori</label>
									<div class="col-sm-9">
										<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="IdCategory" id="IdCategory" data-toggle="tooltip" title="Kategori">										
											<?php
												foreach($programkegiatancategory as $row){
											?>
													<option value="<?=$row->IdCategory;?>"><?=$row->NameCategory;?></option>
											<?php
												}
											?>
										</select>
									</div>					
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Tentang</label>
								<div class="col-sm-9">
									<textarea type="text" name="Tentang" id="Tentang" placeholder="Tentang" class="form-control tooltip-right" title="Tentang"/></textarea>					
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Lokasi</label>
								<div class="col-sm-9">
									<input type="text" name="Fullpath" id="Fullpath" placeholder="Lokasi" class="form-control tooltip-right" title="Lokasi"/>					
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-3 control-label">Opsi</label>
								 <div class="col-sm-9">
										<div class="form-control no-line no-left-padding">
											<input type='checkbox' class="form-inline uniformcheckbox" autocomplete="off" id="FlagPublish" name="FlagPublish" > Publish												
										</div>
								 </div>
							</div>	
						
					<input type="hidden" name="IdProgram" id="IdProgram"/>
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
				"url": "<?=base_url();?>backend/modules_program_kegiatan/ProgramKegiatanList",
				"type": "POST",
				"data":{
					'IdCategory': '<?=$idprogramkegiatancategorylist;?>',
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
				{"data": 'Filename'}, //Filename
				{"data": 'Tentang'}, //Tentang
				{"data": 'Category'}, //Category
				{"data": 'Filesize'},
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
				 { "orderable": true, "targets": 1, 'sClass': 'text-center'},				
				 { "orderable": true, "targets": 2, 'sClass': 'text-center'},				 
				 { "orderable": true, "targets": 3 },				 
				 { "orderable": true, "targets": 4},
				 { "orderable": true, "targets": 5, 'sClass': 'text-center'}
				// { "orderable": true, "targets": 6, 'sClass': 'text-center' },
				//  { "orderable": true, "targets": 8, 'sClass': 'text-center' }
						
			],
			"order": [
				[4, "desc"]
			] 
		});				
		//------------------------------------------------------------------------------------//	
		$("#Refresh").click(function(){MyTable.fnDraw();});
		//------------------------------------------------------------------------------------//
		$("#FormFileEdit").validate({			
			rules: {
				Tentang: {
					'required': true						
				}
			},
			messages: {
				Tentang: {
						required: 'Tentang harus diisi'		
				}
			}			
		});
		$("#FormFileEdit").submit(function(e){
			e.preventDefault();
			if($("#FormFileEdit").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin akan menyimpan program ini?",
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
									var form = $("#FormFileEdit").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/modules_program_kegiatan/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=FileUpdate&'+form,
										success: function(respon){
											if(respon.status=='sukses'){																			
												$.growl({title:respon.status,message: respon.message});
												$("#DialogFileEdit").modal('hide');												
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
	function ProgramKegiatanCreate(){
		$("#DialogUploadFile").on('shown.bs.modal', function(){
			$("#DialogUploadFile").find("#Nomor").focus();
		});
		$("#DialogUploadFile").modal('show');
	}
	//------------------------------------------------------------------------------------//
	$("#FormUploadFile").validate({			
		rules: {
				Tentang: {
					'required': true						
				}
			},
			messages: {
				Tentang: {
						required: 'Tentang harus diisi'		
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
	function FileDelete(IdProgram){		
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
							url: '<?=base_url();?>backend/modules_program_kegiatan/ajax',
							type: 'POST',
							data: {
								'do':'FileDelete',
								'IdProgram':IdProgram,
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
	function FileEdit(IdProgram){		
		$.ajax({
			url: '<?=base_url();?>backend/modules_program_kegiatan/ajax',
			type: 'POST',
			data: {
				'do':'FileEdit',
				'IdProgram':IdProgram,
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
						$("#FormFileEdit").find("#Tentang").val(element.Tentang);
						$("#FormFileEdit").find("#IdProgram").val(element.IdProgram);
						$("#FormFileEdit").find("#Fullpath").val(element.Fullpath);
						$("#FormFileEdit").find("#IdCategory").val(element.IdCategory).change();
						var FlagPublish = element.FlagPublish;
						if(FlagPublish == 1){
							$("#FormFileEdit").find("#FlagPublish").prop("checked", true).change();
							$.uniform.update();
						}
					
					});
					$("#FormFileEdit").on('shown.bs.modal', function(){
						$("#FormFileEdit").find("#Nomor").focus();
					});
					$("#DialogFileEdit").modal('show');
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

