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
                <li><a href="<?= base_url(); ?>backend/unit_kerja">Unit kerja</a></li>
                <li class="active">Unit kerja Baru</li>
            </ol>
            <h1 class="page-title">Unit kerja Baru</h1>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-12" id="AlertTupoksiCreate">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Tutup</span>
                            </button>
                            Unit kerja berhasil disimpan, untuk melihat daftar Unit kerja klik <a class="alert-link"
                                href="<?= base_url(); ?>backend/Unit_kerja" title="Daftar Unit kerja"
                                data-toggle="tooltip">Unit kerja</a>.
                        </div>
                    </div>
                    <form class="form-horizontal" id="FormTupoksiCreate" name="FormTupoksiCreate">
                        <div class="form-group">
                            <label for="judul" class="col-md-2 control-label">Pelapor</label>
                            <div class="col-md-10">
                                <input type='text' class="form-control" value="<?= $author; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UnitKerja" class="col-md-2 control-label">Unit kerja</label>
                            <div class="col-md-10">
                                <input type='text' class="form-control" id="UnitKerja" name="UnitKerja"
                                    title="Unit kerja" data-toggle="tooltip" placeholder="Unit Kerja">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UnitKerjaAlias" class="col-md-2 control-label">Unit kerja / Alias</label>
                            <div class="col-md-10">
                                <input type='text' class="form-control" id="UnitKerjaAlias" name="UnitKerjaAlias"
                                    title="Singkatan" data-toggle="tooltip" placeholder="Singkatan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="TugasPokok" class="col-md-2 control-label">Tugas Pokok</label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="TugasPokok" name="TugasPokok" title="Tugas Pokok"
                                    data-toggle="tooltip" placeholder="Tugas Pokok"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Fungsi" class="col-md-2 control-label">Fungsi</label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="Fungsi" name="Fungsi" data-toggle="tooltip"
                                    title="Fungsi" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Pilihan" class="col-md-2 control-label">Opsi</label>
                            <div class="col-md-9">
                                <div class="form-control no-line no-left-padding">
                                    <input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish"
                                        name="FlagPublish" <?= $flagpublish; ?>> Publish &nbsp;
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                        <hr />
                        <div class="form-group">
                            <legend></legend>
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary" id="SaveButton">Simpan </button>
                                &nbsp; &nbsp;
                                <a href="<?= base_url(); ?>backend/unit_kerja"><button type="button"
                                        class="btn btn-default">Batal </button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page -->
    </div>

    <?php $this->load->view('backend/footer'); ?>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/js/plugins/tinymce/skins/lightgray/skin.min.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/tinymce/tinymce.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
    <script src="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="<?= base_url(); ?>assets/backend/js/components/bootstrap-datepicker.js"></script>

    <script>
        //------------------------------------------------------------------------------------//
        $(function () {
            //------------------------------------------------------------------------------------//
            $("#FormTupoksiCreate").find("#UnitKerja").focus();
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
            $.validator.addMethod("SelectList", function (value, element, params) {
                return (value !== '');
            });
            $("#FormTupoksiCreate").validate({
                rules: {
                    UnitKerja: {
                        'required': true
                    },
                    TugasPokok: {
                        'required': true
                    },
                    Fungsi: {
                        'required': true,
                        'url': true
                    }
                },
                messages: {
                    UnitKerja: {
                        required: 'Unit kerja harus diisi'
                    },
                    TugasPokok: {
                        required: 'Tugas Pokok harus diisi'
                    },
                    Fungsi: {
                        required: 'Fungsi harus diisi'
                    }
                }
            });
            $("#FormTupoksiCreate").submit(function (e) {
                e.preventDefault();
                if ($("#FormTupoksiCreate").valid()) {
                    //////////////////////
                    bootbox.dialog({
                        message: "Apakah anda yakin akan menyimpan Unit kerja ini?",
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
                                    var form = $("#FormTupoksiCreate").serialize();
                                    $.ajax({
                                        url: '<?= base_url(); ?>backend/unit_kerja/ajax',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: 'do=TupoksiCreate&' + form,
                                        success: function (respon) {
                                            if (respon.status == 'sukses') {
                                                $.growl({
                                                    title: respon.status,
                                                    message: respon.message
                                                });
                                                $("#AlertTupoksiCreate").show();
                                                $("#FormTupoksiCreate").trigger("reset");
                                                tinyMCE.activeEditor.setContent('');
                                                $('body').scrollTo('body', {
                                                    duration: 'slow',
                                                    offsetTop: '50'
                                                });
                                                $("#FormTupoksiCreate").find("#UnitKerja").focus();
                                            }
                                        },
                                        timeout: 20000,
                                        error: function () {
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
        //------------------------------------------------------------------------------------//
        // function UploadThumbnail() {
        //     $("#DialogUploadThumbnail").on('shown.bs.modal', function() {
        //         $("#FormUploadThumbnail").find("#Filename").focus();
        //     });
        //     $("#DialogUploadThumbnail").modal('show');
        // }
    </script>

    <!----------------------------------------------------------------------------------------------------------------------------------------->