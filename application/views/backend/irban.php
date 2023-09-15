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
				<li class="active">Inspektur Pembantu</li>
			</ol>
			<h1 class="page-title">Daftar Inspektur Pembantu</h1>
			<div class="page-header-actions">
				<button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
					data-original-title="Kategori baru" onclick="CategoryCreate();">
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
					<table id="MyTable" class="table table-condensed table-striped table-hover">
						<thead>
							<tr>
								<th>IRBAN WILAYAH</th>
								<th>DESKRIPSI</th>
								<th>USER</th>
								<th class="text-center col-md-2">OPSI</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<div class="modal fade modal-fade-in-scale-up" id="DialogCategoryCreate" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Irban Baru</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormCategoryCreate" id="FormCategoryCreate" method="POST">
						<div class="form-group">
							<label for="kategori" class="col-md-3 control-label">User IRBAN</label>
							<div class="col-md-9 errMsg">
								<select class="form-control show-menu-arrow" name="UserIrban" id="UserIrban"
									data-plugin="selectpicker" required>
									<option value="" selected disabled hidden>-PILIH-</option>
									<?php
									foreach ($user_irban as $row) {
										?>
										<option value="<?= $row->IdUser; ?>"><?= $row->NameUser; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="kategori" class="col-md-3 control-label">IRBAN</label>
							<div class="col-md-9 errMsg">
								<select class="form-control show-menu-arrow" name="NameCategory" id="NameCategory"
									data-plugin="selectpicker">
									<option value="" selected>-PILIH-</option>
									<option value="IRBAN WILAYAH 1">IRBAN WILAYAH 1</option>
									<option value="IRBAN WILAYAH 2">IRBAN WILAYAH 2</option>
									<option value="IRBAN WILAYAH 3">IRBAN WILAYAH 3</option>
									<option value="IRBAN WILAYAH 4">IRBAN WILAYAH 4</option>
									<option value="IRBAN WILAYAH 5">IRBAN WILAYAH 5</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Deskripsi</label>
							<div class="col-sm-9">
								<textarea type="text" name="Description" id="Description" placeholder="Deskripsi"
									class="form-control tooltip-right" title="Deskripsi" /></textarea>
							</div>
						</div>
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

	<div class="modal fade modal-fade-in-scale-up" id="DialogCategoryEdit" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Irban</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormCategoryEdit" id="FormCategoryEdit" method="POST">
						<div class="form-group">
							<label class="col-sm-3 control-label">IRBAN</label>
							<div class="col-sm-9">
								<input type="text" name="NameCategory" id="NameCategory" placeholder="Nama kategori"
									class="form-control tooltip-right" title="Judul slide" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Deskripsi</label>
							<div class="col-sm-9">
								<textarea type="text" name="Description" id="Description" placeholder="Deskripsi"
									class="form-control tooltip-right" title="Deskripsi" /></textarea>
							</div>
						</div>
						<input type="hidden" id="IdCategory" name="IdCategory" />
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
					"url": "<?= base_url(); ?>backend/irban/IrbanCategoryList",
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
					{ "data": 'NameCategory' },
					{ "data": 'Description' },
					{ "data": 'NameUser' },
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
					{ "orderable": true, "targets": 3, 'sClass': 'text-center' }

				],
				"order": [
					[2, "desc"]
				]
			});
			//------------------------------------------------------------------------------------//
			$("#FormCategoryCreate").validate({
				ignore: ":hidden:not(.selectpicker)",
				rules: {
					UserIrban: {
						'required': true
					},
					NameCategory: {
						'required': true
					}
				},
				messages: {
					UserIrban: {
						required: 'User harus dupilih'
					},
					NameCategory: {
						required: 'Irban harus dupilih'
					}
				},
				errorElement: 'span',
				errorPlacement: function (error, element) {
					error.addClass('invalid-feedback');
					element.closest('.errMsg').append(error);
				},
				highlight: function (element, errorClass, validClass) {
					$(element).addClass('is-invalid');
				},
				unhighlight: function (element, errorClass, validClass) {
					$(element).removeClass('is-invalid');
				}
			}).settings.ignore =
				':not(select:hidden, input:visible, textarea:visible)';
			$("#FormCategoryCreate").submit(function (e) {
				e.preventDefault();
				if ($("#FormCategoryCreate").valid()) {
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
									var form = $("#FormCategoryCreate").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/irban/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=CategoryCreate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												$("#DialogCategoryCreate").modal('hide');
												$("#FormCategoryCreate").trigger("reset");
												MyTable.fnDraw();

											}
											if (respon.status == 'gagal') {
												$.growl.warning({ title: respon.status, message: respon.message });
												$("#FormCategoryCreate").find("#NameCategory").focus();
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
			$("#Refresh").click(function () { MyTable.fnDraw(); });
			//------------------------------------------------------------------------------------//
			$("#FormCategoryEdit").validate({
				rules: {
					NameCategory: {
						'required': true
					},
					Description: {
						'required': true
					}
				},
				messages: {
					NameCategory: {
						required: 'Judul harus diisi'
					},
					Description: {
						required: 'Deskripsi harus diisi'
					}
				}
			});
			$("#FormCategoryEdit").submit(function (e) {
				e.preventDefault();
				if ($("#FormCategoryEdit").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menupdate IRBAN ini?",
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
										url: '<?= base_url(); ?>backend/irban/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=CategoryUpdate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												$("#DialogCategoryEdit").modal('hide');
												MyTable.fnDraw();
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
		function CategoryCreate() {
			$("#DialogUploadFile").on('shown.bs.modal', function () {
				$("#DialogUploadFile").find("#NameCategory").focus();
			});
			$("#DialogUploadFile").modal('show');
		}
		//------------------------------------------------------------------------------------//
		$("#FormUploadFile").validate({
			rules: {
				NameCategory: {
					'required': true
				},
				Description: {
					'required': true
				}
			},
			messages: {
				NameCategory: {
					required: 'Judul harus diisi'
				},
				Description: {
					required: 'Deskripsi harus diisi'
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
					$.growl({ title: 'sukses', message: 'Upload file' });
					$("#MyTable").dataTable().fnDraw();
					$("#FormUploadFile").trigger("reset");
					$("#StatusUpload").html('process');
				}
				if (status == 'gagal') {
					myLoader.hide();
					$("#ResponUpload").fadeIn();
					$("#UploadFile").val('');
					$.growl.error({ title: 'gagal', message: 'Upload file gagal' });
					$("#StatusUpload").html('process');
				}
			}, timeout);
		}
		//------------------------------------------------------------------------------------//
		//------------------------------------------------------------------------------------//	
		function CategoryDelete(IdCategory) {
			bootbox.dialog({
				message: "Anda yakin akan menghapus IRBAN ini?",
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
									'do': 'CategoryDelete',
									'IdCategory': IdCategory,
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
		//------------------------------------------------------------------------------------//
		function CategoryCreate() {
			$("#DialogCategoryCreate").on('shown.bs.modal', function () {
				$("#DialogCategoryCreate").find("#NameCategory").focus();
			});
			$("#DialogCategoryCreate").modal('show');
		}
		//------------------------------------------------------------------------------------//
		function CategoryEdit(IdCategory) {
			$.ajax({
				url: '<?= base_url(); ?>backend/irban/ajax',
				type: 'POST',
				data: {
					'do': 'CategoryEdit',
					'IdCategory': IdCategory,
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
							$("#FormCategoryEdit").find("#NameCategory").val(element.NameCategory);
							$("#FormCategoryEdit").find("#Description").val(element.Description);
							$("#FormCategoryEdit").find("#IdCategory").val(element.IdCategory);

						});
						$("#FormCategoryEdit").on('shown.bs.modal', function () {
							$("#FormCategoryEdit").find("#NameCategory").focus();
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
	//------------------------------------------------------------------------------------//

	</script>

	<!----------------------------------------------------------------------------------------------------------------------------------------->