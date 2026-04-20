<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PemberkasanController extends Controller
{
    public function getBerkasByIDKota($id, $seminar_type) {
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', '=', 'berkas.id_kota')
        ->where('kotas.id', $id)
        ->where('berkas.jenis_seminar', $seminar_type)
        ->select(
            'berkas.id',
            'kotas.nama_kota',
            'kotas.id AS id_kota',
            'berkas.jenis_berkas',
            'berkas.status',
            'berkas.nama_berkas',
            'berkas.url_berkas',
            'berkas.jenis_seminar'
            )
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Berkas',
            'data'    => $berkas
        ], 200);
    }

    public function getBerkas($id, $document, $seminar_type) {
        // for penguji & kota
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', '=', 'berkas.id_kota')
        ->where('kotas.id', $id)
        ->where('berkas.jenis_berkas', $document)
        ->where('berkas.jenis_seminar', $seminar_type)
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Berkas',
            'data'    => $berkas
        ], 200);
    }

    public function getBerkasByIDSeminar($id) {
        // id = id_kota
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', '=', 'berkas.id_kota')
        ->where('kotas.id', $id)
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Berkas',
            'data'    => $berkas
        ], 200);
    }

    public function getBerkasByID($id) {
        // id = id_berkas
        $berkas = DB::table('berkas')
        ->where('berkas.id', $id)
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Berkas',
            'data'    => $berkas
        ], 200);
    }

    public function getBerkasByKota($id, $seminar_type){
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', '=', 'berkas.id_kota')
        ->join('users', 'users.id', '=', 'kotas.id_user')
        ->where('users.id', $id)
        ->where('berkas.jenis_seminar', $seminar_type)
        ->select(
            'berkas.id',
            'kotas.nama_kota',
            'berkas.jenis_berkas',
            'berkas.status',
            'berkas.nama_berkas',
            'berkas.url_berkas',
            'berkas.jenis_seminar'
            )
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Berkas',
            'data'    => $berkas
        ], 200);
    }



    public function getBerkasByProdi($prodi, $seminar_type){
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', '=', 'berkas.id_kota')
        ->where('kotas.prodi', $prodi)
        ->where('berkas.jenis_seminar', $seminar_type)
        ->select(
            'berkas.id',
            'kotas.nama_kota',
            'berkas.jenis_berkas',
            'berkas.status',
            'berkas.nama_berkas')
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Berkas',
            'data'    => $berkas
        ], 200);
    }

    public static function checkIfBerkasExists($id ,$seminar_type ,$jenis_berkas) {
        $berkas = DB::table('berkas')
        ->join('kotas', 'kotas.id', '=', 'berkas.id_kota')
        ->join('users', 'users.id', '=', 'kotas.id_user')
        ->where('users.id', $id)
        ->where('berkas.jenis_seminar', $seminar_type)
        ->where('berkas.jenis_berkas', $jenis_berkas)
        ->select(
            'berkas.id AS id_berkas',
            'kotas.nama_kota',
            'berkas.jenis_berkas',
            'berkas.status',
            'berkas.nama_berkas',
            'berkas.jenis_seminar'
            )
        ->first();

        if($berkas == null) {
            $success = false;
            $id_berkas = null;
        }

        else {
            $success = true;
            $id_berkas = $berkas->id_berkas;
        }


        return response()->json([
            'success' => $success,
            'id' => $id_berkas
        ], 200);



    }

    public function uploadBerkas(Request $request) {
         //for kota

        //set validation
         $validator = Validator::make($request->all(), [
            'id_kota' => 'required',
            'tgl_pengumpulan' => 'required',
            'jenis_berkas' => 'required',
            'jenis_seminar' => 'required',
            'status' => 'required',
            'url_berkas' => 'required',
            'nama_berkas' => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $berkas = Berkas::create([
            'id_kota' => $request->id_kota,
            'tgl_pengumpulan' => $request->tgl_pengumpulan,
            'jenis_berkas' => $request->jenis_berkas,
            'jenis_seminar'=> $request->jenis_seminar,
            'status' => $request->status,
            'url_berkas' => $request->url_berkas,
            'nama_berkas' => $request->nama_berkas
        ]);
         //success save to database
        if($berkas) {
            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil disimpan.',
                'data'    => $berkas
            ], 201);
        }



    }

    public function updateBerkas(Request $request, berkas $berkas) {
        //set validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'tgl_pengumpulan' => 'required',
            'url_berkas' => 'required',
            'nama_berkas' => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find kota by ID
        $berkas = Berkas::find($request->id);

        //update kota
        $berkas->update([
            'id' => $request->id,
            'tgl_pengumpulan' => $request->tgl_pengumpulan,
            'url_berkas' => $request->url_berkas,
            'nama_berkas' => $request->nama_berkas
        ]);

        //update
        return response()->json([
            'success' => true,
            'message' => 'Berkas berhasil diupdate.',
            'data'    => $berkas
        ], 201);
    }

    public function getAllBerkasBySeminar($seminar_type) {
        // seminar_1, seminar_2, seminar_3, sidang
        $berkas = DB::table('berkas')
        ->where('jenis_seminar', $seminar_type)
        ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Berkas',
            'data'    => $berkas
        ], 200);
    }


}
