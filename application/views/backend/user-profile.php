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
				<li class="active">Profil</li>
			</ol>
			<h1 class="page-title">Profil Anda</h1>
		</div>
		<div class="page-content">

			<div class="row">
				<div class="col-md-6">
					<div class="panel">
						<h4 class="panel-title">Akun Anda</h4>
						<div class="panel-body">
							<?php
							foreach ($user as $row) {
							?>
								<form class="form-horizontal" id="FormAccount" name="FormAccount" method="POST">
									<div class="form-group">
										<label for="#" class="col-md-3 control-label"></label>
										<div class="col-md-6 text-center">
											<?php
											if ($row->PictureUser !== null) {
											?>
												<img src="<?php echo base_url() . $row->PictureUser; ?>" class="img-circle" width="120" height="120" id="picture-user" />
											<?php
											} else {
											?>
												<img src="<?= base_url(); ?>assets/backend/portraits/1.jpg" class="img-circle" width="120" height="120" id="picture-user" />
											<?php
											}
											?>

											<button type="button" class="btn btn-primary btn-sm" id="UploadPictureUser">ubah</button>

										</div>
									</div>

									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Username</label>
										<div class="col-md-6">
											<input type="text" name="NameUser" id="NameUser" placeholder="Name" class="form-control tooltip-right" title="Name" value="<?= $row->NameUser; ?>" readonly />
										</div>
									</div>
									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Nama Lengkap</label>
										<div class="col-md-6">
											<input type="text" name="FullName" id="FullName" placeholder="Nama lengkap" class="form-control tooltip-right" title="Nama lengkap" value="<?= $row->FullName; ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Level</label>
											<?php
											$levelUser = $this->user_model->GetLevelUser();

											if ($levelUser == "superadmin") {
												$levelUserModified = "ADMINISTRATOR";
											} elseif ($levelUser == "contributor") {
												$levelUserModified = "SKPD";
											} elseif ($levelUser == "moderator") {
												$levelUserModified = "IRBAN";
											} else {
												$levelUserModified = $levelUser; // Jika level tidak sesuai kriteria, gunakan nilai asli
											}
											?>
										<div class="col-md-6">
											<input type="text" name="LevelUser" id="LevelUser" placeholder="LevelUser" class="form-control tooltip-right" title="Level" value="<?= $levelUserModified; ?>" readonly />
										</div>

									</div>
									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Phone</label>
										<div class="col-md-6">
											<input type="text" name="PhoneUser" id="PhoneUser" placeholder="PhoneUser" class="form-control tooltip-right" title="Phone User" value="<?= $row->PhoneUser; ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Address</label>
										<div class="col-md-9">
											<textarea name="AddressUser" id="AddressUser" class="form-control tooltip-right" title="Address" rows="4" placeholder="Address"><?= $row->AddressUser; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Email</label>
										<div class="col-md-6">
											<input type="text" name="EmailUser" id="EmailUser" placeholder="Email" class="form-control tooltip-right" title="Email" value="<?= $row->EmailUser; ?>" readonly />
										</div>
									</div>
									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Tentang saya</label>
										<div class="col-md-9">
											<textarea name="AboutMe" id="AboutMe" class="form-control tooltip-right" title="Tentang saya" rows="4" placeholder="Tentang saya"><?= $row->AboutMe; ?></textarea>
										</div>
									</div>

									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

									<div class="form-group">
										<label for="#" class="col-md-3 control-label"></label>
										<div class="col-md-6">
											<button type="submit" class="btn btn-primary" id="SaveButton">Simpan</button>
										</div>
									</div>
								</form>
							<?php
							}
							?>

						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel">
						<h4 class="panel-title">Password</h4>
						<div class="panel-body">
							<form class="form-horizontal" id="FormPassword" name="FormPassword" method="POST">

								<div class="form-group">
									<label for="#" class="col-md-3 control-label">Saat ini
									</label>
									<div class="col-md-6">
										<input type="password" class="form-control tooltip-right" title="Current password" name="CurrentPassword" id="CurrentPassword" placeholder="Saat ini">
									</div>
								</div>
								<div class="form-group">
									<label for="#" class="col-md-3 control-label">Baru
									</label>
									<div class="col-md-6">
										<input type="password" class="form-control tooltip-right" title="New password" name="NewPassword" id="NewPassword" placeholder="Baru">
									</div>
								</div>
								<div class="form-group">
									<label for="#" class="col-md-3 control-label">Baru (ulang)
									</label>
									<div class="col-md-6">
										<input type="password" class="form-control tooltip-right" title="New password" name="NewPasswordRepeat" id="NewPasswordRepeat" placeholder="Baru (ulang)">
									</div>
								</div>

								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
								<div class="form-group">
									<label for="#" class="col-md-3 control-label"></label>
									<div class="col-md-6">
										<button class="btn btn-primary">Simpan</button>

									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				
				<div class="col-md-6">
					<div class="panel">
						<h4 class="panel-title">Tema</h4>
						<div class="panel-body">
							<?php
							foreach ($user as $row) {
							?>
								<form class="form-horizontal" id="FormThemes" name="FormThemes" method="POST">
									<div class="form-group">
										<label for="#" class="col-md-3 control-label">Pilih Tema</label>
										<div class="col-md-6">
											<select class="form-control show-menu-arrow" data-plugin="selectpicker" name="Theme" id="Theme">
												<?php
												if ($row->Theme == 'red' ? $default = 'selected' : $default = '');
												if ($row->Theme == 'brown' ? $brown = 'selected' : $brown = '');
												if ($row->Theme == 'cyan' ? $cyan = 'selected' : $cyan = '');
												if ($row->Theme == 'blue' ? $blue = 'selected' : $blue = '');
												if ($row->Theme == 'green' ? $green = 'selected' : $green = '');
												if ($row->Theme == 'indigo' ? $indigo = 'selected' : $indigo = '');
												if ($row->Theme == 'orange' ? $orange = 'selected' : $orange = '');
												if ($row->Theme == 'grey' ? $grey = 'selected' : $grey = '');
												if ($row->Theme == 'pink' ? $pink = 'selected' : $pink = '');
												if ($row->Theme == 'purple' ? $purple = 'selected' : $purple = '');
												if ($row->Theme == 'teal' ? $teal = 'selected' : $teal = '');
												if ($row->Theme == 'yellow' ? $yellow = 'selected' : $yellow = '');

												?>
												<option value="red" <?= $default; ?>> Default</option>
												<option value="brown" <?= $brown; ?>> Brown</option>
												<option value="cyan" <?= $cyan; ?>> Cyan </option>
												<option value="blue" <?= $blue; ?>> Blue </option>
												<option value="green" <?= $green; ?>> Green </option>
												<option value="indigo" <?= $indigo; ?>> Indigo </option>
												<option value="orange" <?= $orange; ?>> Orange </option>
												<option value="grey" <?= $grey; ?>> Grey </option>
												<option value="pink" <?= $pink; ?>> Pink </option>
												<option value="purple" <?= $purple; ?>> Purple </option>
												<option value="teal" <?= $teal; ?>> Teal </option>
												<option value="yellow" <?= $yellow; ?>> Yellow </option>
											</select>
										</div>
									</div>
									<input type="hidden" name="IdUser" id="IdUser" value="<?= $row->IdUser; ?>" />
									<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

									<div class="form-group">
										<label for="#" class="col-md-3 control-label"></label>
										<div class="col-md-6">
											<button type="submit" class="btn btn-primary" id="SaveButton">Simpan</button>
										</div>
									</div>

								</form>
							<?php
							}
							?>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- End Page -->
<div class="modal fade modal-fade-in-scale-up" id="DialogUploadPictureUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Unggah</h4>
		  </div>
		  <div class="modal-body">
				
				<iframe name="IFrameUploadPictureUser" style="display:none;"></iframe>
			  	<form class="form-horizontal" name="FormUploadPictureUser" id="FormUploadPictureUser" method="POST" action="<?=base_url();?>backend/user_profile/UploadPictureUser" enctype="multipart/form-data" target="IFrameUploadPictureUser">
					
						
					<div class="form-group">
					    <label class="col-sm-3 control-label"></label>
					    <div class="col-sm-9">
					    	<div id="ResponUpload" style="display:none;"></div>
								<div id="StatusUpload" style="display:none;">process</div>
					    </div>
					  </div>
						
						
						
					  <div class="form-group">
					    <label class="col-sm-3 control-label">Unggah foto anda</label>
					    <div class="col-sm-9">

					     	<input type="file" name="userfile" id="FilePictureUser" placeholder="Pilih file" class="form-control tooltip-right" title="Pilih file"/>					
					    </div>
					  </div>
					 
					  <div class="form-group">
					  	 <label class="col-sm-3 control-label"></label>
					   	 <div class="col-sm-9">
					   	 		Format: .jpg, .jpeg, .gif dan .png
					   	 </div>
					  </div>
						
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
			
				 				 		
		  </div>
		   <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
				<button type="submit" class="btn btn-primary" id="okButton"> Unggah </button>
			  </div>
	 	</form>	  		
		</div>
 	</div>
</div>
	<?php $this->load->view('backend/footer'); ?>
	<script>
		//------------------------------------------------------------------------------------//
		$(function() {
			//------------------------------------------------------------------------------------//
			$('#FormThemes').submit(function(e) {
				e.preventDefault();
				bootbox.dialog({
					message: "Anda yakin akan mengubah tema?",
					title: "Konfirmasi",
					buttons: {
						danger: {
							label: "Tidak",
							className: "btn-default",
							callback: function() {

							}
						},
						main: {
							label: "Ya",
							className: "btn-primary",
							callback: function() {
								var form = $("#FormThemes").serialize();
								$.ajax({
									url: '<?= base_url(); ?>backend/user_profile/ajax',
									type: 'POST',
									data: 'do=SetTheme&' + form,
									dataType: 'json',
									beforeSend: function() {
										myLoader.show();
									},
									success: function(respon) {
										myLoader.hide();
										$.growl({
											title: respon.status,
											message: respon.message
										});
										if (respon.status == 'sukses') {
											setTimeout(function() {
												location.reload();
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
			});
			//------------------------------------------------------------------------------------//
			$("#FormPassword").validate({
				rules: {
					CurrentPassword: {
						'required': true
					},
					NewPassword: {
						'required': true
					},
					NewPasswordRepeat: {
						'required': true
					}
				},
				messages: {
					CurrentPassword: {
						required: 'Password sekarang harus diisi'
					},
					NewPassword: {
						required: 'Password baru harus diisi'
					},
					NewPasswordRepeat: {
						required: 'Password ulang harus diisi'
					}
				}
			});
			$("#FormPassword").submit(function(e) {
				e.preventDefault();
				if ($("#FormPassword").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan mengganti password?",
						title: "Konfirmasi",
						buttons: {
							danger: {
								label: "Tidak",
								className: "btn-default",
								callback: function() {

								}
							},
							main: {
								label: "Ya",
								className: "btn-primary",
								callback: function() {
									var form = $("#FormPassword").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/user_profile/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=UpdatePassword&' + form,
										success: function(respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												setTimeout(function() {
													window.location = '<?= base_url(); ?>backend/logout'
												}, 2000);
											}
											if (respon.status == 'Tidak sesuai') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#FormPassword").find("#NewPassword").focus();
											}
											if (respon.status == 'Password salah') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												$("#FormPassword").find("#CurrentPassword").focus();
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
			$("#FormAccount").validate({
				rules: {
					FullName: {
						'required': true
					},
					PhoneUser: {
						'required': true,
						'number': true
					},
					AddressUser: {
						'required': true
					},
					AboutMe: {
						'required': true,
					}
				},
				messages: {
					FullName: {
						required: 'Nama lengkap harus diisi'
					},
					PhoneUser: {
						required: 'No. telp. harus diisi',
						number: 'No. telp. harus diisi'
					},
					AddressUser: {
						required: 'Alamat harus diisi'
					},
					AboutMe: {
						required: 'Tentang saya harus diisi'
					}
				}
			});
			$("#FormAccount").submit(function(e) {
				e.preventDefault();
				if ($("#FormAccount").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan profil anda?",
						title: "Konfirmasi",
						buttons: {
							danger: {
								label: "Tidak",
								className: "btn-default",
								callback: function() {

								}
							},
							main: {
								label: "Ya",
								className: "btn-primary",
								callback: function() {
									var form = $("#FormAccount").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/user_profile/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=UpdateProfile&' + form,
										success: function(respon) {
											if (respon.status == 'sukses') {
												$.growl({
													title: respon.status,
													message: respon.message
												});
												setTimeout(function() {
													location.reload();
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
			$("#UploadPictureUser").click(function() {
				$("#DialogUploadPictureUser").modal('show');
			});

			
			$('#FormUploadPictureUser').submit(function() {
				// myLoader.show();

				if ($("#FormUploadPictureUser").valid()) {
					var form_data = new FormData($("#FormUploadPictureUser")[0]);
					form_data.append('<?= $this->security->get_csrf_token_name(); ?>', '<?= $this->security->get_csrf_hash(); ?>');
					$.ajax({
						url: '<?= base_url(); ?>/backend/user_profile/UploadPictureUser',
						type: 'POST',
						dataType: 'json',
						data: form_data,
						contentType: false,
						processData: false,
						beforeSend: function() {
							myLoader.show();
						},
						success: function(response) {
							myLoader.hide();
							if (response.status == 'berhasil') {
								$("#DialogUnggahGambar").modal('hide');
								$.growl({
									title: response.status,
									message: response.message
								});
								setTimeout(function() {
									location.reload();
								}, 1000);
							}
							if (response.status == 'gagal upload') {
								$.growl.warning({
									title: response.status,
									message: response.message
								});
							}
							if (response.status == 'gagal') {
								$.growl.warning({
									title: response.status,
									message: response.message
								});
							}


						},
						timeout: 10000,
						error: function(err) {
							myLoader.hide();
							$.growl({
								title: 'sukses',
								message: 'berhasil ubah foto'
							});
							setTimeout(function() {
									location.reload();
							}, 500);
						}
					});
				};
				return false;
				//UploadProcess();
			});
			//------------------------------------------------------------------------------------//
		});
		//------------------------------------------------------------------------------------//
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
					$("#FormUploadPictureUser").trigger("reset");
					$("#DialogUploadPictureUser").modal('hide');
					$.growl({
						title: 'sukses',
						message: 'Upload foto profil'
					});
				}
				if (status == 'gagal') {
					myLoader.hide();
					$("#ResponUpload").fadeIn();
					$("#UploadFile").val('');
					$.growl.error({
						title: 'gagal',
						message: 'Upload foto profil gagal'
					});
					$("#StatusUpload").html('process');
				}
			}, timeout);
		}
		//------------------------------------------------------------------------------------//
	</script>

	<!----------------------------------------------------------------------------------------------------------------------------------------->