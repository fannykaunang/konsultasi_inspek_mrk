<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>

<body class="site-menubar-unfold site-menubar-keep">
	<?php $this->load->view('backend/navbar'); ?>
	<?php $this->load->view('backend/sidebar'); ?>
	<!-- Page -->
	<div class="page animsition">
		<div class="page-header">
			<ol class="breadcrumb">
				<li><a href="<?= base_url(); ?>backend">Dasbor</a></li>
				<li><a href="<?= base_url(); ?>backend/irban">Inspektur Pembantu</a></li>
				<li class="active">Detail Inpektur Pembantu</li>
			</ol>
			<h1 class="page-title">Detail Inspektur Pembantu</h1>
			<div class="page-header-actions">
				<button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" data-original-title="Unggah data"
					onclick="FileCreate();">
					<i class="icon wb-plus-circle" aria-hidden="true"></i>
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
					<div class="alert alert-info">Ada (
						<?= $totalirban; ?>) data di (
						<?= $namecategory; ?>) ini
					</div>
					<table id="MyTable" class="table table-condensed table-striped table-hover">
						<thead>
							<tr>
								<th>SATUAN KERJA</th>
								<th>NAMA PEGAWAI</th>
								<th>NO.TELP</th>
								<th>IRBAN</th>
								<th class="text-center col-md-2">OPSI</th>
							</tr>
						</thead>
					</table>
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
					<h4 class="modal-title" id="myModalLabel">Tambah SKPD di <a style="color: #FF0000;">
							<?= $namecategory; ?>
						</a></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormUploadFile" id="FormUploadFile" method="POST">
						<div class="form-group">
							<label for="NamaSkpd" class="col-md-3 control-label">SKPD</label>
							<div class="col-md-9">
								<select class="form-control show-menu-arrow" name="NamaSkpd" id="NamaSkpd"
									data-plugin="selectpicker">
									<option value="" selected>-PILIH-</option>
									<?php
									foreach ($skpd as $row) {
										?>
										<option value="<?= $row->IdSkpd; ?>"><?= $row->NamaSkpd; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Pegawai</label>
							<div class="col-sm-9">
								<input type="text" name="NamaPegawai" id="NamaPegawai" placeholder="Nama Pegawai"
									class="form-control tooltip-right" title="Nama Pegawai" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">No. Telepon</label>
							<div class="col-sm-9">
								<input type="text" name="NoTelp" id="NoTelp" placeholder="No. Telepon"
									class="form-control tooltip-right" title="No. Telepon" />
							</div>
						</div>
						<input type="hidden" name="IdCategory" id="IdCategory" value="<?= $idcategory; ?>" />
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
							value="<?= $this->security->get_csrf_hash(); ?>" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
					<button type="submit" class="btn btn-primary" id="okButton">Kirim</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade modal-fade-in-scale-up" id="DialogFileEdit" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update data</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormFileEdit" id="FormFileEdit" method="POST">
						<div class="form-group">
							<label for="kategori" class="col-md-3 control-label">SKPD</label>
							<div class="col-md-9">
								<select class="form-control show-menu-arrow" name="NamaSkpd" id="NamaSkpd" disabled
									data-plugin="selectpicker">
									<option value="" selected>-PILIH-</option>
									<?php
									foreach ($skpd as $row) {
										?>
										<option value="<?= $row->IdSkpd; ?>"><?= $row->NamaSkpd; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Pegawai</label>
							<div class="col-sm-9">
								<input type="text" name="NamaPegawai" id="NamaPegawai" placeholder="Nama Pegawai"
									class="form-control tooltip-right" title="Nama Pegawai" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">No. Telepon</label>
							<div class="col-sm-9">
								<input type="text" name="NoTelp" id="NoTelp" placeholder="No. Telepon"
									class="form-control tooltip-right" title="No. Telepon" />
							</div>
						</div>
						<!-- <input type="hidden" name="IdCategory" id="IdCategory" value="<?= $idcategory; ?>"/> -->
						<input type="hidden" name="IdIrban" id="IdIrban" />
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
							value="<?= $this->security->get_csrf_hash(); ?>" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
					<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
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
					"url": "<?= base_url(); ?>backend/irban/IrbanList",
					"type": "POST",
					"data": {
						'IdCategory': '<?= $idirbanlist; ?>',
						'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
					},
					"error": function () {
						$.growl.error({ title: 'Error', message: 'Ajax request' });
					}
				},
				"bStateSave": true,
				"fnDrawCallback": function (oSettings) {
				},
				"columns": [
					{ "data": 'NamaSkpd' },
					{ "data": 'NamaPegawai' },
					{ "data": 'NoTelp' },
					{ "data": 'Category' },
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
					{ "orderable": true, "targets": 4, 'sClass': 'text-center' }

				],
				"order": [
					[3, "desc"]
				]
			});
			//------------------------------------------------------------------------------------//	
			$("#Refresh").click(function () { MyTable.fnDraw(); });
			//------------------------------------------------------------------------------------//
			$("#FormFileEdit").validate({
				rules: {
					NoTelp: {
						'required': true
					},
					NamaPegawai: {
						'required': true
					}
				},
				messages: {
					NoTelp: {
						required: 'NoTelp harus diisi'
					},
					NamaPegawai: {
						required: 'Nama Pegawai harus diisi'
					}
				}
			});
			$("#FormFileEdit").submit(function (e) {
				e.preventDefault();
				if ($("#FormFileEdit").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan data ini?",
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
									var form = $("#FormFileEdit").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/irban/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=FileUpdate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												$("#DialogFileEdit").modal('hide');
												MyTable.fnDraw();
											}
											if (respon.status == 'gagal') {
												$.growl.warning({ title: respon.status, message: respon.message });
												$("#FormUploadFile").find("#NamaSkpd").focus();
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

			$("#FormUploadFile").validate({
				rules: {
					NoTelp: {
						'required': true
					},
					NamaPegawai: {
						'required': true
					}
				},
				messages: {
					NoTelp: {
						required: 'No Telepon harus diisi'
					},
					NamaPegawai: {
						required: 'Nama Pegawai harus diisi'
					}
				}
			});

			$("#FormUploadFile").submit(function (e) {
				e.preventDefault();
				if ($("#FormUploadFile").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan data ini?",
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
									var form = $("#FormUploadFile").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/irban/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=FileCreate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												$("#DialogUploadFile").modal('hide');
												$("#FormCategoryCreate").trigger("reset");
												MyTable.fnDraw();
											}
											if (respon.status == 'gagal') {
												$.growl.warning({ title: respon.status, message: respon.message });
												$("#FormUploadFile").find("#NamaSkpd").focus();
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

		function FileDelete(IdIrban) {
			bootbox.dialog({
				message: "Anda yakin akan menghapus data ini?",
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
								url: '<?= base_url(); ?>backend/irban/ajax',
								type: 'POST',
								data: {
									'do': 'FileDelete',
									'IdIrban': IdIrban,
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
										$.growl({ title: respon.status, message: respon.message });
										setTimeout(function () {
											location.reload();
										}, 1000);
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

		function FileEdit(IdIrban) {
			$.ajax({
				url: '<?= base_url(); ?>backend/irban/ajax',
				type: 'POST',
				data: {
					'do': 'FileEdit',
					'IdIrban': IdIrban,
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
							$("#FormFileEdit").find("#NamaPegawai").val(element.NamaPegawai);
							$("#FormFileEdit").find("#NoTelp").val(element.NoTelp);
							$("#FormFileEdit").find("#IdIrban").val(element.IdIrban);
							$("#FormFileEdit").find("#IdCategory").val(element.IdCategory).change();
							$("#FormFileEdit").find("#NamaSkpd").val(element.IdSkpd).change();

						});
						$("#FormFileEdit").on('shown.bs.modal', function () {
							$("#FormFileEdit").find("#NamaSkpd").focus();
						});
						$("#DialogFileEdit").modal('show');
					}
				},
				timeout: 20000,
				error: function () {
					myLoader.hide();
					$.growl.error({ title: 'Error', message: 'Ajax request' });
				}
			});
		}

		function FileCreate() {
			$("#DialogUploadFile").on('shown.bs.modal', function () {
				$("#DialogUploadFile").find("#NamaSkpd").focus();
			});
			$("#DialogUploadFile").modal('show');
		}
	</script>