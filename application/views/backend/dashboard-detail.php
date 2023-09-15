<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>

<body class="site-menubar-unfold site-menubar-keep">

    <?php $this->load->view('backend/navbar'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <!-- Page -->

    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li><a href="<?= base_url(); ?>backend">Dasbor</a></li>
                <li><a href="">Pelaporan</a></li>
                <li class="active">Detail Pelaporan</li>
            </ol>
            <h1 class="page-title">Detail Pelaporan</h1>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-body">
                    <?php
                    if ($editnews) {
                        foreach ($editnews as $row) {
                            ?>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="judul" class="col-md-2 control-label">Metadata</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control"
                                            value="Pelapor: <?= $row->Author; ?>; Terakhir update: <?= DateTimeIndo($row->Time); ?>"
                                            disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="judul" class="col-md-2 control-label">Perihal</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="Title" name="Title" title="Perihal"
                                            data-toggle="tooltip" placeholder="Perihal" disabled><?= $row->Title; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kategori" class="col-md-2 control-label">Kategori</label>
                                    <div class="col-md-3">
                                        <select class="form-control show-menu-arrow" data-plugin="selectpicker" disabled
                                            name="IdCategory" id="IdCategory" data-toggle="tooltip" title="Kategori">
                                            <?php
                                            foreach ($categorynews as $category) {
                                                if ($category->IdCategory == $row->IdCategory) {
                                                    $sel = 'selected';
                                                } else {
                                                    $sel = '';
                                                }
                                                ?>
                                                <option value="<?= $category->IdCategory; ?>" <?= $sel; ?>><?= $category->NameCategory; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Time" class="col-md-2 control-label">Tanggal</label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type='text' class="form-control" id="Time" data-toggle="tooltip"
                                                title="Tanggal" placeholder="Tanggal" name="Time" disabled
                                                value="<?= DateIndo($row->Time); ?>" data-plugin="datepicker">
                                            <span class="input-group-addon"><i class="icon wb-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="IsiBerita" class="col-md-2 control-label">Isi Pelaporan</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="Content" name="Content" data-toggle="tooltip"
                                            title="Isi Pelaporan" rows="5" disabled><?= $row->Content; ?></textarea>
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-5">
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#DialogUpdate">Simpan </button>
                                        &nbsp; &nbsp;
                                        <a href="<?= base_url(); ?>backend/dashboard"><button type="button"
                                                class="btn btn-primary">Kembali </button></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        $this->load->view('backend/no-data');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page -->



    <div class="modal fade modal-fade-in-scale-up" id="DialogUpdate" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Catatan / Keterangan</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="FormNewsEdit" name="FormNewsEdit">
                        <?php
                        if ($row->FlagAcceptInspektur == '1') {
                            $FlagPublish = 'checked';
                        } else {
                            $FlagPublish = '';
                        }
                        ?>
                        <?php
                        $ulevel = $this->user_model->GetLevelUser();

                        if ($ulevel == 'SKPD' ? $disabled = 'disabled' : $disabled = '')
                            ;
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="Keterangan" name="Keterangan" data-toggle="tooltip"
                                    title="Keterangan" rows="5" placeholder="Catatan / Keterangan" <?= $disabled; ?>><?= $row->CatatanInspektur ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Pilihan" class="col-sm-3 control-label">Opsi</label>
                            <div class="col-sm-9">

                                <div class="form-control no-line no-left-padding">
                                    <input type='checkbox' class="form-inline uniformcheckbox" id="FlagPublish"
                                        name="FlagPublish" <?= $FlagPublish; ?> <?= $disabled; ?> /> Terima Pelaporan
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                        <hr>
                        <input type="hidden" name="IdKonsultasi" id="IdKonsultasi" value="<?= $row->IdKonsultasi; ?>" />
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="form-group text-right mt-2">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
                                <button type="submit" class="btn btn-success" id="okButton">Simpan </button>
                                <button type="submit" class="btn btn-primary hidden" id="SaveButton"> Kirim </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
            $("#FormNewsEdit").find("#Title").focus();
            //------------------------------------------------------------------------------------//
            tinymce.init({
                selector: "#Content",
                theme: "modern",
                height: "300",
                relative_urls: false,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak code",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table directionality",
                    "emoticons template paste textcolor colorpicker textpattern imagetools"
                ],
                // menubar: false,
                // toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                // toolbar2: "print preview media | forecolor backcolor | emoticons | table | pagebreak | code",
                menubar: false,
                statusbar: false,
                toolbar: false,
                image_advtab: true,
                templates: [
                    { title: 'Test template 1', content: 'Test 1' },
                    { title: 'Test template 2', content: 'Test 2' }
                ],
                pagebreak_separator: "<!-- page-break -->",
                readonly: 1
            });
            //------------------------------------------------------------------------------------//
            $("#FormNewsEdit").validate({
                rules: {
                    Title: {
                        'required': true
                    }
                },
                messages: {
                    Title: {
                        required: 'Judul harus diisi'
                    }
                }
            });
            $("#FormNewsEdit").submit(function (e) {
                e.preventDefault();
                if ($("#FormNewsEdit").valid()) {
                    //////////////////////
                    bootbox.dialog({
                        message: "Apakah anda yakin akan menyimpan Pelaporan ini?",
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
                                    var form = $("#FormNewsEdit").serialize();
                                    $.ajax({
                                        url: '<?= base_url(); ?>backend/dashboard/ajax',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: 'do=KonsulUpdateInspektur&' + form,
                                        success: function (respon) {
                                            if (respon.status == 'sukses') {
                                                $.growl({ title: respon.status, message: respon.message });
                                                setTimeout(function () { window.location = '<?= base_url(); ?>backend/dashboard'; }, 1000);
                                            }
                                        },
                                        timeout: 20000,
                                        error: function () {
                                            myLoader.hide();
                                            $.growl.error({ title: 'Error', message: 'Ajax request' });
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            });
            //------------------------------------------------------------------------------------//
            $('#SaveButton').click(function () {
                $("#okButton").trigger("click");
            });
        });
    //------------------------------------------------------------------------------------//
    </script>

    <!----------------------------------------------------------------------------------------------------------------------------------------->