<?php include "layouts/header.php"; ?> <div class="main-content">
  <div class="main-content-inner">
    <div class="page-content">
      <div class="page-header">
        <h1>Laporan Harian</h1>
      </div>
      <!-- /.page-header -->
      <div class="row">
        <div class="col-xs-12">
          <!-- PAGE CONTENT BEGINS -->
          <div class="invisible">
            <button data-target="#sidebar2" type="button" class="pull-left menu-toggler navbar-toggle">
              <span class="sr-only">Toggle sidebar</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button> <?php include "layouts/sidebar.php"; ?>
          </div>
          <button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#myModal">
            <span class="menu-icon fa fa-plus"></span>
          </button>
          <table id="simple-table" class="table table-stripped table-hover">
            <thead>
              <tr>
                <th colspan="2"> <?= date('d-m-Y'); ?> </th>
                <th>
                  <span class="text-primary">Rp. <span id="total_pendapatan_i">0</span>
                  </span>
                </th>
                <th>
                  <span class="text-danger">Rp. <span id="total_pengeluaran_i">0</span>
                  </span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Category</td>
                <td>Nama Kebutuhan</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>Category</td>
                <td>Nama Kebutuhan</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>Category</td>
                <td>Nama Kebutuhan</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>Category</td>
                <td>Nama Kebutuhan</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>Category</td>
                <td>Nama Kebutuhan</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>Category</td>
                <td>Nama Kebutuhan</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>Category</td>
                <td>Nama Kebutuhan</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
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
    </div>
    <!-- /.page-content -->
  </div>
</div>
<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Transaksi</h4>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-7">
            <div class="form-group">
              <label for="form-field-select-3">Tipe Transaksi</label>
              <div>
                <select class="form-control" data-placeholder="Choose a Country..." style="width:100%">
                  <option value="">** Pilih **</option>
                  <option value="0">Pengeluaran</option>
                  <option value="1">Pendapatan</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="form-field-select-3">Kategori</label>
              <div>
                <select data-placeholder="Choose a Country..." style="width:100%">
                  <option value="">** Pilih **</option>
                  <option value="AL">Alabama</option>
                  <option value="AK">Alaska</option>
                  <option value="AZ">Arizona</option>
                  <option value="AR">Arkansas</option>
                  <option value="CA">California</option>
                  <option value="CO">Colorado</option>
                  <option value="CT">Connecticut</option>
                  <option value="DE">Delaware</option>
                  <option value="FL">Florida</option>
                  <option value="GA">Georgia</option>
                  <option value="HI">Hawaii</option>
                  <option value="ID">Idaho</option>
                  <option value="IL">Illinois</option>
                  <option value="IN">Indiana</option>
                  <option value="IA">Iowa</option>
                  <option value="KS">Kansas</option>
                  <option value="KY">Kentucky</option>
                  <option value="LA">Louisiana</option>
                  <option value="ME">Maine</option>
                  <option value="MD">Maryland</option>
                  <option value="MA">Massachusetts</option>
                  <option value="MI">Michigan</option>
                  <option value="MN">Minnesota</option>
                  <option value="MS">Mississippi</option>
                  <option value="MO">Missouri</option>
                  <option value="MT">Montana</option>
                  <option value="NE">Nebraska</option>
                  <option value="NV">Nevada</option>
                  <option value="NH">New Hampshire</option>
                  <option value="NJ">New Jersey</option>
                  <option value="NM">New Mexico</option>
                  <option value="NY">New York</option>
                  <option value="NC">North Carolina</option>
                  <option value="ND">North Dakota</option>
                  <option value="OH">Ohio</option>
                  <option value="OK">Oklahoma</option>
                  <option value="OR">Oregon</option>
                  <option value="PA">Pennsylvania</option>
                  <option value="RI">Rhode Island</option>
                  <option value="SC">South Carolina</option>
                  <option value="SD">South Dakota</option>
                  <option value="TN">Tennessee</option>
                  <option value="TX">Texas</option>
                  <option value="UT">Utah</option>
                  <option value="VT">Vermont</option>
                  <option value="VA">Virginia</option>
                  <option value="WA">Washington</option>
                  <option value="WV">West Virginia</option>
                  <option value="WI">Wisconsin</option>
                  <option value="WY">Wyoming</option>
                </select>
              </div>
            </div>
            <div class="space-2"></div>
            <div class="form-group">
              <label for="form-field-username">Deskripsi</label>
              <div>
                <input type="text" id="form-field-username" placeholder="Username" value="alexdoe" style="width:100%" />
              </div>
            </div>
            <div class="space-2"></div>
            <div class="form-group">
              <label for="form-field-first">Jumlah</label>
              <div>
                <input type="text" id="form-field-first" placeholder="First Name" value="Alex" style="width:100%" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnsave">Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<!-- PAGE CONTENT ENDS -->
<script></script>
<!-- /.main-content --> <?php include "layouts/footer.php"; ?>