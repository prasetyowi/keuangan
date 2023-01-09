<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        $data['kategori_tipe'] = DB::table('category_keuangan')->select('szType')->where('bActive', 1)->groupBy('szType')->get();
        $data['kategori'] = DB::table('category_keuangan')->where('bActive', 1)->get();
        $data['num_rows'] = DB::table('transaksi_keuangan')->count();
        $data['kode'] = date('Ymd');

        $data['laporan_harian'] = DB::select("SELECT
                                        laporan.szTransId,
                                        laporan.szCategoryId,
                                        kategori.szDesc AS kategori_desc,
                                        laporan.szDesc,
                                        DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') AS dtmTrans,
                                        (CASE
                                            WHEN kategori.szType = 'MASUK' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountMasuk,
                                        (CASE
                                            WHEN kategori.szType = 'KELUAR' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountKeluar
                                        FROM transaksi_keuangan laporan
                                        LEFT JOIN category_keuangan kategori
                                        ON kategori.szCategoryId = laporan.szCategoryId
                                        WHERE DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') = '" . date('Y-m-d') . "'
                                        AND laporan.is_delete = 0
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

        //return view with data
        return view('laporan_keuangan/laporan_harian', compact('data'));
    }

    public function GetAllLaporan()
    {
        //get all posts from Models
        $data['laporan_harian'] = DB::select("SELECT
                                        laporan.szTransId,
                                        laporan.szCategoryId,
                                        kategori.szDesc AS kategori_desc,
                                        laporan.szDesc,
                                        DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') AS dtmTrans,
                                        (CASE
                                            WHEN kategori.szType = 'MASUK' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountMasuk,
                                        (CASE
                                            WHEN kategori.szType = 'KELUAR' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountKeluar
                                        FROM transaksi_keuangan laporan
                                        LEFT JOIN category_keuangan kategori
                                        ON kategori.szCategoryId = laporan.szCategoryId
                                        WHERE DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') = '" . date('Y-m-d') . "'
                                        AND laporan.is_delete = 0
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

        $data['num_rows'] = DB::table('transaksi_keuangan')->count();

        //return view with data
        return $data;
    }

    public function GetAllLaporanByDate($tgl)
    {
        //get all posts from Models
        $data['laporan_harian'] = DB::select("SELECT
                                        laporan.szTransId,
                                        laporan.szCategoryId,
                                        kategori.szDesc AS kategori_desc,
                                        laporan.szDesc,
                                        DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') AS dtmTrans,
                                        (CASE
                                            WHEN kategori.szType = 'MASUK' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountMasuk,
                                        (CASE
                                            WHEN kategori.szType = 'KELUAR' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountKeluar
                                        FROM transaksi_keuangan laporan
                                        LEFT JOIN category_keuangan kategori
                                        ON kategori.szCategoryId = laporan.szCategoryId
                                        WHERE DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') = '" . $tgl . "'
                                        AND laporan.is_delete = 0
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

        $data['num_rows'] = DB::table('transaksi_keuangan')->count();

        //return view with data
        return $data;
    }


    public function LaporanHarian()
    {
        $data['kategori_tipe'] = DB::table('category_keuangan')->select('szType')->where('bActive', 1)->groupBy('szType')->get();
        $data['kategori'] = DB::table('category_keuangan')->where('bActive', 1)->get();
        $data['num_rows'] = DB::table('transaksi_keuangan')->count();
        $data['kode'] = date('Ymd');

        $data['laporan_harian'] = DB::select("SELECT
                                        laporan.szTransId,
                                        laporan.szCategoryId,
                                        kategori.szDesc,
                                        laporan.szDesc,
                                        DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') AS dtmTrans,
                                        laporan.decAmount
                                        FROM transaksi_keuangan laporan
                                        LEFT JOIN category_keuangan kategori
                                        ON kategori.szCategoryId = laporan.szCategoryId
                                        WHERE DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') = '" . date('Y-m-d') . "'
                                        AND laporan.is_delete = 0
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

        //return view with data
        return view('laporan_keuangan/laporan_harian', compact('data'));
    }

    public function LaporanHarianByDate($tgl)
    {
        $data['kategori_tipe'] = DB::table('category_keuangan')->select('szType')->where('bActive', 1)->groupBy('szType')->get();
        $data['kategori'] = DB::table('category_keuangan')->where('bActive', 1)->get();
        $data['num_rows'] = DB::table('transaksi_keuangan')->count();
        $data['kode'] = date('Ymd');
        $data['tgl'] = $tgl;

        $data['laporan_harian'] = DB::select("SELECT
                                        laporan.szTransId,
                                        laporan.szCategoryId,
                                        kategori.szDesc AS kategori_desc,
                                        laporan.szDesc,
                                        DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') AS dtmTrans,
                                        (CASE
                                            WHEN kategori.szType = 'MASUK' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountMasuk,
                                        (CASE
                                            WHEN kategori.szType = 'KELUAR' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountKeluar
                                        FROM transaksi_keuangan laporan
                                        LEFT JOIN category_keuangan kategori
                                        ON kategori.szCategoryId = laporan.szCategoryId
                                        WHERE DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') = '" . $tgl . "'
                                        AND laporan.is_delete = 0
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

        //return view with data
        return view('laporan_keuangan/laporan_harian_by_date', compact('data'));
    }

    public function LaporanMingguan()
    {
        $data['laporan_mingguan'] = DB::select("SELECT
                                                DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') AS dtmTrans,
                                                SUM(CASE
                                                    WHEN kategori.szType = 'MASUK' THEN laporan.decAmount
                                                    ELSE 0
                                                END) decAmountMasuk,
                                                SUM(CASE
                                                    WHEN kategori.szType = 'KELUAR' THEN laporan.decAmount
                                                    ELSE 0
                                                END) decAmountKeluar
                                                FROM transaksi_keuangan laporan
                                                LEFT JOIN category_keuangan kategori
                                                ON kategori.szCategoryId = laporan.szCategoryId
                                                WHERE DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_ADD(NOW(), INTERVAL(1-DAYOFWEEK(NOW())) DAY), '%Y-%m-%d') AND DATE_FORMAT(DATE(NOW() + INTERVAL (7 - DAYOFWEEK(NOW())) DAY), '%Y-%m-%d')
                                                AND laporan.is_delete = 0
                                                GROUP BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d')
                                                ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC;");

        //return view with data
        return view('laporan_keuangan/laporan_mingguan', compact('data'));
    }

    public function LaporanBulanan()
    {
        $data['laporan_bulanan'] = DB::select("SELECT
                                                SUM(CASE
                                                    WHEN kategori.szType = 'MASUK' THEN laporan.decAmount
                                                    ELSE 0
                                                END) decAmountMasuk,
                                                SUM(CASE
                                                    WHEN kategori.szType = 'KELUAR' THEN laporan.decAmount
                                                    ELSE 0
                                                END) decAmountKeluar
                                                FROM transaksi_keuangan laporan
                                                LEFT JOIN category_keuangan kategori
                                                ON kategori.szCategoryId = laporan.szCategoryId
                                                WHERE DATE_FORMAT(laporan.dtmTrans, '%Y') = '" . date('Y') . "'
                                                AND DATE_FORMAT(laporan.dtmTrans, '%m') = '" . date('m') . "'
                                                AND laporan.is_delete = 0;");

        //return view with data
        return view('laporan_keuangan/laporan_bulanan', compact('data'));
    }

    // method untuk insert data ke table pegawai
    public function add(Request $request)
    {
        //define validation rules
        $validator = Validator::make(
            $request->all(),
            [
                'szTransId'     => 'required',
                'szCategoryId'   => 'required',
                'szDesc'   => 'required',
                'dtmTrans'   => 'required',
                'decAmount'   => 'required|numeric|min:0|not_in:0',
            ],
            [
                'szCategoryId.required' => 'Kategori tidak boleh kosong!',
                'szDesc.required' => 'Deskripsi tidak boleh kosong!',
                'dtmTrans.required' => 'Tanggal transaksi tidak boleh kosong!',
                'decAmount.not_in' => 'Limit tidak boleh 0!'
            ]
        );

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = DB::table('transaksi_keuangan')->insert([
            'szTransId' => $request->szTransId,
            'szCategoryId' => $request->szCategoryId,
            'szDesc' => $request->szDesc,
            'dtmTrans' => $request->dtmTrans,
            'dtmCreated' => date('Y-m-d H:i:s'),
            'dtmLastUpdated' => date('Y-m-d H:i:s'),
            'decAmount' => $request->decAmount,
            'is_delete' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post
        ]);
    }

    // method untuk edit data pegawai
    public function edit($id)
    {
        // mengambil data pegawai berdasarkan id yang dipilih
        $data = DB::select("SELECT
                            transaksi.szTransId,
                            transaksi.szCategoryId,
                            category.szType AS category_type,
                            category.decLimit,
                            transaksi.szDesc,
                            DATE_FORMAT(transaksi.dtmTrans,'%Y-%m-%d') AS dtmTrans,
                            DATE_FORMAT(transaksi.dtmCreated,'%Y-%m-%d') AS dtmCreated,
                            DATE_FORMAT(transaksi.dtmLastUpdated,'%Y-%m-%d') AS dtmLastUpdated,
                            transaksi.decAmount,
                            (SELECT 
                                IFNULL(SUM(laporan.decAmount),0) decAmount 
                            FROM transaksi_keuangan laporan
                            WHERE DATE_FORMAT(laporan.dtmTrans, '%Y') = '" . date('Y') . "'
                            AND DATE_FORMAT(laporan.dtmTrans, '%m') = '" . date('m') . "'
                            AND laporan.szCategoryId = transaksi.szCategoryId) AS total_amount
                            FROM transaksi_keuangan transaksi
                            LEFT JOIN category_keuangan category
                            ON category.szCategoryId = transaksi.szCategoryId
                            WHERE transaksi.szTransId = '" . $id . "' ");
        // passing data pegawai yang didapat ke view edit.blade.php
        return $data;
    }

    // update data pegawai
    public function update(Request $request)
    {
        //define validation rules
        $validator = Validator::make(
            $request->all(),
            [
                'szCategoryId'   => 'required',
                'szDesc'   => 'required',
                'dtmTrans'   => 'required',
                'decAmount'   => 'required|numeric|min:0|not_in:0'
            ],
            [
                'szCategoryId.required' => 'Kategori tidak boleh kosong!',
                'szDesc.required' => 'Deskripsi tidak boleh kosong!',
                'dtmTrans.required' => 'Tanggal transaksi tidak boleh kosong!',
                'decAmount.not_in' => 'Limit tidak boleh 0!'
            ]
        );

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = DB::table('transaksi_keuangan')->where('szTransId', $request->szTransId)->update([
            'szCategoryId' => $request->szCategoryId,
            'szDesc' => $request->szDesc,
            'dtmTrans' => $request->dtmTrans,
            'dtmLastUpdated' => date('Y-m-d H:i:s'),
            'decAmount' => $request->decAmount,
            'is_delete' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post
        ]);
    }

    // method untuk hapus data pegawai
    public function hapus($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        $post = DB::table('transaksi_keuangan')->where('szTransId', $id)->update([
            'is_delete' => 1
        ]);

        // alihkan halaman ke halaman pegawai
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
            'data'    => $post
        ]);
    }

    public function get_limit_by_category($id)
    {
        $data['limit'] = DB::table('category_keuangan')->where('szCategoryId', $id)->get()[0]->decLimit;
        $data['total_amount'] = DB::select("SELECT
                                                IFNULL(SUM(laporan.decAmount),0) decAmount
                                                FROM transaksi_keuangan laporan
                                                LEFT JOIN category_keuangan kategori
                                                ON kategori.szCategoryId = laporan.szCategoryId
                                                WHERE DATE_FORMAT(laporan.dtmTrans, '%Y') = '" . date('Y') . "'
                                                AND DATE_FORMAT(laporan.dtmTrans, '%m') = '" . date('m') . "'
                                                AND laporan.szCategoryId = '" . $id . "' ;")[0]->decAmount;

        return $data;
    }

    public function Get_category_keuangan_by_type(Request $request)
    {
        //get all posts from Models
        $data = DB::table('category_keuangan')->where('szType', $request->type)->get();

        //return view with data
        return $data;
    }
}
