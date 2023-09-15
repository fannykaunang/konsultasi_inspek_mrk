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
				<li class="active">Pengaturan Slide</li>
			</ol>
      <h1 class="page-title">Slide</h1>
		<div class="page-header-actions">
			<button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" 
			data-original-title="Unggah Slide" onclick="SliderCreate();">
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
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>								
									<th class="col-md-2">PREVIEW</th>
									<th class="text-center">TIPE</th>
									<th class="col-md-4">LOKASI</th>
									<th class="text-center">UKURAN</th>
									<th>TANGGAL</th>
									<th class="text-center">PUBLISH</th>
									<th class="text-center col-md-2">OPSI</th>														
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="col-md-2">PREVIEW</th>	
									<th class="text-center">TIPE</th>		
									<th class="col-md-4">LOKASI</th>	
									<th class="text-center">UKURAN</th>
									<th>TANGGAL</th>				
									<th class="text-center">PUBLISH</th>	
									<th class="text-center col-md-2">OPSI</th>															
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="panel">			
					<div class="panel-body">
						<h4>Keterangan</h4>
						<div class="list-group">
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img src="<?=base_url();?>assets/backend/images/publish.png"/> Publish</h4>
								<p class="list-group-item-text">Slide sudah dipublish</p>
							</a>
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img src="<?=base_url();?>assets/backend/images/draft.png"/> Draft</h4>
								<p class="list-group-item-text">Slide masih draft</p>
							</a>							
						</div>				
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
					<form class="form-horizontal" name="FormUploadFile" id="FormUploadFile" method="POST" action="<?=base_url();?>backend/slider/UploadFile" enctype="multipart/form-data" target="IFrameUploadFile">
						
							
						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-9">
								<div id="ResponUpload" style="display:none;"></div>
									<div id="StatusUpload" style="display:none;">process</div>
							</div>
						</div>
						
							<div class="form-group">
							<label class="col-sm-3 control-label">Judul</label>
							<div class="col-sm-9">
								<input type="text" name="Caption" id="Caption" placeholder="Judul slide" class="form-control tooltip-right" title="Judul slide"/>					
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
							<div class="col-sm-5">
							<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="FlagPublish" id="FlagPublish"/>	
										<option value="1" selected >aktif</option>
										<option value="0">nonaktif</option>
									</select>							
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
									Format: .jpg, .jpeg, .gif dan .png <br/>
										Dimensi: 1140px X 560px 
							</div>
						</div>
							
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
					<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
					<h4 class="modal-title" id="myModalLabel">Update Slider</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormFileEdit" id="FormFileEdit" method="POST">
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Judul</label>
							<div class="col-sm-9">
								<input type="text" name="Caption" id="Caption" placeholder="Judul slide" class="form-control tooltip-right" title="Judul slide"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Deskripsi</label>
							<div class="col-sm-9">
								<textarea type="text" name="Description" id="Description" placeholder="Deskripsi" class="form-control tooltip-right" title="Deskripsi"></textarea>					
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Opsi</label>
							<div class="col-sm-5">
									<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="FlagPublish" id="FlagPublish">	
										<option value="1">aktif</option>
										<option value="0">nonaktif</option>
									</select>							
							</div>
						</div>
						
						<input type="hidden" name="IdFile" id="IdFile"/>
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


    <div class="modal fade modal-fade-in-scale-up" id="DialogUploadPictureUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Unggah</h4>
		  </div>
		  <div class="modal-body">
				
				<iframe name="IFrameUploadPictureUser" style="display:none;"></iframe>
			  	<form class="form-horizontal" name="FormUploadPictureUser" id="FormUploadPictureUser" method="POST" action="<?=base_url();?>backend/slider/ChangeFoto" enctype="multipart/form-data" target="IFrameUploadPictureUser">
					
						
					<div class="form-group">
					    <label class="col-sm-3 control-label"></label>
					    <div class="col-sm-9">
					    	<div id="ResponUpload" style="display:none;"></div>
								<div id="StatusUpload" style="display:none;">process</div>
					    </div>
					  </div>
						
					  <div class="form-group">
					    <label class="col-sm-3 control-label">Unggah slider</label>
					    <div class="col-sm-9">

					     	<input type="file" name="userfile" id="FilePictureUser" placeholder="Pilih file" class="form-control tooltip-right" title="Pilih file"/>
					    </div>
					  </div>
					 
					  <div class="form-group">
					  	 <label class="col-sm-3 control-label"></label>
					   	 <div class="col-sm-9">
					   	 		Format: .jpg, .jpeg, .gif dan .png
					   	 </div>
					  </div>
                      <input type="hidden" name="IdFile" id="IdFile" value="<?= $row->IdFile; ?>" />
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

    <?php $this->load->view('backend/footer'); ?>




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
				"url": "<?=base_url();?>backend/slider/SliderList",
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
				{"data": 'Filename'}, 
				{"data": 'Extension'},
				{"data": 'Fullpath'}, 				
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
				 { "orderable": true, "targets": 1, 'sClass': 'text-center' },
				 { "orderable": true, "targets": 2 },				 
				 { "orderable": true, "targets": 3, 'sClass': 'text-right' },
				 { "orderable": true, "targets": 4},
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
		$("#FormFileEdit").validate({			
			rules: {
				Caption: {
					'required': true						
				},
				Description: {
					'required': true						
				}
			},
			messages: {
				Caption: {
					required: 'Judul harus diisi'
				},
				Description: {
						required: 'Deskripsi harus diisi'		
				}
			}			
		});
		$("#FormFileEdit").submit(function(e){
			e.preventDefault();
			if($("#FormFileEdit").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin akan menyimpan slider ini?",
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
										url: '<?=base_url();?>backend/slider/ajax',
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
	function SliderCreate(){
		$("#DialogUploadFile").on('shown.bs.modal', function(){
			$("#FormUploadFile").find("#Caption").focus();
		});
		$("#DialogUploadFile").modal('show');
	}
	//------------------------------------------------------------------------------------//
	$("#FormUploadFile").validate({			
		rules: {
			Caption: {
				'required': true						
			},
			Description: {
				'required': true						
			}
		},
		messages: {
			Caption: {
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
	function FileDelete(IdFile){		
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
							url: '<?=base_url();?>backend/slider/ajax',
							type: 'POST',
							data: {
								'do':'FileDelete',
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
	function FileEdit(IdFile){		
		$.ajax({
			url: '<?=base_url();?>backend/slider/ajax',
			type: 'POST',
			data: {
				'do':'FileEdit',
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
						$("#FormFileEdit").find("#Caption").val(element.Caption);
						$("#FormFileEdit").find("#Description").val(element.Description);
						$("#FormFileEdit").find("#IdFile").val(element.IdFile);
						$("#FormFileEdit").find("#Fullpath").val(element.Fullpath);
						$("#FormFileEdit").find("#FlagPublish").val(element.FlagPublish).change();
					
					});
					$("#FormFileEdit").on('shown.bs.modal', function(){
						$("#FormFileEdit").find("#Caption").focus();
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
	

	function ChangeFoto(IdFile) {
            $.ajax({
                url: '<?= base_url(); ?>backend/slider/ajax',
                type: 'POST',
                data: {
                    'do': 'EditFoto',
                    'IdFile': IdFile,
                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                beforeSend: function() {
                    //myLoader.show();
                },
                success: function(respon) {
                    myLoader.hide();
                    if (respon.status == 'sukses') {
                        $.each(respon.data, function(index, element) {
                            $("#FormUploadPictureUser").find("#userfile").val(element.userfile);

                            $("#FormUploadPictureUser").find("#IdFile").val(element.IdFile);
                        });
                        $("#DialogUploadPictureUser").modal('show');
                    }
					
                },
                timeout: 2000,
                error: function() {
                    myLoader.hide();
                    $.growl.error({
                        title: 'Error',
                        message: 'Ajax request'
                    });
                }
            });
        }


        $('#FormUploadPictureUser').submit(function() {
                if ($("#FormUploadPictureUser").valid()) {
                    myLoader.show();
                    ChangeFoto1();
                }
            });

    function ChangeFoto1() {
            var timeout = setTimeout(function() {
            var status = $("#StatusUpload").html();
            var response = $("#ResponUpload").html();
            var timeout = 5000;

            if (status == 'process') {
                ChangeFoto1();
            }
            if (status == 'sukses') {
                myLoader.hide();
                $("#ResponUpload").fadeIn();
                $("#ResponUpload").fadeOut();
                $("#FormUploadPictureUser").trigger("reset");
                $("#DialogUploadPictureUser").modal('hide');
                $.growl({
                    title: 'sukses',
                    message: 'Upload foto slider'
                });
                $("#MyTable").dataTable().fnDraw();
				$("#FormUploadPictureUser").trigger("reset");
				$("#StatusUpload").html('process');
            }
            if (status == 'gagal') {
                myLoader.hide();
                $("#ResponUpload").fadeIn();
                $("#UploadFile").val('');
                $.growl.error({
                    title: 'gagal',
                    message: 'Upload foto slider gagal'
                });
                $("#StatusUpload").html('process');
            }
        }, timeout);
    }













	
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

