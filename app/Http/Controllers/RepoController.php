<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepoController extends Controller
{
    public function getRepo($id) {
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', 'berkas.id_kota')
        ->where('berkas.id', $id)
        ->select(
            'kotas.nama_kota',
            'kotas.tahun_ajaran',
            'kotas.judul_ta',
            'kotas.prodi',
            'kotas.nama_mahasiswa1',
            'kotas.nama_mahasiswa2',
            'kotas.nama_mahasiswa3',
            'berkas.url_berkas',
            'berkas.nama_berkas',
            'berkas.id'
        )
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Repositori',
            'data'    => $berkas
        ], 200);
    }

    public function getAllRepositori() {
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', 'berkas.id_kota')
        ->where('jenis_seminar', 'seminar-3')
        ->where('jenis_berkas', 'proposal-laporan')
        ->select(
            'kotas.nama_kota',
            'kotas.id AS id_kota',
            'kotas.judul_ta',
            'kotas.tahun_ajaran',
            'berkas.id',
            'nama_mahasiswa1',
            'nama_mahasiswa2',
            'nama_mahasiswa3',)
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Repositori',
            'data'    => $berkas
        ], 200);
    }
}
