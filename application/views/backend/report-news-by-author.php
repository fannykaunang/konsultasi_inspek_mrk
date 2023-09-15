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
      <h1 class="page-title">Laporan Berita Oleh Penulis</h1>
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
						<div class="col-md-8"></div>
						<div class="col-md-2">
							<div class="header-top-menu">
								<button type="button" class="btn btn-sm btn-icon btn-inverse pull-right" id="exampleColorDropdown1" style="z-index: 999999;"
									data-toggle="dropdown" aria-expanded="false">
										<i class="icon wb-stats-bars" aria-hidden="true"></i> Grafik Total
										<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" aria-labelledby="exampleColorDropdown1" role="menu">								
									<li role="presentation"><a href="javascript:;" role="menuitem" id="GraphByPeriode">Periode</a></li>
								</ul>
							</div>
						</div>		
						<div class="col-md-2">
							<div class="header-top-menu">
								<button type="button" class="btn btn-sm btn-icon btn-inverse pull-right" id="exampleColorDropdown1" style="z-index: 999999;"
									data-toggle="dropdown" aria-expanded="false">
										<i class="icon wb-stats-bars" aria-hidden="true"></i> Grafik Penulis
										<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" aria-labelledby="exampleColorDropdown1" role="menu">								
									<li role="presentation"><a href="javascript:;" role="menuitem" id="GraphByAuthorPerPeriode">Periode</a></li>
								</ul>
							</div>
						</div>							
					</div>
								
								
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
	<div class="modal fade modal-fade-in-scale-up" id="DialogGraphByPeriode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Laporan Berita Oleh Penulis</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormGraphByPeriode" id="FormGraphByPeriode" method="POST">													
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

		<div class="modal fade modal-fade-in-scale-up" id="DialogGraphByAuthorPerPeriode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Laporan Berita Oleh Penulis</h4>
				</div>
				<div class="modal-body">				
						<form class="form-horizontal" name="FormGraphByAuthorPerPeriode" id="FormGraphByAuthorPerPeriode" method="POST">													
								<div class="form-group">
									<label class="col-sm-3 control-label">Nama Penulis</label>
									<div class="col-sm-9">
										<select class="form-control tooltip-right" id="IdUser" name="IdUser">	
											<option value="" selected>-PILIH-</option>
											<?php
											foreach($authornews as $row){
												?>
												<option value="<?=$row->IdUser;?>"><?=$row->FullName;?></option>
												<?php
											}
											?>
										</select>				
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Awal Periode</label>
									<div class="col-sm-9">
										<input type="text" name="StartPeriode" id="StartPeriode" data-plugin="datepicker" class="form-control tooltip-right" placeholder="Pilih periode"/>					
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Akhir Periode</label>
									<div class="col-sm-9">
										<input type="text" name="EndPeriode" id="EndPeriode" data-plugin="datepicker" class="form-control tooltip-right" placeholder="Pilih periode"/>					
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
				url: '<?=base_url();?>backend/report_news_by_author/ajax',
				type: 'POST',
				dataType: 'json',
				data: {
					'do':'ReportNewsByAuthor',
					'<?=$this->security->get_csrf_token_name();?>':'<?=$this->security->get_csrf_hash();?>'
				},
				beforeSend:function(){
					$(".loading").show();
				},
				success: function(data){
					$(".loading").hide();	
					if(data.status=='sukses'){		

						$('#newschart').highcharts({
								chart: {
				            type: 'bar'
				        },
				        title: {
				            text: data.title
				        },
				        subtitle: {
				            text: data.subtitle
				        },
				        xAxis: {
				            text: {
				            	title: null
				            },
				            categories: data.categories,
				            labels: {
				                rotation: 0,
				                style: {
				                    fontSize: '10px',
				                    fontFamily: 'Lato, sans-serif'
				                }
				            }
				        },
				        yAxis: {
				           min: 0,
			            title: {
			                text: data.ytitle,
			                align: 'high'
			            },
			            labels: {
			                overflow: 'justify'
			            }
				        },
				        legend: {
				            enabled: false
				        },
				        tooltip: {
				            pointFormat: 'Total: <b>{point.y} berita</b>'
				        },
				        legend: {
			            layout: 'vertical',
			            align: 'right',
			            verticalAlign: 'top',
			            x: -40,
			            y: 80,
			            floating: true,
			            borderWidth: 1,
			            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
			            shadow: true
			          },
				        series: data.data,
				        plotOptions: {
				        	 bar: {
			                dataLabels: {
			                    enabled: true
			                },
			                 colorByPoint: true
			            }	           
			          },
			          colors: [
			                '#1abc9c',
			                '#e74c3c',
			                '#95a5a6',
			                '#2c3e50',
			                '#2980b9',
			                '#9b59b6'
			          ],            
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
		$("#GraphByPeriode").click(function(){
			$("#DialogGraphByPeriode").on('shown.bs.modal', function(){
				$("#FormGraphByPeriode").trigger('reset');
			})
			$("#DialogGraphByPeriode").modal('show');
		})

		//------------------------------------------------------------------------------------//
		$("#FormGraphByPeriode").validate({			
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
		$("#FormGraphByPeriode").submit(function(e){
			e.preventDefault();
			if($("#FormGraphByPeriode").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin menampilkan laporan berita oleh penulis dalam periode ini?",
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
									var form = $("#FormGraphByPeriode").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/report_news_by_author/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=GraphByPeriode&'+form,
										success: function(data){
											if(data.status=='sukses'){																			
												$("#DialogGraphByPeriode").modal('hide');
												$.growl({title:data.status,message: data.message});
											
													$('#newschart').highcharts({
														chart: {
										            type: 'bar'
										        },
										        title: {
										            text: data.title
										        },
										        subtitle: {
										            text: data.subtitle
										        },
										        xAxis: {
										            text: {
										            	title: null
										            },
										            categories: data.categories,
										            labels: {
										                rotation: 0,
										                style: {
										                    fontSize: '10px',
										                    fontFamily: 'Lato, sans-serif'
										                }
										            }
										        },
										        yAxis: {
										          min: 0,
									            title: {
									                text: data.ytitle,
									                align: 'high'
									            },
									            labels: {
									                overflow: 'justify'
									            }
										        },
										        legend: {
										            enabled: false
										        },
										        tooltip: {
										            pointFormat: 'Total: <b>{point.y} berita</b>'
										        },
										        legend: {
									            layout: 'vertical',
									            align: 'right',
									            verticalAlign: 'top',
									            x: -40,
									            y: 80,
									            floating: true,
									            borderWidth: 1,
									            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
									            shadow: true
									          },
										        series: data.data,
										        plotOptions: {
										        	bar: {
								                dataLabels: {
								                    enabled: true
								                },
								                 colorByPoint: true
									            }	           
									          },
									          colors: [
									                '#1abc9c',
									                '#e74c3c',
									                '#95a5a6',
									                '#2c3e50',
									                '#2980b9',
									                '#9b59b6'
									          ],            
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
		$("#GraphByAuthorPerPeriode").click(function(){
			$("#DialogGraphByAuthorPerPeriode").on('shown.bs.modal', function(){
				$("#FormGraphByAuthorPerPeriode").trigger('reset');
			})
			$("#DialogGraphByAuthorPerPeriode").modal('show');
		})
		//------------------------------------------------------------------------------------//
		$.validator.addMethod("SelectList", function(value, element, params){
			return (value !== '');
		});

		$("#FormGraphByAuthorPerPeriode").validate({			
			rules: {
				IdUser: {
					SelectList: true
				},
				StartPeriode: {
					'required': true						
				},
				EndPeriode: {
					'required': true						
				}
			},
			messages: {
				IdUser: {
					SelectList: 'Nama penulis belum dipilih'
				},
				StartPeriode: {
					required: 'Periode harus diisi'
				},
				EndPeriode: {
						required: 'Periode harus diisi'		
				}
			}			
		});
		$("#FormGraphByAuthorPerPeriode").submit(function(e){
			e.preventDefault();
			if($("#FormGraphByAuthorPerPeriode").valid()){				
				//////////////////////
				bootbox.dialog({
					message: "Apakah anda yakin menampilkan laporan berita oleh penulis dalam periode ini?",
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
									var form = $("#FormGraphByAuthorPerPeriode").serialize();
									$.ajax({
										url: '<?=base_url();?>backend/report_news_by_author/ajax',
										type: 'POST',
										dataType: 'json',
										data:'do=GraphByAuthorPerPeriode&'+form,
										success: function(data){
											if(data.status=='sukses'){																			
												$("#DialogGraphByAuthorPerPeriode").modal('hide');
												$.growl({title:data.status,message: data.message});
												$('#newschart').highcharts({
													chart: {
									            type: 'column'
									        },
									        title: {
									            text: data.title
									        },
									        subtitle: {
									            text: data.subtitle
									        },
									        xAxis: {
									            type: 'category',
									            labels: {
									                rotation: -45,
									                style: {
									                    fontSize: '10px',
									                    fontFamily: 'Lato, sans-serif'
									                }
									            }
									        },
									        yAxis: {
									            min: 0,
									            title: {
									                text: data.ytitle
									            }
									        },									        
									        tooltip: {
									            pointFormat: data.author+': <b>{point.y} berita</b>'
									        },
									        legend: {
								            layout: 'horizontal',
								            align: 'center',
								            verticalAlign: 'bottom',
								            borderWidth: 0
								          },
									        series: [{
									            name: data.xtitle,
									            data: data.data,
									            dataLabels: {
									                enabled: true,
									                rotation: -90,
									                color: '#000',
									                align: 'right',
									                //format: '{point.y:.1f}', // one decimal
									                y: 0, // 10 pixels down from the top
									                style: {
									                    fontSize: '8px',
									                    fontFamily: 'Lato, sans-serif'
									                }
									            }
									        }],
									        plotOptions: {
						                column: {
								                    colorByPoint: true
								                }
								          },
								          colors: [
								                '#1abc9c',
								                '#e74c3c',
								                '#95a5a6',
								                '#2c3e50',
								                '#2980b9',
								                '#9b59b6'
								          ],            
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

		




		$("#Refresh").click(function(){location.reload();});
		//------------------------------------------------------------------------------------//
	});
	//------------------------------------------------------------------------------------//
	function Grap(){
		$("#DialogReportPerPeriode").modal('show');
	}
	//------------------------------------------------------------------------------------//
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

