<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header');?>
<body class="site-menubar-unfold site-menubar-keep">
		<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<?php $this->load->view('backend/navbar');?>
	<?php $this->load->view('backend/sidebar');?> 
  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
			<ol class="breadcrumb">
        <li><a href="<?=base_url();?>backend">Dasbor</a></li>
        <li class="active">Laporan</li>
      </ol>
      <h1 class="page-title">Laporan Berita</h1>
			 <div class="page-header-actions">
        <button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" <?=$RoleReportCreate;?>
        data-original-title="Laporan per periode" onclick="ShowReportPerPeriode();"> 
          <i class="icon wb-stats-bars" aria-hidden="true"></i>
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
					<?php if($role['RoleReportView'] == 'yes'){ ;?>	
					<div class="row">						
							<div class="col-md-12">
								<span class="loading" style="display:none;"> <i class="fa fa-cog fa-spin"></i> menampilkan grafik .... </span>
								<div id="newschartperperiode"></div>
							</div>						
					</div>
					<div class="row">						
							<div class="col-md-12">
								<span class="loading" style="display:none;"> <i class="fa fa-cog fa-spin"></i> menampilkan grafik .... </span>
								<div id="newschart"></div>
							</div>						
					</div>
					<?php }else{
						$this->load->view('backend/no-access');
					}?>
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
									dataLabels: {
										 enabled: false,
											borderRadius: 5,
											backgroundColor: 'rgba(252, 255, 197, 0.7)',
											borderWidth: 1,
											borderColor: '#AAA',
											y: -6,
											style: {"color": "contrast", "fontSize": "8px", "fontWeight": "normal", "textShadow": "0 0 6px contrast, 0 0 3px contrast" },
											shape: "square"
									},
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
								data: data.news,
								dataLabels: {
										align: 'left',
										enabled: true
								}
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
										url: '<?=base_url();?>backend/report_news/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=ShowReportPerPeriode&'+form,
										success: function(data){
											if(data.status=='sukses'){																			
												$("#DialogReportPerPeriode").modal('hide');
												$.growl({title:data.status,message: data.message});
												$('#newschartperperiode').highcharts({
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
														data: data.news
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
		$("#Refresh").click(function(){location.reload();});
		//------------------------------------------------------------------------------------//
	});
	//------------------------------------------------------------------------------------//
	function ShowReportPerPeriode(){
		$("#DialogReportPerPeriode").modal('show');
	}
	//------------------------------------------------------------------------------------//
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

