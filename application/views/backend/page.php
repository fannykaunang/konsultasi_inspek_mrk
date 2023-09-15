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
				<li class="active">Halaman</li>
			</ol>
			<h1 class="page-title">Daftar Halaman Statis</h1>
			<div class="page-header-actions">
				<a href="<?= base_url(); ?>backend/page/add" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" data-original-title="Halaman Baru" id="AddPage">
					<i class="icon wb-plus-circle" aria-hidden="true"></i>
				</a>
				<button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" data-original-title="Refresh" id="Refresh">
					<i class="icon wb-refresh" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-sm-4">
					<!-- Widget -->
					<div class="widget">
						<div class="widget-content padding-10 bg-green-600">
							<div class="widget-watermark darker font-size-60 margin-15"><i class="icon wb-order" aria-hidden="true"></i></div>
							<div class="counter counter-md counter-inverse text-left">
								<div class="counter-number-group">
									<span class="counter-number"><?= $totalpage; ?></span>
									<span class="counter-number-related text-capitalize">halaman</span>
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
							<div class="widget-watermark darker font-size-60 margin-15"><i class="icon wb-eye" aria-hidden="true"></i></div>
							<div class="counter counter-md counter-inverse text-left">
								<div class="counter-number-group">
									<span class="counter-number"><?= $totalpagepublish; ?></span>
									<span class="counter-number-related text-capitalize">halaman</span>
								</div>
								<div class="counter-label text-capitalize">di publish</div>
							</div>
						</div>
					</div>
					<!-- End Widget -->
				</div>
				<div class="col-sm-4">
					<!-- Widget  -->
					<div class="widget">
						<div class="widget-content padding-10 bg-cyan-600">
							<div class="widget-watermark lighter font-size-60 margin-15"><i class="icon wb-eye-close" aria-hidden="true"></i></div>
							<div class="counter counter-md counter-inverse text-left">
								<div class="counter-number-wrap font-size-30">
									<span class="counter-number"><?= $totalpagedraft; ?></span>
									<span class="counter-number-related text-capitalize">halaman</span>
								</div>
								<div class="counter-label text-capitalize">di draft</div>
							</div>
						</div>
					</div>
					<!-- End Widget -->
				</div>
			</div>


			<div class="panel">
				<div class="panel-body">

					<?php if ($role['RoleNewsView'] == 'yes') {; ?>

						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th class="col-md-3">TGL POSTING</th>
									<th>JUDUL HALAMAN</th>
									<th>KATEGORI</th>
									<th>PENULIS</th>
									<th class="text-center">PUBLISH</th>
									<th class="text-center col-md-2">OPSI</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="col-md-3">TGL POSTING</th>
									<th>JUDUL HALAMAN</th>
									<th>KATEGORI</th>
									<th>PENULIS</th>
									<th class="text-center">PUBLISH</th>
									<th class="text-center col-md-2">OPSI</th>
								</tr>
							</tfoot>
						</table>

					<?php } else {
						$this->load->view('backend/no-access');
					} ?>


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
	<?php $this->load->view('backend/footer'); ?>
	<script>
		//------------------------------------------------------------------------------------//
		$(function() {
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
					"url": "<?= base_url(); ?>backend/page/PageList",
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
						"data": 'CreatedPage'
					},
					{
						"data": 'TitlePage'
					},
					{
						"data": 'CategoryPage'
					},
					{
						"data": 'AuthorPage'
					},
					{
						"data": 'FlagPublish'
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
						"targets": 2
					},
					{
						"orderable": true,
						"targets": 3
					},
					{
						"orderable": true,
						"targets": 4,
						'sClass': 'text-center'
					},
					{
						"orderable": false,
						"targets": 5,
						'sClass': 'text-center'
					}

				],
				"order": [
					[0, "desc"]
				]
			});
			/*-------------------------------------------------------------------------------------*/
			$("#Refresh").click(function() {
				MyTable.fnDraw();
			});
			/*-------------------------------------------------------------------------------------*/
		});
		//------------------------------------------------------------------------------------//
		function PageDelete(IdPage) {
			bootbox.dialog({
				message: "Anda yakin akan menghapus halaman ini?",
				title: "Konfirmasi",
				buttons: {
					danger: {
						label: "No",
						className: "btn-default",
						callback: function() {}
					},
					main: {
						label: "Yes",
						className: "btn-primary",
						callback: function() {
							$.ajax({
								url: '<?= base_url(); ?>backend/page/ajax',
								type: 'POST',
								data: {
									'do': 'PageDelete',
									'IdPage': IdPage,
									'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
								},
								dataType: 'json',
								beforeSend: function() {
									//myLoader.show();
								},
								success: function(respon) {
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
	</script>

	<!----------------------------------------------------------------------------------------------------------------------------------------->