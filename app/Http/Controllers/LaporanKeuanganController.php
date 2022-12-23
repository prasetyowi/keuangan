<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
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
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

        $data['num_rows'] = DB::table('transaksi_keuangan')->count();

        //return view with data
        return $data;
    }


    public function LaporanHarian()
    {
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
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

        //return view with data
        return view('laporan_keuangan/laporan_harian', compact('data'));
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
                                                GROUP BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d')
                                                ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC;");

        //return view with data
        return view('laporan_keuangan/laporan_mingguan', compact('data'));
    }

    public function LaporanBulanan()
    {
        $data['laporan_harian'] = DB::select("SELECT
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
                                                AND DATE_FORMAT(laporan.dtmTrans, '%m') = '" . date('m') . "';");

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
            'decAmount' => $request->decAmount
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
        $data = DB::table('transaksi_keuangan')->where('szTransId', $id)->get();
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
            'decAmount' => $request->decAmount
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
            'bActive' => 0
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
                                                SUM(laporan.decAmount) decAmount
                                                FROM transaksi_keuangan laporan
                                                LEFT JOIN category_keuangan kategori
                                                ON kategori.szCategoryId = laporan.szCategoryId
                                                WHERE DATE_FORMAT(laporan.dtmTrans, '%Y') = '" . date('Y') . "'
                                                AND DATE_FORMAT(laporan.dtmTrans, '%m') = '" . date('m') . "'
                                                AND laporan.szCategoryId = '" . $id . "' ;")[0]->decAmount;

        return $data;
    }
}
