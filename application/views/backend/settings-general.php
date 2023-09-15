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
				<li class="active">Pengaturan Umum</li>
			</ol>
			<h1 class="page-title">Pengaturan Umum</h1>
			<div class="page-header-actions">
				<a href="<?= base_url(); ?>backend/news/add" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
					data-original-title="Berita Baru" id="AddNews">
					<i class="icon wb-plus-circle" aria-hidden="true"></i>
				</a>
				<button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
					data-original-title="Refresh" id="Refresh">
					<i class="icon wb-refresh" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-md-6">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Mode Situs</h3>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" name="FormSiteMode" id="FormSiteMode" method="POST">
								<div class="form-group">
									<label class="col-sm-3 control-label">Mode Situs</label>
									<div class="col-sm-8">
										<select class="form-control show-menu-arrow" autocomplete="off"
											data-plugin="selectpicker" name="SiteMode" id="SiteMode" />
										<?php
										if ($sitemode == 'online' ? $selonline = 'selected' : $selonline = '')
											;
										if ($sitemode == 'offline' ? $seloffline = 'selected' : $seloffline = '')
											;
										?>
										<option value="online" <?= $selonline; ?>>Online</option>
										<option value="offline" <?= $seloffline; ?>>Offline</option>


										</select>
									</div>
								</div>
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
								<div class="form-group">
									<label class="col-sm-3 control-label"></label>
									<div class="col-sm-8">
										<button type="button" class="btn btn-default" data-dismiss="modal"> Batal
										</button>
										<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Maksimal Logs</h3>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" name="FormMaxLogs" id="FormMaxLogs" method="POST">
								<div class="form-group">
									<label class="col-sm-4 control-label">Maksimal Logs</label>
									<div class="col-sm-8">
										<input type="text" name="MaxLogs" id="MaxLogs" placeholder="Maksimal logs"
											class="form-control tooltip-right" title="Maksimal logs"
											value="<?= $maxlogs; ?>" />
									</div>
								</div>
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
									value="<?= $this->security->get_csrf_hash(); ?>" />
								<div class="form-group">
									<label class="col-sm-4 control-label"></label>
									<div class="col-sm-8">
										<button type="button" class="btn btn-default" data-dismiss="modal"> Batal
										</button>
										<button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row hidden">
				<div class="col-md-6">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Konfigurasi Email</h3>
						</div>
						<div class="panel-body">
							<?php
							foreach ($emailsettings as $row) {
								?>
									<form class="form-horizontal" name="FEmailSettings" id="FEmailSettings" method="post">
										<div class="form-group">
											<label for="#" class="col-sm-3 control-label">SMTP Host</label>
											<div class="col-sm-9">
												<input type="text" id="smtp_host" name="smtp_host" class="form-control"
													value="<?= $row->smtp_host; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label for="#" class="col-sm-3 control-label">SMTP Port</label>
											<div class="col-md-3">
												<input type="text" id="smtp_port" name="smtp_port" class="form-control"
													value="<?= $row->smtp_port; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label for="#" class="col-sm-3 control-label">SMTP User</label>
											<div class="col-sm-9">
												<input type="text" id="smtp_user" name="smtp_user" class="form-control"
													value="<?= $row->smtp_user; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label for="#" class="col-sm-3 control-label">SMTP Password</label>
											<div class="col-sm-9">
												<input type="password" id="smtp_pass" name="smtp_pass" class="form-control"
													value="" placeholder="[kosong tidak mengubah password]" />
											</div>
										</div>

										<div class="form-group">
											<label for="#" class="col-md-3 control-label">Protocol</label>
											<div class="col-md-8">
												<select id="protocol" name="protocol" class="form-control"
													placeholder="protocol" />
												<?php
												if ($row->protocol == 'mail' ? $protocolmail = 'selected' : $protocolmail = '')
													;
												if ($row->protocol == 'sendmail' ? $protocolsendmail = 'selected' : $protocolsendmail = '')
													;
												if ($row->protocol == 'smtp' ? $protocolsmtp = 'selected' : $protocolsmtp = '')
													;
												?>
												<option value="mail" <?= $protocolmail; ?>>Mail</option>
												<option value="sendmail" <?= $protocolsendmail; ?>>Sendmail</option>
												<option value="smtp" <?= $protocolsmtp; ?>>Smtp</option>

												</select>
											</div>
										</div>

										<div class="form-group">
											<label for="#" class="col-md-3 control-label">Mail Type</label>
											<div class="col-md-8">
												<select id="mailtype" name="mailtype" class="form-control"
													placeholder="Mail type" />
												<?php
												if ($row->mailtype == 'text' ? $mailtypetext = 'selected' : $mailtypetext = '')
													;
												if ($row->mailtype == 'html' ? $mailtypehtml = 'selected' : $mailtypehtml = '')
													;
												?>
												<option value="text" <?= $mailtypetext; ?>>Text</option>
												<option value="html" <?= $mailtypehtml; ?>>Html</option>
												</select>

											</div>
										</div>

										<div class="form-group">
											<label for="#" class="col-md-3 control-label">SMTP Crypto</label>
											<div class="col-md-8">
												<select id="smtp_crypto" name="smtp_crypto" class="form-control"
													placeholder="SMTP crypto" />
												<?php
												if ($row->smtp_crypto == 'tls' ? $smtpcryptotls = 'selected' : $smtpcryptotls = '')
													;
												if ($row->smtp_crypto == 'ssl' ? $smtpcryptossl = 'selected' : $smtpcryptossl = '')
													;
												?>
												<option value="tls" <?= $smtpcryptotls; ?>>TLS</option>
												<option value="ssl" <?= $smtpcryptossl; ?>>SSL</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label for="#" class="col-md-3 control-label">Charset</label>
											<div class="col-md-8">
												<select id="charset" name="charset" class="form-control"
													placeholder="Charset" />
												<?php
												if ($row->charset == 'utf-8' ? $charsetutf = 'selected' : $charsetutf = '')
													;
												if ($row->charset == 'iso-8859-1' ? $charsetiso = 'selected' : $charsetiso = '')
													;
												?>
												<option value="utf-8" <?= $charsetutf; ?>>UTF-8</option>
												<option value="iso-8859-1" <?= $charsetiso; ?>>ISO-8859-1</option>
												</select>
											</div>
										</div>


										<div class="form-group">
											<label for="#" class="col-sm-3 control-label">Word Wrap</label>
											<div class="col-sm-4">
												<input type="text" id="wordwrap" name="wordwrap" class="form-control"
													value="<?= $row->wordwrap; ?>" disabled />
											</div>
										</div>
										<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
											value="<?= $this->security->get_csrf_hash(); ?>" />
										<div class="form-group">
											<legend></legend>
											<label for="#" class="col-sm-3 control-label"></label>
											<div class="col-sm-9">
												<button type="submit" class="btn btn-primary" id="okButton"><i
														class="fa fa-save"></i> Simpan </button>
												<a href="javascript:KirimEmail();" class="btn btn-info"><i
														class="fa fa-paper-plane"></i> Test Kirim Email</a>
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
	<!------------------DIALOG EMAIL----------------->
	<div class="modal fade" id="DialogKirimEmail" tabindex="-2" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Kirim Email</h3>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" name="FKirimEmailTest" id="FKirimEmailTest" method="post">
						<div class="form-group">
							<label for="#" class="col-sm-3 control-label">Tujuan</label>
							<div class="col-sm-8">
								<input type="text" id="Tujuan" name="Tujuan" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="#" class="col-sm-3 control-label">Subyek</label>
							<div class="col-sm-8">
								<input type="text" id="Subyek" name="Subyek" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="#" class="col-sm-3 control-label">Isi Email</label>
							<div class="col-sm-8">
								<textarea id="IsiEmail" name="IsiEmail" class="form-control"></textarea>
							</div>
						</div>
						<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
							value="<?= $this->security->get_csrf_hash(); ?>" />
				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
						Batal</button>
					<button type="submit" class="btn btn-primary" id="okButton"><i class="fa fa-paper-plane"></i> Kirim
					</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<!------------------END DIALOG EMAIL----------------->
	<?php $this->load->view('backend/footer'); ?>
	<script>
		//------------------------------------------------------------------------------------//
		$(function () {
			//------------------------------------------------------------------------------------//		
			$("#FormSiteMode").submit(function (e) {
				e.preventDefault();
				if ($("#FormSiteMode").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan pengaturan mode situs ini?",
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
									var form = $("#FormSiteMode").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/settings_general/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=SiteMode&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												setTimeout(function () {
													location.reload();
												}, 2000);
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
			});
			//------------------------------------------------------------------------------------//	
			$("#FormEmail").validate({
				rules: {
					Email: {
						required: true,
						email: true,
					}
				},
				messages: {
					Email: {
						required: 'Harus diisi',
						email: 'Email harus valid'
					}
				}
			});
			$("#FormEmail").submit(function (e) {
				e.preventDefault();
				if ($("#FormEmail").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan pengaturan email ini?",
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
									var form = $("#FormEmail").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/settings_general/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=Email&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
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
			});
			//------------------------------------------------------------------------------------//
			$("#FormMaxLogs").validate({
				rules: {
					MaxLogs: {
						required: true,
						number: true,
						min: 0
					}
				},
				messages: {
					MaxLogs: {
						required: 'Harus diisi',
						number: 'Harus angka',
						min: 'Harus lebih dari 0'
					}
				}
			});
			$("#FormMaxLogs").submit(function (e) {
				e.preventDefault();
				if ($("#FormMaxLogs").valid()) {
					//////////////////////
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan pengaturan maksimal logs ini?",
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
									var form = $("#FormMaxLogs").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/settings_general/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=MaxLogs&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
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
			});
		});
	//------------------------------------------------------------------------------------//
	</script>

	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<script type="text/javascript">
		function KirimEmail() {
			$("#DialogKirimEmail").on("shown.bs.modal", function () {
				$("#Tujuan").focus();
			});
			$("#DialogKirimEmail").modal('show');
		}

		$(function () {

			/*
			$.validator.addMethod("valueNotEquals", function(value, element, arg){
			  return arg != value;
			}, "Value must not equal arg.");
			*/

			$("#FEmailSettings").validate({
				rules: {
					smtp_host: {
						required: true
					},
					smtp_port: {
						required: true,
						maxlength: 6
					},
					smtp_user: {
						required: true
					}

				},
				messages: {
					smtp_host: 'Host tidak boleh kosong!',
					smtp_port: 'Port tidak boleh kosong!',
					smtp_user: 'User tidak boleh kosong!'

				}
			});

			$("#FEmailSettings").submit(function (event) {
				event.preventDefault();
				if ($("#FEmailSettings").valid()) {
					var form = $("#FEmailSettings").serialize();
					/*--------------------------------------------------------------------*/
					bootbox.dialog({
						message: "Apakah anda yakin akan menyimpan konfigurasi email?",
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
									var form = $("#FEmailSettings").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/settings_general/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=EmailSettingsUpdate&' + form,
										success: function (respon) {
											if (respon.status == 'sukses') {
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
					/*--------------------------------------------------------------------*/
				}
			});
		});

		//test kirim email
		$(function () {
			$("#FKirimEmailTest").validate({
				rules: {
					Tujuan: {
						required: true
					},
					Subyek: {
						required: true

					},
					IsiEmail: {
						required: true
					}
				},
				messages: {
					Tujuan: 'Tujuan tidak boleh kosong!',
					Subyek: 'Subyek tidak boleh kosong!',
					IsiEmail: 'User tidak boleh kosong!'
				}
			});

			$("#FKirimEmailTest").submit(function (event) {
				event.preventDefault();
				if ($("#FKirimEmailTest").valid()) {
					var form = $("#FKirimEmailTest").serialize();
					/*--------------------------------------------------------------------*/
					bootbox.dialog({
						message: "Apakah anda yakin akan mengirim email ini?",
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
									var form = $("#FKirimEmailTest").serialize();
									$.ajax({
										url: '<?= base_url(); ?>backend/settings_general/ajax',
										type: 'POST',
										dataType: 'json',
										data: 'do=EmailSendTest&' + form,
										beforeSend: function () {
											myLoader.show();
										},
										success: function (respon) {
											myLoader.hide();
											if (respon.status == 'sukses') {
												$.growl({ title: respon.status, message: respon.message });
												$("#DialogKirimEmail").modal('hide');
											}
											if (respon.status == 'gagal') {
												$.growl.warning({ title: respon.status, message: respon.message });
											}
										},
										timeout: 120000, function() {
											$.growl.error({ title: 'Time', message: 'Request timeout' });
										},
										error: function () {
											myLoader.hide();
											$.growl.error({ title: 'Error', message: 'Ajax request' });
										}
									});
								}
							}
						}
					});
					/*--------------------------------------------------------------------*/
				}
			});

		});


	</script>