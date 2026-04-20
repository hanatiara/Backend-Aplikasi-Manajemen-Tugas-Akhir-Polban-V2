<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;



class AuthController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where([
            'username' => $validated['username'],
        ])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            $response = [
                'success' => false,
                'message' => 'Username atau Password Salah.',
            ];

            throw (new HttpResponseException(response()->json($response, 200)));
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        if($user->role == 'dosen') {
            $role = DB::table('users')
            ->join('dosens', 'dosens.id_user', '=', 'users.id')
            ->join('dosen_roles', 'dosens.id', '=', 'dosen_roles.id_dosen')
            ->join('roles', 'dosen_roles.id_role', '=', 'roles.id')
            ->where('users.id', $user->id)
            ->get();

            if(count($role) == 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Login',
                    'data' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'role' => $user->role,
                        'role_dosen' => []
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer '
                ], Response::HTTP_OK);
            }

            for ($i = 0;$i < count($role); $i++) {
               $roles[$i] = $role[$i]->nama_role;
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Login',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'role_dosen' => $roles
                ],
                'token' => $token,
                'token_type' => 'Bearer '
            ], Response::HTTP_OK);

        }
        else {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Login',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'role_dosen' => []
                ],
                'token' => $token,
                'token_type' => 'Bearer '
            ], Response::HTTP_OK);
        }


    }

    public function getProfile(Request $request) {
        return auth()->user();

    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout Berhasil',
        ], Response::HTTP_OK);
    }
}
