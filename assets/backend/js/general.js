$(function () {
	$(".tooltip").tooltip({
		placement : 'right'
	});
	$(".tooltip-right").tooltip({
		placement : 'right'
	});
	$(".tooltip-bottom").tooltip({
		placement : 'bottom'
	});
	$(".beli").tooltip({
		placement : 'right'
	});
	$(".lihat").tooltip({
		placement : 'right'
	});
	$(".cek").tooltip({
		placement : 'bottom'
	});
	$(".cek").tooltip({
		placement : 'bottom'
	});
})
function resetForm($form) {
	$form.find('input:text, input:password, input:file, select, textarea').val('');
	$form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
}

var CwxInit = function () {
	return {		
		CwxSessionUser : function (base_url) {
			$.ajax({
				url : base_url + 'backend/session_user',
				cache : false,
				success : function (data) {
					if (data == 'nonaktif') {
						location.reload();
					}
				},
				timeout : 10000,
				error : function (request, status, err) {
					if (status === 'error') {
						console.log('Server tidak merespon, periksa koneksi atau refresh halaman');
					} else {
						console.log(status);
					}
				}
			});
		}
	}
}
()