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
            <h1>Menu Peserta Didik</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#"><?= $this->uri->segment(1) ?></a></div>
                <div class="breadcrumb-item"><a href="#"><?= $this->uri->segment(2) ?></a></div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Halaman manajemen Peserta Didik</h2>
            <p class="section-lead">Halaman ini digunakan untuk mengelola data Peserta Didik.</p>
            <div class="card">
                <div class="card-header">
                    <h4>Tabel data Peserta Didik</h4>
                </div>

                <div class="card-body row">
                    <div class="col-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 text-left">
                        <button class="btn btn-md btn-info" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="col-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 text-right">
                        <button class="btn btn-sm btn-success" title="lihat" id="btn-lihat"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-sm btn-default" title="edit" id="btn-edit"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" title="hapus" id="btn-hapus"><i class="fa fa-trash"></i></button>
                    </div>
                    <div style="overflow: auto;" class="col-md-12">
                        <table class="table table-striped" id="ajax_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>ROMBEL</th>
                                    <th>NAMA</th>
                                    <th>L/P</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal untuk Tambah dan Edit data -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="form_simpan">
                        <ul class="nav nav-tabs" id="details_form" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="data_pesdik-tab2" data-toggle="tab" href="#data_pesdik" role="tab" aria-controls="data_pesdik" aria-selected="true">Data Peserta Didik</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="data_pesdik" role="tabpanel" aria-labelledby="data_pesdik-tab2">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="nama">Nama</label>
                                        <input type="text" class="form-control" name="nama" id="nama" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="jenis_kelamin">Jenis kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                            <option value="">Pilih</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="tanggal_lahir">Tanggal lahir</label>
                                        <input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="nama_ibu">Nama ibu</label>
                                        <input type="text" class="form-control" name="nama_ibu" id="nama_ibu" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="nisn">NISN</label>
                                        <input type="number" class="form-control" name="nisn" id="nisn" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="tingkat">Tingkat</label>
                                        <input type="number" class="form-control" name="tingkat" id="tingkat" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="rombongan">Rombel</label>
                                        <input type="text" class="form-control" name="rombongan" id="rombongan" placeholder="...">
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

<!-- modal untuk melihat detail pesdik -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_see">
    <div class="modal-dialog modal-md" role="document" style=" overflow-y: initial !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow: auto; height: 750px;
            overflow-y: auto;">
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
                            <h4>Data Peserta Didik</h4>
                        </div>
                        <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>NISN</td>
                                        <td class="nisn"></td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td class="nama"></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis kelamin</td>
                                        <td class="jenis_kelamin"></td>
                                    </tr>
                                    <tr>
                                        <td>tanggal lahir</td>
                                        <td class="tanggal_lahir"></td>
                                    </tr>
                                    <tr>
                                        <td>Nama ibu</td>
                                        <td class="nama_ibu"></td>
                                    </tr>
                                    <tr>
                                        <td>Tingkat</td>
                                        <td class="tingkat"></td>
                                    </tr>
                                    <tr>
                                        <td>Rombel</td>
                                        <td class="rombongan"></td>
                                    </tr>
                                    <tr>
                                        <td>Penghasilan Orang Tua</td>
                                        <td class="pendapatan_ortu"></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Saudara</td>
                                        <td class="jumlah_saudara"></td>
                                    </tr>
                                    <tr>
                                        <td>Status Tempat Tinggal</td>
                                        <td class="status_tempat_tinggal"></td>
                                    </tr>
                                    <tr>
                                        <td>Kelengkapan Berkas</td>
                                        <td class="kelengkapan_berkas"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

<script>
    var save_method = "add";
    var global_id;
    var global_all_id = [];

    // Table Pesdik
    $(document).ready(function() {
        table = $('#ajax_table').DataTable({
            "order": [],
            "searching": true,
            "lengthChange": false,
            "ajax": {
                "url": "<?php echo base_url('master/pesdik/ajaxTable'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [1, 2],
                    "orderable": true,
                    "className": "text-center absensi-control",
                },
                {
                    "targets": [0, -1],
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

    // tanggal 
    $('#tanggal_lahir').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });


    $("#btn-tambah").click(function() {
        save_method = "add";
        clear_data();
        $("#modal_form").modal("show");
        $(".modal-title").text("Tambah data Peserta Didik");
    });

    function clear_data() {
        $('#nama').val('');
        $('#nisn').val('');
        $("#jenis_kelamin").val('');
        $("#nama_ibu").val('');
        $("#tingkat").val('');
        $("#rombongan").val('');
    }

    function form_validation() {
        var status = "true";

        if ($("#nama").val() == "") {
            $("#nama").addClass("is-invalid");
            notif_warning('#nama', 'Wajib diisi!');
            status = "false";
        } else {
            $("#nama").removeClass("is-invalid");
            $("#nama").next().text("");
        }

        if ($("#tingkat").val() == "") {
            $("#tingkat").addClass("is-invalid");
            notif_warning('#tingkat', 'Wajib diisi!');
            status = "false";
        } else {
            $("#tingkat").removeClass("is-invalid");
            $("#tingkat").next().text("");
        }

        if ($("#nisn").val() == "") {
            $("#nisn").addClass("is-invalid");
            notif_warning('#nisn', 'Wajib diisi!');
            status = "false";
        } else {
            $("#nisn").removeClass("is-invalid");
            $("#nisn").next().text("");
        }

        if ($("#rombongan").val() == "") {
            $("#rombongan").addClass("is-invalid");
            notif_warning('#rombongan', 'Wajib diisi!');
            status = "false";
        } else {
            $("#rombongan").removeClass("is-invalid");
            $("#rombongan").next().text("");
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
                url = "<?= base_url() ?>master/pesdik/ajax_save";
            } else {
                url = "<?= base_url() ?>master/pesdik/ajax_update/" + global_id;
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

    $("#btn-edit").click(function() {
        if (global_all_id.length < 1) {
            swal("Ooops!", "Tolong pilih 1 data!", "warning");
        } else if (global_all_id.length > 1) {
            swal("Ooops!", "Tolong pilih 1 saja, tidak boleh lebih!", "warning");
        } else {
            global_id = global_all_id[0];
            save_method = "edit";
            $.ajax({
                url: "<?php echo base_url(); ?>master/pesdik/ajax_edit/" + global_all_id[0],
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $("#nama").val(data.nama);
                    $("#nisn").val(data.nisn);
                    $("#jenis_kelamin").val(data.jenis_kelamin);
                    $("#tanggal_lahir").val(sqlToDateIndo(data.tanggal_lahir));
                    $("#nama_ibu").val(data.nama_ibu);
                    $("#tingkat").val(data.tingkat);
                    $("#rombongan").val(data.rombongan);
                    $("#modal_form").modal("show");

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
                        url: "<?php echo base_url(); ?>master/pesdik/ajax_delete",
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

    $('#btn-lihat').click(function() {
        if (global_all_id.length < 1) {
            swal("Ooops!", "Tolong pilih 1 data dong!", "warning");
        } else if (global_all_id.length > 1) {
            swal("Ooops!", "Tolong pilih 1 saja, tidak boleh lebih!", "warning");
        } else {
            global_id = global_all_id[0];
            save_method = "edit";
            $.ajax({
                url: "<?php echo base_url(); ?>master/pesdik/ajax_edit/" + global_all_id[0],
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $(".modal-title").html(data.nama);
                    $(".nama").html(data.nama);
                    $(".nisn").html(data.nisn);
                    $(".jenis_kelamin").html(data.jenis_kelamin);
                    $(".tanggal_lahir").html(sqlToDateIndo(data.tanggal_lahir));
                    $(".nama_ibu").html(data.nama_ibu);
                    $(".tingkat").html(data.tingkat);
                    $(".rombongan").html(data.rombongan);

                    $("#modal_see").modal("show");

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }
    });
</script>