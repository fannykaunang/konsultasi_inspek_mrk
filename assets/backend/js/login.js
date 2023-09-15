var CWXLogin = function () {
	return {
		GetLogin : function (root) {
			$("#Flogin").validate({
				rules : {
					Email : {
						required : true,
						email : true
					},
					Password : 'required'
				},
				messages : {
					Email : {
						required : "Email tidak boleh kosong!.",
						email : "Email harus valid!."
					},
					Password : {
						required : "Password login tidak boleh kosong!."
					},
				}
			});
			$("#Flogin").submit(function (event) {
				event.preventDefault();
				if ($("#Flogin").valid()) {
					var form = $("#Flogin").serialize();
					$.ajax({
						url : root + 'login/ajax',
						type : 'post',
						dataType : 'json',
						data : 'aksi=GetLogin&' + form,
						beforeSend : function () {
							$(".loaders").show();
						},
						success : function (data) {
							if (data.status == 'sukses') {
								setTimeout(function () {
									window.location = root + 'backend/' + data.landingpage;
								}, 1000);
							}
							if (data.status == 'gagal') {
								$(".mycontainer").shake({
									direction : "left",
									distance : 15,
									times : 3,
									speed : 150
								});
								$(".loaders").hide();
								$("#NamaLogin").focus();
							}
						},
						timeout : 10000,
						error : function () {
							alert('Error');
						}
					});
				}
			});
		},
		LupaPassword : function (root) {
			$("#FLupaPassword").validate({
				rules : {
					Email : {
						required : true,
						email : true
					}
				},
				messages : {
					Email : {
						required : "Email tidak boleh kosong!.",
						email : "Email harus valid!."
					}
				}
			});
			$("#FLupaPassword").submit(function (event) {
				event.preventDefault();
				if ($("#FLupaPassword").valid()) {
					var form = $("#FLupaPassword").serialize();
					$.ajax({
						url : root + 'login/ajax',
						type : 'post',
						dataType : 'json',
						data : 'aksi=LupaPassword&' + form,
						beforeSend : function () {
							$(".loaders").show();
						},
						success : function (data) {
							if (data.status == 'sukses') {
								$("#DialogLupaPassword").modal('hide');
								$("#FlupaPassword").find($("#Email").focus());
								$(".loaders").hide();
								alert(data.message);
							}
							if (data.status == 'gagal') {
								$("#DialogLupaPassword").modal('hide');
								$("#FlupaPassword").find($("#Email").focus());
								$(".loaders").hide();
								alert(data.message);
							}
						},
						timeout : 20000,
						error : function () {
							alert('Error');
							$(".loaders").hide();
						}
					});
				}
			});
		}
	}
}
()
