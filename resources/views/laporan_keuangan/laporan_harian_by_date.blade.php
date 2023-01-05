<!-- Menghubungkan dengan view template master -->
@extends('../layouts/layout')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Kategori Keuangan - Catatan Keuangan')

@section('konten')
<div class="main-content">
    <div class="main-content-inner">

        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="invisible">
                        <button data-target="#sidebar2" type="button" class="pull-left menu-toggler navbar-toggle">
                            <span class="sr-only">Toggle sidebar</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="page-header">
                        <h1>
                            Laporan Keuangan Harian
                            <button type="button" class="btn btn-sm btn-primary pull-right" id="btnadd" data-toggle="modal" data-target="#modal-catatan-keuangan">
                                <span class="menu-icon fa fa-plus"></span>
                            </button>
                        </h1>
                    </div><!-- /.page-header -->

                    <?php
                    $total_pendapatan = 0;
                    $total_pengeluaran = 0;
                    ?>

                    <input type="hidden" id="kode" value="{{ $data['kode'] }}">
                    <input type="hidden" id="num_rows" value="{{ $data['num_rows'] + 1 }}">
                    <input type="hidden" id="tgl_transaksi" value="{{ date('Y-m-d', strtotime($data['tgl'])) }}">

                    <table id="table-laporan-keuangan" class="table table-stripped table-hover">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-left">{{ date('d-m-Y', strtotime($data['tgl'])) }}</th>
                                <th class="text-right"><span class="text-primary">Pendapatan</span></th>
                                <th class="text-right"><span class="text-danger">Pengeluaran</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['laporan_harian'] as $value)
                            <?php
                            $total_pendapatan += round($value->decAmountMasuk);
                            $total_pengeluaran += round($value->decAmountKeluar);
                            ?>
                            <tr>
                                <td class="text-left"><a href="#" onclick="EditKeuangan('{{ $value->szTransId }}')">{{ $value->kategori_desc }}</a></td>
                                <td class="text-left"><a href="#" onclick="EditKeuangan('{{ $value->szTransId }}')">{{ $value->szDesc }}</a></td>
                                <td class="text-right"><a href="#" onclick="EditKeuangan('{{ $value->szTransId }}')">Rp. {{ round($value->decAmountMasuk) }}</a></td>
                                <td class="text-right"><a href="#" onclick="EditKeuangan('{{ $value->szTransId }}')">Rp. {{ round($value->decAmountKeluar) }}</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-warning">
                                <th class="text-left">Grand Total</th>
                                <th class="text-right">Rp. <span id="total_keuangan">{{$total_pendapatan - $total_pengeluaran}}</span></th>
                                <th class="text-right"><span class="text-primary">Rp. <span id="total_pendapatan">{{$total_pendapatan}}</span></span></th>
                                <th class="text-right"><span class="text-danger">Rp. <span id="total_pengeluaran">{{$total_pengeluaran}}</span></span></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="hidden-sm hidden-xs">
                        <button type="button" class="sidebar-collapse btn btn-white btn-primary" data-target="#sidebar">
                            <i id="sidebar4-toggle-icon" class="ace-icon fa fa-angle-double-up ace-save-state" data-icon1="ace-icon fa fa-angle-double-up" data-icon2="ace-icon fa fa-angle-double-down"></i> Collapse/Expand Menu </button>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="modal" id="modal-catatan-keuangan">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Catatan Keuangan</h4>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">

                                    <input type="hidden" id="action" value="add">
                                    <input type="hidden" id="LaporanKeuangan-szTransId" value="">
                                    <input type="hidden" id="LaporanKeuangan-decLimit" value="">
                                    <input type="hidden" id="LaporanKeuangan-decMax" value="">
                                    <input type="hidden" id="LaporanKeuangan-decTotalAmount" value="">

                                    <div class="form-group">
                                        <label for="form-field-select-3">Kategori Tipe</label>
                                        <div>
                                            <select class="form-control" id="LaporanKeuangan-szCategoryType" data-placeholder="Choose a State..." style="width:100%;" onchange="Get_category_keuangan_by_type(this.value,'add')">
                                                <option value="">** Pilih Tipe **</option>
                                                @foreach($data['kategori_tipe'] as $value)
                                                <option value="{{ $value->szType }}">{{ $value->szType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="form-field-select-3">Kategori</label>
                                        <div>
                                            <select class="form-control" id="LaporanKeuangan-szCategoryId" data-placeholder="Choose a State..." style="width:100%;" onchange="GetLimitByCategory(this.value,'add')">
                                                <option value="">** Pilih Tipe **</option>
                                                @foreach($data['kategori'] as $value)
                                                <option value="{{ $value->szCategoryId }}">{{ $value->szDesc }}</option>
                                                @endforeach
                                            </select>
                                            <div class="alert alert-danger d-none" role="alert" id="alert-szCategoryId" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="LaporanKeuangan-szDesc">Deskripsi</label>
                                        <div>
                                            <input type="text" id="LaporanKeuangan-szDesc" placeholder="Deskripsi" value="" style="width:100%" />
                                            <div class="alert alert-danger d-none" role="alert" id="alert-szDesc" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="LaporanKeuangan-decLimit">Tanggal Transaksi</label>
                                        <div>
                                            <input class="form-control date-picker" id="LaporanKeuangan-dtmTrans" type="text" data-date-format="yyyy-mm-dd" style="width:100%" value="<?= date('Y-m-d') ?>" />
                                            <div class="alert alert-danger d-none" role="alert" id="alert-dtmTrans" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="LaporanKeuangan-decAmount">Jumlah</label>
                                        <div>
                                            <input type="text" id="LaporanKeuangan-decAmount" placeholder="Rp." value="0" style="width:100%" />
                                            <div class="alert alert-danger d-none" role="alert" id="alert-decAmount" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <span id="loadingkeuangan" style="display: none;"><i class="ace-icon fa fa-refresh fa-spin"></i> Loading</span>
                            <button type="button" class="btn btn-success" id="btnsave">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modal-catatan-keuangan-edit">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Catatan Keuangan</h4>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">

                                    <input type="hidden" id="action" value="edit">
                                    <input type="hidden" id="LaporanKeuangan-szTransId_edit" value="">
                                    <input type="hidden" id="LaporanKeuangan-decLimit_edit" value="">
                                    <input type="hidden" id="LaporanKeuangan-decMax_edit" value="">
                                    <input type="hidden" id="LaporanKeuangan-decTotalAmount_edit" value="">

                                    <div class="form-group">
                                        <label for="form-field-select-3">Kategori Tipe</label>
                                        <div>
                                            <select class="form-control" id="LaporanKeuangan-szCategoryType_edit" data-placeholder="Choose a State..." style="width:100%;" onchange="Get_category_keuangan_by_type(this.value,'edit')">
                                                <option value="">** Pilih Tipe **</option>
                                                @foreach($data['kategori_tipe'] as $value)
                                                <option value="{{ $value->szType }}">{{ $value->szType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="form-field-select-3">Kategori</label>
                                        <div>
                                            <select class="form-control" id="LaporanKeuangan-szCategoryId_edit" data-placeholder="Choose a State..." style="width:100%;" onchange="GetLimitByCategory(this.value,'edit')">
                                                <option value="">** Pilih Tipe **</option>
                                                @foreach($data['kategori'] as $value)
                                                <option value="{{ $value->szCategoryId }}">{{ $value->szDesc }}</option>
                                                @endforeach
                                            </select>
                                            <div class="alert alert-danger d-none" role="alert" id="alert-szCategoryId_edit" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="LaporanKeuangan-szDesc">Deskripsi</label>
                                        <div>
                                            <input type="text" id="LaporanKeuangan-szDesc_edit" placeholder="Deskripsi" value="" style="width:100%" />
                                            <div class="alert alert-danger d-none" role="alert" id="alert-szDesc_edit" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="LaporanKeuangan-decLimit">Tanggal Transaksi</label>
                                        <div>
                                            <input class="form-control date-picker" id="LaporanKeuangan-dtmTrans_edit" type="text" data-date-format="yyyy-mm-dd" style="width:100%" value="<?= date('Y-m-d') ?>" />
                                            <div class="alert alert-danger d-none" role="alert" id="alert-dtmTrans_edit" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                    <div class="form-group">
                                        <label for="LaporanKeuangan-decAmount">Jumlah</label>
                                        <div>
                                            <input type="text" id="LaporanKeuangan-decAmount_edit" placeholder="Rp." value="0" style="width:100%" />
                                            <div class="alert alert-danger d-none" role="alert" id="alert-decAmount_edit" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <div class="space-2"></div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <span id="loadingkeuangan" style="display: none;"><i class="ace-icon fa fa-refresh fa-spin"></i> Loading</span>
                            <button type="button" class="btn btn-success" id="btnupdate">Simpan</button>
                            <button type="button" class="btn btn-danger" id="btndelete">Hapus</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
@endsection

@section('script_function')
<script>
    var no = 0;

    function GetAllLaporanByDate() {
        var total_pendapatan = 0;
        var total_pengeluaran = 0;
        var tgl_transaksi = $("#tgl_transaksi").val();

        $("#total_keuangan").html('');
        $("#total_pendapatan").html('');
        $("#total_pengeluaran").html('');

        $.ajax({
            async: false,
            type: 'GET',
            url: "/LaporanKeuangan/GetAllLaporanByDate/" + tgl_transaksi,
            dataType: "JSON",
            success: function(response) {
                $("#table-laporan-keuangan > tbody").empty('');

                $("#num_rows").val(response.num_rows + 1);

                $.each(response.laporan_harian, function(i, v) {
                    $("#table-laporan-keuangan > tbody").append(`
            <tr>
              <td class="text-left"><a href="#" onclick="EditKeuangan('${v.szTransId}')">${v.kategori_desc}</a></td>
              <td class="text-left"><a href="#" onclick="EditKeuangan('${v.szTransId}')">${v.szDesc}</a></td>
              <td class="text-right"><a href="#" onclick="EditKeuangan('${v.szTransId}')">Rp. ${Math.round(v.decAmountMasuk)}</a></td>
              <td class="text-right"><a href="#" onclick="EditKeuangan('${v.szTransId}')">Rp. ${Math.round(v.decAmountKeluar)}</a></td>
            </tr>
          `);

                    total_pendapatan += Math.round(v.decAmountMasuk);
                    total_pengeluaran += Math.round(v.decAmountKeluar);

                });

                $("#total_keuangan").append(total_pendapatan - total_pengeluaran);
                $("#total_pendapatan").append(total_pendapatan);
                $("#total_pengeluaran").append(total_pengeluaran);
            }
        });

    }

    function EditKeuangan(id) {

        $("#modal-catatan-keuangan-edit").modal('show');

        $.ajax({
            async: false,
            type: 'GET',
            url: "/LaporanKeuangan/edit/" + id,
            dataType: "JSON",
            success: function(response) {
                $.each(response, function(i, v) {
                    $("#LaporanKeuangan-szTransId_edit").val(v.szTransId);
                    $("#LaporanKeuangan-szDesc_edit").val(v.szDesc);
                    $("#LaporanKeuangan-dtmTrans_edit").val(v.dtmTrans);
                    $("#LaporanKeuangan-decAmount_edit").val(v.decAmount);
                    $("#LaporanKeuangan-decLimit_edit").val(v.decLimit);
                    $("#LaporanKeuangan-decTotalAmount_edit").val(v.total_amount);

                    $("#LaporanKeuangan-szCategoryId_edit").html('');
                    $("#LaporanKeuangan-szCategoryId_edit").append(`<option value="">** Pilih Tipe **</option>`);
                    <?php foreach ($data['kategori'] as $value) : ?>
                        $("#LaporanKeuangan-szCategoryId_edit").append(`<option value="<?= $value->szCategoryId ?>" ${v.szCategoryId == '<?= $value->szCategoryId ?>' ? 'selected' : ''}><?= $value->szDesc ?></option>`);
                    <?php endforeach; ?>

                    $("#LaporanKeuangan-szCategoryType_edit").html('');
                    $("#LaporanKeuangan-szCategoryType_edit").append(`<option value="">** Pilih Tipe **</option>`);
                    <?php foreach ($data['kategori_tipe'] as $value) : ?>
                        $("#LaporanKeuangan-szCategoryType_edit").append(`<option value="<?= $value->szType ?>" ${v.category_type == '<?= $value->szType ?>' ? 'selected' : ''}><?= $value->szType ?></option>`);
                    <?php endforeach; ?>

                });
            }
        });
    }

    function DeleteKeuangan(id) {

        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Pastikan data yang ingin dihapus benar!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Simpan",
            cancelButtonText: "Tidak, Tutup"
        }).then((result) => {
            if (result.value == true) {
                //ajax save data
                $.ajax({
                    async: false,
                    type: 'GET',
                    url: "/LaporanKeuangan/hapus/" + id,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success === true) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            GetAllLaporanByDate();
                        }
                    }
                });
            }
        });
    }

    function GetLimitByCategory(szCategoryId, act) {
        if (act == "add") {
            $.ajax({
                async: false,
                type: 'GET',
                url: "/LaporanKeuangan/get_limit_by_category/" + szCategoryId,
                dataType: "JSON",
                success: function(response) {
                    $("#LaporanKeuangan-decLimit").val(response.limit);
                    $("#LaporanKeuangan-decTotalAmount").val(response.total_amount);
                }
            });

        } else if (act == "edit") {
            $.ajax({
                async: false,
                type: 'GET',
                url: "/LaporanKeuangan/get_limit_by_category/" + szCategoryId,
                dataType: "JSON",
                success: function(response) {
                    $("#LaporanKeuangan-decLimit_edit").val(response.limit);
                    $("#LaporanKeuangan-decTotalAmount_edit").val(response.total_amount);
                }
            });

        }

    }

    function Get_category_keuangan_by_type(type, act) {
        if (act == "add") {
            $.ajax({
                async: false,
                type: 'GET',
                url: "/LaporanKeuangan/Get_category_keuangan_by_type",
                data: {
                    type: type
                },
                dataType: "JSON",
                success: function(response) {
                    $("#LaporanKeuangan-szCategoryId").html('');

                    $("#LaporanKeuangan-szCategoryId").append(`<option value="">** Pilih Tipe **</option>`);
                    if (response != "") {
                        $.each(response, function(i, v) {
                            $("#LaporanKeuangan-szCategoryId").append(`<option value="${v.szCategoryId}">${v.szDesc}</option>`);
                        });
                    }
                }
            });

        } else if (act == "edit") {
            $.ajax({
                async: false,
                type: 'GET',
                url: "/LaporanKeuangan/Get_category_keuangan_by_type",
                data: {
                    type: type
                },
                dataType: "JSON",
                success: function(response) {
                    $("#LaporanKeuangan-szCategoryId_edit").html('');

                    $("#LaporanKeuangan-szCategoryId_edit").append(`<option value="">** Pilih Tipe **</option>`);
                    if (response != "") {
                        $.each(response, function(i, v) {
                            $("#LaporanKeuangan-szCategoryId_edit").append(`<option value="${v.szCategoryId}">${v.szDesc}</option>`);
                        });
                    }
                }
            });

        }

    }

    $("#btnadd").click(function() {
        $("#action").val("add");

        $("#LaporanKeuangan-szCategoryId").val('');
        $("#LaporanKeuangan-szDesc").val('');
        $("#LaporanKeuangan-decLimit").val('');
        $("#LaporanKeuangan-decTotalAmount").val('');
    });

    $("#btnsave").click(function() {
        var szTransId = "";
        var act = $("#action").val();
        var amount = parseInt($("#LaporanKeuangan-decAmount").val());
        var total_amount = parseInt($("#LaporanKeuangan-decTotalAmount").val()) + amount;
        var limit = parseInt($("#LaporanKeuangan-decLimit").val());

        // $('#alert-szCategoryId').hide();
        // $('#alert-szDesc').hide();
        // $('#alert-dtmTrans').hide();
        // $('#alert-decAmount').hide();

        if (act == "add") {

            if ($("#num_rows").val() >= 0 && $("#num_rows").val() < 10) {
                szTransId = $("#kode").val() + "000" + $("#num_rows").val();
            } else if ($("#num_rows").val() >= 10 && $("#num_rows").val() < 100) {
                szTransId = $("#kode").val() + "00" + $("#num_rows").val();
            } else if ($("#num_rows").val() >= 100 && $("#num_rows").val() < 1000) {
                szTransId = $("#kode").val() + "0" + $("#num_rows").val();
            } else if ($("#num_rows").val() >= 1000) {
                szTransId = $("#kode").val() + $("#num_rows").val();
            }

            if ($("#LaporanKeuangan-szCategoryType").val() == "KELUAR") {

                if (total_amount <= limit) {

                    $("#loadingkeuangan").show();
                    $("#btnsave").prop("disabled", true);

                    $.ajax({
                        async: false,
                        type: 'POST',
                        url: "/LaporanKeuangan/add",
                        data: {
                            szTransId: szTransId,
                            szCategoryId: $("#LaporanKeuangan-szCategoryId").val(),
                            szDesc: $("#LaporanKeuangan-szDesc").val(),
                            dtmTrans: $("#LaporanKeuangan-dtmTrans").val(),
                            decAmount: $("#LaporanKeuangan-decAmount").val(),
                            "_token": $("meta[name='csrf-token']").attr("content")
                        },
                        dataType: "JSON",
                        success: function(response) {
                            $("#loadingkeuangan").hide();
                            $("#btnsave").prop("disabled", false);

                            if (response.success === true) {
                                Swal.fire({
                                    type: 'success',
                                    icon: 'success',
                                    title: `${response.message}`,
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                $("#modal-catatan-keuangan").modal('hide');

                                GetAllLaporanByDate();
                            }

                        },
                        error: function(error) {

                            $("#loadingkeuangan").hide();
                            $("#btnsave").prop("disabled", false);

                            if (error.responseJSON.szDesc) {

                                //show alert
                                $('#alert-szDesc').show();
                                $('#alert-szDesc').removeClass('d-none');
                                $('#alert-szDesc').addClass('d-block');

                                //add message to alert
                                $('#alert-szDesc').html(error.responseJSON.szDesc[0]);
                            }

                            if (error.responseJSON.decLimit) {

                                //show alert
                                $('#alert-decLimit').show();
                                $('#alert-decLimit').removeClass('d-none');
                                $('#alert-decLimit').addClass('d-block');

                                //add message to alert
                                $('#alert-decLimit').html(error.responseJSON.decLimit[0]);
                            }

                            if (error.responseJSON.szType) {

                                //show alert
                                $('#alert-szType').show();
                                $('#alert-szType').removeClass('d-none');
                                $('#alert-szType').addClass('d-block');

                                //add message to alert
                                $('#alert-szType').html(error.responseJSON.szType[0]);
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Melebihi nilai limit'
                    });
                }

            } else {

                $("#loadingkeuangan").show();
                $("#btnsave").prop("disabled", true);

                $.ajax({
                    async: false,
                    type: 'POST',
                    url: "/LaporanKeuangan/add",
                    data: {
                        szTransId: szTransId,
                        szCategoryId: $("#LaporanKeuangan-szCategoryId").val(),
                        szDesc: $("#LaporanKeuangan-szDesc").val(),
                        dtmTrans: $("#LaporanKeuangan-dtmTrans").val(),
                        decAmount: $("#LaporanKeuangan-decAmount").val(),
                        "_token": $("meta[name='csrf-token']").attr("content")
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $("#loadingkeuangan").hide();
                        $("#btnsave").prop("disabled", false);

                        if (response.success === true) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            $("#modal-catatan-keuangan").modal('hide');

                            GetAllLaporanByDate();
                        }

                    },
                    error: function(error) {

                        $("#loadingkeuangan").hide();
                        $("#btnsave").prop("disabled", false);

                        if (error.responseJSON.szDesc) {

                            //show alert
                            $('#alert-szDesc').show();
                            $('#alert-szDesc').removeClass('d-none');
                            $('#alert-szDesc').addClass('d-block');

                            //add message to alert
                            $('#alert-szDesc').html(error.responseJSON.szDesc[0]);
                        }

                        if (error.responseJSON.decLimit) {

                            //show alert
                            $('#alert-decLimit').show();
                            $('#alert-decLimit').removeClass('d-none');
                            $('#alert-decLimit').addClass('d-block');

                            //add message to alert
                            $('#alert-decLimit').html(error.responseJSON.decLimit[0]);
                        }

                        if (error.responseJSON.szType) {

                            //show alert
                            $('#alert-szType').show();
                            $('#alert-szType').removeClass('d-none');
                            $('#alert-szType').addClass('d-block');

                            //add message to alert
                            $('#alert-szType').html(error.responseJSON.szType[0]);
                        }
                    }
                });

            }

        } else if (act == "edit") {

            $("#loadingkeuangan").show();
            $("#btnsave").prop("disabled", true);

            $.ajax({
                async: false,
                type: 'POST',
                url: "/LaporanKeuangan/update",
                data: {
                    szTransId: $("#LaporanKeuangan-szTransId").val(),
                    szCategoryId: $("#LaporanKeuangan-szCategoryId").val(),
                    szDesc: $("#LaporanKeuangan-szDesc").val(),
                    dtmTrans: $("#LaporanKeuangan-dtmTrans").val(),
                    decAmount: $("#LaporanKeuangan-decAmount").val(),
                    "_token": $("meta[name='csrf-token']").attr("content")
                },
                dataType: "JSON",
                success: function(response) {
                    $("#loadingkeuangan").hide();
                    $("#btnsave").prop("disabled", false);

                    if (response.success === true) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        $("#modal-catatan-keuangan").modal('hide');
                        GetAllLaporanByDate();
                    }

                },
                error: function(error) {

                    $("#loadingkeuangan").hide();
                    $("#btnsave").prop("disabled", false);

                    if (error.responseJSON.szDesc) {

                        //show alert
                        $('#alert-szDesc').show();
                        $('#alert-szDesc').removeClass('d-none');
                        $('#alert-szDesc').addClass('d-block');

                        //add message to alert
                        $('#alert-szDesc').html(error.responseJSON.szDesc[0]);
                    }

                    if (error.responseJSON.decLimit) {

                        //show alert
                        $('#alert-decLimit').show();
                        $('#alert-decLimit').removeClass('d-none');
                        $('#alert-decLimit').addClass('d-block');

                        //add message to alert
                        $('#alert-decLimit').html(error.responseJSON.decLimit[0]);
                    }

                    if (error.responseJSON.szType) {

                        //show alert
                        $('#alert-szType').show();
                        $('#alert-szType').removeClass('d-none');
                        $('#alert-szType').addClass('d-block');

                        //add message to alert
                        $('#alert-szType').html(error.responseJSON.szType[0]);
                    }
                }
            });
        }

    });

    $("#btnupdate").click(function() {
        var szTransId = "";
        var act = $("#action").val();
        var amount = parseInt($("#LaporanKeuangan-decAmount_edit").val());
        var total_amount = parseInt($("#LaporanKeuangan-decTotalAmount_edit").val()) + amount;
        var limit = parseInt($("#LaporanKeuangan-decLimit_edit").val());

        if ($("#LaporanKeuangan-szCategoryType_edit").val() == "KELUAR") {

            if (total_amount <= limit) {

                $("#loadingkeuanganupdate").show();
                $("#btnupdate").prop("disabled", true);

                $.ajax({
                    async: false,
                    type: 'POST',
                    url: "/LaporanKeuangan/update",
                    data: {
                        szTransId: $("#LaporanKeuangan-szTransId_edit").val(),
                        szCategoryId: $("#LaporanKeuangan-szCategoryId_edit").val(),
                        szDesc: $("#LaporanKeuangan-szDesc_edit").val(),
                        dtmTrans: $("#LaporanKeuangan-dtmTrans_edit").val(),
                        decAmount: $("#LaporanKeuangan-decAmount_edit").val(),
                        "_token": $("meta[name='csrf-token']").attr("content")
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $("#loadingkeuanganupdate").hide();
                        $("#btnupdate").prop("disabled", false);

                        if (response.success === true) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            $("#modal-catatan-keuangan-edit").modal('hide');

                            GetAllLaporanByDate();
                        }

                    },
                    error: function(error) {

                        $("#loadingkeuanganupdate").hide();
                        $("#btnupdate").prop("disabled", false);

                        if (error.responseJSON.szDesc) {

                            //show alert
                            $('#alert-szDesc_edit').show();
                            $('#alert-szDesc_edit').removeClass('d-none');
                            $('#alert-szDesc_edit').addClass('d-block');

                            //update message to alert
                            $('#alert-szDesc_edit').html(error.responseJSON.szDesc[0]);
                        }

                        if (error.responseJSON.decLimit) {

                            //show alert
                            $('#alert-decLimit_edit').show();
                            $('#alert-decLimit_edit').removeClass('d-none');
                            $('#alert-decLimit_edit').addClass('d-block');

                            //update message to alert
                            $('#alert-decLimit_edit').html(error.responseJSON.decLimit[0]);
                        }

                        if (error.responseJSON.szType) {

                            //show alert
                            $('#alert-szType_edit').show();
                            $('#alert-szType_edit').removeClass('d-none');
                            $('#alert-szType_edit').addClass('d-block');

                            //update message to alert
                            $('#alert-szType_edit').html(error.responseJSON.szType[0]);
                        }
                    }
                });
            } else {
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Melebihi nilai limit'
                });
            }

        } else {

            $("#loadingkeuanganupdate").show();
            $("#btnupdate").prop("disabled", true);

            $.ajax({
                async: false,
                type: 'POST',
                url: "/LaporanKeuangan/update",
                data: {
                    szTransId: szTransId,
                    szCategoryId: $("#LaporanKeuangan-szCategoryId_edit").val(),
                    szDesc: $("#LaporanKeuangan-szDesc_edit").val(),
                    dtmTrans: $("#LaporanKeuangan-dtmTrans_edit").val(),
                    decAmount: $("#LaporanKeuangan-decAmount_edit").val(),
                    "_token": $("meta[name='csrf-token']").attr("content")
                },
                dataType: "JSON",
                success: function(response) {
                    $("#loadingkeuanganupdate").hide();
                    $("#btnupdate").prop("disabled", false);

                    if (response.success === true) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        $("#modal-catatan-keuangan-edit").modal('hide');

                        GetAllLaporanByDate();
                    }

                },
                error: function(error) {

                    $("#loadingkeuanganupdate").hide();
                    $("#btnupdate").prop("disabled", false);

                    if (error.responseJSON.szDesc) {

                        //show alert
                        $('#alert-szDesc_edit').show();
                        $('#alert-szDesc_edit').removeClass('d-none');
                        $('#alert-szDesc_edit').addClass('d-block');

                        //update message to alert
                        $('#alert-szDesc_edit').html(error.responseJSON.szDesc[0]);
                    }

                    if (error.responseJSON.decLimit) {

                        //show alert
                        $('#alert-decLimit_edit').show();
                        $('#alert-decLimit_edit').removeClass('d-none');
                        $('#alert-decLimit_edit').addClass('d-block');

                        //update message to alert
                        $('#alert-decLimit_edit').html(error.responseJSON.decLimit[0]);
                    }

                    if (error.responseJSON.szType) {

                        //show alert
                        $('#alert-szType_edit').show();
                        $('#alert-szType_edit').removeClass('d-none');
                        $('#alert-szType_edit').addClass('d-block');

                        //update message to alert
                        $('#alert-szType_edit').html(error.responseJSON.szType[0]);
                    }
                }
            });

        }

    });

    $("#btndelete").click(function() {
        $("#loadingkeuanganupdate").show();
        $("#btndelete").prop("disabled", true);

        $.ajax({
            async: false,
            type: 'GET',
            url: "/LaporanKeuangan/hapus/" + $("#LaporanKeuangan-szTransId_edit").val(),
            dataType: "JSON",
            success: function(response) {
                $("#loadingkeuanganupdate").hide();
                $("#btndelete").prop("disabled", false);

                if (response.success === true) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    $("#modal-catatan-keuangan-edit").modal('hide');

                    GetAllLaporanByDate();
                }

            },
            error: function(error) {

                $("#loadingkeuanganupdate").hide();
                $("#btnupdate").prop("disabled", false);

            }
        });

    });
</script>
@endsection