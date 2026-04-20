<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
/**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table kotas
        $jadwal = Jadwal::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data jadwal',
            'data'    => $jadwal
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
        //find jadwal by ID
        $jadwal = Jadwal::findOrfail($id);


        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data jadwal',
            'data'    => $jadwal
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
            'nama_file' => 'required',
            // 'keterangan' => 'required',
            'url' => 'required'
          ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $jadwal = Jadwal::create([
            'nama_file' => $request->nama_file,
            'keterangan' => $request->keterangan,
            'url' => $request->url,
        ]);

        //success save to database
        if($jadwal) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil diupload.',
                'data'    => $jadwal
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Jadwal gagal diupload.',
        ], 409);

    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $jadwal
     * @return void
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_file' => 'required',
            // 'keterangan' => 'required',
            'url' => 'required'

        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find jadwal by ID
        $jadwal = Jadwal::find($request->id);

        if($jadwal) {

            //update jadwal
            $jadwal->update([
                'id' => $request->id,
                'nama_file' => $request->nama_file,
                'keterangan' => $request->keterangan,
                'url' => $request->url,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil diupdate.',
                'data'    => $jadwal
            ], 200);

        }

        //data jadwal not found
        return response()->json([
            'success' => false,
            'message' => 'Jadwal tidak ditemukan.',
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
        //find jadwal by ID
        $jadwal = Jadwal::findOrfail($id);

        if($jadwal) {

            //delete jadwal
            $jadwal->delete();

            return response()->json([
                'success' => true,
                'message' => 'jadwal Deleted',
            ], 200);

        }

        //data jadwal not found
        return response()->json([
            'success' => false,
            'message' => 'jadwal Not Found',
        ], 404);
    }
}
