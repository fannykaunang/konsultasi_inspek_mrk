<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header'); ?>

<body class="site-menubar-unfold site-menubar-keep">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php $this->load->view('backend/navbar'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <!-- Page -->
    <div class="page animsition">
        <div class="page-header">
            <ol class="breadcrumb">
                <li><a href="<?= base_url(); ?>backend">Dasbor</a></li>
                <li class="active">Pegawai</li>
            </ol>
            <h1 class="page-title">Daftar Pegawai</h1>
            <div class="page-header-actions">
                <button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" data-original-title="Pegawai baru"
                    onclick="UserCreate();">
                    <i class="icon wb-plus-circle" aria-hidden="true"></i>
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

                    <table id="MyTable" class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-bold">NIP</th>
                                <th>NAMA LENGKAP</th>
                                <th>TGL. LAHIR</th>
                                <th>JABATAN</th>
                                <th>JENIS PEG.</th>
                                <th>UNIT KERJA</th>
                                <th class="text-center col-md-2">OPSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page -->
    <div class="modal fade modal-fade-in-scale-up" id="DialogUserCreate" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Form Pegawai</h4>
                </div>
                <div class="modal-body">
                    <iframe name="IFrameUploadFile" style="display:none;"></iframe>
                    <form class="form-horizontal" name="FormPegawaiCreate" id="FormPegawaiCreate" method="POST"
                        action="<?= base_url(); ?>/backend/pegawai/UploadFile" enctype="multipart/form-data"
                        target="IFrameUploadFile">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <div id="ResponUpload" style="display:none;"></div>
                                <div id="StatusUpload" style="display:none;">process</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">No. Urut</label>
                            <div class="col-md-6">
                                <input type="number" name="NoUrut" id="NoUrut"
                                    placeholder="Nomor Urut dalam daftar absensi" class="form-control tooltip-right"
                                    title="Nomor Urut" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">N.I.P</label>
                            <div class="col-md-9">
                                <input type="text" name="NIP" id="NIP" placeholder="NIP (kosongkan jika tidak ada)"
                                    class="form-control tooltip-right" title="NIP" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nama Pegawai</label>
                            <div class="col-md-9">
                                <input type="text" name="NamaPegawai" id="NamaPegawai" placeholder="Nama Pegawai"
                                    class="form-control tooltip-right" title="Nama Pegawai" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="TglLahir" class="col-md-3 control-label">Tanggal Lahir</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type='text' class="form-control" id="TglLahir" data-toggle="tooltip"
                                        title="Tanggal" placeholder="Tanggal" name="TglLahir"
                                        value="<?= date('d/m/Y'); ?>" data-plugin="datepicker">
                                    <span class="input-group-addon"><i class="icon wb-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">J. Kelamin</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker" name="JKelamin"
                                    id="JKelamin" required class="required">
                                    <option value="0">-PILIH-</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Pangkat/Golongan</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker"
                                    name="PangkatGolongan" id="PangkatGolongan">
                                    <option value="">-PILIH-</option>
                                    <option value="Juru Muda / I A">Juru Muda / I A</option>
                                    <option value="Juru Muda TK. I / I B">Juru Muda TK. I / I B</option>
                                    <option value="Juru / I C">Juru / I C</option>
                                    <option value="Juru TK. I / I D">Juru TK. I / I D</option>
                                    <option value="Pengatur Muda / II A">Pengatur Muda / II A</option>
                                    <option value="Pengatur Muda TK. I / II B">Pengatur Muda TK. I / II B</option>
                                    <option value="Pengatur / II C">Pengatur / II C</option>
                                    <option value="Pengatur TK. I / II D">Pengatur TK. I / II D</option>
                                    <option value="Penata Muda / III A">Penata Muda / III A</option>
                                    <option value="Penata Muda TK. I / III B">Penata Muda TK. I / III B</option>
                                    <option value="Penata / III C">Penata / III C</option>
                                    <option value="Penata TK. I / III D">Penata TK. I / III D</option>
                                    <option value="Pembina / IV A">Pembina / IV A</option>
                                    <option value="Pembina TK. I / IV B">Pembina TK. I / IV B</option>
                                    <option value="Pembina Utama Muda / IV C">Pembina Utama Muda / IV C</option>
                                    <option value="Pembina Utama Madya / IV D">Pembina Utama Madya / IV D</option>
                                    <option value="Pembina Utama / IV E">Pembina Utama / IV E</option>
                                    <option value="-">Tidak ada</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Jabatan</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker" name="Jabatan"
                                    id="Jabatan">
                                    <option value="">-PILIH-</option>
                                    <option value="Kepala Dinas">Kepala Dinas</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Kepala Bidang">Kepala Bidang</option>
                                    <option value="Kepala Seksi/Sub Bagian">Kepala Seksi/Sub Bagian</option>
                                    <option value="-">Tidak ada</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Jenis Pegawai</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker"
                                    name="JenisPegawai" id="JenisPegawai" required class="required">
                                    <option value="" selected>-PILIH-</option>
                                    <option value="ASN">ASN</option>
                                    <option value="PPPK">PPPK</option>
                                    <option value="Honor Daerah">Honor Daerah</option>
                                    <option value="Honor Kontrak">Honor Kontrak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kategori" class="col-md-3 control-label">Unit Kerja</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" name="IdUnit" id="IdUnit"
                                    data-plugin="selectpicker">
                                    <option value="" selected>-PILIH-</option>
                                    <?php
                                    foreach ($unit_kerja as $row) {
                                        ?>
                                        <option value="<?= $row->IDUnit; ?>"><?= $row->UnitKerja; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Tipe Jabatan</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker"
                                    name="TipeJabatan" id="TipeJabatan">
                                    <option value="">-PILIH-</option>
                                    <option value="Pejabat">Pejabat</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Unggah Foto</label>
                            <div class="col-md-9">
                                <input type="file" name="userfile" id="FileThumbnail" placeholder="Pilih file"
                                    class="form-control tooltip-right" title="Pilih file" />
                            </div>
                        </div>

                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
                            <button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-fade-in-scale-up" id="DialogUserEdit" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Pegawai</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" name="FormUserEdit" id="FormUserEdit" method="POST"
                        action="<?= base_url(); ?>/backend/pegawai/EditFile">
                        <div class="row" style="margin-bottom:14px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <img src="#" width="120" height="120" alt="" id="imgUserEdit" name="imgUserEdit"
                                    class="img-circle" />
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">No. Urut</label>
                            <div class="col-md-4">
                                <input type="number" name="NoUrut" id="NoUrut" placeholder="Nomor Urut"
                                    class="form-control tooltip-right" title="Nomor Urut" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">N.I.P</label>
                            <div class="col-md-9">
                                <input type="text" name="NIP" id="NIP" placeholder="NIP"
                                    class="form-control tooltip-right" title="NIP" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nama Pegawai</label>
                            <div class="col-md-9">
                                <input type="text" name="NamaPegawai" id="NamaPegawai" placeholder="Nama Pegawai"
                                    class="form-control tooltip-right" title="Nama Pegawai" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="TglLahirEdit" class="col-md-3 control-label">Tanggal Lahir</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type='text' class="form-control" id="TglLahirEdit" data-toggle="tooltip"
                                        title="Tanggal" placeholder="Tanggal Lahir" name="TglLahirEdit"
                                        value="<?= $row->TglLahir; ?>" data-plugin="datepicker">
                                    <span class="input-group-addon"><i class="icon wb-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">J. Kelamin</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker"
                                    name="JKelaminEdit" id="JKelaminEdit">
                                    <option value="">-PILIH-</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Pangkat/Golongan</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker"
                                    name="PangkatGolongan" id="PangkatGolongan" />
                                <option value="">-PILIH-</option>
                                <option value="Juru Muda / I A">Juru Muda / I A</option>
                                <option value="Juru Muda TK. I / I B">Juru Muda TK. I / I B</option>
                                <option value="Juru / I C">Juru / I C</option>
                                <option value="Juru TK. I / I D">Juru TK. I / I D</option>
                                <option value="Pengatur Muda / II A">Pengatur Muda / II A</option>
                                <option value="Pengatur Muda TK. I / II B">Pengatur Muda TK. I / II B</option>
                                <option value="Pengatur / II C">Pengatur / II C</option>
                                <option value="Pengatur TK. I / II D">Pengatur TK. I / II D</option>
                                <option value="Penata Muda / III A">Penata Muda / III A</option>
                                <option value="Penata Muda TK. I / III B">Penata Muda TK. I / III B</option>
                                <option value="Penata / III C">Penata / III C</option>
                                <option value="Penata TK. I / III D">Penata TK. I / III D</option>
                                <option value="Pembina / IV A">Pembina / IV A</option>
                                <option value="Pembina TK. I / IV B">Pembina TK. I / IV B</option>
                                <option value="Pembina Utama Muda / IV C">Pembina Utama Muda / IV C</option>
                                <option value="Pembina Utama Madya / IV D">Pembina Utama Madya / IV D</option>
                                <option value="Pembina Utama / IV E">Pembina Utama / IV E</option>
                                <option value="-">Tidak ada</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Jabatan</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker" name="Jabatan"
                                    id="Jabatan" />
                                <option value="">-PILIH-</option>
                                <option value="Kepala Dinas">Kepala Dinas</option>
                                <option value="Sekretaris">Sekretaris</option>
                                <option value="Kepala Bidang">Kepala Bidang</option>
                                <option value="Kepala Seksi/Sub Bagian">Kepala Seksi/Sub Bagian</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Jenis Pegawai</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker"
                                    name="JenisPegawai" id="JenisPegawai" />
                                <option value="">-PILIH-</option>
                                <option value="ASN">ASN</option>
                                <option value="PPPK">PPPK</option>
                                <option value="Honor Daerah">Honor Daerah</option>
                                <option value="Honor Kontrak">Honor Kontrak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kategori" class="col-md-3 control-label">Unit Kerja</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" name="IdUnit" id="IdUnit"
                                    data-plugin="selectpicker">
                                    <option value="" selected>-PILIH-</option>
                                    <?php
                                    foreach ($unit_kerja as $row) {
                                        ?>
                                        <option value="<?= $row->IDUnit; ?>"><?= $row->UnitKerja; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Tipe Jabatan</label>
                            <div class="col-md-9">
                                <select class="form-control show-menu-arrow" data-plugin="selectpicker"
                                    name="TipeJabatan" id="TipeJabatan" />
                                <option value="">-PILIH-</option>
                                <option value="Pejabat">Pejabat</option>
                                <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="IdPegawai" name="IdPegawai" />
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
                            <button type="submit" class="btn btn-primary" id="okButton"> Simpan </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-fade-in-scale-up" id="DialogUploadPictureUser" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Unggah</h4>
                </div>
                <div class="modal-body">

                    <iframe name="IFrameUploadPictureUser" style="display:none;"></iframe>
                    <form class="form-horizontal" name="FormUploadPictureUser" id="FormUploadPictureUser" method="POST"
                        action="<?= base_url(); ?>backend/pegawai/UploadPictureUser" enctype="multipart/form-data"
                        target="IFrameUploadPictureUser">


                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <div id="ResponUpload" style="display:none;"></div>
                                <div id="StatusUpload" style="display:none;">process</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Unggah foto anda</label>
                            <div class="col-sm-9">

                                <input type="file" name="userfile" id="FilePictureUser" placeholder="Pilih file"
                                    class="form-control tooltip-right" title="Pilih file" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                Format: .jpg, .jpeg, .gif dan .png
                            </div>
                        </div>
                        <input type="hidden" name="IdPegawai" id="IdPegawai" value="<?= $row->IdPegawai; ?>" />
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
                    <button type="submit" class="btn btn-primary" id="okButton"> Unggah </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('backend/footer'); ?>

    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
    <script src="<?= base_url(); ?>assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="<?= base_url(); ?>assets/backend/js/components/bootstrap-datepicker.js"></script>

    <script>
        //------------------------------------------------------------------------------------//
        $(function () {
            $('#TglLahirEdit').datepicker({
                format: 'yyyy/mm/dd'
            });

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
                        "previous": "Sebelum",
                        "next": "Berikut",
                        "last": "Akhir",
                        "first": "Awal"
                    }
                },
                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    "url": "<?= base_url(); ?>backend/pegawai/PegawaiList",
                    "type": "POST",
                    "data": {
                        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                    },
                    "error": function () {
                        $.growl.error({
                            title: 'Error',
                            message: 'Ajax request'
                        });
                    }
                },
                "bStateSave": true,
                "fnDrawCallback": function (oSettings) {
                    //$("input:checkbox").uniform();
                },
                "columns": [{
                    "data": 'NIP'
                },
                {
                    "data": 'NamaPegawai'
                },
                {
                    "data": 'TglLahir'
                },
                {
                    "data": 'Jabatan'
                },
                {
                    "data": 'JenisPegawai'
                },
                {
                    "data": 'UnitKerja'
                },
                {
                    "data": 'Option'
                }
                ],
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                "pageLength": 5,
                "columnDefs": [{
                    "orderable": true,
                    "targets": 0
                },
                {
                    "orderable": true,
                    "targets": 1
                },
                {
                    "orderable": true,
                    "targets": 2
                },
                {
                    "orderable": true,
                    "targets": 3
                },
                {
                    "orderable": true,
                    "targets": 4
                },
                {
                    "orderable": true,
                    "targets": 5
                },
                {
                    "orderable": false,
                    "targets": 6,
                    'sClass': 'text-center'
                }
                ],
                "order": [
                    [5, "desc"]
                ]
            });
            //------------------------------------------------------------------------------------//
            $("#Refresh").click(function () {
                MyTable.fnDraw();
            });

            //------------------------------------------------------------------------------------//
            $("#FormPegawaiCreate").validate({
                rules: {
                    NoUrut: {
                        required: true
                    },
                    NamaPegawai: {
                        required: true
                    },
                    TglLahir: {
                        required: true
                    },
                    JKelamin: {
                        required: true,
                        min: 1
                    },
                    PangkatGolongan: {
                        required: true
                    },
                    Jabatan: {
                        required: true
                    },
                    JenisPegawai: {
                        required: true
                    },
                    TipePegawai: {
                        required: true
                    }

                },
                messages: {
                    NoUrut: {
                        required: 'No urut harus diisi'
                    },
                    NamaPegawai: {
                        required: 'Nama Pegawai harus diisi'
                    },
                    JKelamin: {
                        required: "Jenis Kelamin harus dipilih!"
                    }
                }
            });
            function UploadFile() {
                $("#DialogUserCreate").on('shown.bs.modal', function () {
                    $("#DialogUploadFile").find("#NoUrut").focus();
                });
                $("#DialogUserCreate").modal('show');
            }

            //------------------------------------------------------------------------------------//
            $('#FormPegawaiCreate').submit(function () {
                if ($("#FormPegawaiCreate").valid()) {
                    myLoader.show();
                    CreatePegawai();
                }
            });

            function CreatePegawai() {
                var timeout = setTimeout(function () {
                    var status = $("#StatusUpload").html();
                    var response = $("#ResponUpload").html();
                    var timeout = 5000;

                    if (status == 'process') {
                        CreatePegawai();
                    }
                    if (status == 'sukses') {
                        myLoader.hide();
                        $("#ResponUpload").fadeIn();
                        $("#ResponUpload").fadeOut();
                        $("#FormPegawaiCreate").trigger("reset");
                        $("#DialogUploadFile").modal('hide');
                        $.growl({
                            title: 'sukses',
                            message: 'Upload Pegawai'
                        });
                        $("#MyTable").dataTable().fnDraw();
                        $("#FormPegawaiCreate").trigger("reset");
                        $("#StatusUpload").html('process');
                    }
                    if (status == 'gagal') {
                        myLoader.hide();
                        $("#ResponUpload").fadeIn();
                        $("#UploadFile").val('');
                        $.growl.error({
                            title: 'gagal',
                            message: 'Upload Pegawai'
                        });
                        $("#StatusUpload").html('process');
                    }
                }, timeout);
            }
            //------------------------------------------------------------------------------------//		
            $("#FormUserEdit").validate({
                rules: {
                    NamaPegawai: {
                        required: true
                    }
                },
                messages: {
                    NamaPegawai: {
                        required: 'Pegawai harus diisi'
                    }
                }
            });
            $("#FormUserEdit").submit(function (e) {
                e.preventDefault();
                if ($("#FormUserEdit").valid()) {
                    //////////////////////
                    bootbox.dialog({
                        message: "Apakah anda yakin akan mengupdate pegawai ini?",
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
                                    var form = $("#FormUserEdit").serialize();
                                    $.ajax({
                                        url: '<?= base_url(); ?>backend/pegawai/ajax',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: 'do=UserUpdate&' + form,
                                        success: function (respon) {
                                            if (respon.status == 'sukses') {
                                                $.growl({
                                                    title: respon.status,
                                                    message: respon.message
                                                });
                                                $("#DialogUserEdit").modal('hide');
                                                MyTable.fnDraw();
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
        function UserCreate() {
            $("#DialogUserCreate").on('shown.bs.modal', function () {
                $("#FormPegawaiCreate").find("#NoUrut").focus();
            });
            $("#DialogUserCreate").modal('show');
        }
        //------------------------------------------------------------------------------------//	
        function UserDelete(IdPegawai) {
            bootbox.dialog({
                message: "Anda yakin akan menghapus Pegawai ini?",
                title: "Konfirmasi",
                buttons: {
                    danger: {
                        label: "No",
                        className: "btn-default",
                        callback: function () { }
                    },
                    main: {
                        label: "Yes",
                        className: "btn-primary",
                        callback: function () {
                            $.ajax({
                                url: '<?= base_url(); ?>backend/pegawai/ajax',
                                type: 'POST',
                                data: {
                                    'do': 'UserDelete',
                                    'IdPegawai': IdPegawai,
                                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                                },
                                dataType: 'json',
                                beforeSend: function () {
                                    //myLoader.show();
                                },
                                success: function (respon) {
                                    myLoader.hide();
                                    if (respon.status == 'sukses') {
                                        $("#MyTable").dataTable().fnDraw();
                                        $.growl({
                                            title: respon.status,
                                            message: respon.message
                                        });
                                    }
                                    if (respon.status == 'NIP ada') {
                                        $.growl.warning({
                                            title: respon.status,
                                            message: respon.message
                                        });
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
        //------------------------------------------------------------------------------------//
        function UserEdit(IdPegawai) {
            $.ajax({
                url: '<?= base_url(); ?>backend/pegawai/ajax',
                type: 'POST',
                data: {
                    'do': 'UserEdit',
                    'IdPegawai': IdPegawai,
                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function (respon) {
                    myLoader.hide();
                    if (respon.status == 'sukses') {
                        $.each(respon.data, function (index, element) {
                            var date = new Date(element.TglLahir);
                            $("#FormUserEdit").find("#imgUserEdit").attr("src", element.Fullpath);
                            $("#FormUserEdit").find("#NoUrut").val(element.NoUrut);
                            $("#FormUserEdit").find("#NIP").val(element.NIP);
                            $("#FormUserEdit").find("#NamaPegawai").val(element.NamaPegawai).change();
                            $("#FormUserEdit").find("#TglLahirEdit").val(((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear());
                            $("#FormUserEdit").find("#JKelaminEdit").val(element.JKelamin).change();
                            $("#FormUserEdit").find("#PangkatGolongan").val(element.PangkatGolongan).change();
                            $("#FormUserEdit").find("#Jabatan").val(element.Jabatan).change();
                            $("#FormUserEdit").find("#JenisPegawai").val(element.JenisPegawai).change();
                            $("#FormUserEdit").find("#IdUnit").val(element.IdUnit).change();
                            $("#FormUserEdit").find("#TipeJabatan").val(element.TipeJabatan).change();
                            $("#FormUserEdit").find("#IdPegawai").val(element.IdPegawai);
                        });
                        $("#DialogUserEdit").on('shown.bs.modal', function () {
                            $("#DialogUserEdit").find("#NamaPegawai").focus();
                        });
                        $("#DialogUserEdit").modal('show');
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

        function getFormattedDate(date) {
            let year = date.getFullYear();
            let month = (1 + date.getMonth()).toString().padStart(2, '0');
            let day = date.getDate().toString().padStart(2, '0');

            return day + '/' + month + '/' + year;
        }

        function UploadPictureUser(IdPegawai) {
            $.ajax({
                url: '<?= base_url(); ?>backend/pegawai/ajax',
                type: 'POST',
                data: {
                    'do': 'EditFoto',
                    'IdPegawai': IdPegawai,
                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                beforeSend: function () {
                    //myLoader.show();
                },
                success: function (respon) {
                    myLoader.hide();
                    if (respon.status == 'sukses') {
                        $.each(respon.data, function (index, element) {
                            $("#FormUploadPictureUser").find("#userfile").val(element.userfile);

                            $("#FormUploadPictureUser").find("#IdPegawai").val(element.IdPegawai);

                        });
                        $("#DialogUploadPictureUser").modal('show');
                    }
                },
                timeout: 2000,
                error: function () {
                    myLoader.hide();
                    $.growl.error({
                        title: 'Error',
                        message: 'Ajax request'
                    });
                }
            });
        }

        $('#FormUploadPictureUser').submit(function () {
            if ($("#FormUploadPictureUser").valid()) {
                myLoader.show();
                UploadPictureUser1();
            }
        });

        function UploadPictureUser1() {

            $("#DialogUploadPictureUser").modal('show');

            // $("#DialogUploadPictureUser").modal('show');
            var timeout = setTimeout(function () {
                var status = $("#StatusUpload").html();
                var response = $("#ResponUpload").html();
                var timeout = 5000;

                if (status == 'process') {
                    UploadPictureUser1();
                }
                if (status == 'sukses') {
                    myLoader.hide();
                    $("#ResponUpload").fadeIn();
                    $("#ResponUpload").fadeOut();
                    $("#FormUploadPictureUser").trigger("reset");
                    $("#DialogUploadPictureUser").modal('hide');
                    $.growl({
                        title: 'sukses',
                        message: 'Upload foto slider'
                    });
                    $("#MyTable").dataTable().fnDraw();
                    $("#FormUploadPictureUser").trigger("reset");
                    $("#StatusUpload").html('process');

                }
                if (status == 'gagal') {
                    myLoader.hide();
                    $("#ResponUpload").fadeIn();
                    $("#UploadFile").val('');
                    $.growl.error({
                        title: 'gagal',
                        message: 'Upload foto profil gagal'
                    });
                    $("#StatusUpload").html('process');
                }
            }, timeout);
        }







    </script>