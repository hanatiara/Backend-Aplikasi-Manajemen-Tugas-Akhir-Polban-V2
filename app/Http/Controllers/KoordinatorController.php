<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koordinator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KoordinatorController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table koordinators
        $koordinator = Koordinator::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data koordinator',
            'data'    => $koordinator
        ], 200);

    }

    public function getProdi($id) {
        $koordinator = DB::table('users')
        ->join('dosens', 'dosens.id_user', '=', 'users.id')
        ->join('koordinators', 'dosens.id', '=', 'koordinators.id_dosen')
        ->select('koordinators.prodi')
        ->where('users.id', $id)
        ->first();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data koordinator',
            'data'    => $koordinator
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
        //find koordinator by ID
        $koordinator = Koordinator::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data koordinator',
            'data'    => $koordinator
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
            'id_dosen' => 'required',
            'prodi' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $koordinator = Koordinator::create([
            'id_dosen' => $request->id_dosen,
            'prodi' => $request->prodi,

        ]);

        //success save to database
        if($koordinator) {
            return response()->json([
                'success' => true,
                'message' => 'koordinator Created',
                'data'    => $koordinator
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Data Koordinator Failed to Save',
        ], 409);

    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $koordinator
     * @return void
     */
    public function update(Request $request, koordinator $koordinator)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_dosen' => 'required',
            'prodi' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find koordinator by ID
        $koordinator = Koordinator::find($request->id);

        if($koordinator) {

            //update koordinator
            $koordinator->update([
                'id' => $request->id,
                'id_dosen' => $request->id_dosen,
                'prodi' => $request->prodi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'koordinator Updated',
                'data'    => $koordinator
            ], 200);

        }

        //data koordinator not found
        return response()->json([
            'success' => false,
            'message' => 'koordinator Not Found',
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
        //find koordinator by ID
        $koordinator = Koordinator::findOrfail($id);

        if($koordinator) {

            //delete koordinator
            $koordinator->delete();

            return response()->json([
                'success' => true,
                'message' => 'koordinator Deleted',
            ], 200);

        }

        //data koordinator not found
        return response()->json([
            'success' => false,
            'message' => 'koordinator Not Found',
        ], 404);
    }
}
