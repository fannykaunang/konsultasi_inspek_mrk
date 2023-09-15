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
        <li class="active">Captcha</li>
      </ol>
      <h1 class="page-title">Daftar Captcha</h1>
			 <div class="page-header-actions">
				 <button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" <?=$RoleCaptchaCreate;?>
        data-original-title="Captca Baru" onclick="CaptchaCreate();">
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
					<?php if($role['RoleCommentView'] == 'yes'){ ;?>					
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>	
									<th>PERTANYAAN</th>							
									<th>JAWABAN</th>							
									<th class="text-center col-md-2">OPSI</th>															
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th>PERTANYAAN</th>							
									<th>JAWABAN</th>									
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
	<div class="modal fade modal-fade-in-scale-up" id="DialogCaptchaCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Captcha</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormCaptchaCreate" id="FormCaptchaCreate" method="POST">													
								<div class="form-group">
									<label class="col-sm-3 control-label">Pertanyaan</label>
									<div class="col-sm-9">
										<textarea name="Question" id="Question" placeholder="Pertanyaan" class="form-control tooltip-right" title="Pertanyaan"/></textarea>				
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Jawaban</label>
									<div class="col-sm-9">
										<input type="text" name="Answer" id="Answer" placeholder="Jawaban" class="form-control tooltip-right" title="Jawaban"/>					
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
	
	<div class="modal fade modal-fade-in-scale-up" id="DialogCaptchaEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Edit Captcha</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormCaptchaEdit" id="FormCaptchaEdit" method="POST">													
								<div class="form-group">
									<label class="col-sm-3 control-label">Pertanyaan</label>
									<div class="col-sm-9">
										<textarea name="Question" id="Question" placeholder="Pertanyaan" class="form-control tooltip-right" title="Pertanyaan"/></textarea>				
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Jawaban</label>
									<div class="col-sm-9">
										<input type="text" name="Answer" id="Answer" placeholder="Jawaban" class="form-control tooltip-right" title="Jawaban"/>					
									</div>
								</div>
								<input type="hidden" id="IdCaptcha" name="IdCaptcha"/>			
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
				"url": "<?=base_url();?>backend/captcha/CaptchaList",
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
				{"data": 'Question'}, 
				{"data": 'Answer'},
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
				 { "orderable": true, "targets": 2, 'sClass': 'text-center' }						
			],
			"order": [
				[0, "desc"]
			] 
		});				
		//------------------------------------------------------------------------------------//
		$("#Refresh").click(function(){MyTable.fnDraw();});
		//------------------------------------------------------------------------------------//
		$("#FormCaptchaCreate").validate({			
			rules: {
				Question: {
					'required': true						
				},
				Answer: {
					'required': true						
				}
			},
			messages: {
				Question: {
					required: 'Pertanyaan harus diisi'
				},
				Answer: {
						required: 'Jawaban harus diisi'		
				}
			}			
		});
		$("#FormCaptchaCreate").submit(function(e){
			e.preventDefault();
			if($("#FormCaptchaCreate").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin akan menyimpan catpcha ini?",
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
									var form = $("#FormCaptchaCreate").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/captcha/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=CaptchaCreate&'+form,
										success: function(respon){
											if(respon.status=='sukses'){																			
												$.growl({title:respon.status,message: respon.message});
												$("#DialogCaptchaCreate").modal('hide');
												$("#FormCaptchaCreate").trigger("reset");	
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
		$("#FormCaptchaEdit").validate({			
			rules: {
				Question: {
					'required': true						
				},
				Answer: {
					'required': true						
				}
			},
			messages: {
				Question: {
					required: 'Pertanyaan harus diisi'
				},
				Answer: {
						required: 'Jawaban harus diisi'		
				}
			}			
		});
		$("#FormCaptchaEdit").submit(function(e){
			e.preventDefault();
			if($("#FormCaptchaEdit").valid()){				
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
									var form = $("#FormCaptchaEdit").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/captcha/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=CaptchaUpdate&'+form,
										success: function(respon){
											if(respon.status=='sukses'){																			
												$.growl({title:respon.status,message: respon.message});
												$("#DialogCaptchaEdit").modal('hide');												
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
	function CaptchaCreate(){
		$("#DialogCaptchaCreate").on('shown.bs.modal', function(){
			$("#FormCaptchaCreate").find("#Question").focus();
		});
		$("#DialogCaptchaCreate").modal('show');
	}
	//------------------------------------------------------------------------------------//	
	function CaptchaDelete(IdCaptcha){		
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
							url: '<?=base_url();?>backend/captcha/ajax',
							type: 'POST',
							data: {
								'do':'CaptchaDelete',
								'IdCaptcha':IdCaptcha,
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
	function CaptchaEdit(IdCaptcha){		
		$.ajax({
			url: '<?=base_url();?>backend/captcha/ajax',
			type: 'POST',
			data: {
				'do':'CaptchaEdit',
				'IdCaptcha':IdCaptcha,
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
						$("#FormCaptchaEdit").find("#Question").val(element.Question);
						$("#FormCaptchaEdit").find("#Answer").val(element.Answer);
						$("#FormCaptchaEdit").find("#IdCaptcha").val(element.IdCaptcha);
						
					});
					$("#DialogCaptchaEdit").modal('show');
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



