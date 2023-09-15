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
        <li class="active">Pengunjung</li>
      </ol>
      <h1 class="page-title">Catatan Log Pengunjung</h1>
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
					<?php if($role['RoleReportView'] == 'yes'){ ;?>	
					<div class="row">						
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-9"></div>
									<div class="col-md-3">
										<div class="header-top-menu">
											<button type="button" class="btn btn-sm btn-icon btn-inverse pull-right" id="exampleColorDropdown1" style="z-index: 999999;"
												data-toggle="dropdown" aria-expanded="false">
													<i class="icon wb-stats-bars" aria-hidden="true"></i> Grafik
													<span class="caret"></span>
											</button>
											<ul class="dropdown-menu pull-right" aria-labelledby="exampleColorDropdown1" role="menu">
												<li role="presentation"><a href="javascript:;" id="GraphVisitorByPeriode">Periode</a></li>											
											</ul>
										</div>
									</div>
									
								</div>
								<span class="loading" style="display:none;"> <i class="fa fa-cog fa-spin"></i> menampilkan grafik .... </span>
								<div id="visitorchart"></div>
							</div>						
					</div>					
					<?php }else{
						$this->load->view('backend/no-access');
					}?>
				</div>
			</div>			

			<div class="panel">			
				<div class="panel-body">	
					<?php if($role['RoleReportView'] == 'yes'){ ;?>	
					<div class="row">						
							<div class="col-md-12">

								<span class="loading" style="display:none;"> <i class="fa fa-cog fa-spin"></i> menampilkan grafik .... </span>
								<div id="graphvisitorplatformchart"></div>
							</div>						
					</div>					
					<?php }else{
						$this->load->view('backend/no-access');
					}?>
				</div>
			</div>			

			<div class="panel">			
				<div class="panel-body">	
					<?php if($role['RoleReportView'] == 'yes'){ ;?>						
					<div class="row">						
							<div class="col-md-12">					
								<span class="loading" style="display:none;"> <i class="fa fa-cog fa-spin"></i> menampilkan grafik .... </span>
								<div id="graphvisitorbrowserchart"></div>
							</div>						
					</div>
					<?php }else{
						$this->load->view('backend/no-access');
					}?>
				</div>
			</div>	

			


			<div class="panel">			
				<div class="panel-body">						
					<div class="row">
					<?php if($role['RoleReportView'] == 'yes'){ ;?>	
						<table id="MyTable" class="table table-condensed table-striped table-hover">
							<thead>
								<tr>								
									<th>IP Address</th>	
									<th>TANGGAL</th>							
									<th>BROWSER</th>							
									<th>AGENT</th>							
								</tr>
							</thead>
							<tfoot>
								<tr>								
									<th>IP Address</th>	
									<th>TANGGAL</th>							
									<th>BROWSER</th>							
									<th>AGENT</th>														
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

	
	<!-- report by days -->
	<div class="modal fade modal-fade-in-scale-up" id="DialogGraphVisitorByPeriode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Grafik Berita Harian</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormGraphVisitorByPeriode" id="FormGraphVisitorByPeriode" method="POST">													
								<div class="form-group">
									<label class="col-sm-3 control-label">Awal Hari</label>
									<div class="col-sm-9">
										<input type="text" name="StartDays" id="StartDays" placeholder="Pilih hari" class="form-control tooltip-right" title="Pilih hari"/>					
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Akhir Hari</label>
									<div class="col-sm-9">
										<input type="text" name="EndDays" id="EndDays" placeholder="Pilih hari" class="form-control tooltip-right" title="Pilih hari"/>					
									</div>
								</div>
								
														
									<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
									
				</div>
				<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
										<button type="submit" class="btn btn-primary" id="okButton"> Tampilkan </button>
									</div>
								
						</form>	
			</div>
		</div>
	</div>
	<!-- report by days -->

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
				"url": "<?=base_url();?>backend/report_visitor/ReportVisitorList",
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
				{"data": 'AgentString'}
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
				 { "orderable": true, "targets": 3 }
		
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
				url: '<?=base_url();?>backend/report_visitor/ajax',
				type: 'POST',
				dataType: 'json',
				data: {
					'do':'ShowGraphVisitor',
					'<?=$this->security->get_csrf_token_name();?>':'<?=$this->security->get_csrf_hash();?>'
				},
				beforeSend:function(){
					$(".loading").show();
				},
				success: function(data){
					$(".loading").hide();	
					if(data.status=='sukses'){						
						$('#visitorchart').highcharts({
							title: {
								text: data.title,
								x: -20 //center
							},
							subtitle: {
								text: data.subtitle,
								x: -20
							},
							xAxis: {
								categories: data.days
							},
							yAxis: {
								title: {
									text: data.ytitle
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
								name: data.seriestitle,
								data: data.visitor
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
		$("#GraphVisitorByPeriode").click(function(){
			$("#DialogGraphVisitorByPeriode").on('shown.bs.modal', function(){
				$("#FormGraphVisitorByPeriode").trigger('reset');
			})
			$("#DialogGraphVisitorByPeriode").modal('show');
		});
		//------------------------------------------------------------------------------------//
		$("#FormGraphVisitorByPeriode").validate({			
			rules: {
				StartPeriode: {
					required: true						
				},
				EndPeriode: {
					required: true						
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
		$("#FormGraphVisitorByPeriode").submit(function(e){
			e.preventDefault();
			if($("#FormGraphVisitorByPeriode").valid()){				
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
									var form = $("#FormGraphVisitorByPeriode").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/report_visitor/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=ShowGraphVisitorByPeriode&'+form,
										success: function(data){
											if(data.status=='sukses'){																			
												$("#DialogGraphVisitorByPeriode").modal('hide');
												$.growl({title:data.status,message: data.message});
												$('#visitorchart').highcharts({
													title: {
														text: data.title,
														x: -20 //center
													},
													subtitle: {
														text: data.subtitle,
														x: -20
													},
													xAxis: {
														categories: data.days
													},
													yAxis: {
														title: {
															text: data.ytitle
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
														name: data.seriestitle,
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

	<!----------------------------------------------------------------------------------------------------------------------------------------->

	$('#StartDays').datepicker({
		format: "dd/mm/yyyy",
		viewMode: "days", 
		minViewMode: "days"
	});
	$('#EndDays').datepicker({
		format: "dd/mm/yyyy",
		viewMode: "days", 
		minViewMode: "days"
	});
	<!----------------------------------------------------------------------------------------------------------------------------------------->	
	
	
 </script>

<script>
  /*
  Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
      return {
          radialGradient: {
              cx: 0.5,
              cy: 0.3,
              r: 0.7
          },
          stops: [
              [0, color],
              [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
          ]
      };
  });
  */

$.ajax({
  url: '<?=base_url();?>backend/report_visitor/ajax',
  type: 'POST',
  dataType: 'json',
  data: {
    'do':'ShowGraphVisitorBrowser',
    '<?=$this->security->get_csrf_token_name();?>':'<?=$this->security->get_csrf_hash();?>'
  },
  beforeSend:function(){
    $(".loading").show();
  },
  success: function(respon){
    $(".loading").hide(); 
    if(respon.status=='sukses'){     
    ////////////////////        
        Highcharts.setOptions({
          chart: {
              style: {
                  fontFamily: 'Lato'
              }
          }
        });
        $('#graphvisitorbrowserchart').highcharts({
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
          title: {
              text: respon.title
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: true,
                      format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                      style: {
                          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                      }
                  },
                  showInLegend: true
              }
          },
          legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0
          },
          series: [{
              name: 'total',
              colorByPoint: true,
              data: respon.data
  
          }],       
          credits: {
            enabled: false
          }     
      });
      ////////////////////
    }
    
    if(respon.status=='notfound'){
      $("#devicegraph").html(respon.message);
      $.growl.warning({title:respon.status,message: respon.message});
    }
    
  },
  timeout: 20000,
  error: function(){
    $(".loading").hide(); 
    /*$.growl.error({title:'Error', message: 'Ajax request'});*/
  }
      
});


$.ajax({
  url: '<?=base_url();?>backend/report_visitor/ajax',
  type: 'POST',
  dataType: 'json',
  data: {
    'do':'ShowGraphVisitorPlatform',
    '<?=$this->security->get_csrf_token_name();?>':'<?=$this->security->get_csrf_hash();?>'
  },
  beforeSend:function(){
    $(".loading").show();
  },
  success: function(respon){
    $(".loading").hide(); 
    if(respon.status=='sukses'){     
    ////////////////////        
        Highcharts.setOptions({
          chart: {
              style: {
                  fontFamily: 'Lato'
              }
          }
        });
        $('#graphvisitorplatformchart').highcharts({
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
          title: {
              text: respon.title
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: true,
                      format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                      style: {
                          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                      }
                  },
                  showInLegend: true
              }
          },
          legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0
          },
          series: [{
              name: 'total',
              colorByPoint: true,
              data: respon.data
  
          }],       
          credits: {
            enabled: false
          }     
      });
      ////////////////////
    }
    
    if(respon.status=='notfound'){
      $("#devicegraph").html(respon.message);
      $.growl.warning({title:respon.status,message: respon.message});
    }
    
  },
  timeout: 20000,
  error: function(){
    $(".loading").hide(); 
    /*$.growl.error({title:'Error', message: 'Ajax request'});*/
  }
      
});

</script>

