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
              Laporan Keuangan Mingguan
            </h1>
          </div><!-- /.page-header -->

          <?php
          $total_pendapatan = 0;
          $total_pengeluaran = 0;

          $monday = strtotime('last monday', strtotime('tomorrow'));
          $sunday = strtotime('+6 days', $monday);
          ?>
          <table id="simple-table" class="table  table-stripped table-hover">
            <thead>
              <tr>
                <th class="text-left"> <?= date('M') . " " . date('d', $monday) . " - " . date('d', $sunday) . " " . date('Y') ?> </th>
                <th class="text-right">
                  <span class="text-primary text-right">Pendapatan</span>
                  </span>
                </th>
                <th class="text-right">
                  <span class="text-danger">Pengeluaran</span>
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($data['laporan_mingguan'] as $value)
              <?php
              $total_pendapatan += round($value->decAmountMasuk);
              $total_pengeluaran += round($value->decAmountKeluar);
              ?>
              <tr>
                <td class="text-left">
                  <a href="/LaporanKeuangan/LaporanHarianByDate/<?= date('Y-m-d', strtotime($value->dtmTrans)) ?>"> {{ $value->dtmTrans }}</a>
                </td>
                <td class="text-right"><a href="/LaporanKeuangan/LaporanHarianByDate/<?= date('Y-m-d', strtotime($value->dtmTrans)) ?>">Rp. {{ round($value->decAmountMasuk) }}</a></td>
                <td class="text-right"><a href="/LaporanKeuangan/LaporanHarianByDate/<?= date('Y-m-d', strtotime($value->dtmTrans)) ?>">Rp. {{ round($value->decAmountKeluar) }}</a></td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr class="bg-warning">
                <th class="text-left">Grand Total</th>
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
    </div><!-- /.page-content -->
  </div>
</div><!-- /.main-content -->
@endsection

@section('script_function')

@endsection