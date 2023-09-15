$(function () {
	CWXGrafik.GrafikLaporanBeritaByPeriode();
	CWXGrafik.GrafikLaporanBeritaByPeriodePerPenulis();
})
var CWXGrafik = function () {
	return {
		GrafikLaporanBeritaByPeriode : function () {
			$.jqplot.LabelFormatter = function (format, val) {
				return val;
			};
			$("#FGrafikLaporanBerita").validate({
				rules : {
					TglAwal : 'required',
					TglAkhir : 'required'
				},
				messages : {
					TglAwal : 'Tanggal tidak boleh kosong!',
					TglAkhir : 'Tanggal tidak boleh kosong!'
				}
			});
			$("#FGrafikLaporanBerita").submit(function (event) {
				event.preventDefault();
				var frm = $("#FGrafikLaporanBerita").serialize();
				var TglDari = $("#TglAwal").val();
				var TglKe = $("#TglAkhir").val();
				if ($("#FGrafikLaporanBerita").valid()) {
					var heading = 'Konfirmasi';
					var question = 'Apakah anda yakin akan menggenerate laporan berita per periode ini?';
					var cancelButtonTxt = 'Tidak';
					var okButtonTxt = 'Ya';
					var callback = function () {
						$.ajax({
							type : 'POST',
							url : 'ajax',
							dataType : 'json',
							data : 'aksi=GrafikLaporanBerita&' + frm,
							beforeSend : function () {
								$("#transaksi-periode").html('');
								$(".loaders").show();
							},
							success : function (respon) {
								if (respon.status == 'sukses') {
									$('#transaksi-periode').jqplot([respon.data], {
										title : respon.label,
										seriesDefaults : {
											renderer : $.jqplot.BarRenderer,
											pointLabels : {
												show : true,
												formatString : '%s',
												formatter : $.jqplot.LabelFormatter
											},
											rendererOptions : {
												varyBarColor : true,
												barWidth : 20
											}
										},
										axes : {
											xaxis : {
												renderer : $.jqplot.CategoryAxisRenderer
											},
											yaxis : {
												label : 'Jumlah Berita',
												tickOptions : {
													formatter : $.jqplot.LabelFormatter
												}
											}
										}
									});
									$.jGrowl('Grafik berhasil digenerate');
								}
								if (respon.status == 'datatidakada') {
									$("#transaksi-periode").html('<div class="alert alert-info"> Data tidak ada!</div>');
									$.jGrowl('Grafik gagal digenerate');
								}
								$(".loaders").hide();
							},
							timeout : 10000,
							error : function () {
								$.jGrowl('Error, data tidak ada.');
								$(".loaders").hide();
							}
						});
					}
					confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);
				}
			})
		},
		GrafikLaporanBeritaByPeriodePerPenulis : function () {
			$.jqplot.LabelFormatter = function (format, val) {
				return val;
			};
			$("#FGrafikLaporanBeritaByPeriodePerPenulis").validate({
				rules : {
					TglAwal : 'required',
					TglAkhir : 'required'
				},
				messages : {
					TglAwal : 'Tanggal tidak boleh kosong!',
					TglAkhir : 'Tanggal tidak boleh kosong!'
				}
			});
			$("#FGrafikLaporanBeritaByPeriodePerPenulis").submit(function (event) {
				event.preventDefault();
				var frm = $("#FGrafikLaporanBeritaByPeriodePerPenulis").serialize();
				var TglDari = $("#TglAwal").val();
				var TglKe = $("#TglAkhir").val();
				if ($("#FGrafikLaporanBeritaByPeriodePerPenulis").valid()) {
					var heading = 'Konfirmasi';
					var question = 'Apakah anda yakin akan menggenerate laporan berita per periode dan penulis ini?';
					var cancelButtonTxt = 'Tidak';
					var okButtonTxt = 'Ya';
					var callback = function () {
						$.ajax({
							type : 'POST',
							url : '../ajax',
							dataType : 'json',
							data : 'aksi=GrafikLaporanBeritaByPeriodePerPenulis&' + frm,
							beforeSend : function () {
								$("#transaksi-periode").html('');
								$(".loaders").show();
							},
							success : function (respon) {
								if (respon.status == 'sukses') {
									$('#transaksi-periode').jqplot([respon.data], {
										title : respon.label,
										seriesDefaults : {
											renderer : $.jqplot.BarRenderer,
											pointLabels : {
												show : true,
												formatString : '%s',
												formatter : $.jqplot.LabelFormatter
											},
											rendererOptions : {
												varyBarColor : true,
												barWidth : 20
											}
										},
										axes : {
											xaxis : {
												renderer : $.jqplot.CategoryAxisRenderer
											},
											yaxis : {
												label : 'Jumlah Berita',
												tickOptions : {
													formatter : $.jqplot.LabelFormatter
												}
											}
										}
									});
									$.jGrowl('Grafik berhasil digenerate');
								}
								if (respon.status == 'datatidakada') {
									$("#transaksi-periode").html('<div class="alert alert-info"> Data tidak ada!</div>');
									$.jGrowl('Grafik gagal digenerate');
								}
								$(".loaders").hide();
							},
							timeout : 10000,
							error : function () {
								$.jGrowl('Error, data tidak ada.');
								$(".loaders").hide();
							}
						});
					}
					confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);
				}
			})
		},
	}
}
()
