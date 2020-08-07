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
            <h2 class="section-title">Halaman Penilaian</h2>
            <p class="section-lead">Halaman ini digunakan untuk memberi penilaian.</p>
            <div class="card">
                <div class="card-header">
                    <h4>Tabel data Penilaian</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                <button class="btn btn-md btn-info" id="btn-tambah"><i class="fa fa-plus"></i>
                                    Tambah</button>
                            </div>
                            <button class="btn btn-md btn-success" id="btn-kalkulasi"><i class="fa fa-plus"></i> Kalkulasi
                            </button>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            <button class="btn btn-sm btn-danger" title="hapus" id="btn-hapus"><i class="fa fa-trash"></i></button>
                        </div>
                        <div style="overflow: auto;" class="col-md-12">
                            <table class="table table-striped" id="ajax_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kriteria</th>
                                        <th>Bobot</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL -->
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
                                        <label class="form-label" for="pesdik">Nama Siswa</label>
                                        <input type="text" class="form-control" name="pesdik" id="pesdik" placeholder="...">
                                    </div>
                                    <div class="form-group col-md-6" id="kriteria"></div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_hasil">
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
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>No </th>
                            <th>Nama </th>
                            <th>Nilai </th>
                        </thead>
                        <tbody id="hasil">

                        </tbody>
                    </table>
                    <div id="kesimpulan"></div>
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

    $(document).ready(function() {
        table = $('#ajax_table').DataTable({
            "order": [],
            "searching": false,
            "lengthChange": false,
            "ajax": {
                "url": "<?php echo base_url('master/nilai/ajaxTable'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [1, 2],
                "orderable": true,
                "className": "text-center absensi-control",
            }, {
                "targets": [0, -1],
                "orderable": false,
                "className": "text-center",
            }, ],
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "processing": true,

            "scrollCollapse": true,
        }).on("click", "tr", function() {
            var row = table.row($(this));
            var data_row = row.data();
            id_row = data_row[4];
            if ($(this).children().hasClass("holding")) {
                $(this).children().removeClass("holding");
                if (global_all_id.includes(id_row)) {
                    var key = global_all_id.indexOf(id_row);
                    global_all_id.splice(key, 1);
                }
            } else {
                $(this).children().addClass("holding");
                global_all_id.push(data_row[4]);
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
        $.ajax({
            url: "<?php echo base_url(); ?>master/pesdik/ajax_get/" + global_all_id[0],
            type: "POST",
            dataType: "JSON",
            async: false,
            success: function(data) {
                var kriteria = '';
                for (let index = 0; index < data.kriteria.length; index++) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>master/pesdik/detail_kriteria/" + data.kriteria[index].id,
                        type: "POST",
                        dataType: "JSON",
                        async: false,
                        success: function(data_detail) {
                            kriteria += '<label class="form-label" for="detail_kriteria[' + data.kriteria[index].id + ']">C' + data.kriteria[index].id + '</label>';
                            kriteria += '<select class="form-control" name="detail_kriteria[' + data.kriteria[index].id + ']"  id="detail_kriteria[' + data.kriteria[index].id + ']">';
                            for (let i = 0; i < data_detail.length; i++) {
                                kriteria += '<option value=' + data_detail[i].id + '>' + data_detail[i].detail + '</option>';

                            }
                            kriteria += '</select>';
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error get data from ajax');
                        }
                    });
                }
                $('#kriteria').html(kriteria);
                $("#modal_form_kriteria").modal("show");

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
        $("#modal_form").modal("show");
        $(".modal-title").text("Tambah data Kriteria");
    });

    $("#btn-kalkulasi").click(function() {

        $.ajax({
            url: "<?php echo base_url(); ?>master/nilai/kalkulasi",
            type: "POST",
            dataType: "JSON",
            async: false,
            success: function(data) {
                //console.log(data);
                string = '';
                var thebest = [];
                no = 0;
                $.each(data, function(key, value) {
                    thebest.push(value);
                    no++;
                    string += '<tr>';
                    string += '<td>' + no + '</td>';
                    string += '<td>' + value["nama_pesdik"] + '</td>';
                    string += '<td>' + value["nilai"] + '</td>';
                    string += '</tr>';
                });
                console.log(thebest);


                var i = 0;
                var len = thebest.length;
                var seleksi = []; //10
                var hs = []; //

                for (; i < len;) {
                    if (seleksi[i] == 0) {
                        seleksi.push(thebest[i]["nilai"]);
                    } else if (seleksi[i - 1] == thebest[i]["nilai"]) {
                        hs.push(thebest[i]["nilai"]);
                    } else {
                        break;
                    }
                    i++;
                }
                console.log(hs);

                // console.log(thebest);
                // $('#hasil').html(string);
                // $("#modal_hasil").modal("show");
                // var i = 0;
                // var len = thebest.length;
                // var text = "";
                // var n = thebest[i]["nilai"];
                // console.log(n);
                // for (; i < len;) {
                //     if (thebest[i]["nilai"] == thebest[i + 1]["nilai"]) {
                //         text += thebest[i]["nilai"]+"<br>";
                //         $('#kesimpulan').html(text);
                //     } else {

                //     }
                //     i++;
                // }
                // console.log(thebest[0]["nilai"]);
                // var i = 0;
                // var text = [];
                // console.log(text);

                // document.getElementById("kesimpulan").innerHTML = text;
                // for (; i < thebest.length;) {

                //     if (thebest[i]["nilai"] == thebest[i + i]["nilai"]) {
                //         text.push(thebest[i]["nilai"]);
                //         text.push(thebest[i]["nama_pesdik"]);
                //     } else if (thebest[i]["nilai"] == thebest[i - 1]["nilai"]) {
                //         text.push(thebest[i]["nilai"]);
                //         text.push(thebest[i]["nama_pesdik"]);
                //     } else {
                //         break;
                //     }
                //     i++;
                // }
                // $('#kesimpulan').html("<h6><b>Kesimpulan : </b> Dari hasil perhitungan yang dilakukan menggunakan metode SAW, Peserta Didik yang layak diajukan untuk PIP adalah " + text + "</h6>");
                // console.log(text);
                //$('#kesimpulan').html("<h6><b>Kesimpulan : </b> Dari hasil perhitungan yang dilakukan menggunakan metode SAW, Peserta Didik yang layak diajukan untuk PIP adalah " + thebest[0]["nama_pesdik"] + " dengan nilai " + thebest[0]["nilai"] + "</h6>");
                // if (thebest.length == 0) {
                //     swal("Kalkulasi GAGAL!", "Masukkan data dulu, untuk kalkulasi", "warning");
                // } else {
                //     $('#kesimpulan').html("<h6><b>Kesimpulan : </b> Dari hasil perhitungan yang dilakukan menggunakan metode SAW, Peserta Didik yang layak diajukan untuk PIP adalah " + thebest[0]["nama_pesdik"] + " dengan nilai " + thebest[0]["nilai"] + "</h6>");
                //     $('#hasil').html(string);
                //     console.log(thebest);
                //     $("#modal_hasil").modal("show");
                // }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    });

    function clear_data() {
        $("#pesdik").select2("val", "");
    }

    $("#btn-simpan").click(function() {
        status = "true";
        element_data = document.getElementById('form_simpan');
        $('#btn-simpan').text('Menyimpan...'); //change button text
        $('#btn-simpan').attr('disabled', true); //set button enable 
        if (status == "true") {
            $.ajax({
                url: "<?= base_url() ?>master/nilai/ajax_save/",
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
                        url: "<?php echo base_url(); ?>master/nilai/ajax_delete",
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

    $('#pesdik').select2({
        placeholder: "Input peserta didik",
        allowClear: true,
        ajax: {
            url: '<?php echo base_url(); ?>master/nilai/select2_pesdik',
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
                url: '<?php echo base_url(); ?>master/nilai/select2_pesdik',
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
            return "<div>" + data.nama + "<div>";
        },
        formatSelection: function(data) {
            $('#pesdik').val(data.id);
            return data.nama;

        },
        escapeMarkup: function(m) {
            return m;
        } // we do not want to escape markup since we are displaying html in results
    }).on('select2-clearing', function() {
        $('.btn-simpan-detail').attr('disabled', false);
    });
</script>