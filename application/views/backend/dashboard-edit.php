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
				<li><a href="">Pelaporan</a></li>
				<li class="active">Edit Pelaporan</li>
			</ol>
			<h1 class="page-title">Edit Pelaporan</h1>

		</div>
		<div class="page-content">
			<div class="panel">
				<div class="panel-body">
					<?php
					if ($editnews !== null) {
						foreach ($editnews as $row) {
							?>
							<form class="form-horizontal" id="FormNewsEdit" name="FormNewsEdit">
								<div class="form-group">
									<label for="judul" class="col-md-2 control-label">Metadata</label>
									<div class="col-md-10">
										<input type="text" class="form-control"
											value="Penulis: <?= $row->Author; ?>; Terakhir update: <?= DateTimeIndo($row->Time); ?>"
											disabled>
									</div>
								</div>
								<div class="form-group">
									<label for="judul" class="col-md-2 control-label">Perihal</label>
									<div class="col-md-10">
										<textarea class="form-control" id="Title" name="Title" title="Perihal"
											data-toggle="tooltip" placeholder="Perihal" disabled><?= $row->Title; ?></textarea>
									</div>
								</div>

								<div class="form-group">
									<label for="kategori" class="col-md-2 control-label">Kategori</label>

									<div class="col-md-3">
										<select class="form-control show-menu-arrow" data-plugin="selectpicker"
											name="IdCategory" id="IdCategory" data-toggle="tooltip" title="Kategori">
											<?php
											foreach ($categorynews as $category) {
												if ($category->IdCategory == $row->IdCategory) {
													$sel = 'selected';
												} else {
													$sel = '';
												}
												?>
												<option value="<?= $category->IdCategory; ?>" <?= $sel; ?>><?= $category->NameCategory; ?>
												</option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="Time" class="col-md-2 control-label">Tanggal</label>
									<div class="col-md-3">
										<div class="input-group">
											<input type='text' class="form-control" id="Time" data-toggle="tooltip"
												title="Tanggal" placeholder="Tanggal" name="Time"
												value="<?= DateIndo($row->Time); ?>" data-plugin="datepicker">
											<span class="input-group-addon"><i class="icon wb-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="IsiBerita" class="col-md-2 control-label">Isi Pelaporan</label>
									<div class="col-md-10">
										<textarea class="form-control" id="Content" name="Content" data-toggle="tooltip"
											title="Isi Pelaporan" rows="10"><?= $row->Content; ?></textarea>
									</div>
								</div>

								<input type="hidden" name="IdKonsultasi" id="IdKonsultasi" value="<?= $row->IdKonsultasi; ?>" />
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />

								<hr />

								<div class="form-group">
									<legend></legend>
									<label class="col-md-2 control-label"></label>
									<div class="col-md-5">
										<button type="submit" class="btn btn-primary" id="SaveButton">Simpan </button>
										&nbsp; &nbsp;
										<a href="<?= base_url(); ?>backend/dashboard"><button type="button"
												class="btn btn-default">Batal </button></a>
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
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->

	<?php $this->load->view('backend/footer'); ?>

	<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/js/plugins/tinymce/skins/lightgray/skin.min.css">
	<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/tinymce/tinymce.min.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
	<script src="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="<?= base_url(); ?>assets/backend/js/components/bootstrap-datepicker.js"></script>

	<script>
		//------------------------------------------------------------------------------------//
		$(function () {
			//------------------------------------------------------------------------------------//
			$("#FormNewsEdit").find("#Title").focus();
			//------------------------------------------------------------------------------------//
			tinymce.init({
				selector: "#Content",
				theme: "modern",
				height: "480",
				relative_urls: false,
				plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak code",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table directionality",
					"emoticons template paste textcolor colorpicker textpattern imagetools"
				],
				menubar: false,
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				toolbar2: "print preview media | forecolor backcolor | emoticons | table | pagebreak | code",
				image_advtab: true,
				templates: [
					{ title: 'Test template 1', content: 'Test 1' },
					{ title: 'Test template 2', content: 'Test 2' }
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
					"url": "<?= base_url(); ?>backend/dashboard/GalleryList",
					"type": "POST",
					"data": {
						'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
					},
					"error": function () {
						$.growl.error({ title: 'Error', message: 'Ajax request' });
					}
				},
				"bStateSave": true,
				"fnDrawCallback": function (oSettings) {
					//$("input:checkbox").uniform();
				},
				"columns": [
					{ "data": 'Time' },
					{ "data": 'Fullpath' },
					{ "data": 'Basename' },
					{ "data": 'Filesize' },
					{ "data": 'Option' }
				],
				"lengthMenu": [
					[3, 5, 10, 20, 50, 100],
					[3, 5, 10, 20, 50, 100]
				],
				"pageLength": 3,

				"columnDefs": [
					{ "orderable": true, "targets": 0 },
					{ "orderable": true, "targets": 1, 'sClass': 'text-center' },
					{ "orderable": true, "targets": 2 },
					{ "orderable": true, "targets": 3, 'sClass': 'text-right' },
					{ "orderable": true, "targets": 4, 'sClass': 'text-center' },

				],
				"order": [
					[0, "desc"]
				]
			});
			//------------------------------------------------------------------------------------//
			$("#FormNewsEdit").validate({
				rules: {
					Title: {
						'required': true
					}
				},
				messages: {
					Title: {
						required: 'Judul harus diisi'
					}
				}
			});
			$("#FormNewsEdit").submit(function (e) {
				e.preventDefault();
				if ($("#FormNewsEdit").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan Pelaporan ini?",
						title: "Konfirmasi",
						buttons: {
							danger: {
								label: "No",
								className: "btn-default",
								callback: function () {

								}
							},
							main: {
								label: "Yes",
								className: "btn-primary",
								callback: function () {
									var form = $("#FormNewsEdit").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/dashboard/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=konsultasiUpdate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												setTimeout(function () { window.location = '<?= base_url(); ?>backend/dashboard'; }, 1000);
											}
										},
										timeout: 20000,
										error: function () {
											myLoader.hide();
											$.growl.error({ title: 'Error', message: 'Ajax request' });
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
	</script>

	<!----------------------------------------------------------------------------------------------------------------------------------------->