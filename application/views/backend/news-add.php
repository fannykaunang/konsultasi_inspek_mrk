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
				<li><a href="<?= base_url(); ?>backend/news">Berita</a></li>
				<li class="active">Berita Baru</li>
			</ol>
			<h1 class="page-title">Berita Baru</h1>

		</div>
		<div class="page-content">
			<div class="panel">
				<div class="panel-body">
					<?php
					if ($RoleNewsCreate == 'yes') {
					?>
						<div class="col-md-12" id="AlertNewsCreate">
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Tutup</span>
								</button>
								Berita berhasil disimpan, untuk melihat daftar berita klik <a class="alert-link" href="<?= base_url(); ?>backend/news" title="Daftar berita" data-toggle="tooltip">berita</a>.
							</div>
						</div>
						<form class="form-horizontal" id="FormNewsCreate" name="FormNewsCreate">
							<div class="form-group">
								<label for="judul" class="col-md-2 control-label">Penulis</label>
								<div class="col-md-10">
									<input type='text' class="form-control" value="<?= $authornews; ?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label for="judul" class="col-md-2 control-label">Judul Berita</label>
								<div class="col-md-10">
									<textarea class="form-control" id="TitleNews" name="TitleNews" title="Judul Berita" data-toggle="tooltip" placeholder="Judul berita"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="kategori" class="col-md-2 control-label">Kategori</label>
								<div class="col-md-3">
									<select class="form-control show-menu-arrow" name="IdCategory" id="IdCategory" data-toggle="tooltip" title="Kategori">
										<option value="" selected>-PILIH-</option>
										<?php
										foreach ($category as $row) {
										?>
											<option value="<?= $row->IdCategory; ?>"><?= $row->NameCategory; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="CreatedNews" class="col-md-2 control-label">Tanggal</label>
								<div class="col-md-3">
									<div class="input-group">
										<input type='text' class="form-control" id="CreatedNews" data-toggle="tooltip" title="Tanggal" placeholder="Tanggal" name="CreatedNews" value="<?= date('d/m/Y'); ?>" data-plugin="datepicker">
										<span class="input-group-addon"><i class="icon wb-calendar"></i></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="IsiBerita" class="col-md-2 control-label">Isi Berita</label>
								<div class="col-md-10">
									<textarea class="form-control" id="ContentNews" name="ContentNews" data-toggle="tooltip" title="Isi berita" rows="10"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="Pilihan" class="col-md-2 control-label">Opsi</label>
								<div class="col-md-9">
									<div class="form-control no-line no-left-padding">
										<input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish" name="FlagPublish" <?= $flagpublish; ?>> Publish &nbsp;
										<input type='checkbox' class="form-inline uniformcheckbox" id="FlagDate" name="FlagDate" <?= $flagdate; ?>> Tanggal &nbsp;
										<input type='checkbox' class="form-inline uniformcheckbox" id="FlagComment" name="FlagComment" <?= $flagcomment; ?>> Komentar &nbsp;
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="CreatedNews" class="col-md-2 control-label">Thumbnail</label>
								<div class="col-md-5">
									<div class="row">
										<div class="col-md-12">
											<img id="ImgThumbnail" src="<?= base_url(); ?>assets/frontend/themes/2017/images/post-1/img-01.jpg" width="200" />

										</div>

										<input type='hidden' class="form-control" id="Thumbnail" data-toggle="tooltip" title="Gambar" placeholder="Gambar cuplikan berita" name="Thumbnail" value="">

									</div>
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
								<label for="CreatedNews" class="col-md-2 control-label">Unggah file (lampiran)</label>
								<div class="col-md-9">
									<a href="<?= base_url(); ?>backend/file_manager" target="_blank"><button type="button" class="btn btn-warning btn-sm">File manager <i class="fa fa-arrow-circle-right"></i> </button></a>
								</div>
							</div>
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

							<hr />
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
							<p class="list-group-item-text">Berita sudah dipublish</p>
						</a>
						<a class="list-group-item" href="javascript:void(0)">
							<h4 class="list-group-item-heading"><img src="<?= base_url(); ?>assets/backend/images/draft.png" /> Draft</h4>
							<p class="list-group-item-text">Berita masih draft</p>
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
			$("#FormNewsCreate").find("#TitleNews").focus();
			//------------------------------------------------------------------------------------//
			tinymce.init({
				selector: "#ContentNews",
				theme: "modern",
				height: "480",
				relative_urls: false,
				plugins: [
					"paste advlist autolink lists link image charmap print preview hr anchor pagebreak code",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table directionality",
					"emoticons template paste textcolor colorpicker textpattern imagetools"
				],
				menubar: false,
				toolbar1: "insertfile paste undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
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
					"url": "<?= base_url(); ?>backend/news/GalleryList",
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
			$("#Refresh").click(function() {
				MyTable.fnDraw();
			});
			//------------------------------------------------------------------------------------//
			$.validator.addMethod("SelectList", function(value, element, params) {
				return (value !== '');
			});
			$("#FormNewsCreate").validate({
				rules: {
					IdCategory: {
						SelectList: true
					},
					TitleNews: {
						'required': true
					},
					Thumbnail: {
						'required': true,
						'url': true
					}
				},
				messages: {
					IdCategory: {
						SelectList: 'Kategori belum dipilih'
					},
					TitleNews: {
						required: 'Judul harus diisi'
					},
					Thumbnail: {
						required: 'Thumbnail harus diisi',
						url: 'Alamat URL harus valid'
					}
				}
			});
			$("#FormNewsCreate").submit(function(e) {
				e.preventDefault();
				if ($("#FormNewsCreate").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan berita ini?",
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
									var form = $("#FormNewsCreate").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/news/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=NewsCreate&' + form,
										success: function(respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#AlertNewsCreate").show();
												$("#FormNewsCreate").trigger("reset");
												tinyMCE.activeEditor.setContent('');
												$('body').scrollTo('body', {
													duration: 'slow',
													offsetTop: '50'
												});
												$("#FormNewsCreate").find("#TitleNews").focus();
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
			$("#MyTable").dataTable().fnDraw();
		}

		function SelectImage(Fullpath) {


			$("#FormNewsCreate").find("#ImgThumbnail").attr("src", "<?= base_url(); ?>" + Fullpath);
			$("#FormNewsCreate").find("#Thumbnail").val(Fullpath);


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