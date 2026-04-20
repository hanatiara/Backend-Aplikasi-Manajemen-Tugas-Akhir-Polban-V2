<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\DataPembimbing;
use App\Models\Dosen_Role;
use App\Models\Pembimbing;

class PembimbingController extends Controller
{
    public function getDataPembimbing()
    {
        $data = DB::table('dosens')
                ->join('pembimbings', 'dosens.id', '=', 'pembimbings.id_dosen')
                ->join('data_pembimbings', 'pembimbings.id', '=', 'data_pembimbings.id_pembimbing')
                ->join('kotas', 'kotas.id', '=', 'data_pembimbings.id_kota')
                ->get();


        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Pembimbing',
            'data'    => $data
        ], 200);

    }

    public function getlistPembimbing() {
         //get data from table Pembimbing
         $data = DB::table('dosens')
                ->join('pembimbings', 'dosens.id', '=', 'pembimbings.id_dosen')
                ->get();

         //make response JSON
         return response()->json([
             'success' => true,
             'message' => 'List Pembimbing',
             'data'    => $data
         ], 200);
    }

    public function getPembimbingFromKota($id) {
        //get pembimbing from id_user
        $data = DB::table('users')
            ->join('kotas', 'kotas.id_user', '=', 'users.id')
            ->join('data_pembimbings', 'data_pembimbings.id_kota', '=', 'kotas.id')
            ->join('pembimbings', 'data_pembimbings.id_pembimbing', '=', 'pembimbings.id')
            ->join('dosens', 'pembimbings.id_dosen', '=', 'dosens.id')
            ->where('users.id', $id)
            ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Pembimbing for Kota with id = '.$id,
            'data'    => $data
        ], 200);
   }

    public function store(Request $request)
    {
        //save to database
        $datapembimbing = DataPembimbing::create([
            'id_pembimbing' => $request->id_pembimbing,
            'id_kota'=> $request->id_kota,

        ]);

        //success save to database
        if($datapembimbing) {
            return response()->json([
                'success' => true,
                'message' => 'datapembimbing Created',
                'data'    => $datapembimbing
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Data DataPembimbing Failed to Save',
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

        $check = Pembimbing::where([
            'id_dosen' => $request->id_dosen,
        ])->first();

        // If id_dosen not registered yet
        if(!$check) {
            //save to database
            $pembimbing = Pembimbing::create([
                'id_dosen' => $request->id_dosen,

            ]);

            $dosen_role = DB::table('dosen_roles')
            ->insert([
                'id_dosen' => $request->id_dosen,
                'id_role' => '2'
            ]);

            //success save to database
            if($pembimbing && $dosen_role) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pembimbing Created',
                    'data'    => $pembimbing,
                    'dosen_role' => $dosen_role,
                ], 201);

            }

            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Pembimbing Failed to Save',
            ], 409);
        }
        else {
            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Pembimbing already exist.',
                'data' => $check,
            ], 409);
        }

    }

    public function update(Request $request, datapembimbing $datapembimbing)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'id_pembimbing' => 'required',
            'id_kota'=> 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if($datapembimbing) {

            //update datapembimbing
            $datapembimbing->insert([
                'id_pembimbing' => $request->id_pembimbing,
                'id_kota'=> $request->id_kota,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'datapembimbing Updated',
                'data'    => $datapembimbing
            ], 200);

        }

        //data datapembimbing not found
        return response()->json([
            'success' => false,
            'message' => 'datapembimbing Not Found',
        ], 404);

    }

    public function deletePembimbing($id) {
        //find datapembimbing by ID
        $data = DB::table('pembimbings')->where('id_dosen', $id)->get();


        if(isset($data)) {

            //delete datapembimbing
            DB::table('pembimbings')->where('id_dosen', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pembimbing Deleted',
            ], 200);

        }

        //data datapembimbing not found
        return response()->json([
            'success' => false,
            'message' => 'data pembimbing Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        //find datapembimbing by ID
        $data = DB::table('data_pembimbings')->where('id_kota', $id)->get();


        if(isset($data)) {

            //delete datapembimbing
            DB::table('data_pembimbings')->where('id_kota', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'data pembimbing Deleted',
            ], 200);

        }

        //data datapembimbing not found
        return response()->json([
            'success' => false,
            'message' => 'data pembimbing Not Found',
        ], 404);
    }

}
