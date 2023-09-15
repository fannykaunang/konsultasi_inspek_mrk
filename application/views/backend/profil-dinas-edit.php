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
                <li><a href="<?= base_url(); ?>backend/profil_dinas">Profil dinas</a></li>
                <li class="active">Edit Profil</li>
            </ol>
            <h1 class="page-title">Edit Profil Dinas</h1>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-body">
                    <?php
                    if ($RoleNewsUpdate == 'yes') {
                        if ($editpage !== null) {
                            foreach ($editpage as $row) {
                                ?>
                                <form class="form-horizontal" id="FormPageSambutan" name="FormPageSambutan">
                                    <div class="form-group">
                                        <label for="judul" class="col-md-2 control-label">Metadata</label>
                                        <div class="col-md-10">
                                            <input type='text' class="form-control"
                                                value="Pelapor: <?= $authorpage; ?>, Terakhir update: <?= DateTimeIndo($row->TglUpdate); ?>"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ContentPage" class="col-md-2 control-label">Isi Profil</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" id="ContentPage" name="ContentPage" data-toggle="tooltip"
                                                title="Isi p4rofil" rows="10"><?= $row->Sambutan; ?></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="IdProfil" id="IdProfil" value="<?= $row->IdProfil; ?>" />
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                        value="<?= $this->security->get_csrf_hash(); ?>" />
                                    <div class="form-group">
                                        <legend></legend>
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary" id="SaveButton">Simpan </button>
                                            &nbsp; &nbsp;
                                            <a href="<?= base_url(); ?>backend/profil_dinas"><button type="button"
                                                    class="btn btn-default">Batal </button></a>
                                        </div>
                                    </div>
                                </form>
                                <?php
                            }
                        } else {
                            if ($prohibitupdate == 'yes') {
                                $this->load->view('backend/prohibit-update');
                            } else {
                                $this->load->view('backend/no-data');
                            }
                        }
                        ?>
                        <?php
                    } else {
                        $this->load->view('backend/no-access');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page -->

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
            $("#FormPageSambutan").find("#TitlePage").focus();
            //------------------------------------------------------------------------------------//
            tinymce.init({
                selector: "#ContentPage",
                theme: "modern",
                height: "480",
                relative_urls: false,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak code",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern imagetools"
                ],
                menubar: false,
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
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
            $("#FormPageSambutan").validate({
                rules: {
                    ContentPage: {
                        'required': true
                    }
                },
                messages: {
                    ContentPage: {
                        required: 'Sambutan harus diisi'
                    }
                }
            });
            $("#FormPageSambutan").submit(function (e) {
                e.preventDefault();
                if ($("#FormPageSambutan").valid()) {
                    //////////////////////
                    bootbox.dialog({
                        message: "Apakah anda yakin akan menyimpan profil ini?",
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
                                    var form = $("#FormPageSambutan").serialize();
                                    $.ajax({
                                        url: '<?= base_url(); ?>backend/profil_dinas/ajax',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: 'do=PageUpdate&' + form,
                                        success: function (respon) {
                                            if (respon.status == 'sukses') {
                                                $.growl({
                                                    title: respon.status,
                                                    message: respon.message
                                                });
                                                setTimeout(function () {
                                                    window.location = '<?= base_url(); ?>backend/profil_dinas';
                                                }, 1000);
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
    </script>

    <!----------------------------------------------------------------------------------------------------------------------------------------->