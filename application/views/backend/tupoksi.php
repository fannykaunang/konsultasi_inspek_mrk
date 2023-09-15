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
                <li class="active">Tupoksi</li>
            </ol>
            <h1 class="page-title">Tugas pokok & fungsi</h1>
            <div class="page-header-actions">
                <?php
                    $displayButton = ($totaltupoksi == 0 || $totaltupoksi > 1) ? "display:inline-block" : "display:none";
                ?>
                <a href="<?= base_url(); ?>backend/tupoksi/add" style="<?=$displayButton?>" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" data-original-title="Tupoksi Baru" id="AddNews">
                    <i class="icon wb-plus-circle" aria-hidden="true"></i>
                </a>
                <button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" data-original-title="Refresh" id="Refresh">
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
                                <th class="col-md-2">TGL DIBUAT</th>
                                <th class="col-md-2">TGL UPDATE</th>
                                <th class="col-md-3">TUGAS POKOK</th>
                                <th class="col-md-3">FUNGSI</th>
                                <th>PENULIS</th>
                                <th class="text-center">PUBLISH</th>
                                <th class="text-center col-md-2">OPSI</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="col-md-2">TGL DIBUAT</th>
                                <th class="col-md-2">TGL UPDATE</th>
                                <th class="col-md-3">TUGAS POKOK</th>
                                <th class="col-md-3">FUNGSI</th>
                                <th>PENULIS</th>
                                <th class="text-center">PUBLISH</th>
                                <th class="text-center col-md-2">OPSI</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <h4>Keterangan</h4>
                    <div class="list-group">
                        <a class="list-group-item" href="javascript:void(0)">
                            <h4 class="list-group-item-heading"><img src="<?= base_url(); ?>assets/backend/images/publish.png" /> Publish</h4>
                            <p class="list-group-item-text">Tupoksi sudah dipublish</p>
                        </a>
                        <a class="list-group-item" href="javascript:void(0)">
                            <h4 class="list-group-item-heading"><img src="<?= base_url(); ?>assets/backend/images/draft.png" /> Draft</h4>
                            <p class="list-group-item-text">Tupoksi masih draft</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page -->
    <?php $this->load->view('backend/footer'); ?>
    <script>
        //------------------------------------------------------------------------------------//
        $(function() {
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
                    "url": "<?= base_url(); ?>backend/tupoksi/TupoksiList",
                    "type": "POST",
                    "data": {
                        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                    },
                    "error": function() {
                        $.growl.error({
                            title: 'Error',
                            message: 'Ajax request'
                        });
                    }
                },
                "bStateSave": true,
                "fnDrawCallback": function(oSettings) {
                    //$("input:checkbox").uniform();
                },
                "columns": [{
                        "data": 'DateCreated'
                    },
                    {
                        "data": 'LastUpdated'
                    },
                    {
                        "data": 'TugasPokok'
                    },
                    {
                        "data": 'Fungsi'
                    },
                    {
                        "data": 'Author'
                    },
                    {
                        "data": 'FlagPublish'
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
                        "targets": 4,
                        'sClass': 'text-center'
                    },
                    {
                        "orderable": true,
                        "targets": 5,
                        'sClass': 'text-center'
                    },
                    {
                        "orderable": false,
                        "targets": 6,
                        'sClass': 'text-center'
                    }

                ]
            });
            /*-------------------------------------------------------------------------------------*/
            $("#Refresh").click(function() {
                MyTable.fnDraw();
            });
            /*-------------------------------------------------------------------------------------*/
        });
        //------------------------------------------------------------------------------------//
        function TupoksiDelete(IDTupoksi) {
            bootbox.dialog({
                message: "Anda yakin akan menghapus Tupoksi ini?",
                title: "Konfirmasi",
                buttons: {
                    danger: {
                        label: "No",
                        className: "btn-default",
                        callback: function() {}
                    },
                    main: {
                        label: "Yes",
                        className: "btn-primary",
                        callback: function() {
                            $.ajax({
                                url: '<?= base_url(); ?>backend/tupoksi/ajax',
                                type: 'POST',
                                data: {
                                    'do': 'TupoksiDelete',
                                    'IDTupoksi': IDTupoksi,
                                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                                },
                                dataType: 'json',
                                beforeSend: function() {
                                    //myLoader.show();
                                },
                                success: function(respon) {
                                    myLoader.hide();
                                    if (respon.status == 'sukses') {
                                        $("#MyTable").dataTable().fnDraw();
                                        $.growl({
                                            title: respon.status,
                                            message: respon.message
                                        });
                                        location.reload();
                                    }
                                    if (respon.status == 'gagal') {
                                        $.growl.warning({
                                            title: respon.status,
                                            message: respon.message
                                        });
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
    </script>

    <!----------------------------------------------------------------------------------------------------------------------------------------->