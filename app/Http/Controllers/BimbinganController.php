<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bimbingan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BimbinganController extends Controller
{
    public function getBimbinganFromKota($id)
    {
        //get bimbingan from kotas using id_user

        $bimbingan = DB::table('users')
        ->join('kotas', 'kotas.id_user', '=', 'users.id')
        ->join('bimbingans', 'bimbingans.id_kota', '=', 'kotas.id')
        ->join('pembimbings', 'pembimbings.id', '=', 'bimbingans.id_pembimbing')
        ->join('dosens', 'dosens.id', '=', 'pembimbings.id_dosen')
        ->where('kotas.id_user', $id)
        ->select(
            'kotas.nama_kota',
            'kotas.nama_mahasiswa1',
            'kotas.nama_mahasiswa2',
            'kotas.nama_mahasiswa3',
            'bimbingans.topik_bimbingan',
            'dosens.nama_dosen',
            'bimbingans.status',
            'bimbingans.tanggal_bimbingan',
            'bimbingans.id AS id_bimbingan')
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Bimbingan',
            'data'    => $bimbingan
        ], 200);

    }
    public function getBimbinganByID($id) {
        $bimbingan = DB::table('bimbingans')
        ->join('kotas', 'kotas.id', '=', 'bimbingans.id_kota')
        ->join('pembimbings', 'pembimbings.id', '=', 'bimbingans.id_pembimbing')
        ->join('dosens', 'dosens.id', '=', 'pembimbings.id_dosen')
        ->select(
            'bimbingans.tanggal_bimbingan',
            'bimbingans.topik_bimbingan',
            'dosens.nama_dosen',
            'bimbingans.id AS id_bimbingan',
            'kotas.nama_kota',
            'kotas.nama_mahasiswa1',
            'kotas.nama_mahasiswa2',
            'kotas.nama_mahasiswa3',
            'bimbingans.catatan',
            'bimbingans.url',
            'bimbingans.nama_file',
            'bimbingans.status',
            'bimbingans.komentar')
        ->where('bimbingans.id', $id)
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Bimbingan',
            'data'    => $bimbingan
        ], 200);
    }

    public function getBimbinganFromPembimbing($id) {
        $bimbingan = DB::table('users')
        ->join('dosens', 'dosens.id_user', '=', 'users.id')
        ->join('pembimbings', 'pembimbings.id', '=', 'dosens.id')
        ->join('bimbingans', 'pembimbings.id', '=', 'bimbingans.id_pembimbing')
        ->join('kotas', 'kotas.id', '=', 'bimbingans.id_kota')
        ->select(
            'kotas.nama_kota',
            'bimbingans.topik_bimbingan',
            'dosens.nama_dosen',
            'bimbingans.status',
            'bimbingans.tanggal_bimbingan',
            'bimbingans.id AS id_bimbingan')
        ->where('dosens.id_user', $id)
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Bimbingan',
            'data'    => $bimbingan
        ], 200);
    }

    public function getAllBimbingan() {
        // Get all list bimbingan for koordinator role
        $bimbingan = DB::table('dosens')
        ->join('pembimbings', 'pembimbings.id_dosen', '=', 'dosens.id')
        ->join('bimbingans', 'bimbingans.id_pembimbing', '=', 'pembimbings.id')
        ->join('kotas', 'bimbingans.id_kota', '=', 'kotas.id')
        ->select(
            'kotas.nama_kota',
            'bimbingans.topik_bimbingan',
            'bimbingans.tanggal_bimbingan',
            'bimbingans.status',
            'dosens.nama_dosen',
            'bimbingans.id AS id_bimbingan')
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Bimbingan',
            'data'    => $bimbingan
        ], 200);
    }

    public function getBimbinganFromIDKota($id) {
        // Get all list bimbingan from ID Kota
        $bimbingan = DB::table('bimbingans')
        ->join('kotas', 'bimbingans.id_kota', '=', 'kotas.id')
        ->where('kotas.id', $id)
        ->select(
            'kotas.nama_kota',
            'bimbingans.topik_bimbingan',
            'bimbingans.tanggal_bimbingan',
            'bimbingans.status',
            'bimbingans.id AS id_bimbingan')
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Bimbingan',
            'data'    => $bimbingan
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'tanggal_bimbingan' => 'required',
            'topik_bimbingan' => 'required',
            'catatan' => 'required',
            'id_kota' => 'required',
            'status' => 'required',
            'id_pembimbing' => 'required',
          ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $bimbingan = Bimbingan::create([
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'topik_bimbingan' => $request->topik_bimbingan,
            'catatan' => $request->catatan,
            'id_kota' => $request->id_kota,
            'status' => $request->status,
            'komentar' => $request->komentar,
            'id_pembimbing' => $request->id_pembimbing,
            'url' => $request->url,
            'nama_file' => $request->nama_file
        ]);

        //success save to database
        if($bimbingan) {
            return response()->json([
                'success' => true,
                'message' => 'Bimbingan berhasil disimpan.',
                'data'    => $bimbingan
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Bimbingan Failed to Save',
        ], 409);

    }

    public function updateKomentar(Request $request, Bimbingan $bimbingan)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find kota by ID
        $bimbingan = Bimbingan::find($request->id);

        if($bimbingan) {

            //update bimbingan
            $bimbingan->update([
                'id' => $request->id,
                'komentar' => $request->komentar,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bimbingan berhasil diupdate.',
                'data'    => $bimbingan
            ], 200);

        }

        //data kota not found
        return response()->json([
            'success' => false,
            'message' => 'kota Not Found',
        ], 404);


    }

    public function updateBimbingan(Request $request, Bimbingan $bimbingan)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find kota by ID
        $bimbingan = Bimbingan::find($request->id);

        if($bimbingan) {

            //update kota
            $bimbingan->update([
                'id' => $request->id,
                'topik_bimbingan' => $request->topik_bimbingan,
                'catatan' => $request->catatan,
                'url' => $request->url,
                'nama_file' => $request->nama_file
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bimbingan berhasil diupdate.',
                'data'    => $bimbingan
            ], 200);

        }

        //data kota not found
        return response()->json([
            'success' => false,
            'message' => 'kota Not Found',
        ], 404);

    }

    public function destroy($id)
    {
        //find kota by ID
        $bimbingan = Bimbingan::findOrfail($id);

        if($bimbingan) {

            //delete kota
            $bimbingan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Bimbingan Deleted',
            ], 200);

        }

        //data kota not found
        return response()->json([
            'success' => false,
            'message' => 'Data Bimbingan Not Found',
        ], 404);
    }
}
