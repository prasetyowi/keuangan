<?php include "layouts/header.php"; ?> <div class="main-content">
  <div class="main-content-inner">
    <div class="page-content">
      <div class="page-header">
        <h1>Laporan Mingguan</h1>
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
          <table id="simple-table" class="table  table-stripped table-hover">
            <thead>
              <tr>
                <th> Dec 11-17 </th>
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
                <td>11</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>12</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>13</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>14</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>15</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>16</td>
                <td>Rp. 0</td>
                <td>Rp. 0</td>
              </tr>
              <tr>
                <td>17</td>
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
<!-- /.main-content --> <?php include "layouts/footer.php"; ?>