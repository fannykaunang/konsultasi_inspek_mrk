<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>

<body class="site-menubar-unfold site-menubar-keep">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('backend/navbar'); ?>
	<?php $this->load->view('backend/sidebar'); ?>
	<!-- Page -->
	<div class="page animsition">
		<div class="page-header">
			<ol class="breadcrumb">
				<li><a href="<?= base_url(); ?>backend">Dasbor</a></li>
				<li class="active">Satuan Kerja Perangkat Daerah</li>
			</ol>
			<h1 class="page-title">Satuan Kerja Perangkat Daerah</h1>
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
								<th>NAMA SKPD</th>
								<th>ALIAS</th>
								<th>TELPON</th>
								<th class="text-center">EMAIL</th>
								<th class="text-center">ALAMAT</th>
								<!-- <th class="text-center">AKTIF</th> -->
								<th class="text-center col-md-2">OPSI</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<!-- <div class="panel">
				<div class="panel-body">
					<h4>Keterangan</h4>
					<div class="list-group">
						<a class="list-group-item" href="javascript:void(0)">
							<h4 class="list-group-item-heading"><img src="<?= base_url(); ?>assets/backend/images/publish.png" /> Publish</h4>
							<p class="list-group-item-text">Skpd diaktif</p>
						</a>
						<a class="list-group-item" href="javascript:void(0)">
							<h4 class="list-group-item-heading"><img src="<?= base_url(); ?>assets/backend/images/draft.png" /> Draft</h4>
							<p class="list-group-item-text">Skpd nonaktif</p>
						</a>
					</div>
				</div>
			</div> -->
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
					<h4 class="modal-title" id="myModalLabel">SKPD Baru</h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal" name="FormCategoryCreate" id="FormCategoryCreate" method="POST">

						<div class="form-group">
							<label class="col-sm-3 control-label">Nama</label>
							<div class="col-sm-9">
								<input type="text" name="NamaSkpd" id="NamaSkpd" placeholder="Nama Skpd"
									class="form-control tooltip-right" title="Nama skpd" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alias</label>
							<div class="col-sm-9">
								<input type="text" name="SkpdAlias" id="SkpdAlias" placeholder="Alias"
									class="form-control tooltip-right" title="Nama skpd" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Phone</label>
							<div class="col-sm-9">
								<input type="number" name="NoTelp" id="NoTelp" placeholder="Nomer Telpon"
									class="form-control tooltip-right" title="phone" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" name="Email" id="Email" placeholder="Email"
									class="form-control tooltip-right" title="Nama skpd" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alamat</label>
							<div class="col-sm-9">
								<textarea type="text" name="Alamat" id="Alamat" placeholder="Alamat"
									class="form-control tooltip-right" title="Deskripsi" /></textarea>
							</div>
						</div>

						<!-- <div class="form-group">
								<label for="Pilihan"  class="col-sm-3 control-label">Opsi</label>
								<div class="col-sm-5">
									<div class="form-control no-line no-left-padding">
										<input type='checkbox' class="form-inline uniformcheckbox" autocomplete="off" id="FlagPublish" name="FlagPublish"> Publish &nbsp;
									  
									</div>
								</div>				
							</div> -->


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
					<h4 class="modal-title" id="myModalLabel">Update Skpd</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormCategoryEdit" id="FormCategoryEdit" method="POST">
						<div class="form-group">
							<label class="col-sm-3 control-label">Skpd</label>
							<div class="col-sm-9">
								<input type="text" name="NamaSkpd" id="NamaSkpd" placeholder="Nama kategori"
									class="form-control tooltip-right" title="Judul slide" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alias</label>
							<div class="col-sm-9">
								<input type="text" name="SkpdAlias" id="SkpdAlias" placeholder="Alias"
									class="form-control tooltip-right" title="Judul slide" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Phone</label>
							<div class="col-sm-9">
								<input type="number" name="NoTelp" id="NoTelp" placeholder="Nomer Telpon"
									class="form-control tooltip-right" title="Judul slide" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" name="Email" id="Email" placeholder="Email"
									class="form-control tooltip-right" title="Judul slide" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alamat</label>
							<div class="col-sm-9">
								<textarea type="text" name="Alamat" id="Alamat" placeholder="Deskripsi"
									class="form-control tooltip-right" title="Deskripsi" /></textarea>
							</div>
						</div>

						<!-- <div class="form-group">
									 <label class="col-sm-3 control-label">Opsi</label>
									 <div class="col-sm-9">
											<div class="form-control no-line no-left-padding">
												<input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish" name="FlagPublish"> Publish												
											</div>
									 </div>
								</div>	 -->

						<input type="hidden" id="IdSkpd" name="IdSkpd" />
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
					"url": "<?= base_url(); ?>backend/skpd/SkpdList",
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
					{ "data": 'NamaSkpd' },
					{ "data": 'SkpdAlias' },
					{ "data": 'NoTelp' },
					{ "data": 'Email' },
					{ "data": 'Alamat' },
					//{"data": 'FlagPublish'},
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
					//{ "orderable": true, "targets": 5, 'sClass': 'text-center' },
					{ "orderable": true, "targets": 5, 'sClass': 'text-center' }


				],
				"order": [
					[2, "desc"]
				]
			});
			//------------------------------------------------------------------------------------//
			$("#FormCategoryCreate").validate({
				rules: {
					NamaSkpd: {
						'required': true
					},
					SkpdAlias: {
						'required': true
					},
					NoTelp: {
						'required': true
					},
					Email: {
						'required': true
					},
					Alamat: {
						'required': true
					}
				},
				messages: {
					NamaSkpd: {
						required: 'Nama skpd harus diisi'
					},
					SkpdAlias: {
						required: 'Skpd alias harus diisi'
					},
					NoTelp: {
						required: 'Nomor telp harus diisi'
					},
					Email: {
						required: 'Email harus diisi'
					},
					Alamat: {
						required: 'Alamat harus diisi'
					}
				}
			});
			$("#FormCategoryCreate").submit(function (e) {
				e.preventDefault();
				if ($("#FormCategoryCreate").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan SKPD ini?",
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
										url: '<?= base_url(); ?>backend/skpd/ajax',
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
						message: "Apakah anda yakin akan menyimpan Skpd ini?",
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
										url: '<?= base_url(); ?>backend/skpd/ajax',
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
		//------------------------------------------------------------------------------------//	
		function CategoryDelete(IdSkpd) {
			bootbox.dialog({
				message: "Anda yakin akan menghapus skpd ini?",
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
								url: '<?= base_url(); ?>backend/skpd/ajax',
								type: 'POST',
								data: {
									'do': 'CategoryDelete',
									'IdSkpd': IdSkpd,
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
		function CategoryEdit(IdSkpd) {
			$.ajax({
				url: '<?= base_url(); ?>backend/skpd/ajax',
				type: 'POST',
				data: {
					'do': 'CategoryEdit',
					'IdSkpd': IdSkpd,
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
							$("#FormCategoryEdit").find("#NamaSkpd").val(element.NamaSkpd);
							$("#FormCategoryEdit").find("#SkpdAlias").val(element.SkpdAlias);
							$("#FormCategoryEdit").find("#NoTelp").val(element.NoTelp);
							$("#FormCategoryEdit").find("#Email").val(element.Email);
							$("#FormCategoryEdit").find("#Alamat").val(element.Alamat);
							$("#FormCategoryEdit").find("#IdSkpd").val(element.IdSkpd);
							// var FlagPublish = element.FlagPublish;
							// if(FlagPublish == 1){
							// 	$("#FormCategoryEdit").find("#FlagPublish").prop("checked", true).change();
							// 	$.uniform.update();
							// }

						});
						$("#FormCategoryEdit").on('shown.bs.modal', function () {
							$("#NamaSkpd").find("#NamaSkpd").focus();
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