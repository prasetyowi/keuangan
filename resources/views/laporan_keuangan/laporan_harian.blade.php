<!-- Menghubungkan dengan view template master -->
@extends('../layouts/layout')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Kategori Keuangan - Catatan Keuangan')

@section('konten')
<div class="main-content">
  <div class="main-content-inner">
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
      <ul class="breadcrumb">
        <li>
          <i class="ace-icon fa fa-home home-icon"></i>
          <a href="#">Home</a>
        </li>
        <li class="active">Kategori Keuangan</li>
      </ul><!-- /.breadcrumb -->

      <div class="nav-search" id="nav-search">
        <form class="form-search">
          <span class="input-icon">
            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
            <i class="ace-icon fa fa-search nav-search-icon"></i>
          </span>
        </form>
      </div><!-- /.nav-search -->
    </div>

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
              Kategori Keuangan
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
          <table id="table-laporan-keuangan" class="table table-stripped table-hover">
            <thead>
              <tr>
                <th colspan="2" class="text-left"><?= date('d-m-Y'); ?></th>
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
                <td class="text-left">{{ $value->kategori_desc }}</td>
                <td class="text-left">{{ $value->szDesc }}</td>
                <td class="text-right">Rp. {{ round($value->decAmountMasuk) }}</td>
                <td class="text-right">Rp. {{ round($value->decAmountKeluar) }}</td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr class="bg-warning">
                <th class="text-left" colspan="2">Grand Total</th>
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

                  <input type="hidden" id="action" value="">
                  <input type="hidden" id="LaporanKeuangan-szTransId" value="">
                  <input type="hidden" id="LaporanKeuangan-decLimit" value="">
                  <input type="hidden" id="LaporanKeuangan-decMax" value="">
                  <input type="hidden" id="LaporanKeuangan-decTotalAmount" value="">

                  <div class="form-group">
                    <label for="form-field-select-3">Kategori</label>
                    <div>
                      <select class="form-control" id="LaporanKeuangan-szCategoryId" data-placeholder="Choose a State..." style="width:100%;" onchange="GetLimitByCategory(this.value)">
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
    </div><!-- /.page-content -->
  </div>
</div><!-- /.main-content -->
@endsection

@section('script_function')
<script>
  var no = 0;

  function GetAllLaporan() {
    var total_pendapatan = 0;
    var total_pengeluaran = 0;

    $("#total_pendapatan").html('');
    $("#total_pengeluaran").html('');

    $.ajax({
      async: false,
      type: 'GET',
      url: "/LaporanKeuangan/GetAllLaporan",
      dataType: "JSON",
      success: function(response) {
        $("#table-laporan-keuangan > tbody").empty('');

        $("#num_rows").val(response.num_rows + 1);

        $.each(response.laporan_harian, function(i, v) {
          $("#table-laporan-keuangan > tbody").append(`
            <tr>
              <td class="text-left">${v.kategori_desc}</td>
              <td class="text-left">${v.szDesc}</td>
              <td class="text-right">${Math.round(v.decAmountMasuk)}</td>
              <td class="text-right">${Math.round(v.decAmountKeluar)}</td>
            </tr>
          `);

          total_pendapatan += Math.round(v.decAmountMasuk);
          total_pengeluaran += Math.round(v.decAmountKeluar);

        });

        $("#total_pendapatan").append(total_pendapatan);
        $("#total_pengeluaran").append(total_pengeluaran);
      }
    });

  }

  function EditKeuangan(id) {

    $("#modal-catatan-keuangan").modal('show');
    $("#action").val("edit");
    $("#LaporanKeuangan-szCategoryId").val(id);

    $.ajax({
      async: false,
      type: 'GET',
      url: "/LaporanKeuangan/edit/" + id,
      dataType: "JSON",
      success: function(response) {
        $.each(response, function(i, v) {
          $("#LaporanKeuangan-szDesc").val(v.szDesc);
          $("#LaporanKeuangan-decLimit").val(Math.round(v.decLimit));

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

              GetAllLaporan();
            }
          }
        });
      }
    });
  }

  function GetLimitByCategory(szCategoryId) {
    $.ajax({
      async: false,
      type: 'GET',
      url: "/LaporanKeuangan/get_limit_by_category/" + szCategoryId,
      dataType: "JSON",
      success: function(response) {
        $("#LaporanKeuangan-decLimit").val(response.limit);
        $("#LaporanKeuangan-total_amount").val(response.total_amount);
      }
    });

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
    var amount = $("#LaporanKeuangan-decAmount").val();
    var total_amount = $("#LaporanKeuangan-total_amount").val();
    var limit = $("#LaporanKeuangan-decLimit").val();

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

      if (total_amount + amount <= limit) {

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

              GetAllLaporan();
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
            GetAllLaporan();
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
</script>
@endsection