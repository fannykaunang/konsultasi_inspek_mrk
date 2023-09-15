<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>

<body class="site-menubar-unfold site-menubar-keep">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('backend/navbar'); ?>
	<?php $this->load->view('backend/sidebar'); ?>
	<!-- Page -->
	<div class="page">
		<div class="page-header">
			<ol class="breadcrumb">
				<li><a href="<?= base_url(); ?>backend">Dasbor</a></li>
				<li class="active">File Pelaporan</li>
			</ol>
			<h1 class="page-title">File Pelaporan</h1>
			<div class="page-header-actions">
				<button class="btn btn-sm btn-icon btn-inverse hidden" data-toggle="tooltip" <?= $RoleFileCreate; ?>
					data-original-title="Unggah File" onclick="UploadFile();">
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

					<?php if ($role['RoleFileView'] == 'yes') {
						; ?>
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th class="col-md-2">GAMBAR</th>
									<th class="col-md-4">NAMA FILE</th>
									<th class="text-center">UKURAN</th>
									<th>TANGGAL</th>
									<th>SKPD</th>
									<th>USER</th>
									<th class="text-center col-md-2">OPSI</th>
								</tr>
							</thead>
						</table>
					<?php } else {
						$this->load->view('backend/no-access');
					} ?>

				</div>
			</div>

		</div>
	</div>
	<!-- End Page -->
	<div class="modal fade modal-fade-in-scale-up" id="DialogUploadFile" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Unggah</h4>
				</div>
				<div class="modal-body">

					<iframe name="IFrameUploadFile" style="display:none;"></iframe>
					<form class="form-horizontal" name="FormUploadFile" id="FormUploadFile" method="POST"
						action="<?= base_url(); ?>backend/file_manager/UploadFile" enctype="multipart/form-data"
						target="IFrameUploadFile">


						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-9">
								<div id="ResponUpload" style="display:none;"></div>
								<div id="StatusUpload" style="display:none;">process</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama file</label>
							<div class="col-sm-9">

								<input type="text" name="Filename" id="Filename" placeholder="Nama file"
									class="form-control tooltip-right" title="Nama file" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Unggah File</label>
							<div class="col-sm-9">

								<input type="file" name="userfile" id="FileThumbnail" placeholder="Pilih file"
									class="form-control tooltip-right" title="Pilih file" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-9">
								Format: .pdf, .doc, .docx, .xls, .xlsx, .zip, .rar, .7zip, .jpg, .jpeg, .gif dan .png
							</div>
						</div>

						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
							value="<?= $this->security->get_csrf_hash(); ?>" />


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
		$(function () {
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
						"previous": "Sebelum",
						"next": "Berikut",
						"last": "Akhir",
						"first": "Awal"
					}
				},
				"bProcessing": true,
				"bServerSide": true,
				"ajax": {
					"url": "<?= base_url(); ?>backend/file_manager/FileManagerList",
					"type": "POST",
					"data": {
						'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
					},
					"error": function () {
						$.growl.error({
							title: 'Error',
							message: 'Ajax request'
						});
					}
				},
				"bStateSave": true,
				"fnDrawCallback": function (oSettings) {
					//$("input:checkbox").uniform();
				},
				"columns": [{
					"data": 'Filename'
				},
				{
					"data": 'FilenameStr'
				},
				{
					"data": 'Filesize'
				},
				{
					"data": 'Time'
				},
				{
					"data": 'NamaSkpd'
				},
				{
					"data": 'NameUser'
				},
				{
					"data": 'Option'
				}
				],
				"lengthMenu": [
					[5, 10, 20, 50, 100],
					[5, 10, 20, 50, 100]
				],
				"pageLength": 5,
				"columnDefs": [{
					"orderable": true,
					"targets": 0
				},
				{
					"orderable": true,
					"targets": 1
				},
				{
					"orderable": true,
					"targets": 2,
					'sClass': 'text-right'
				},
				{
					"orderable": true,
					"targets": 3
				},
				{
					"orderable": true,
					"targets": 4
				},
				{
					"orderable": true,
					"targets": 5
				},
				{
					"orderable": false,
					"targets": 6,
					'sClass': 'text-center'
				}

				],
				"order": [
					[3, "desc"]
				]
			});
			//------------------------------------------------------------------------------------//
			$("#Refresh").click(function () {
				MyTable.fnDraw();
			});
			//------------------------------------------------------------------------------------//
		});
		//------------------------------------------------------------------------------------//
		function UploadFile() {
			$("#DialogUploadFile").on('shown.bs.modal', function () {
				$("#DialogUploadFile").find("#Filename").focus();
			});
			$("#DialogUploadFile").modal('show');
		}
		//------------------------------------------------------------------------------------//
		$("#FormUploadFile").validate({
			rules: {
				Filename: {
					'required': true
				}
			},
			messages: {
				Filename: {
					required: 'Nama file harus diisi'
				}
			}
		});
		$('#FormUploadFile').submit(function () {
			if ($("#FormUploadFile").valid()) {
				myLoader.show();
				UploadProcess();
			}
		});

		function UploadProcess() {
			var timeout = setTimeout(function () {
				var status = $("#StatusUpload").html();
				var response = $("#ResponUpload").html();
				var timeout = 5000;

				if (status == 'process') {
					UploadProcess();
				}
				if (status == 'sukses') {
					myLoader.hide();
					$("#ResponUpload").fadeIn();
					$("#ResponUpload").fadeOut();
					$("#FormUploadFile").trigger("reset");
					$("#DialogUploadFile").modal('hide');
					$.growl({
						title: 'sukses',
						message: 'Upload file'
					});
					$("#MyTable").dataTable().fnDraw();
					$("#FormUploadFile").trigger("reset");
					$("#StatusUpload").html('process');
				}
				if (status == 'gagal') {
					myLoader.hide();
					$("#ResponUpload").fadeIn();
					$("#UploadFile").val('');
					$.growl.error({
						title: 'gagal',
						message: 'Upload file gagal'
					});
					$("#StatusUpload").html('process');
				}
			}, timeout);
		}
		//------------------------------------------------------------------------------------//
		//------------------------------------------------------------------------------------//	
		function FileDelete(IdFile) {
			bootbox.dialog({
				message: "Anda yakin akan menghapus file ini?",
				title: "Konfirmasi",
				buttons: {
					danger: {
						label: "No",
						className: "btn-default",
						callback: function () { }
					},
					main: {
						label: "Yes",
						className: "btn-primary",
						callback: function () {
							$.ajax({
								url: '<?= base_url(); ?>backend/file_manager/ajax',
								type: 'POST',
								data: {
									'do': 'FileDelete',
									'IdFile': IdFile,
									'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
								},
								dataType: 'json',
								beforeSend: function () {
									//myLoader.show();
								},
								success: function (respon) {
									myLoader.hide();
									if (respon.status == 'sukses') {
										$("#MyTable").dataTable().fnDraw();
										$.growl({
											title: respon.status,
											message: respon.message
										});
									}
									if (respon.status == 'gagal') {
										$.growl.warning({
											title: respon.status,
											message: respon.message
										});
									}
								},
								timeout: 20000,
								error: function () {
									myLoader.hide();
									$.growl.error({
										title: 'Error',
										message: 'Ajax request'
									});
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