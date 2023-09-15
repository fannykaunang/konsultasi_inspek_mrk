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
				<li><a href="<?= base_url(); ?>backend/page">Halaman</a></li>
				<li class="active">Edit Halaman</li>
			</ol>
			<h1 class="page-title">Edit Halaman Statis</h1>

		</div>
		<div class="page-content">
			<div class="panel">
				<div class="panel-body">
					<?php
					if ($RoleNewsUpdate == 'yes') {
						if ($editpage !== null) {
							foreach ($editpage as $row) {
					?>
								<form class="form-horizontal" id="FormPageEdit" name="FormPageEdit">
									<div class="form-group">
										<label for="judul" class="col-md-2 control-label">Metadata</label>
										<div class="col-md-10">
											<input type='text' class="form-control" value="Penulis: <?= $authorpage; ?>, Terakhir update: <?= DateTimeIndo($row->UpdatedPage); ?>, Oleh: <?= $row->UpdatedBy; ?>" disabled>
										</div>
									</div>
									<div class="form-group">
										<label for="judul" class="col-md-2 control-label">Judul Halaman</label>
										<div class="col-md-10">
											<textarea class="form-control" id="TitlePage" name="TitlePage" title="Judul Page" data-toggle="tooltip" placeholder="Judul halaman"><?= $row->TitlePage; ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label for="kategori" class="col-md-2 control-label">Kategori</label>

										<div class="col-md-3">
											<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="IdCategory" id="IdCategory" data-toggle="tooltip" title="Kategori">
												<?php
												foreach ($categorypage as $category) {
													if ($category->IdCategory == $row->IdCategoryPage) {
														$sel = 'selected';
													} else {
														$sel = '';
													}
												?>
													<option value="<?= $category->IdCategory; ?>" <?= $sel; ?>><?= $category->NameCategory; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="CreatedPage" class="col-md-2 control-label">Tanggal</label>
										<div class="col-md-3">
											<div class="input-group">
												<input type='text' class="form-control" id="CreatedPage" data-toggle="tooltip" title="Tanggal" placeholder="Tanggal" name="CreatedPage" value="<?= DateIndo($row->CreatedPage); ?>" data-plugin="datepicker">
												<span class="input-group-addon"><i class="icon wb-calendar"></i></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="IsiPage" class="col-md-2 control-label">Isi Page</label>
										<div class="col-md-10">
											<textarea class="form-control" id="ContentPage" name="ContentPage" data-toggle="tooltip" title="Isi halaman" rows="10"><?= $row->ContentPage; ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label for="Pilihan" class="col-md-2 control-label">Opsi</label>
										<div class="col-md-9">
											<?php
											if ($row->FlagDate == '1') {
												$FlagDate = 'checked';
											} else {
												$FlagDate = '';
											}
											if ($row->FlagPublish == '1') {
												$FlagPublish = 'checked';
											} else {
												$FlagPublish = '';
											}
											if ($row->FlagComment == '1') {
												$FlagComment = 'checked';
											} else {
												$FlagComment = '';
											}
											?>

											<?php
											$ulevel = $this->user_model->GetLevelUser();

											if ($ulevel == 'contributor' ? $disabled = 'disabled' : $disabled = '');

											?>
											<div class="form-control no-line no-left-padding">
												<input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish" name="FlagPublish" <?= $FlagPublish; ?> <?= $disabled; ?> /> Publish &nbsp;
												<input type='checkbox' class="form-inline uniformcheckbox" id="FlagDate" name="FlagDate" <?= $FlagDate; ?> /> Tanggal &nbsp;
												<input type='checkbox' class="form-inline uniformcheckbox" id="FlagComment" name="FlagComment" <?= $FlagComment; ?> /> Komentar &nbsp;
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="CreatedPage" class="col-md-2 control-label">Thumbnail</label>
										<div class="col-md-5">
											<div class="row">
												<div class="col-md-12">
													<?php

													if ($row->Thumbnail == null) {
														$ImgThumbnail = 	'<img id="ImgThumbnail" src="' . base_url() . 'assets/frontend/themes/2017/images/post-1/img-01.jpg" width="200"/>';
														$Thumbnail = null;
													} else {
														$ImgThumbnail = '<img id="ImgThumbnail" src="' . base_url() . $row->Thumbnail . '" width="200"/>';
														$Thumbnail = base_url() . $row->Thumbnail;
													}
													echo $ImgThumbnail;
													?>
												</div>
											</div>

											<input type='hidden' class="form-control" id="Thumbnail" data-toggle="tooltip" title="Gambar" placeholder="Gambar cuplikan berita" name="Thumbnail" value="<?= $Thumbnail; ?>">


											<br />

											<div class="row">
												<div class="col-md-12">
													<button type="button" onclick="UploadThumbnail();" class="btn btn-success btn-sm btn-round"><i class="fa fa-file-image-o"></i> Unggah</button> &nbsp; &nbsp;
													<button type="button" onclick="Gallery();" class="btn btn-primary btn-sm btn-round"><i class="fa fa-file-image-o"></i> Galeri </button>
												</div>
											</div>
										</div>

									</div>


									<div class="form-group">
										<label for="CreatedPage" class="col-md-2 control-label">Unggah file (lampiran)</label>
										<div class="col-md-9">
											<a href="<?= base_url(); ?>backend/file_manager" target="_blank"><button type="button" class="btn btn-warning btn-sm">File manager <i class="fa fa-arrow-circle-right"></i> </button></a>
										</div>
									</div>
									<input type="hidden" name="IdPage" id="IdPage" value="<?= $row->IdPage; ?>" />
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
									<div class="form-group">
										<legend></legend>
										<label class="col-md-2 control-label"></label>
										<div class="col-md-5">
											<button type="submit" class="btn btn-primary" id="SaveButton">Simpan </button>
											&nbsp; &nbsp;
											<a href="<?= base_url(); ?>backend/news"><button type="button" class="btn btn-default">Batal </button></a>
										</div>
									</div>
								</form>
						<?php
							}
						} else {
							if ($prohibitupdate == 'yes') {
								$this->load->view('backend/prohibit-update');
							} else {
								$this->load->view('backend/no-data');
							}
						}
						?>

					<?php
					} else {
						$this->load->view('backend/no-access');
					}
					?>
				</div>
			</div>

			<div class="panel">
				<div class="panel-body">
					<h4>Keterangan</h4>
					<div class="list-group">
						<a class="list-group-item" href="javascript:void(0)">
							<h4 class="list-group-item-heading"><img src="<?= base_url(); ?>assets/backend/images/publish.png" /> Publish</h4>
							<p class="list-group-item-text">Halaman sudah dipublish</p>
						</a>
						<a class="list-group-item" href="javascript:void(0)">
							<h4 class="list-group-item-heading"><img src="<?= base_url(); ?>assets/backend/images/draft.png" /> Draft</h4>
							<p class="list-group-item-text">Halaman masih draft</p>
						</a>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- End Page -->
	<div class="modal fade modal-fade-in-scale-up" id="DialogUploadThumbnail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Unggah</h4>
				</div>
				<div class="modal-body">

					<iframe name="IFrameUploadThumbnail" style="display:none;"></iframe>
					<form class="form-horizontal" name="FormUploadThumbnail" id="FormUploadThumbnail" method="POST" action="<?= base_url(); ?>backend/news/UploadThumbnail" enctype="multipart/form-data" target="IFrameUploadThumbnail">


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

								<input type="text" name="Filename" id="Filename" placeholder="Nama file" class="form-control tooltip-right" title="Nama file" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Unggah Gambar</label>
							<div class="col-sm-9">

								<input type="file" name="userfile" id="FileThumbnail" placeholder="Pilih file" class="form-control tooltip-right" title="Pilih file" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-9">
								Format: .jpg, .jpeg, .gif dan .png
							</div>
						</div>

						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

						<input type="hidden" id="Judul" name="Judul" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
					<button type="submit" class="btn btn-primary" id="okButton"> Unggah </button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="DialogGallery" aria-hidden="true" aria-labelledby="exampleGrid" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Pilih gambar/thumbnail</h4>
				</div>
				<div class="modal-body">
					<div id="gallery-container" />
					<table id="MyTable" class="table table-condensed table-striped table-hover">
						<thead>
							<tr>
								<th class="col-md-2">TANGGAL</th>
								<th class="col-md-1">GAMBAR</th>
								<th class="text-center">NAMA FILE</th>
								<th class="text-center">UKURAN</th>
								<th class="text-center col-md-2">OPSI</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th class="col-md-2">TANGGAL</th>
								<th class="col-md-1">GAMBAR</th>
								<th class="text-center">NAMA FILE</th>
								<th class="text-center">UKURAN</th>
								<th class="text-center col-md-2">OPSI</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>

	<?php $this->load->view('backend/footer'); ?>

	<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/js/plugins/tinymce/skins/lightgray/skin.min.css">
	<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/tinymce/tinymce.min.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
	<script src="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="<?= base_url(); ?>assets/backend/js/components/bootstrap-datepicker.js"></script>

	<script>
		//------------------------------------------------------------------------------------//
		$(function() {
			//------------------------------------------------------------------------------------//
			$("#FormPageEdit").find("#TitlePage").focus();
			//------------------------------------------------------------------------------------//
			tinymce.init({
				selector: "#ContentPage",
				theme: "modern",
				height: "480",
				relative_urls: false,
				plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak code",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor colorpicker textpattern imagetools"
				],
				menubar: false,
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				toolbar2: "print preview media | forecolor backcolor | emoticons | table | pagebreak | code",
				image_advtab: true,
				templates: [{
						title: 'Test template 1',
						content: 'Test 1'
					},
					{
						title: 'Test template 2',
						content: 'Test 2'
					}
				],
				pagebreak_separator: "<!-- page-break -->"
			});
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
					"url": "<?= base_url(); ?>backend/page/GalleryList",
					"type": "POST",
					"data": {
						'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
					},
					"error": function() {
						$.growl.error({
							title: 'Error',
							message: 'Ajax request'
						});
					}
				},
				"bStateSave": true,
				"fnDrawCallback": function(oSettings) {
					//$("input:checkbox").uniform();
				},
				"columns": [{
						"data": 'Time'
					},
					{
						"data": 'Fullpath'
					},
					{
						"data": 'Basename'
					},
					{
						"data": 'Filesize'
					},
					{
						"data": 'Option'
					}
				],
				"lengthMenu": [
					[3, 5, 10, 20, 50, 100],
					[3, 5, 10, 20, 50, 100]
				],
				"pageLength": 3,

				"columnDefs": [{
						"orderable": true,
						"targets": 0
					},
					{
						"orderable": true,
						"targets": 1,
						'sClass': 'text-center'
					},
					{
						"orderable": true,
						"targets": 2
					},
					{
						"orderable": true,
						"targets": 3,
						'sClass': 'text-right'
					},
					{
						"orderable": true,
						"targets": 4,
						'sClass': 'text-center'
					},

				],
				"order": [
					[0, "desc"]
				]
			});
			//------------------------------------------------------------------------------------//
			$("#FormPageEdit").validate({
				rules: {
					TitlePage: {
						'required': true
					},
					Thumbnail: {
						'required': true,
						'url': true
					}
				},
				messages: {
					TitlePage: {
						required: 'Judul harus diisi'
					},
					Thumbnail: {
						required: 'Thumbnail harus diisi',
						url: 'Alamat URL harus valid'
					}
				}
			});
			$("#FormPageEdit").submit(function(e) {
				e.preventDefault();
				if ($("#FormPageEdit").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan halaman ini?",
						title: "Konfirmasi",
						buttons: {
							danger: {
								label: "No",
								className: "btn-default",
								callback: function() {

								}
							},
							main: {
								label: "Yes",
								className: "btn-primary",
								callback: function() {
									var form = $("#FormPageEdit").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/page/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=PageUpdate&' + form,
										success: function(respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												setTimeout(function() {
													window.location = '<?= base_url(); ?>backend/page';
												}, 1000);
											}
										},
										timeout: 20000,
										error: function() {
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
			});
			//------------------------------------------------------------------------------------//
		});
		//------------------------------------------------------------------------------------//
		//------------------------------------------------------------------------------------//
		function UploadThumbnail() {
			$("#DialogUploadThumbnail").on('shown.bs.modal', function() {
				$("#FormUploadThumbnail").find("#Filename").focus();
			});
			$("#DialogUploadThumbnail").modal('show');
		}
		//------------------------------------------------------------------------------------//
		$("#FormUploadThumbnail").validate({
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
		$('#FormUploadThumbnail').submit(function() {
			if ($("#FormUploadThumbnail").valid()) {
				myLoader.show();
				UploadProcess();
			}
		});

		function UploadProcess() {
			var timeout = setTimeout(function() {
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
					$("#FormUploadThumbnail").trigger("reset");
					$("#DialogUploadThumbnail").modal('hide');
					$.growl({
						title: 'sukses',
						message: 'Upload image thumbnail'
					});
					//$("#FilenameDokumenInfo").show();
					//$("#TombolUploadDokumen").hide();
					$("#StatusUploadFileDokumen").html('process');
				}
				if (status == 'gagal') {
					myLoader.hide();
					$("#ResponUpload").fadeIn();
					$("#UploadFile").val('');
					$.growl.error({
						title: 'gagal',
						message: 'Upload thumbnail gagal'
					});
					$("#StatusUpload").html('process');
				}
			}, timeout);
		}
		//------------------------------------------------------------------------------------//
		function Gallery() {
			$("#DialogGallery").modal('show');
		}

		function SelectImage(Fullpath) {
			$("#FormPageEdit").find("#ImgThumbnail").attr("src", "<?= base_url(); ?>" + Fullpath);
			$("#FormPageEdit").find("#Thumbnail").val(Fullpath);
			$.growl({
				title: 'sukses',
				message: 'File thumbnail dipilih'
			});
		}

		function InsertIntoEditor(Fullpath) {
			tinyMCE.execCommand('mceInsertContent', false, '<img src="' + Fullpath + '"/>');
			$.growl({
				title: 'success',
				message: 'Gambar masuk ke editor...'
			});
		}
	</script>

	<!----------------------------------------------------------------------------------------------------------------------------------------->