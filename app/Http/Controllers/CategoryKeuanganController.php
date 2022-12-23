<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryKeuanganController extends Controller
{
    public function index()
    {
        //get all posts from Models
        $data['kategori'] = DB::table('category_keuangan')->where('bActive', 1)->get();
        $data['num_rows'] = DB::table('category_keuangan')->count();

        //return view with data
        return view('category_keuangan/index', compact('data'));
    }

    public function GetAllCategory()
    {
        //get all posts from Models
        $data['kategori'] = DB::table('category_keuangan')->where('bActive', 1)->get();
        $data['num_rows'] = DB::table('category_keuangan')->count();

        //return view with data
        return $data;
    }

    // method untuk menampilkan view form tambah pegawai
    public function tambah()
    {

        // memanggil view tambah
        return view('tambah');
    }

    // method untuk insert data ke table pegawai
    public function add(Request $request)
    {
        //define validation rules
        $validator = Validator::make(
            $request->all(),
            [
                'szCategoryid'     => 'required',
                'szDesc'   => 'required',
                'decLimit'   => 'required|numeric|min:0|not_in:0',
                'szType'   => 'required',
                'bActive'   => 'required',
            ],
            [
                'szDesc.required' => 'Deskripsi tidak boleh kosong!',
                'decLimit.not_in' => 'Limit tidak boleh 0!',
                'szType.required' => 'Tipe tidak boleh kosong!'
            ]
        );

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = DB::table('category_keuangan')->insert([
            'szCategoryid' => $request->szCategoryid,
            'szDesc' => $request->szDesc,
            'decLimit' => $request->decLimit,
            'szType' => $request->szType,
            'bActive' => $request->bActive
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
        $data = DB::table('category_keuangan')->where('szCategoryId', $id)->get();
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
                'szCategoryId'     => 'required',
                'szDesc'   => 'required',
                'decLimit'   => 'required|numeric|min:0|not_in:0',
                'szType'   => 'required',
                'bActive'   => 'required',
            ],
            [
                'szDesc.required' => 'Deskripsi tidak boleh kosong!',
                'decLimit.not_in' => 'Limit tidak boleh 0!',
                'szType.required' => 'Tipe tidak boleh kosong!'
            ]
        );

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = DB::table('category_keuangan')->where('szCategoryId', $request->szCategoryId)->update([
            'szDesc' => $request->szDesc,
            'decLimit' => $request->decLimit,
            'szType' => $request->szType,
            'bActive' => $request->bActive
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
        $post = DB::table('category_keuangan')->where('szCategoryId', $id)->update([
            'bActive' => 0
        ]);

        // alihkan halaman ke halaman pegawai
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
            'data'    => $post
        ]);
    }
}
