<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header');?>
<body class="site-menubar-unfold site-menubar-keep">
		<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<?php $this->load->view('backend/navbar');?>
	<?php $this->load->view('backend/sidebar');?> 
  <!-- Page -->
  <div class="page">
    <div class="page-header">
			<ol class="breadcrumb">
        <li><a href="<?=base_url();?>backend">Dasbor</a></li>
        <li class="active">Pengguna</li>
      </ol>
      <h1 class="page-title">Catatan Log Pengguna</h1>
			<div class="page-header-actions">        
        <button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
        data-original-title="Refresh" id="Refresh">
          <i class="icon wb-refresh" aria-hidden="true"></i>
        </button>        
      </div>
    </div>
    <div class="page-content">			
			<div class="panel">			
				<div class="panel-body">						
					<div class="row">
					<?php 	$ulevel = $this->user_model->GetLevelUser();
						if ($ulevel == 'superadmin') {
					?>				
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>								
									<th>IP Address</th>	
									<th>TANGGAL</th>							
									<th>BROWSER</th>							
									<th>AGENT</th>							
									<th>PLATFORM</th>							
									<th>CONTENT</th>							
									<th>STATUS</th>							
									<th>ID USER</th>							
									<th>URL</th>							
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th>IP Address</th>	
									<th>TANGGAL</th>							
									<th>BROWSER</th>	
									<th>AGENT</th>								
									<th>PLATFORM</th>							
									<th>CONTENT</th>							
									<th>STATUS</th>							
									<th>ID USER</th>							
									<th>URL</th>													
								</tr>
							</tfoot>
						</table>
					<?php }else{
						$this->load->view('backend/no-access');
					}?>
					</div>
					
				</div>
			</div>
			
    </div>
  </div>
  <!-- End Page -->
	<div class="modal fade modal-fade-in-scale-up" id="DialogReportPerPeriode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Laporan Berita</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormReportNewsPeriode" id="FormReportNewsPeriode" method="POST">													
								<div class="form-group">
									<label class="col-sm-3 control-label">Awal Periode</label>
									<div class="col-sm-9">
										<input type="text" name="StartPeriode" id="StartPeriode" data-plugin="datepicker" placeholder="Pilih periode" class="form-control tooltip-right" title="Pilih periode"/>					
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Akhir Periode</label>
									<div class="col-sm-9">
										<input type="text" name="EndPeriode" id="EndPeriode" data-plugin="datepicker" placeholder="Pilih periode" class="form-control tooltip-right" title="Pilih periode"/>					
									</div>
								</div>
								<div class="form-group">
														
									<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
										<button type="submit" class="btn btn-primary" id="okButton"> Tampilkan </button>
									</div>
								</div>
						</form>	
				</div>
			</div>
		</div>
	</div>
 <?php $this->load->view('backend/footer');?>
 	<script type="text/javascript" src="<?=base_url();?>assets/backend/js/plugins/highchart/js/highcharts.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/backend/js/plugins/highchart/js/modules/exporting.js"></script>
	<link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
	<script src="<?=base_url();?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="<?=base_url();?>assets/backend/js/components/bootstrap-datepicker.js"></script>
	
 <script>
	//------------------------------------------------------------------------------------//
	$(function(){
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
					"previous":"Sebelum",
					"next": "Berikut",
					"last": "Akhir",
					"first": "Awal"
				}
			},
			"bProcessing": true,
			"bServerSide": true,			
			"ajax": {
				"url": "<?=base_url();?>backend/logs_user/LogsUserList",
				"type": "POST",
				"data":{
					'<?=$this->security->get_csrf_token_name();?>' : '<?=$this->security->get_csrf_hash();?>'			
				},
				"error": function(){
					$.growl.error({title: 'Error', message: 'Ajax request'});
				}
			},
			"bStateSave": true, 	
			"fnDrawCallback": function( oSettings ) {
				//$("input:checkbox").uniform();
			},	
			"columns": [				
				{"data": 'IPAddress'}, 
				{"data": 'TimeStamp'}, 
				{"data": 'Browser'},
				{"data": 'AgentString'},
				{"data": 'Platform'},
				{"data": 'ContentLog'},
				{"data": 'StatusLog'},
				{"data": 'IdUser'},
				{"data": 'Url'}
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
				 { "orderable": true, "targets": 5 },
				 { "orderable": true, "targets": 6 },
				 { "orderable": true, "targets": 7 }
		
			],
			"order": [
				[1, "desc"]
			] 
		});				
		//------------------------------------------------------------------------------------//
		$("#Refresh").click(function(){MyTable.fnDraw();});
		//------------------------------------------------------------------------------------//
				//------------------------------------------------------------------------------------//
		$.ajax({
				url: '<?=base_url();?>backend/report_news/ajax',
				type: 'POST',
				dataType: 'json',
				data: {
					'do':'ShowReport',
					'<?=$this->security->get_csrf_token_name();?>':'<?=$this->security->get_csrf_hash();?>'
				},
				beforeSend:function(){
					$(".loading").show();
				},
				success: function(data){
					$(".loading").hide();	
					if(data.status=='sukses'){						
						$('#newschart').highcharts({
							title: {
								text: data.label,
								x: -20 //center
							},
							subtitle: {
								text: 'Grafik Berita',
								x: -20
							},
							xAxis: {
								categories: data.month
							},
							yAxis: {
								title: {
									text: 'Berita'
								},
								plotLines: [{
									value: 0,
									width: 1,
									color: '#808080'
								}],
								 allowDecimals: false,
								 min: 0
							},
							plotOptions: {
								area: {
									fillColor: {
										linearGradient: {
											x1: 0,
											y1: 0,
											x2: 0,
											y2: 1
										},
										stops: [
											[0, Highcharts.getOptions().colors[0]],
											[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
										]
									},
									marker: {
										radius: 2
									},
									lineWidth: 1,
									states: {
										hover: {
											lineWidth: 1
										}
									},
									threshold: null
								}
							},
							/*
							plotOptions: {
								line: {
									dataLabels: {
										enabled: true
									},
									enableMouseTracking: false
								}
							},
							*/
							tooltip: {
								valueSuffix: ''
							},
							legend: {
								layout: 'vertical',
								align: 'center',
								verticalAlign: 'bottom',
								borderWidth: 0
							},
							series: [{
								type: 'area',
								name: 'Berita',
								data: data.news
							}],
							credits: {
								enabled: false
							}						
						});
						////////////////////
					}					
					if(data.status=='notfound'){
						$("#newschart").html(data.message);
						$.growl({title:respon.status,message: respon.message});
					}					
				},
				timeout: 20000,
				error: function(){
					$(".loading").hide();	
					$.growl.error({title: 'Error',message: 'Ajax request'});
				}				
			});
		//------------------------------------------------------------------------------------//
		$("#FormReportNewsPeriode").validate({			
			rules: {
				StartPeriode: {
					'required': true						
				},
				EndPeriode: {
					'required': true						
				}
			},
			messages: {
				StartPeriode: {
					required: 'Periode harus diisi'
				},
				EndPeriode: {
						required: 'Periode harus diisi'		
				}
			}			
		});
		$("#FormReportNewsPeriode").submit(function(e){
			e.preventDefault();
			if($("#FormReportNewsPeriode").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin menampilkan laporan berita dalam periode ini?",
					title: "Konfirmasi",
					buttons: {				
						danger: {
							label: "No",
							className: "btn-default",
							callback: function(){
								
							}
						},
						main: {
							label: "Yes",
							className: "btn-primary",
							callback: function() {
									var form = $("#FormReportNewsPeriode").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/report_visitor/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=ShowReportPerPeriode&'+form,
										success: function(data){
											if(data.status=='sukses'){																			
												$("#DialogReportPerPeriode").modal('hide');
												$.growl({title:data.status,message: data.message});
												$('#visitorchartperperiode').highcharts({
													title: {
														text: data.label,
														x: -20 //center
													},
													subtitle: {
														text: 'Grafik Berita',
														x: -20
													},
													xAxis: {
														categories: data.month
													},
													yAxis: {
														title: {
															text: 'Berita'
														},
														plotLines: [{
															value: 0,
															width: 1,
															color: '#808080'
														}],
														 allowDecimals: false,
														 min: 0
													},
													plotOptions: {
														area: {
															fillColor: {
																linearGradient: {
																	x1: 0,
																	y1: 0,
																	x2: 0,
																	y2: 1
																},
																stops: [
																	[0, Highcharts.getOptions().colors[0]],
																	[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
																]
															},
															marker: {
																radius: 2
															},
															lineWidth: 1,
															states: {
																hover: {
																	lineWidth: 1
																}
															},
															threshold: null
														}
													},
													/*
													plotOptions: {
														line: {
															dataLabels: {
																enabled: true
															},
															enableMouseTracking: false
														}
													},
													*/
													tooltip: {
														valueSuffix: ''
													},
													legend: {
														layout: 'vertical',
														align: 'center',
														verticalAlign: 'bottom',
														borderWidth: 0
													},
													series: [{
														type: 'area',
														name: 'Berita',
														color: '#F14C39',
														data: data.visitor
													}],
													credits: {
														enabled: false
													}						
												});
											}
											if(data.status=="tidak tersedia"){
													$.growl.warning({title:data.status,message: data.message});
											}
										},
										timeout: 20000,
										error: function(){
											myLoader.hide();
											$.growl.error({title: 'Error',message: 'Ajax request'});
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
	function ShowReportPerPeriode(){
		$("#DialogReportPerPeriode").modal('show');
	}
 </script>
<!----------------------------------------------------------------------------------------------------------------------------------------->



