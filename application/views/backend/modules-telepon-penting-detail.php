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
        <li><a href="<?=base_url();?>backend/modules_telepon_penting">Telepon Penting</a></li>
        <li class="active">Daftar Telepn Penting</li>
      </ol>
      <h1 class="page-title">Telepon Penting</h1>
			 <div class="page-header-actions">
			 
        <button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" 
        data-original-title="Telepon penting baru" onclick="TeleponPentingCreate();">
          <i class="icon wb-pencil" aria-hidden="true"></i>
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
				
						<div class="alert alert-info">Ada (<?=$totalteleponpenting;?>) telepon penting di kategori (<?=$namecategory;?>) ini </div>
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>								
									<th>NAMA</th>	
									<th>ALAMAT</th>	
									<th>NOMOR TELEPON</th>
									<th>KATEGORI</th>														
									<th>TANGGAL</th>														
									<th class="text-center">PUBLISH</th>
									<th class="text-center col-md-2">OPSI</th>															
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th>NAMA</th>	
									<th>ALAMAT</th>	
									<th>NOMOR TELEPON</th>
									<th>KATEGORI</th>														
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

	<div class="modal fade modal-fade-in-scale-up" id="DialogTeleponPentingCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Telepon Penting Baru</h4>
				</div>
				<div class="modal-body">
					
						<form class="form-horizontal" name="FormTeleponPentingCreate" id="FormTeleponPentingCreate" method="POST">
						
							<div class="form-group">
								<label class="col-sm-3 control-label">Kategori</label>
								<div class="col-sm-9">
									<input type="text" class="form-control tooltip-right" title="Kategori" value="<?=$namecategory;?>" readonly />					
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama Instansi</label>
								<div class="col-sm-9">
									<input type="text" name="Name" id="Name" placeholder="Nama instansi" class="form-control tooltip-right" title="Nama instansi"/>					
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-3 control-label">Alamat</label>
								<div class="col-sm-9">
									<textarea type="text" name="Address" id="Address" placeholder="Alamat" class="form-control tooltip-right" title="Alamat"/></textarea>					
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nomor Telepon</label>
								<div class="col-sm-4">
									<input type="text" name="NoTelp" id="NoTelp" placeholder="Nomor telepon" class="form-control tooltip-right" title="Nomor telepon"/>					
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
						
					<input type="hidden" name="IdCategory" id="IdCategory" value="<?=$idcategory;?>"/>
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
	<div class="modal fade modal-fade-in-scale-up" id="DialogTeleponPentingEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Update Telepon Penting</h4>
				</div>
				<div class="modal-body">
					
						<form class="form-horizontal" name="FormTeleponPentingEdit" id="FormTeleponPentingEdit" method="POST">
							<div class="form-group">
										<label class="col-sm-3 control-label">Kategori</label>
									<div class="col-sm-9">										
										<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="IdCategory" id="IdCategory" data-toggle="tooltip" title="Kategori">										
											<?php
												foreach($teleponpentingcategory as $row){
											?>
													<option value="<?=$row->IdCategory;?>"><?=$row->NameCategory;?></option>
											<?php
												}
											?>
										</select>
									</div>	
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama Instansi</label>
								<div class="col-sm-9">
									<input type="text" name="Name" id="Name" placeholder="Nama instansi" class="form-control tooltip-right" title="Nama instansi"/>					
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-3 control-label">Alamat</label>
								<div class="col-sm-9">
									<textarea type="text" name="Address" id="Address" placeholder="Alamat" class="form-control tooltip-right" title="Alamat"/></textarea>					
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nomor Telepon</label>
								<div class="col-sm-4">
									<input type="text" name="NoTelp" id="NoTelp" placeholder="Nomor telepon" class="form-control tooltip-right" title="Nomor telepon"/>					
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
						
					<input type="hidden" name="IdFile" id="IdFile"/>
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
				"url": "<?=base_url();?>backend/modules_telepon_penting/TeleponPentingList",
				"type": "POST",
				"data":{
					'IdCategory': '<?=$idteleponpentingcategorylist;?>',	
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
				{"data": 'Name'}, 
				{"data": 'Address'}, 
				{"data": 'NoTelp'},								
				{"data": 'Category'},			
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
				 { "orderable": true, "targets": 3 },	
				 { "orderable": true, "targets": 4 },
				 { "orderable": true, "targets": 5, 'sClass': 'text-center' },
				 { "orderable": true, "targets": 6, 'sClass': 'text-center' }
						
			],
			"order": [
				[4, "desc"]
			] 
		});				
		//------------------------------------------------------------------------------------//	
		$("#Refresh").click(function(){MyTable.fnDraw();});
		//------------------------------------------------------------------------------------//
		
		$("#FormTeleponPentingCreate").validate({			
			rules: {
					Name: {
						'required': true						
					},				
					Address: {
						'required': true						
					}
				},
				messages: {
					Name: {
						required: 'Nama harus diisi'
					},			
					Address: {
							required: 'Alamat harus diisi'		
					}
				}			
		});	
		$("#FormTeleponPentingCreate").submit(function(e){
				e.preventDefault();
				if($("#FormTeleponPentingCreate").valid()){				
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan nomor telepon ini?",
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
										var form = $("#FormTeleponPentingCreate").serialize();
										$.ajax({
											url: '<?=base_url();?>backend/modules_telepon_penting/ajax',
											type: 'POST',
											dataType: 'json',
											data:'do=TeleponPentingCreate&'+form,
											success: function(respon){
												if(respon.status=='sukses'){																			
													$.growl({title:respon.status,message: respon.message});
													$("#DialogTeleponPentingCreate").modal('hide');
													$("#FormCreateteleponPenting").trigger("reset");	
														MyTable.fnDraw();												
												}
												if(respon.status=='gagal'){
													$.growl.warning({title:respon.status,message: respon.message});
													$("#FormCreateteleponPenting").find("#Name").focus();												
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
		$("#FormTeleponPentingEdit").validate({			
			rules: {
				Name: {
					'required': true						
				},				
				Address: {
					'required': true						
				}
			},
			messages: {
				Name: {
					required: 'Nama harus diisi'
				},			
				Address: {
						required: 'Alamat harus diisi'		
				}
			}			
		});
		$("#FormTeleponPentingEdit").submit(function(e){
			e.preventDefault();
			if($("#FormTeleponPentingEdit").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin akan menyimpan telepon penting ini?",
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
									var form = $("#FormTeleponPentingEdit").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/modules_telepon_penting/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=TeleponPentingUpdate&'+form,
										success: function(respon){
											if(respon.status=='sukses'){																			
												$.growl({title:respon.status,message: respon.message});
												$("#DialogTeleponPentingEdit").modal('hide');												
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
	function TeleponPentingCreate(){
		$("#DialogTeleponPentingCreate").on('shown.bs.modal', function(){
			$("#DialogTeleponPentingCreate").find("#Name").focus();
		});
		$("#DialogTeleponPentingCreate").modal('show');
	}
	
	
	
	//------------------------------------------------------------------------------------//
	//------------------------------------------------------------------------------------//	
	function TeleponPentingDelete(IdFile){		
		bootbox.dialog({
			message: "Anda yakin akan menghapus telepon penting ini?",
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
								'do':'TeleponPentingDelete',
								'IdFile':IdFile,
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
	function TeleponPentingEdit(IdFile){		
		$.ajax({
			url: '<?=base_url();?>backend/modules_telepon_penting/ajax',
			type: 'POST',
			data: {
				'do':'TeleponPentingEdit',
				'IdFile':IdFile,
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
						$("#FormTeleponPentingEdit").find("#Name").val(element.Name);
						$("#FormTeleponPentingEdit").find("#Address").val(element.Address);
						$("#FormTeleponPentingEdit").find("#NoTelp").val(element.NoTelp);
						$("#FormTeleponPentingEdit").find("#IdFile").val(element.IdFile);
						$("#FormTeleponPentingEdit").find("#IdCategory").val(element.IdCategory).change();
						var FlagPublish = element.FlagPublish;
						if(FlagPublish == 1){
							$("#FormTeleponPentingEdit").find("#FlagPublish").prop("checked", true).change();
							$.uniform.update();
						}
					
					});
					$("#FormTeleponPentingEdit").on('shown.bs.modal', function(){
						$("#FormTeleponPentingEdit").find("#Name").focus();
					});
					$("#DialogTeleponPentingEdit").modal('show');
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

