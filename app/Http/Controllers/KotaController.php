<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kota;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KotaController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table kotas
        $kota = Kota::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data kota',
            'data'    => $kota
        ], 200);

    }

     /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find kota by ID
        $kota = Kota::findOrfail($id);


        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data kota',
            'data'    => $kota
        ], 200);

    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_kota' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $kota = Kota::create([
            'nama_kota' => $request->nama_kota,
            'prodi' => $request->prodi,
            'tahun_ajaran' => $request->tahun_ajaran,
            'nama_mahasiswa1' => $request->nama_mahasiswa1,
            'nama_mahasiswa2' => $request->nama_mahasiswa2,
            'nama_mahasiswa3' => $request->nama_mahasiswa3,
            'nim1' => $request->nim1,
            'nim2' => $request->nim2,
            'nim3' => $request->nim3,
            'judul_ta' => $request->judul_ta,
            'id_user' => $request->id_user,
        ]);

        //success save to database
        if($kota) {
            return response()->json([
                'success' => true,
                'message' => 'Kota Created',
                'data'    => $kota
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Kota Failed to Save',
        ], 409);

    }

    public function getLastID() {
        $id = DB::table('kotas')->latest()->first();

        return response()->json([
            'success' => true,
            'message' => 'Kota last ID',
            'data'    => $id
        ], 200);
    }

    public function getLoggedID() {
        $id = Auth::id();

        $kota = DB::table('users')
        ->join('kotas', 'kotas.id_user', '=', 'users.id')
        ->where('users.id', $id)
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Logged KoTA ID',
            'data'    => $kota
        ], 200);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $kota
     * @return void
     */
    public function update(Request $request, Kota $kota)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_kota' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find kota by ID
        $kota = Kota::find($request->id);

        if($kota) {

            //update kota
            $kota->update([
                'id' => $request->id,
                'nama_kota' => $request->nama_kota,
                'prodi' => $request->prodi,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status' => $request->status,
                'nama_mahasiswa1' => $request->nama_mahasiswa1,
                'nama_mahasiswa2' => $request->nama_mahasiswa2,
                'nama_mahasiswa3' => $request->nama_mahasiswa3,
                'nim1' => $request->nim1,
                'nim2' => $request->nim2,
                'nim3' => $request->nim3,
                'judul_ta' => $request->judul_ta,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'KoTA berhasil diupdate.',
                'data'    => $kota
            ], 200);

        }

        //data kota not found
        return response()->json([
            'success' => false,
            'message' => 'KoTA tidak ditemukan.',
        ], 404);

    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find kota by ID
        $kota = Kota::findOrfail($id);

        if($kota) {

            //delete kota
            $kota->delete();

            return response()->json([
                'success' => true,
                'message' => 'kota Deleted',
            ], 200);

        }

        //data kota not found
        return response()->json([
            'success' => false,
            'message' => 'kota Not Found',
        ], 404);
    }
}
