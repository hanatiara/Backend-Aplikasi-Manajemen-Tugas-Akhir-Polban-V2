<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\DataPenguji;
use App\Models\Penguji;

class PengujiController extends Controller
{
    public function getDataPenguji()
    {
        $data = DB::table('dosens')
                ->join('pengujis', 'dosens.id', '=', 'pengujis.id_dosen')
                ->join('data_pengujis', 'pengujis.id', '=', 'data_pengujis.id_penguji')
                ->join('kotas', 'kotas.id', '=', 'data_pengujis.id_kota')
                ->get();


        return response()->json([
            'success' => true,
            'message' => 'Detail Data Penguji',
            'data'    => $data
        ], 200);


    }


    public function getlistPenguji() {
        //get data from table kotas
        $data = DB::table('dosens')
               ->join('pengujis', 'dosens.id', '=', 'pengujis.id_dosen')
               ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Penguji',
            'data'    => $data
        ], 200);
   }

    public function store(Request $request)
    {
        // //set validation
        // $validator = Validator::make($request->all(), [
        //     'id_penguji' => 'required',
        //     'id_kota'=> 'required',
        // ]);

        // //response error validation
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        //save to database
        $datapenguji = DataPenguji::create([
            'id_penguji' => $request->id_penguji,
            'id_kota'=> $request->id_kota,

        ]);

        //success save to database
        if($datapenguji) {
            return response()->json([
                'success' => true,
                'message' => 'datapembimbing Created',
                'data'    => $datapenguji
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Data DataPenguji Failed to Save',
        ], 409);

    }

    public function create(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'id_dosen' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $check = Penguji::where([
            'id_dosen' => $request->id_dosen,
        ])->first();

        // If id_dosen not registered yet
        if(!$check) {
            //save to database
            $penguji = Penguji::create([
                'id_dosen' => $request->id_dosen,

            ]);

            $dosen_role = DB::table('dosen_roles')
            ->insert([
                'id_dosen' => $request->id_dosen,
                'id_role' => '2'
            ]);

            //success save to database
            if($penguji && $dosen_role) {
                return response()->json([
                    'success' => true,
                    'message' => 'Penguji Created',
                    'data'    => $penguji,
                    'dosen_role' => $dosen_role,
                ], 201);

            }

            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Penguji Failed to Save',
            ], 409);
        }
        else {
            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Penguji already exist.',
                'data' => $check,
            ], 409);
        }

    }

    public function deletePenguji($id) {
        //find datapembimbing by ID
        $data = DB::table('pengujis')->where('id_dosen', $id)->get();


        if(isset($data)) {

            //delete datapembimbing
            DB::table('pengujis')->where('id_dosen', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Penguji Deleted',
            ], 200);

        }

        //data datapembimbing not found
        return response()->json([
            'success' => false,
            'message' => 'data penguji Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        //find datapembimbing by ID
        $datapenguji = DB::table('data_pengujis')->where('id_kota', $id)->get();


        if(isset($datapenguji)) {

            //delete datapembimbing
            DB::table('data_pengujis')->where('id_kota', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'datapembimbing Deleted',
            ], 200);

        }

        //data datapembimbing not found
        return response()->json([
            'success' => false,
            'message' => 'datapembimbing Not Found',
        ], 404);
    }
}
