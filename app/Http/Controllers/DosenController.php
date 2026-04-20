<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table koordinators
        $data = DB::table('dosens')
                ->join('users', 'dosens.id_user', '=', 'users.id')
                ->select(
                    'dosens.id',
                    'dosens.nama_dosen',
                    'dosens.id_user',
                    'dosens.inisial_dosen',
                    'dosens.nip')
                ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data dosen',
            'data'    => $data
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
        //find dosen by ID
        $data = DB::table('dosens')
                ->join('users', 'dosens.id_user', '=', 'users.id')
                ->where('dosens.id', $id)
                ->select(
                    'users.id as id_user',
                    'dosens.id as id',
                    'dosens.inisial_dosen',
                    'dosens.nama_dosen',
                    'dosens.nip'
                )
                ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Dosen',
            'data'    => $data
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
        // api error probably here
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'inisial_dosen' => 'required',
            'nama_dosen' => 'required',
            'nip' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $dosen = Dosen::create([
            'id_user' => $request->id_user,
            'inisial_dosen' => $request->inisial_dosen,
            'nama_dosen' => $request->nama_dosen,
            'nip' => $request->nip,

        ]);

        //success save to database
        if($dosen) {
            return response()->json([
                'success' => true,
                'message' => 'dosen Created',
                'data'    => $dosen
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Data Dosen Failed to Save',
        ], 409);

    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $dosen
     * @return void
     */
    public function update(Request $request, Dosen $dosen)
    {
        // set validation
        $validator = $request->validate([
            'id' => ['required'],
            'id_user' => ['required'],
            'inisial_dosen' => ['required'],
            'nama_dosen' => ['required'],
            'nip' => ['required'],
        ]);

        // $validator = Validator::make($request->all(), [
        //     'id' => 'required',
        //     'id_user' => 'required',
        //     'inisial_dosen' => 'required',
        //     'nama_dosen' => 'required',
        //     'nip' => 'required',
        // ]);

        // // response error validation
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        //find dosen by ID
        $dosen = Dosen::find($request->id);

        if($dosen) {

            //update dosen
            $dosen->update([
                'id' => $request->id,
                'id_user' => $request->id_user,
                'inisial_dosen' => $request->inisial_dosen,
                'nama_dosen' => $request->nama_dosen,
                'nip' => $request->nip,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dosen berhasil diupdate.',
                'data'    => $dosen
            ], 200);

        }

        //data dosen not found
        return response()->json([
            'success' => false,
            'message' => 'dosen Not Found',
        ], 404);

    }

    public function getLastID() {
        $id = DB::table('dosens')->latest()->first();

        return response()->json([
            'success' => true,
            'message' => 'Dosen Last ID',
            'data'    => $id
        ], 200);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find dosen by ID
        $dosen = Dosen::findOrfail($id);

        if($dosen) {

            //delete dosen
            $dosen->delete();

            return response()->json([
                'success' => true,
                'message' => 'dosen Deleted',
            ], 200);

        }

        //data dosen not found
        return response()->json([
            'success' => false,
            'message' => 'dosen Not Found',
        ], 404);
    }
}
