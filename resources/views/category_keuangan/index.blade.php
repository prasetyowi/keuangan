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
              <button type="button" class="btn btn-sm btn-primary pull-right" id="btnadd" data-toggle="modal" data-target="#modal-kategori">
                <span class="menu-icon fa fa-plus"></span>
              </button>
            </h1>
          </div><!-- /.page-header -->
          <input type="hidden" id="num_rows" value="{{ $data['num_rows'] + 1 }}">
          <table id="table-Kategori" class="table table-stripped table-hover">
            <thead>
              <tr>
                <th class="text-center">Kategori</th>
                <th class="text-center">Limit</th>
                <th class="text-center">Tipe</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data['kategori'] as $value)
              <tr>
                <td class="text-center">{{ $value->szDesc }}</td>
                <td class="text-center">{{ $value->decLimit }}</td>
                <td class="text-center">{{ $value->szType }}</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-primary" onclick="EditKategori('{{ $value->szCategoryId }}')">
                    <span class="menu-icon fa fa-pencil"></span>
                  </button>
                  <button type="button" class="btn btn-sm btn-danger" onclick="DeleteKategori('{{ $value->szCategoryId }}')">
                    <span class="menu-icon fa fa-trash"></span>
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
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
      <div class="modal" id="modal-kategori">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kategori</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-sm-12">
                  <div class="form-group">
                    <label for="CategoryKeuangan-szDesc">Deskripsi</label>
                    <div>
                      <input type="hidden" id="action" value="">
                      <input type="hidden" id="CategoryKeuangan-szCategoryId" value="" />
                      <input type="text" id="CategoryKeuangan-szDesc" placeholder="Deskripsi" value="" style="width:100%" />
                      <div class="alert alert-danger d-none" role="alert" id="alert-szDesc" style="display: none;"></div>
                    </div>
                  </div>
                  <div class="space-2"></div>

                  <div class="form-group">
                    <label for="CategoryKeuangan-decLimit">Limit</label>
                    <div>
                      <input type="number" id="CategoryKeuangan-decLimit" placeholder="Limit" value="0" style="width:100%" />
                      <div class="alert alert-danger d-none" role="alert" id="alert-decLimit" style="display: none;"></div>
                    </div>
                  </div>
                  <div class="space-2"></div>

                  <div class="form-group">
                    <label for="form-field-select-3">Tipe</label>
                    <div>
                      <select class="form-control" id="CategoryKeuangan-szType" data-placeholder="Choose a State..." style="width:100%;">
                        <option value="">** Pilih Tipe **</option>
                        <option value="MASUK">Masuk</option>
                        <option value="KELUAR">Keluar</option>
                      </select>
                      <div class="alert alert-danger d-none" role="alert" id="alert-szType" style="display: none;"></div>
                    </div>
                  </div>
                  <div class="space-2"></div>
                </div>
              </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <span id="loadingkategori" style="display: none;"><i class="ace-icon fa fa-refresh fa-spin"></i> Loading</span>
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

  function GetAllCategory() {
    $.ajax({
      async: false,
      type: 'GET',
      url: "/CategoryKeuangan/GetAllCategory",
      dataType: "JSON",
      success: function(response) {
        $("#table-Kategori > tbody").empty('');

        $("#num_rows").val(response.num_rows + 1);

        $.each(response.kategori, function(i, v) {
          $("#table-Kategori > tbody").append(`
            <tr>
              <td class="text-center">${v.szDesc}</td>
              <td class="text-center">${Math.round(v.decLimit)}</td>
              <td class="text-center">${v.szType}</td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-primary" onclick="EditKategori('${v.szCategoryId}')">
                  <span class="menu-icon fa fa-pencil"></span>
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="DeleteKategori('${v.szCategoryId}')">
                  <span class="menu-icon fa fa-trash"></span>
                </button>
              </td>
            </tr>
          `);
        });
      }
    });

  }

  function EditKategori(id) {

    $("#modal-kategori").modal('show');
    $("#action").val("edit");
    $("#CategoryKeuangan-szCategoryId").val(id);

    $.ajax({
      async: false,
      type: 'GET',
      url: "/CategoryKeuangan/edit/" + id,
      dataType: "JSON",
      success: function(response) {
        $.each(response, function(i, v) {
          $("#CategoryKeuangan-szDesc").val(v.szDesc);
          $("#CategoryKeuangan-decLimit").val(Math.round(v.decLimit));

          $("#CategoryKeuangan-szType").html('');
          $("#CategoryKeuangan-szType").append(`<option value="MASUK" ${v.szType == 'MASUK' ? 'selected' : ''}>Masuk</option>`);
          $("#CategoryKeuangan-szType").append(`<option value="KELUAR" ${v.szType == 'KELUAR' ? 'selected' : ''}>Keluar</option>`);
        });
      }
    });
  }

  function DeleteKategori(id) {

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
          url: "/CategoryKeuangan/hapus/" + id,
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

              GetAllCategory();
            }
          }
        });
      }
    });
  }

  $("#btnadd").click(function() {
    $("#action").val("add");

    $("#CategoryKeuangan-szCategoryId").val('');
    $("#CategoryKeuangan-szDesc").val('');
    $("#CategoryKeuangan-decLimit").val('');

    $("#CategoryKeuangan-szType").html('');
    $("#CategoryKeuangan-szType").append(`<option value="MASUK">Masuk</option>`);
    $("#CategoryKeuangan-szType").append(`<option value="KELUAR">Keluar</option>`);
  });

  $("#btnsave").click(function() {
    var szCategoryid = "";
    var act = $("#action").val();

    $('#alert-szDesc').hide();
    $('#alert-decLimit').hide();
    $('#alert-szType').hide();

    if (act == "add") {


      if ($("#num_rows").val() >= 0 && $("#num_rows").val() < 10) {
        szCategoryid = "C000" + $("#num_rows").val();
      } else if ($("#num_rows").val() >= 10 && $("#num_rows").val() < 100) {
        szCategoryid = "C00" + $("#num_rows").val();
      } else if ($("#num_rows").val() >= 100 && $("#num_rows").val() < 1000) {
        szCategoryid = "C0" + $("#num_rows").val();
      } else if ($("#num_rows").val() >= 1000) {
        szCategoryid = "C" + $("#num_rows").val();
      }

      $("#loadingkategori").show();
      $("#btnsave").prop("disabled", true);

      $.ajax({
        async: false,
        type: 'POST',
        url: "/CategoryKeuangan/add",
        data: {
          "szCategoryid": szCategoryid,
          "szDesc": $("#CategoryKeuangan-szDesc").val(),
          "decLimit": $("#CategoryKeuangan-decLimit").val(),
          "szType": $("#CategoryKeuangan-szType").val(),
          "bActive": 1,
          "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: "JSON",
        success: function(response) {
          $("#loadingkategori").hide();
          $("#btnsave").prop("disabled", false);

          if (response.success === true) {
            Swal.fire({
              type: 'success',
              icon: 'success',
              title: `${response.message}`,
              showConfirmButton: false,
              timer: 3000
            });

            $("#modal-kategori").modal('hide');

            GetAllCategory();
          }

        },
        error: function(error) {

          $("#loadingkategori").hide();
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

    } else if (act == "edit") {

      $("#loadingkategori").show();
      $("#btnsave").prop("disabled", true);

      $.ajax({
        async: false,
        type: 'POST',
        url: "/CategoryKeuangan/update",
        data: {
          "szCategoryId": $("#CategoryKeuangan-szCategoryId").val(),
          "szDesc": $("#CategoryKeuangan-szDesc").val(),
          "decLimit": $("#CategoryKeuangan-decLimit").val(),
          "szType": $("#CategoryKeuangan-szType").val(),
          "bActive": 1,
          "_token": $("meta[name='csrf-token']").attr("content")
        },
        dataType: "JSON",
        success: function(response) {
          $("#loadingkategori").hide();
          $("#btnsave").prop("disabled", false);

          if (response.success === true) {
            Swal.fire({
              type: 'success',
              icon: 'success',
              title: `${response.message}`,
              showConfirmButton: false,
              timer: 3000
            });

            $("#modal-kategori").modal('hide');
            GetAllCategory();
          }

        },
        error: function(error) {

          $("#loadingkategori").hide();
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