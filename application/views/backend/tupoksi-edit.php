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
        <li><a href="<?=base_url();?>backend/tupoksi">tupoksi</a></li>
        <li class="active">Edit Tupoksi</li>
      </ol>
      <h1 class="page-title">Edit Tupoksi</h1>
			
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">					
                <?php
                        $ulevel = $this->user_model->GetLevelUser();
                        if ($ulevel == 'superadmin') {
                    ?>
								<form class="form-horizontal" id="FormTupoksiEdit" name="FormTupoksiEdit">
                                    <div class="form-group">
                                        <label for="author" class="col-md-2 control-label">penulis</label>
                                        <div class="col-md-10">
                                            <input type='text' class="form-control" value="Penulis: <?= $author; ?>, Terakhir update: <?= DateTimeIndo($row->LastUpdate); ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="TugasPokok" class="col-md-2 control-label">Tugas Pokok</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" id="TugasPokok" name="TugasPokok" data-toggle="tooltip" title="TugasPokok" rows="10"><?= $row->TugasPokok; ?></textarea>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="Fungsi" class="col-md-2 control-label">Fungsi</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" id="Fungsi" name="Fungsi" data-toggle="tooltip" title="Fungsi" rows="10"><?= $row->Fungsi; ?></textarea>
                                        </div>
                                    </div>
									<div class="form-group">
										<label for="FlagPublish" class="col-md-2 control-label">Opsi</label>
										<div class="col-md-9">
											<div class="form-control no-line no-left-padding">
												<input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish" name="FlagPublish" <?= $flagpublish; ?>> Publish &nbsp;
											</div>
										</div>
									</div>
                                    <input type="hidden" name="IDTupoksi" id="IDTupoksi" value="<?= $row->IDTupoksi; ?>" />
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                    <div class="form-group">
                                        <legend></legend>
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary" id="SaveButton">Simpan </button>
                                            &nbsp; &nbsp;
                                            <a href="<?= base_url(); ?>backend/tupoksi"><button type="button" class="btn btn-default">Batal </button></a>
                                        </div>
                                    </div>
                                </form>	
                    <?php
                    } else {
                        $this->load->view('backend/no-access');
                    }
                    ?>		
					
				</div>
			</div>
			
			<div class="panel">			
				<div class="panel-body">
						<h4>Keterangan</h4>
						<div class="list-group">
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img src="<?=base_url();?>assets/backend/images/publish.png"/> Publish</h4>
								<p class="list-group-item-text">Tupoksi sudah dipublish</p>
							</a>
							<a class="list-group-item" href="javascript:void(0)">
								<h4 class="list-group-item-heading"><img src="<?=base_url();?>assets/backend/images/draft.png"/> Draft</h4>
								<p class="list-group-item-text">Tupoksi masih draft</p>
							</a>							
						</div>				
				</div>
			</div>
			
    </div>
  </div>
  <!-- End Page -->
 
 <?php $this->load->view('backend/footer');?>
 
 <link rel="stylesheet" href="<?=base_url();?>assets/backend/js/plugins/tinymce/skins/lightgray/skin.min.css">
 <script type="text/javascript" src="<?=base_url();?>assets/backend/js/plugins/tinymce/tinymce.min.js"></script>
 <link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
 <script src="<?=base_url();?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
 <script src="<?=base_url();?>assets/backend/js/components/bootstrap-datepicker.js"></script>
 
 <script>
	//------------------------------------------------------------------------------------//
	$(function(){
		//------------------------------------------------------------------------------------//
		$("#FormTupoksiEdit").find("#TugasPokok").focus();
            //------------------------------------------------------------------------------------//
            tinymce.init({
                selector: "#Fungsi, #TugasPokok",
                theme: "modern",
                height: "480",
                relative_urls: false,
                plugins: [
                    "paste advlist autolink lists link image charmap print preview hr anchor pagebreak code",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table directionality",
                    "emoticons template paste textcolor colorpicker textpattern imagetools"
                ],
                menubar: false,
                toolbar1: "insertfile paste undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                toolbar2: "print preview media | forecolor backcolor | emoticons | table | pagebreak | code",
                image_advtab: true,
                templates: [{
                        title: 'Test template 1',
                        content: 'Test 1'
                    },
                    {
                        title: 'Test template 2',
                        content: 'Test 2'
                    }
                ],
                pagebreak_separator: "<!-- page-break -->"
            });
		//------------------------------------------------------------------------------------//		
		//------------------------------------------------------------------------------------//
			$("#FormTupoksiEdit").validate({
                rules: {
                    TugasPokok: {
                        'required': true
                    },
                    Fungsi: {
                        'required': true,
                    }
                },
                messages: {
                    TugasPokok: {
                        required: 'Tugas Pokok harus diisi'
                    },
                    Fungsi: {
                        required: 'Fungsi harus diisi'
                    }
                }
            });
			$("#FormTupoksiEdit").submit(function(e) {
                e.preventDefault();
                if ($("#FormTupoksiEdit").valid()) {
                    //////////////////////
                    bootbox.dialog({
                        message: "Apakah anda yakin akan menyimpan tupoksi ini?",
                        title: "Konfirmasi",
                        buttons: {
                            danger: {
                                label: "No",
                                className: "btn-default",
                                callback: function() {

                                }
                            },
                            main: {
                                label: "Yes",
                                className: "btn-primary",
                                callback: function() {
                                    var form = $("#FormTupoksiEdit").serialize();
                                    $.ajax({
                                        url: '<?= base_url(); ?>backend/tupoksi/ajax',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: 'do=TupoksiUpdate&' + form,
                                        success: function(respon) {
                                            if (respon.status == 'sukses') {
                                                $.growl({
                                                    title: respon.status,
                                                    message: respon.message
                                                });
                                                setTimeout(function() {
                                                    window.location = '<?= base_url(); ?>backend/tupoksi';
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
	});

 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

