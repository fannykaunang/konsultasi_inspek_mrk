<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet"
	href="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/css/scroller.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/css/select.bootstrap4.min.css">

<body class="site-menubar-unfold site-menubar-keep">
	<?php $this->load->view('backend/navbar'); ?>
	<?php $this->load->view('backend/sidebar'); ?>
	<!-- Page -->
	<div class="page animsition">
		<div class="page-header">
			<ol class="breadcrumb">
				<li><a href="<?= base_url(); ?>backend">Dasbor</a></li>
				<li class="active">Pelaporan</li>
			</ol>
			<h1 class="page-title">Daftar Pelaporan Masuk</h1>
			<div class="page-header-actions">
				<button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
					data-original-title="Refresh" id="Refresh">
					<i class="icon wb-refresh" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="page-content">
			<div class="panel">
				<div class="panel-body">
					<style>
						.dataTables_length {
							margin-top: 10px;
							margin-bottom: 10px;
						}
					</style>
					<table id="MyTableDashboard" class="table table-condensed table-striped table-hover">
						<thead>
							<tr>
								<th>TGL PELAPORAN</th>
								<th>PERIHAL</th>
								<th>KATEGORI</th>
								<th>PELAPOR</th>
								<th>SKPD</th>
								<th class="text-center">IRBAN</th>
								<th class="text-center">INSPEKTUR</th>
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
		</div>
	</div>

	<div class="modal fade modal-fade-in-scale-up" id="DialogCategoryEdit" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Pesan Pelaporan</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormCategoryEdit" id="FormCategoryEdit" method="POST">
						<div class="form-group">
							<!-- <label class="col-sm-3 control-label">Nama pengirim</label> -->
							<div class="col-sm-12">
								<input type="text" name="Author" id="Author" placeholder="Nama pengirim"
									class="form-control tooltip-right" title="Nama pengirim" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<textarea name="Content " id="Content" placeholder="Keterangan"
									class="form-control tooltip-right" title="Keterangan"
									rows="5"> <?= $row->Content; ?></textarea>
							</div>
						</div>

						<input type="hidden" id="IdKonsultasi" name="IdKonsultasi" />
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
							value="<?= $this->security->get_csrf_hash(); ?>" />
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
							<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<?php $this->load->view('backend/footer'); ?>

	<!-- 	<script src="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/js/jszip.min.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/js/pdfmake.min.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/js/vfs_fonts.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/js/buttons.colVis.min.js"></script> -->

	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
	<script src="<?= base_url(); ?>assets/backend/vendor/datatables-buttons/js/dataTables.select.min.js"></script>
	<script>
		//------------------------------------------------------------------------------------//
		$(function () {
			//------------------------------------------------------------------------------------//
			var MyTableDashboard = $("#MyTableDashboard").dataTable({
				dom: 'Blfrtip',
				buttons: [
					'copyHtml5',
					{
						extend: 'excelHtml5',
						exportOptions: {
							columns: ':visible',
							orthogonal: 'export'
						}
					},
					{
						extend: 'print',
						text: 'Print all',
						exportOptions: {
							modifier: {
								selected: null
							},
							columns: ':visible'
						}
					},
					{
						extend: 'print',
						autoPrint: false,
						text: 'Print Terpilih',
						exportOptions: {
							columns: ':visible',
							rows: function (idx, data, node) {
								var dt = new $.fn.dataTable.Api('#MyTableDashboard');
								var selected = dt.rows({ selected: true }).indexes().toArray();

								if (selected.length === 0 || $.inArray(idx, selected) !== -1)
									return true;
								return false;
							}
						}
					},
					{
						extend: 'pdfHtml5',
						exportOptions: {
							columns: ':visible'
						}
					},
					'colvis'
				],
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
					"url": "<?= base_url(); ?>backend/pesan/NewsList",
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
					{ "data": 'FlagPublish' },
					{ "data": 'FlagPublishInspektur' },
					{ "data": 'Option' }
				],
				"lengthMenu": [
					[5, 10, 20, 50, 100],
					[5, 10, 20, 50, 100]
				],
				"pageLength": 5,
				select: true,
				"columnDefs": [
					{ "orderable": true, "targets": 0 },
					{ "orderable": true, "targets": 1 },
					{ "orderable": true, "targets": 2 },
					{ "orderable": true, "targets": 3 },
					{ "orderable": true, "targets": 4 },
					{ "orderable": true, "targets": 5, 'sClass': 'text-center' },
					{ "orderable": true, "targets": 6, 'sClass': 'text-center' },
					{ "orderable": false, "targets": 7, 'sClass': 'text-center' }

				],
				"order": [
					[0, "desc"]
				]
			});
			/*-------------------------------------------------------------------------------------*/
			$("#Refresh").click(function () { MyTableDashboard.fnDraw(); });
			$(".buttons-pdf").addClass("btn-danger");
			$(".buttons-excel").addClass("btn-success");
			/*-------------------------------------------------------------------------------------*/
			$('#MyTableDashboard_filter').appendTo('#MyTableDashboard_length');

			$("#FormCategoryEdit").submit(function (e) {
				e.preventDefault();
				if ($("#FormCategoryEdit").valid()) {
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
									var form = $("#FormCategoryEdit").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/pesan/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=pesanUpdate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												// $("#DialogCategoryEdit").modal('hide');
												MyTableDashboard.fnDraw();
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


		});
		//------------------------------------------------------------------------------------//
		function NewsDelete(IdKonsultasi) {
			bootbox.dialog({
				message: "Anda yakin akan menghapus pesan ini?",
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
								url: '<?= base_url(); ?>backend/pesan/ajax',
								type: 'POST',
								data: {
									'do': 'NewsDelete',
									'IdKonsultasi': IdKonsultasi,
									'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
								},
								dataType: 'json',
								beforeSend: function () {
									//myLoader.show();
								},
								success: function (respon) {
									myLoader.hide();
									if (respon.status == 'sukses') {
										$("#MyTableDashboard").dataTable().fnDraw();
										$.growl({ title: respon.status, message: respon.message });
									}
									if (respon.status == 'gagal') {
										$.growl.warning({ title: respon.status, message: respon.message });
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

		function pesan(IdKonsultasi) {
			$.ajax({
				url: '<?= base_url(); ?>backend/pesan/ajax',
				type: 'POST',
				data: {
					'do': 'pesan',
					'IdKonsultasi': IdKonsultasi,
					'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					//myLoader.show();
				},
				success: function (respon) {
					myLoader.hide();
					if (respon.status == 'sukses') {
						$.each(respon.data, function (index, element) {
							$("#FormCategoryEdit").find("#Content").val(element.Content);
							$("#FormCategoryEdit").find("#IdKonsultasi").val(element.IdKonsultasi);

						});
						$("#DialogCategoryEdit").modal('show');
					}

				},
				timeout: 20000,
				error: function () {
					myLoader.hide();
					$.growl.error({ title: 'Error', message: 'Ajax request' });
				}
			});
		}
	</script>

	<!----------------------------------------------------------------------------------------------------------------------------------------->