<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Dosen_Role;
use App\Models\Koordinator;
use Illuminate\Http\Request;
use App\Models\Kota;
use App\Models\Pembimbing;
use App\Models\Penguji;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\KotaController;

class UserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table kotas
        $user = User::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data User',
            'data'    => $user
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
        //find user by ID
        $user = User::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data User',
            'data'    => $user
        ], 200);

    }

    public static function getUserRole($id)
    {
        //find roles by ID
        // $id == role

        if($id == 'kota') {
            $data = DB::table('users')
                ->join('kotas', 'kotas.id_user', '=', 'users.id')
                ->where('users.role', $id)
                ->get();
        }
        else{
            $data = DB::table('users')
                ->join('dosens', 'dosens.id_user', '=', 'users.id')
                ->join('dosen_roles', 'dosens.id', '=', 'dosen_roles.id_dosen')
                ->join('roles', 'dosen_roles.id_role', '=', 'roles.id')
                ->select('roles.nama_role', 'users.id as id_user', 'users.username')
                ->orderBy('users.id')
                ->get();
        }
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List user with '.$id .' roles.',
            'data'    => $data
        ], 200);

    }

    public static function getDosenRoles($id) {
        $role = DB::table('users')
            ->join('dosens', 'dosens.id_user', '=', 'users.id')
            ->join('dosen_roles', 'dosens.nip', '=', 'dosen_roles.nip')
            ->join('roles', 'dosen_roles.id_role', '=', 'roles.id')
            ->where('users.id', $id)
            ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List user with '.$id .' roles.',
            'data'    => $role
        ], 200);
    }

    public static function getPembimbingPengujiByIDUserKota($id) {
        $pembimbing = DB::table('users')
            ->join('kotas', 'kotas.id_user', '=', 'users.id')
            ->join('data_pembimbings', 'kotas.id', '=', 'data_pembimbings.id_kota')
            ->join('pembimbings', 'data_pembimbings.id_pembimbing', '=', 'pembimbings.id')
            ->join('dosens', 'pembimbings.id', '=', 'dosens.id')
            ->where('users.id', $id)
            ->select('nama_dosen as pembimbing')
            ->get();

        $penguji = DB::table('users')
            ->join('kotas', 'kotas.id_user', '=', 'users.id')
            ->join('data_pengujis', 'kotas.id', '=', 'data_pengujis.id_kota')
            ->join('pengujis', 'data_pengujis.id_penguji', '=', 'pengujis.id')
            ->join('dosens', 'pengujis.id', '=', 'dosens.id')
            ->where('users.id', $id)
            ->select('nama_dosen as penguji')
            ->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Pembimbing',
            'data'    => [
                'pembimbing' => $pembimbing,
                'penguji'   => $penguji
            ]
        ], 200);
    }

    public static function getLastID() {
        $id = DB::table('users')->latest()->first();

        return response()->json([
            'success' => true,
            'message' => 'Users last ID',
            'data'    => $id
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
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('myAppToken');

        //success save to database
        if($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Created',
                'data'    => $user,
                'token'   => $token->plainTextToken,
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'User Failed to Save',
        ], 409);

    }

    /**
     * create dosen
     *
     * @param  mixed $request
     * @return void
     */
    public function importUserDosen(Request $request)
    {

        //set validation
        $validator = Validator::make($request->all(), [
            'username'   => 'required',
            'password'   => 'required',
            'role'       => 'required',
            'nama_dosen' => 'required',
            'nip'        => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $username = DB::table('users')
        ->select('username')
        ->where('username', $request->username)->first('username');

        if($username == null){
            //save to database
            $user = User::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            $lastUserID = DB::table('users')->latest('id')->first('id')->id;

            $dosen = Dosen::create([
                'id_user' => $lastUserID,
                'nama_dosen' => $request->nama_dosen,
                'nip' => $request->nip,
                'inisial_dosen' => $request->username
            ]);

            $lastDosenID = DB::table('dosens')->latest('id')->first('id')->id;

            // dd($lastUserID);

            $dosen_roles = DB::table('dosen_roles')->insert([
                'id_dosen' => $lastDosenID,
                'id_role' => '2',
            ]);

            $dosen_roles = DB::table('dosen_roles')->insert([
                'id_dosen' => $lastDosenID,
                'id_role' => '3',
            ]);

            $penguji = Penguji::create([
                'id' => $lastDosenID,
                'id_dosen' => $lastDosenID,
            ]);

            $pembimbing = Pembimbing::create([
                'id' => $lastDosenID,
                'id_dosen' => $lastDosenID,
            ]);

            $token = $user->createToken('myAppToken');

            //success save to database
            if($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'User Created',
                    'data'    => $user,
                    'token'   => $token->plainTextToken,
                ], 201);

            }
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'User Failed to Save',
        ], 409);

    }

    /**
     * create dosen
     *
     * @param  mixed $request
     * @return void
     */
    public function importUserKota(Request $request)
    {

        //set validation
        $validator = Validator::make($request->all(), [
            'username'       => 'required',
            'password'       => 'required',
            'role'           => 'required',
            'prodi'          => 'required',
            'tahun_ajaran'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $username = DB::table('users')
        ->select('username')
        ->where('username', $request->username)->first('username');

        if($username == null){
            //save to database
            // dd('true');
            $user = User::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            $lastUserID = DB::table('users')->latest('id')->first('id')->id;

            $kota = Kota::create([
                'id_user' => $lastUserID,
                'nama_kota' => $request->username,
                'prodi' => $request->prodi,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status' => 'BL'
            ]);

            // dd($lastUserID);

            $token = $user->createToken('myAppToken');

            //success save to database
            if($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'User KoTA berhasil dibuat.',
                    'data'    => $user,
                    'token'   => $token->plainTextToken,
                ], 201);

            }
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'User Failed to Save',
        ], 409);

    }

    public function getDataPenguji($id) {
        $data = DB::table('kotas')
        ->join('data_pengujis', 'kotas.id', '=', 'data_pengujis.id_kota')
        ->join('pengujis', 'data_pengujis.id_penguji', '=', 'pengujis.id')
        ->join('dosens', 'pengujis.id_dosen', '=', 'dosens.id')
        ->join('users', 'users.id', '=', 'dosens.id_user')
        ->select(
            'kotas.nama_kota',
            'dosens.nama_dosen',
            'kotas.nama_mahasiswa1',
            'kotas.nama_mahasiswa2',
            'kotas.nama_mahasiswa3',
            'kotas.prodi',
            'kotas.id as id_kota',
            'kotas.status'
            )
        ->where('users.id', $id)
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Penguji Kota',
            'data'    => $data
        ], 200);
    }

    public function getDataPembimbing($id) {
        $data = DB::table('kotas')
        ->join('data_pembimbings', 'kotas.id', '=', 'data_pembimbings.id_kota')
        ->join('pembimbings', 'data_pembimbings.id_pembimbing', '=', 'pembimbings.id')
        ->join('dosens', 'pembimbings.id_dosen', '=', 'dosens.id')
        ->join('users', 'users.id', '=', 'dosens.id_user')
        ->select(
            'kotas.nama_kota',
            'dosens.nama_dosen',
            'kotas.nama_mahasiswa1',
            'kotas.nama_mahasiswa2',
            'kotas.nama_mahasiswa3',
            'kotas.prodi',
            'kotas.id AS id_kota',
            'kotas.status'
            )
        ->where('users.id', $id)
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pembimbing Kota',
            'data'    => $data,
        ], 200);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $kota
     * @return void
     */
    public function update(Request $request, User $user)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find user by ID
        $user = User::find($request->id);

        if($user) {

            //update user
            $user->update([
                'id' => $request->id,
                'username' => $request->username,
            ]);


            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate.',
                'data'    => $user
            ], 200);

        }

        //data user not found
        return response()->json([
            'success' => false,
            'message' => 'User Not Found',
        ], 404);

    }

    public function updateKoor(Request $request) {
        // get id dosen by id_user
        $id_dosen = DB::table('users')
        ->join('dosens', 'dosens.id_user', '=', 'users.id')
        ->where('users.id', $request->id)
        ->first('dosens.id');

        $dosen_roles = DB::table('dosen_roles')->insert([
            'id_dosen' => $id_dosen->id,
            'id_role' => '1',
        ]);

        DB::table('koordinators')->insert([
            'id_dosen' => $id_dosen->id,
            'prodi'  => $request->prodi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Koordinator berhasil diupdate.',
            // 'data'    =>
        ], 200);
    }

    public function deleteKoor($id) {
        // delete koordinator by id_user
        $data = DB::table('koordinators')
        ->join('dosens', 'dosens.id', '=', 'koordinators.id_dosen')
        ->join('users', 'users.id', '=', 'dosens.id_user')
        ->where('users.id', $id)
        ->delete();

        // delete koordinator roles in dosen_roles by ID
        $data = DB::table('dosen_roles')
        ->join('dosens', 'dosens.id', '=', 'dosen_roles.id_dosen')
        ->join('users', 'users.id', '=', 'dosens.id_user')
        ->where('users.id', $id)
        ->where('dosen_roles.id_role', '1')
        ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Koordinator Deleted',
            // 'data' => $data
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
        //find kota by ID
        $user = User::findOrfail($id);

        if($user) {

            //delete kota
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User Deleted',
            ], 200);

        }

        //data kota not found
        return response()->json([
            'success' => false,
            'message' => 'User Not Found',
        ], 404);
    }

    public function updateUser(Request $request, User $user)
    {
        //set validation
        $validator = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where([
            'username' => $validator['username'],
        ])->first();

        if (!$user || !Hash::check($validator['password'], $user->password)) {
            $response = [
                'success' => false,
                'message' => 'Password Salah',
            ];

            throw (new HttpResponseException(response()->json($response, 200)));
        }

        //find user by ID
        $user = User::find($request->id);

        if($user) {

            //update user
            $user->update([
                'id' => $request->id,
                'password' => bcrypt($request->new_password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password Updated',
                'data'    => $user
            ], 200);

        }

        //data kota not found
        return response()->json([
            'success' => false,
            'message' => 'User Not Found',
        ], 404);

    }
}

