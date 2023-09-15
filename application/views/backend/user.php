<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>

<body class="site-menubar-unfold site-menubar-keep">
	<?php $this->load->view('backend/navbar'); ?>
	<?php $this->load->view('backend/sidebar'); ?>
	<div class="page animsition">
		<div class="page-header">
			<ol class="breadcrumb">
				<li><a href="<?= base_url(); ?>backend">Dasbor</a></li>
				<li class="active">User</li>
			</ol>
			<h1 class="page-title">Daftar User</h1>
			<div class="page-header-actions">
				<button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" <?= $RoleUserCreate; ?>
					data-original-title="User baru" onclick="UserCreate();">
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
					<?php if ($role['RoleUserView'] == 'yes') {
						; ?>
					<table id="MyTable" class="table table-condensed table-striped table-hover">
						<thead>
							<tr>
								<th class="col-md-2">NAMA</th>
								<th>LEVEL</th>
								<th>EMAIL</th>
								<th>TELEPON</th>
								<th>TERAKHIR LOGIN</th>
								<th class="text-center col-md-2">OPSI</th>
							</tr>
						</thead>
						<tfoot>
					</table>
					<?php } else {
						$this->load->view('backend/no-access');
					} ?>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page -->
	<div class="modal fade modal-fade-in-scale-up" id="DialogUserCreate" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Administrasi Pengguna</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormUserCreate" id="FormUserCreate" method="POST">
						<div class="form-group">
							<label for="kategori" class="col-md-3 control-label">SKPD</label>
							<div class="col-md-9">
								<select class="form-control show-menu-arrow" name="Skpd" id="Skpd"
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
							<label class="col-md-3 control-label">Username</label>
							<div class="col-md-9">
								<input type="text" name="NameUser" id="NameUser" placeholder="Username"
									class="form-control tooltip-right" title="Username" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Nama Lengkap</label>
							<div class="col-md-9">
								<input type="text" name="FullName" id="FullName" placeholder="Nama lengkap"
									class="form-control tooltip-right" title="Nama lengkap" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Tingkat</label>
							<div class="col-md-6">
								<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="LevelUser"
									id="LevelUser">
									<option value="superadmin">Administrator</option>
									<option value="Inspektur">Inspektur</option>
									<option value="IRBAN">IRBAN</option>
									<option value="SKPD">SKPD</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Email</label>
							<div class="col-md-6">
								<input type="text" name="EmailUser" id="EmailUser" placeholder="Email"
									class="form-control tooltip-right" title="Email" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Password</label>
							<div class="col-md-9">
								<input type="password" name="PasswordUser" id="PasswordUser" placeholder="Password"
									class="form-control tooltip-right" title="Password" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Status</label>
							<div class="col-md-6">
								<select class="form-control show-menu-arrow" data-plugin="selectpicker"
									name="StatusUser" id="StatusUser" />
								<option value="aktif">Aktif</option>
								<option value="nonaktif">Nonaktif</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Alamat</label>
							<div class="col-md-9">
								<textarea name="AddressUser" id="AddressUser" placeholder="Alamat"
									class="form-control tooltip-right" title="Alamat" /></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Tema</label>
							<div class="col-md-6">
								<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="Theme"
									id="Theme" />
								<option value="red" selected> Default</option>
								<option value="brown"> Brown</option>
								<option value="cyan"> Cyan </option>
								<option value="blue"> Blue </option>
								<option value="green"> Green </option>
								<option value="indigo"> Indigo </option>
								<option value="orange"> Orange </option>
								<option value="grey"> Grey </option>
								<option value="pink"> Pink </option>
								<option value="purple"> Purple </option>
								<option value="teal"> Teal </option>
								<option value="yellow"> Yellow </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Telepon</label>
							<div class="col-md-6">
								<input type="text" name="PhoneUser" id="PhoneUser" placeholder="Telepon"
									class="form-control tooltip-right" title="Telepon" />
							</div>
						</div>

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
	<div class="modal fade modal-fade-in-scale-up" id="DialogUserEdit" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Pengguna</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FormUserEdit" id="FormUserEdit" method="POST">
						<div class="form-group" style="margin-bottom:14px;">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<!-- <img src="#" width="120" height="120" alt="" id="PictureUser" name="PictureUser"
									class="img-circle" /> -->
								<div class="div-circle" id="PictureUser"></div>
							</div>
							<div class="col-md-4"></div>
						</div>

						<!-- <div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-9">
								<div id="PictureUser"></div>
							</div>
						</div> -->

						<div class="form-group">
							<label class="col-sm-3 control-label">SKPD</label>
							<div class="col-sm-9">
								<input type="text" name="Skpd" id="Skpd" placeholder="Nama SKPD"
									class="form-control tooltip-right" title="Nama SKPD" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Username</label>
							<div class="col-md-9">
								<input type="text" name="NameUser" id="NameUser" placeholder="Nama user"
									class="form-control tooltip-right" title="Nama user" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Nama Lengkap</label>
							<div class="col-md-9">
								<input type="text" name="FullName" id="FullName" placeholder="Nama lengkap"
									class="form-control tooltip-right" title="Nama lengkap" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Tingkat</label>
							<div class="col-md-6">
								<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="LevelUser"
									id="LevelUser">
									<option value="superadmin">Administrator</option>
									<option value="Inspektur">Inspektur</option>
									<option value="IRBAN">IRBAN</option>
									<option value="SKPD">SKPD</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Email</label>
							<div class="col-md-6">
								<input type="text" name="EmailUser" id="EmailUser" placeholder="Email"
									class="form-control tooltip-right" title="Email" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Password</label>
							<div class="col-md-9">
								<input type="password" name="PasswordUser" id="PasswordUser" autocomplete="off"
									placeholder="kosong [tidak diubah]" class="form-control tooltip-right"
									title="Password" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Status</label>
							<div class="col-md-6">
								<select class="form-control show-menu-arrow" data-plugin="selectpicker"
									name="StatusUser" id="StatusUser">
									<option value="aktif">Aktif</option>
									<option value="nonaktif">Nonaktif</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Alamat</label>
							<div class="col-md-9">
								<textarea name="AddressUser" id="AddressUser" placeholder="Alamat"
									class="form-control tooltip-right" title="Alamat" /></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Tema</label>
							<div class="col-md-6">
								<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="Theme"
									id="Theme" />
								<?php
								if ($theme == 'red' ? $selred = 'selected' : $selred = '')
									;
								if ($theme == 'brown' ? $selbrown = 'selected' : $selbrown = '')
									;
								if ($theme == 'cyan' ? $selcyan = 'selected' : $selcyan = '')
									;
								if ($theme == 'blue' ? $selblue = 'selected' : $selblue = '')
									;
								if ($theme == 'green' ? $selgreen = 'selected' : $selgreen = '')
									;
								if ($theme == 'indigo' ? $selindigo = 'selected' : $selindigo = '')
									;
								if ($theme == 'orange' ? $selorange = 'selected' : $selorange = '')
									;
								if ($theme == 'grey' ? $selgrey = 'selected' : $selgrey = '')
									;
								if ($theme == 'pink' ? $selpink = 'selected' : $selpink = '')
									;
								if ($theme == 'purple' ? $selpurple = 'selected' : $selpurple = '')
									;
								if ($theme == 'teal' ? $selteal = 'selected' : $selteal = '')
									;
								if ($theme == 'yellow' ? $selyellow = 'selected' : $selyellow = '')
									;
								?>
								<option value="red" <?= $selred; ?>> Default</option>
								<option value="brown" <?= $selbrown; ?>> Brown</option>
								<option value="cyan" <?= $selcyan; ?>> Cyan </option>
								<option value="blue" <?= $selblue; ?>> Blue </option>
								<option value="green" <?= $selgreen; ?>> Green </option>
								<option value="indigo" <?= $selindigo; ?>> Indigo </option>
								<option value="orange" <?= $selorange; ?>> Orange </option>
								<option value="grey" <?= $selgrey; ?>> Grey </option>
								<option value="pink" <?= $selpink; ?>> Pink </option>
								<option value="purple" <?= $selpurple; ?>> Purple </option>
								<option value="teal" <?= $selteal; ?>> Teal </option>
								<option value="yellow" <?= $selyellow; ?>> Yellow </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Telepon</label>
							<div class="col-md-6">
								<input type="text" name="PhoneUser" id="PhoneUser" placeholder="Telepon"
									class="form-control tooltip-right" title="Telepon" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Tentang Pelapor</label>
							<div class="col-md-9">
								<textarea name="AboutMe" id="AboutMe" placeholder="Tentang Pelapor"
									class="form-control tooltip-right" title="Tentang Pelapor" /></textarea>
							</div>
						</div>
						<input type="hidden" id="IdUser" name="IdUser" />
						<input type="hidden" id="NamaUserOld" name="NamaUserOld" />

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
					"url": "<?= base_url(); ?>backend/user/UserList",
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
					"data": 'NameUser'
				},
				{
					"data": 'LevelUser'
				},
				{
					"data": 'EmailUser'
				},
				{
					"data": 'PhoneUser'
				},
				{
					"data": 'LastLogin'
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
					"targets": 4
				},
				{
					"orderable": false,
					"targets": 5,
					'sClass': 'text-center'
				}
				],
				"order": [
					[4, "desc"]
				]
			});
			//------------------------------------------------------------------------------------//
			$("#Refresh").click(function () {
				MyTable.fnDraw();
			});
			//------------------------------------------------------------------------------------//
			$("#FormUserCreate").validate({
				rules: {
					NameUser: {
						required: true
					},
					Skpd: {
						required: true
					},
					FullName: {
						required: true
					},
					PhoneUser: {
						required: true,
						'number': true
					},
					EmailUser: {
						required: true,
						'email': true
					},
					PasswordUser: {
						required: true
					},
					AddressUser: {
						required: true
					},
				},
				messages: {
					NameUser: {
						required: 'Nama user harus diisi'
					},
					Skpd: {
						required: 'Nama Skpd harus diisi'
					},
					FullName: {
						required: 'Nama lengkap harus diisi'
					},
					EmailUser: {
						required: 'Email harus diisi',
						email: 'Email harus valid'
					},
					PhoneUser: {
						required: 'Telepon harus diisi',
						number: 'Telepon harus angka'
					},
					AddressUser: {
						required: 'Alamat harus diisi'
					},
					PasswordUser: {
						required: 'Password harus diisi'
					}
				}
			});
			$("#FormUserCreate").submit(function (e) {
				e.preventDefault();
				if ($("#FormUserCreate").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan user ini?",
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
									var form = $("#FormUserCreate").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/user/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=UserCreate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#DialogUserCreate").modal('hide');
												$("#FormUserCreate").trigger("reset");
												MyTable.fnDraw();
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
			$("#FormUserEdit").validate({
				rules: {
					NameUser: {
						required: true
					},
					FullName: {
						required: true
					},
					PhoneUser: {
						required: true,
						'number': true
					},
					EmailUser: {
						required: true,
						'email': true
					},
					AddressUser: {
						required: true
					},
				},
				messages: {
					NameUser: {
						required: 'Nama user harus diisi'
					},
					FullName: {
						required: 'Nama lengkap harus diisi'
					},
					EmailUser: {
						required: 'Email harus diisi',
						email: 'Email harus valid'
					},
					PhoneUser: {
						required: 'Telepon harus diisi',
						number: 'Telepon harus angka'
					},
					AddressUser: {
						required: 'Alamat harus diisi'
					}
				}
			});
			$("#FormUserEdit").submit(function (e) {
				e.preventDefault();
				if ($("#FormUserEdit").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan user ini?",
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
									var form = $("#FormUserEdit").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/user/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=UserUpdate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#DialogUserEdit").modal('hide');
												MyTable.fnDraw();
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
		//------------------------------------------------------------------------------------//
		function UserCreate() {
			$("#DialogUserCreate").on('shown.bs.modal', function () {
				$("#FormUserCreate").find("#Skpd").focus();
			});
			$("#DialogUserCreate").modal('show');
		}
		//------------------------------------------------------------------------------------//	
		function UserDelete(IdUser) {
			bootbox.dialog({
				message: "Anda yakin akan menghapus user ini?",
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
								url: '<?= base_url(); ?>backend/user/ajax',
								type: 'POST',
								data: {
									'do': 'UserDelete',
									'IdUser': IdUser,
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
									if (respon.status == 'email ada') {
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
		function UserEdit(IdUser) {
			$.ajax({
				url: '<?= base_url(); ?>backend/user/ajax',
				type: 'POST',
				data: {
					'do': 'UserEdit',
					'IdUser': IdUser,
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
							$("#FormUserEdit").find("#NameUser").val(element.NameUser);
							$("#FormUserEdit").find("#NameUserOld").val(element.NameUser);
							$("#FormUserEdit").find("#FullName").val(element.FullName);
							$("#FormUserEdit").find("#EmailUser").val(element.EmailUser);
							$("#FormUserEdit").find("#PhoneUser").val(element.PhoneUser);
							$("#FormUserEdit").find("#AddressUser").val(element.AddressUser);
							$("#FormUserEdit").find("#LevelUser").val(element.LevelUser).change();
							$("#FormUserEdit").find("#StatusUser").val(element.StatusUser).change();
							$("#FormUserEdit").find("#Theme").val(element.Theme).change();
							$("#FormUserEdit").find("#Skpd").val(element.NamaSkpd).change();

							$("#FormUserEdit").find("#IdUser").val(element.IdUser);
							$("#FormUserEdit").find("#AboutMe").val(element.AboutMe);
							$("#FormUserEdit").find("#PictureUser").html(element.PictureUser);

						});
						$("#DialogUserEdit").on('shown.bs.modal', function () {
							$("#DialogUserEdit").find("#NamaSkpd").focus();
						});
						$("#DialogUserEdit").modal('show');
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
	</script>
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<script>
		$("#LoginAsContributor").click(function () {
			$("#DialogLoginContributor").modal('show');
		});

		$(function () {
			//------------------------------------------------------------------------------------//
			$("#FormLoginContributor").validate({
				rules: {
					IdUser: {
						required: true
					}
				},
				messages: {
					IdUser: {
						required: 'Nama user harus dipilih'
					}
				}
			});
			$("#FormLoginContributor").submit(function (e) {
				e.preventDefault();
				if ($("#FormLoginContributor").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan login sebagai operator atau editor ?",
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
									var form = $("#FormLoginContributor").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/user/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=LoginAsContributor&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#DialogLoginContributor").modal('hide');
												setTimeout(function () {
													location.reload();
												});
											}
											if (respon.status == 'gagal') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#DialogLoginContributor").modal('hide');
											}

										},
										timeout: 20000,
										function() {
											$.growl.error({
												title: 'Timeout',
												message: 'Request timeout'
											});
										},
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
	</script>
	<!----------------------------------------------------------------------------------------------------------------------------------------->