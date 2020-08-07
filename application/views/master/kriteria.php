<?php
$modul['modul'] = $this->db->get("modul")->result();
?>
<style type="text/css">
    .absensi-control {
        cursor: pointer;
    }

    .holding {
        background-color: #c9c9c9;
    }

    @media (min-width: 1200px) {
        .modal-lg {
            max-width: 950px;
        }

        .modal-md {
            max-width: 650px;
        }

        .modal-md {
            width: 40%;
        }
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Menu Kriteria</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#"><?= $this->uri->segment(1) ?></a></div>
                <div class="breadcrumb-item"><a href="#"><?= $this->uri->segment(2) ?></a></div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Halaman manajemen Kriteria</h2>
            <p class="section-lead">Halaman ini digunakan untuk mengelola data Kriteria.</p>
            <div class="card">
                <div class="card-header">
                    <h4>Tabel data Kriteria</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">Kriteria</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Detail Kriteria</a>
                        </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <button class="btn btn-md btn-info" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
                                </div>
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button class="btn btn-sm btn-default" title="edit" id="btn-edit"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" title="hapus" id="btn-hapus"><i class="fa fa-trash"></i></button>
                                </div>
                                <div style="overflow: auto;" class="col-md-12">
                                    <!-- table Kriteria -->
                                    <table class="table table-striped" style="width: 100%;" id="ajax_table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Kriteria</th>
                                                <th>Nama Kriteria</th>
                                                <th>Sifat</th>
                                                <th>Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <button class="btn btn-md btn-info" id="btn-tambah-detail"><i class="fa fa-plus"></i> Tambah</button>
                                </div>
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button class="btn btn-sm btn-default" title="edit" id="btn-edit-detail"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" title="hapus" id="btn-hapus-detail"><i class="fa fa-trash"></i></button>
                                </div>
                                <div style="overflow: auto;" class="col-md-12">
                                    <!-- table detail kriteria -->
                                    <table class="table table-striped" style="width: 100%;" id="ajax_table_detail">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Kriteria</th>
                                                <th>Nama Kriteria</th>
                                                <th>Detail Kriteria</th>
                                                <th>Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL simpan dan edit kriteria -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="form_simpan">
                        <ul class="nav nav-tabs" id="details_form" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="data_kriteria-tab2" data-toggle="tab" href="#data_kriteria" role="tab" aria-controls="data_kriteria" aria-selected="true">Data Kriteria</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="data_kriteria" role="tabpanel" aria-labelledby="data_kriteria-tab2">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="kd_kriteria">Kode Kriteria</label>
                                        <input type="text" class="form-control" name="kd_kriteria" id="kd_kriteria" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="kriteria">Nama Kriteria</label>
                                        <input type="text" class="form-control" name="kriteria" id="kriteria" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="sifat">Sifat</label>
                                        <select class="form-control" name="sifat" id="sifat">
                                            <option value="">Pilih</option>
                                            <option value="C">Cost</option>
                                            <option value="B">Benefit</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="bobot">Bobot</label>
                                        <input type="number" class="form-control" name="bobot" id="bobot" placeholder="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL simpan dan edit detail kriteria -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_form_detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="form_simpan_detail">
                        <ul class="nav nav-tabs" id="details_forms" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="data_kriteria_detail-tab2" data-toggle="tab" href="#data_kriteria_detail" role="tab" aria-controls="data_kriteria_detail" aria-selected="true">Data Kriteria</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="data_kriteria_detail" role="tabpanel" aria-labelledby="data_kriteria_detail-tab2">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="id_kriteria">Kode Kriteria</label>
                                        <input type="text" name="id_kriteria" id="id_kriteria" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="detail">Detail Kriteria</label>
                                        <input type="text" class="form-control" name="detail" id="detail" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="bobot_detail">Bobot</label>
                                        <input type="number" class="form-control" name="bobot_detail" id="bobot_detail" placeholder="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-detail">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

<script>
    var save_method = "add";
    var global_id;
    var global_all_id = [];

    $(document).ready(function() {
        table = $('#ajax_table').DataTable({
            "order": [],
            "searching": false,
            "lengthChange": false,
            "ajax": {
                "url": "<?php echo base_url('master/kriteria/ajaxTable'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [1],
                    "orderable": true,
                    "className": "text-center absensi-control",
                },
                {
                    "targets": [0, -1, -2, -3],
                    "orderable": false,
                    "className": "text-center",
                },
            ],
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "processing": true,

            "scrollCollapse": true,
        }).on("click", "tr", function() {
            var row = table.row($(this));
            var data_row = row.data();
            id_row = data_row[5];
            if ($(this).children().hasClass("holding")) {
                $(this).children().removeClass("holding");
                if (global_all_id.includes(id_row)) {
                    var key = global_all_id.indexOf(id_row);
                    global_all_id.splice(key, 1);
                }
            } else {
                $(this).children().addClass("holding");
                global_all_id.push(data_row[5]);
                if (!global_all_id.includes(id_row)) {
                    global_all_id.push(id_row);
                }
            }
            console.log(global_all_id);
        });
    });

    $(document).ready(function() {
        table_detail = $('#ajax_table_detail').DataTable({
            "order": [],
            "searching": false,
            "lengthChange": false,
            "ajax": {
                "url": "<?php echo base_url('master/kriteria/ajaxTable_detail'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [1],
                    "orderable": true,
                    "className": "text-center absensi-control",
                },
                {
                    "targets": [0, -1, -2, -3],
                    "orderable": false,
                    "className": "text-center",
                },
            ],
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "processing": true,

            "scrollCollapse": true,
        }).on("click", "tr", function() {
            var row = table_detail.row($(this));
            var data_row = row.data();
            id_row = data_row[5];
            if ($(this).children().hasClass("holding")) {
                $(this).children().removeClass("holding");
                if (global_all_id.includes(id_row)) {
                    var key = global_all_id.indexOf(id_row);
                    global_all_id.splice(key, 1);
                }
            } else {
                $(this).children().addClass("holding");
                global_all_id.push(data_row[5]);
                if (!global_all_id.includes(id_row)) {
                    global_all_id.push(id_row);
                }
            }
            console.log(global_all_id);
        });
    });

    $("#btn-tambah").click(function() {
        save_method = "add";
        clear_data();
        $("#modal_form").modal("show");
        $(".modal-title").text("Tambah data Kriteria");
    });

    $("#btn-tambah-detail").click(function() {
        save_method = "add";
        clear_data_detail();
        $("#modal_form_detail").modal("show");
        $(".modal-title").text("Tambah detail Kriteria");
    });

    function clear_data() {
        $('#kd_kriteria').val('');
        $('#kriteria').val('');
        $("#sifat").val('');
        $("#bobot").val('');
    }

    function clear_data_detail() {
        $("#id_kriteria").select2("val", "");
        $('#detail').val('');
        $("#bobot_detail").val('');
    }

    function form_validation() {
        var status = "true";

        if ($("#kd_kriteria").val() == "") {
            $("#kd_kriteria").addClass("is-invalid");
            notif_warning('#kd_kriteria', 'Wajib diisi!');
            status = "false";
        } else {
            $("#kd_kriteria").removeClass("is-invalid");
            $("#kd_kriteria").next().text("");
        }

        if ($("#kriteria").val() == "") {
            $("#kriteria").addClass("is-invalid");
            notif_warning('#kriteria', 'Wajib diisi!');
            status = "false";
        } else {
            $("#kriteria").removeClass("is-invalid");
            $("#kriteria").next().text("");
        }

        if ($("#sifat").val() == "") {
            $("#sifat").addClass("is-invalid");
            notif_warning('#sifat', 'Wajib dipilih!');
            status = "false";
        } else {
            $("#sifat").removeClass("is-invalid");
            $("#sifat").next().text("");
        }

        if ($("#bobot").val() == "") {
            $("#bobot").addClass("is-invalid");
            notif_warning('#bobot', 'Wajib diisi!');
            status = "false";
        } else {
            $("#bobot").removeClass("is-invalid");
            $("#bobot").next().text("");
        }

        return status;
    }

    function form_validation_detail() {
        var status = "true";

        if ($("#id_kriteria").val() == "") {
            $("#id_kriteria").addClass("is-invalid");
            notif_warning('#id_kriteria', 'Wajib dipilih!');
            status = "false";
        } else {
            $("#id_kriteria").removeClass("is-invalid");
            $("#id_kriteria").next().text("");
        }

        if ($("#detail").val() == "") {
            $("#detail").addClass("is-invalid");
            notif_warning('#detail', 'Wajib diisi!');
            status = "false";
        } else {
            $("#detail").removeClass("is-invalid");
            $("#detail").next().text("");
        }

        if ($("#bobot_detail").val() == "") {
            $("#bobot_detail").addClass("is-invalid");
            notif_warning('#bobot_detail', 'Wajib diisi!');
            status = "false";
        } else {
            $("#bobot_detail").removeClass("is-invalid");
            $("#bobot_detail").next().text("");
        }

        return status;
    }

    $("#btn-simpan").click(function() {
        status = form_validation();
        element_data = document.getElementById('form_simpan');
        $('#btn-simpan').text('Menyimpan...'); //change button text
        $('#btn-simpan').attr('disabled', true); //set button enable 
        if (status == "true") {
            if (save_method == "add") {
                url = "<?= base_url() ?>master/kriteria/ajax_save";
            } else {
                url = "<?= base_url() ?>master/kriteria/ajax_update/" + global_id;
            }
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(element_data),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                dataType: "JSON",
                success: function(data) {
                    if (data == "true") {
                        $('#modal_form').modal('hide');
                        table.ajax.reload();
                        swal("Success!", "Data berhasil disimpan!", "success");
                        global_all_id = [];
                    } else {
                        swal("Failed!", "Data gagal disimpan!", "warning");
                    }

                    $('#btn-simpan').text('Simpan'); //change button text
                    $('#btn-simpan').attr('disabled', false); //set button enable 

                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        } else {
            $('#btn-simpan').text('Simpan'); //change button text
            $('#btn-simpan').attr('disabled', false); //set button enable 
        }

    });

    $("#btn-simpan-detail").click(function() {
        status = form_validation_detail();
        element_data = document.getElementById('form_simpan_detail');
        $('#btn-simpan-detail').text('Menyimpan...'); //change button text
        $('#btn-simpan-detail').attr('disabled', true); //set button enable 
        if (status == "true") {
            if (save_method == "add") {
                url = "<?= base_url() ?>master/kriteria/ajax_save_detail";
            } else {
                url = "<?= base_url() ?>master/kriteria/ajax_update_detail/" + global_id;
            }
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(element_data),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                dataType: "JSON",
                success: function(data) {
                    if (data == "true") {
                        $('#modal_form_detail').modal('hide');
                        table_detail.ajax.reload();
                        swal("Success!", "Data berhasil disimpan!", "success");
                        global_all_id = [];
                    } else {
                        swal("Failed!", "Data gagal disimpan!", "warning");
                    }

                    $('#btn-simpan-detail').text('Simpan'); //change button text
                    $('#btn-simpan-detail').attr('disabled', false); //set button enable 

                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        } else {
            $('#btn-simpan-detail').text('Simpan'); //change button text
            $('#btn-simpan-detail').attr('disabled', false); //set button enable 
        }

    });

    $("#btn-edit").click(function() {
        if (global_all_id.length < 1) {
            swal("Ooops!", "Tolong pilih 1 data!", "warning");
        } else if (global_all_id.length > 1) {
            swal("Ooops!", "Tolong pilih 1 saja, tidak boleh lebih!", "warning");
        } else {
            global_id = global_all_id[0];
            save_method = "edit";
            $.ajax({
                url: "<?php echo base_url(); ?>master/kriteria/ajax_edit/" + global_all_id[0],
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $("#kd_kriteria").val(data.kd_kriteria);
                    $("#kriteria").val(data.kriteria);
                    $("#sifat").val(data.sifat);
                    $("#bobot").val(data.bobot);
                    $("#modal_form").modal("show");

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    });

    $("#btn-edit-detail").click(function() {
        if (global_all_id.length < 1) {
            swal("Ooops!", "Tolong pilih 1 data!", "warning");
        } else if (global_all_id.length > 1) {
            swal("Ooops!", "Tolong pilih 1 saja, tidak boleh lebih!", "warning");
        } else {
            global_id = global_all_id[0];
            save_method = "edit";
            $.ajax({
                url: "<?php echo base_url(); ?>master/kriteria/ajax_edit_detail/" + global_all_id[0],
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $("#id_kriteria").select2("val", data.id_kriteria);
                    $("#detail").val(data.detail);
                    $("#bobot_detail").val(data.bobot);
                    $("#modal_form_detail").modal("show");

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    });

    $("#btn-hapus").click(function() {
        if (global_all_id.length < 1) {
            swal("Ooops!", "Tolong pilih 1 data atau lebih!", "warning");
        } else {
            swal({
                title: "Anda yakin?",
                text: "Data akan terhapus secara permanen!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, saya yakin!",
                cancelButtonText: "Tidak, batalkan!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $("#btn-hapus").html("<i class='fa fa-spin fa-spinner'></i>");
                    $.ajax({
                        url: "<?php echo base_url(); ?>master/kriteria/ajax_delete",
                        type: "POST",
                        data: {
                            id: global_all_id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data == "true") {

                                table.ajax.reload();
                                swal("Success!", "Data berhasil dihapus!", "success");
                                global_all_id = [];
                            } else {
                                swal("Failed!", "Data gagal dihapus!", "warning");
                            }
                            $("#btn-hapus").html("<i class='fa fa-trash'></i>");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error get data from ajax');
                        }
                    });

                }
            });
        }
    });

    $("#btn-hapus-detail").click(function() {
        if (global_all_id.length < 1) {
            swal("Ooops!", "Tolong pilih 1 data atau lebih!", "warning");
        } else {
            swal({
                title: "Anda yakin?",
                text: "Data akan terhapus secara permanen!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, saya yakin!",
                cancelButtonText: "Tidak, batalkan!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $("#btn-hapus-detail").html("<i class='fa fa-spin fa-spinner'></i>");
                    $.ajax({
                        url: "<?php echo base_url(); ?>master/kriteria/ajax_delete_detail",
                        type: "POST",
                        data: {
                            id: global_all_id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data == "true") {

                                table_detail.ajax.reload();
                                swal("Success!", "Data berhasil dihapus!", "success");
                                global_all_id = [];
                            } else {
                                swal("Failed!", "Data gagal dihapus!", "warning");
                            }
                            $("#btn-hapus-detail").html("<i class='fa fa-trash'></i>");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error get data from ajax');
                        }
                    });

                }
            });
        }
    });

    $('#id_kriteria').select2({
        placeholder: "Input Kode Kriteria",
        allowClear: true,
        ajax: {
            url: '<?php echo base_url(); ?>master/kriteria/select2_kode_kriteria',
            dataType: 'json',
            type: 'post',
            quietMillis: 100,
            data: function(term, page) {
                return {
                    query: term,
                    limit: 10,
                    page: page
                };
            },
            results: function(data, page) {
                var more = (page * 10) < data.total;
                return {
                    results: data.rows,
                    more: more
                };
            }
        },
        initSelection: function(el, cb) {
            var id = $(el).val();
            $.ajax({
                url: '<?php echo base_url(); ?>master/kriteria/select2_kode_kriteria',
                data: {
                    id: id
                },
                dataType: 'json',
                type: 'post'
            }).done(function(data) {
                if (data.rows && data.rows.length) {
                    cb(data.rows[0]);
                }
            });
        },
        id: function(data) {
            return data.id;
        },
        formatResult: function(data) {
            return "<div>" + data.kd_kriteria + "<div>";
        },
        formatSelection: function(data) {
            $('#id_kriteria').val(data.id);
            return data.kd_kriteria;

        },
        escapeMarkup: function(m) {
            return m;
        } // we do not want to escape markup since we are displaying html in results
    }).on('select2-clearing', function() {
        $('.btn-simpan-detail').attr('disabled', false);
    });
</script>