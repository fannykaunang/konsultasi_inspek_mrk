<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/examples/css/uikit/progress-bars.css">

<body class="site-menubar-unfold site-menubar-keep">

	<?php $this->load->view('backend/navbar'); ?>
	<?php $this->load->view('backend/sidebar'); ?>
	<!-- Page -->
	<div class="page">
		<div class="page-header">
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			$uname = $this->user_model->GetUserIrban();
			if ($ulevel == 'IRBAN') {
				?>
				<h1 class="page-title">
					<?php echo $uname ?>
				</h1>
				<?php
			} elseif ($ulevel == 'superadmin' || $ulevel == 'SKPD' || $ulevel == 'Inspektur') {
				?>
				<h1 class="page-title">
					DASBOR
				</h1>
				<?php
			} ?>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'SKPD') {
				?>
				<div class="page-header-actions">
					<a href="<?= base_url(); ?>backend/dashboard/add" class="btn btn-sm btn-icon btn-inverse"
						data-toggle="tooltip" data-original-title="Pelaporan Baru" id="AddNews">
						<i class="icon wb-plus-circle" aria-hidden="true"></i>
					</a>
					<button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
						data-original-title="Refresh" id="RefreshSKPD">
						<i class="icon wb-refresh" aria-hidden="true"></i>
					</button>
				</div>
			<?php } ?>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'IRBAN') {
				?>
				<div class="page-header-actions">
					<button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
						data-original-title="Refresh" id="RefreshIRBAN">
						<i class="icon wb-refresh" aria-hidden="true"></i>
					</button>
				</div>
			<?php } ?>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'Inspektur') {
				?>
				<div class="page-header-actions">
					<button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
						data-original-title="Refresh" id="RefreshInspektur">
						<i class="icon wb-refresh" aria-hidden="true"></i>
					</button>
				</div>
			<?php } ?>
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-sm-4">
					<!-- Widget -->
					<div class="widget">
						<div class="widget-content padding-10 bg-green-600">
							<div class="widget-watermark darker font-size-60 margin-15"><i class="icon wb-order"
									aria-hidden="true"></i></div>
							<div class="counter counter-md counter-inverse text-left">
								<div class="counter-number-group">
									<span class="counter-number">
										<?= $this->backend_konsultasi_model->CountTotalSKPD(); ?>
									</span>
									<span class="counter-number-related text-capitalize">SKPD</span>
								</div>
								<div class="counter-label text-capitalize">total</div>
							</div>
						</div>
					</div>
					<!-- End Widget -->
				</div>
				<div class="col-sm-4">
					<!-- Widget -->
					<div class="widget">
						<div class="widget-content padding-10 bg-red-600">
							<div class="widget-watermark darker font-size-60 margin-15"><i class="icon wb-eye"
									aria-hidden="true"></i></div>
							<div class="counter counter-md counter-inverse text-left">
								<div class="counter-number-group">
									<span class="counter-number">
										<?= $this->backend_konsultasi_model->CountTotalKonsultasi(); ?>
									</span>
									<span class="counter-number-related text-capitalize">Pelaporan</span>
								</div>
								<div class="counter-label text-capitalize">Di-publish</div>
							</div>
						</div>
					</div>
					<!-- End Widget -->
				</div>
				<div class="col-sm-4">
					<!-- Widget  -->
					<div class="widget">
						<div class="widget-content padding-10 bg-cyan-600">
							<div class="widget-watermark lighter font-size-60 margin-15"><i class="icon wb-eye-close"
									aria-hidden="true"></i></div>
							<div class="counter counter-md counter-inverse text-left">
								<div class="counter-number-wrap font-size-30">
									<span class="counter-number">
										<?= $this->backend_konsultasi_model->CountTotalKonsultasiDraft(); ?>
									</span>
									<span class="counter-number-related text-capitalize">Pelaporan</span>
								</div>
								<div class="counter-label text-capitalize">Di-draft</div>
							</div>
						</div>
					</div>
					<!-- End Widget -->
				</div>
			</div>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'superadmin') {
				?>
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Kutipan Hari Ini</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<blockquote>
									<i class="fa fa-quote-left fa-2x pull-left fa-border"></i>
									<p>
										<?php
										foreach ($randomquote as $row) {
											echo $row->Quote;
											?>
										</p>
										<footer><cite>
												<?= $row->Author; ?>
											</cite></footer>
										<?php
										}
										?>
								</blockquote>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'superadmin') {
				?>
				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title">Grafik Pelaporan</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<span class="loading" style="display:none;"> <i class="fa fa-cog fa-spin"></i> menampilkan
									grafik .... </span>
								<div id="Pelaporanchart"></i></div>
							</div>
						</div>
					</div>
				</div>
				<?php
			} else {
				$this->load->view('backend/no-blank');
			}
			?>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'SKPD') {
				?>
				<div class="panel">
					<div class="panel-body">
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>TGL PELAPORAN</th>
									<th>PERIHAL</th>
									<th>KATEGORI</th>
									<th>PELAPOR</th>
									<th>IRBAN</th>
									<th>INSPEKTUR</th>
									<th class="text-center col-md-2">OPSI</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="panel">
					<div class="panel-body">
						<h4>Keterangan</h4>
						<div class="list-group">
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img
										src="<?= base_url(); ?>assets/backend/images/publish.png" /> Diteruskan & Diterima
								</h4>
								<p class="list-group-item-text">Pelaporan Diteruskan ke IRBAN dan Diterima oleh Inspektur
								</p>
							</a>
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img
										src="<?= base_url(); ?>assets/backend/images/draft.png" /> Draft</h4>
								<p class="list-group-item-text">Pelaporan masih draft</p>
							</a>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'IRBAN') {
				?>
				<div class="panel">
					<div class="panel-body">
						<table id="MyTableIrban" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>TGL PELAPORAN</th>
									<th>PERIHAL</th>
									<th>KATEGORI</th>
									<th>PELAPOR</th>
									<th>SKPD</th>
									<th>DITERUSKAN</th>
									<th class="text-center col-md-2">OPSI</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="panel">
					<div class="panel-body">
						<h4>Keterangan</h4>
						<div class="list-group">
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img
										src="<?= base_url(); ?>assets/backend/images/publish.png" /> Diteruskan</h4>
								<p class="list-group-item-text">Pelaporan Diteruskan ke Inspektur</p>
							</a>
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img
										src="<?= base_url(); ?>assets/backend/images/draft.png" /> Draft</h4>
								<p class="list-group-item-text">Pelaporan masih draft</p>
							</a>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php
			$ulevel = $this->user_model->GetLevelUser();
			if ($ulevel == 'Inspektur') {
				?>
				<div class="panel">
					<div class="panel-body">
						<table id="MyTableInspektur" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>TGL PELAPORAN</th>
									<th>PERIHAL</th>
									<th>KATEGORI</th>
									<th>PELAPOR</th>
									<th>SKPD</th>
									<th class="text-center col-md-2">OPSI</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- End Page -->
	<?php $this->load->view('backend/footer'); ?>
	<script type="text/javascript"
		src="<?= base_url(); ?>assets/backend/js/plugins/highchart/js/highcharts.js"></script>
	<script type="text/javascript"
		src="<?= base_url(); ?>assets/backend/js/plugins/highchart/js/modules/exporting.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/asprogress/jquery-asProgress.js"></script>
	<script src="<?= base_url(); ?>assets/backend/js/components/asprogress.js"></script>
	<script src="<?= base_url(); ?>assets/backend/examples/js/uikit/progress-bars.js"></script>
	<script src="<?= base_url(); ?>assets/backend/js/components/bootstrap-datepicker.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.css">

	<script>
		$("#FormPageSambutan").find("#Title").focus();

		$('#MyTable').DataTable().destroy();
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
				"url": "<?= base_url(); ?>backend/dashboard/KonsultasiListAll",
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
				{ "data": 'Title' },
				{ "data": 'Category' },
				{ "data": 'Author' },
				{ "data": 'FlagPublish' },
				{ "data": 'FlagPublishInspektur' },
				{ "data": 'Option' }
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
				{ "orderable": false, "targets": 4, 'sClass': 'text-center' },
				{ "orderable": false, "targets": 5, 'sClass': 'text-center' },
				{ "orderable": false, "targets": 6, 'sClass': 'text-center' }

			],
			"order": [
				[3, "desc"]
			]
		});
		var MyTableIrban = $("#MyTableIrban").dataTable({
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
				"url": "<?= base_url(); ?>backend/dashboard/KonsultasiListIrban",
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
				{ "data": 'Title' },
				{ "data": 'Category' },
				{ "data": 'Author' },
				{ "data": 'NamaSkpd' },
				{ "data": 'FlagPublishInspektur' },
				{ "data": 'Option' }
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
				{ "orderable": false, "targets": 6, 'sClass': 'text-center' }

			],
			"order": [
				[4, "desc"]
			]
		});
		var MyTableInspektur = $("#MyTableInspektur").dataTable({
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
				"url": "<?= base_url(); ?>backend/dashboard/KonsultasiListInspektur",
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
				{ "data": 'Title' },
				{ "data": 'Category' },
				{ "data": 'Author' },
				{ "data": 'NamaSkpd' },
				{ "data": 'Option' }
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
				{ "orderable": false, "targets": 5, 'sClass': 'text-center' }

			],
			"order": [
				[4, "desc"]
			]
		});
		/*-------------------------------------------------------------------------------------*/
		$("#RefreshSKPD").click(function () {
			MyTable.fnDraw();
		});
		$("#RefreshIRBAN").click(function () {
			MyTableIrban.fnDraw();
		});
		$("#RefreshInspektur").click(function () {
			MyTableInspektur.fnDraw();
		});

		$(function () {
			$.validator.addMethod("SelectList", function (value, element, params) {
				return (value !== '');
			});
			$("#FormPageSambutan").validate({
				rules: {
					ContentPage: {
						'required': true
					}
				},
				messages: {
					ContentPage: {
						required: 'Sambutan harus diisi'
					}
				}
			});
			$("#FormPageSambutan").submit(function (e) {
				e.preventDefault();
				if ($("#FormPageSambutan").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan mengirim Pelaporan ini?",
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
									var form = $("#FormPageSambutan").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/dashboard/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=PageCreate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#AlertPageCreate").show();
												$("#FormPageSambutan").trigger("reset");
												tinyMCE.activeEditor.setContent('');
												$('body').scrollTo('body', {
													duration: 'slow',
													offsetTop: '50'
												});
												$("#FormPageSambutan").find("#Title").focus();
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
			});
			//------------------------------------------------------------------------------------//
		});

		$(function () {
			/*Pelaporan*/
			$.ajax({
				url: '<?= base_url(); ?>backend/dashboard/ajax',
				type: 'POST',
				dataType: 'json',
				data: {
					'do': 'PelaporChart',
					'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
				},
				beforeSend: function () {
					$(".loading").show();
				},
				success: function (data) {
					$(".loading").hide();
					if (data.status == 'sukses') {
						$('#Pelaporanchart').highcharts({
							title: {
								text: data.label,
								x: -20 //center
							},
							subtitle: {
								text: 'Grafik Pelaporan',
								x: -20
							},
							xAxis: {
								categories: data.month
							},
							yAxis: {
								title: {
									text: 'Pelaporan'
								},
								plotLines: [{
									value: 0,
									width: 1,
									color: '#808080'
								}],
								allowDecimals: false,
								min: 0
							},
							plotOptions: {
								area: {
									fillColor: {
										linearGradient: {
											x1: 0,
											y1: 0,
											x2: 0,
											y2: 1
										},
										stops: [
											[0, Highcharts.getOptions().colors[0]],
											[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
										]
									},
									marker: {
										radius: 2
									},
									lineWidth: 1,
									states: {
										hover: {
											lineWidth: 1
										}
									},
									threshold: null
								}
							},
							/*
							plotOptions: {
								line: {
									dataLabels: {
										enabled: true
									},
									enableMouseTracking: false
								}
							},
							*/
							tooltip: {
								valueSuffix: ''
							},
							legend: {
								layout: 'vertical',
								align: 'center',
								verticalAlign: 'bottom',
								borderWidth: 0
							},
							series: [{
								type: 'area',
								name: 'Pelaporan',
								color: '#F14C39',
								data: data.visitor
							}],
							credits: {
								enabled: false
							}
						});
						////////////////////
					}
					if (data.status == 'tidak tersedia') {
						$("#Pelaporanchart").html(data.message);
						$.growl({ title: respon.status, message: respon.message });
					}
				},
				timeout: 20000,
				error: function () {
					$(".loading").hide();
					$.growl.error({ title: 'Error', message: 'Ajax request' });
				}
			});
			/*visitor*/
			//------------------------------------------------------------------------------------//

		});
		//------------------------------------------------------------------------------------//
		function UploadThumbnail() {
			$("#DialogUploadThumbnail").on('shown.bs.modal', function () {
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
		$('#FormUploadThumbnail').submit(function () {
			if ($("#FormUploadThumbnail").valid()) {
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