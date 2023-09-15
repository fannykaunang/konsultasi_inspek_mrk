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
                <li class="active">Kepala Dinas</li>
            </ol>
            <h1 class="page-title">Sambutan Kepala Dinas</h1>
            <div class="page-header-actions">
                <?php
                    $displayButton = ($totalpage == 0 || $totalpage > 1) ? "display:inline-block" : "display:none";
                ?>
                <a href="<?= base_url(); ?>backend/sambutan/add" style="<?php echo $displayButton; ?>" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" data-original-title="Sambutan Baru" id="AddSambutan">
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
                    <?php if ($role['RoleNewsView'] == 'yes') {; ?>
                        <table id="MyTable" class="table table-condensed table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-8">SAMBUTAN</th>
                                    <th class="col-md-3">TGL UPDATE</th>
                                    <th class="text-center col-md-2">OPSI</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="col-md-8">SAMBUTAN</th>
                                    <th class="col-md-3">TGL UPDATE</th>
                                    <th class="text-center col-md-2">OPSI</th>
                                </tr>
                            </tfoot>
                        </table>
                    <?php } else {
                        $this->load->view('backend/no-access');
                    } ?>
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
                    "url": "<?= base_url(); ?>backend/sambutan/SambutanList",
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
                "fnDrawCallback": function(oSettings) {},
                "columns": [{
                        "data": 'Sambutan'
                    },
                    {
                        "data": 'TglUpdate'
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
                        "orderable": false,
                        "targets": 2,
                        'sClass': 'text-center'
                    }

                ],
                "order": [
                    [0, "desc"]
                ]
            });
            /*-------------------------------------------------------------------------------------*/
            $("#Refresh").click(function() {
                MyTable.fnDraw();
            });
            /*-------------------------------------------------------------------------------------*/
        });
        //------------------------------------------------------------------------------------//
        function PageDelete(IDSambutan) {
            bootbox.dialog({
                message: "Anda yakin akan menghapus sambutan ini?",
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
                                url: '<?= base_url(); ?>backend/sambutan/ajax',
                                type: 'POST',
                                data: {
                                    'do': 'PageDelete',
                                    'IDSambutan': IDSambutan,
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
                                        $("#AddSambutan").show();
                                        $.growl({
                                            title: respon.status,
                                            message: respon.message
                                        });
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