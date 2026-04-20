<?php
namespace App\Http\Controllers;

use App\Models\Koordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::delete('/user/delete-koor/{idUser}', [UserController::class, 'deleteKoor']);
Route::put('/user/update-koor/{idUser}', [UserController::class, 'updateKoor']);

Route::post('/user/import-user-dosen', [UserController::class, 'importUserDosen']);
Route::post('/user/import-user-kota', [UserController::class, 'importUserKota']);
Route::get('/repo/get-repo', [RepoController::class, 'getAllRepositori']);
Route::get('/repo/get-repo/{idBerkas}', [RepoController::class, 'getRepo']);

Route::get('/user/get-pembimbing-penguji/{idUser}', [UserController::class, 'getPembimbingPengujiByIDUserKota']);

//Auth
Route::post('/auth/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/profile', [AuthController::class, 'getProfile']);

    // API route for logout user
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //User
    Route::get('/user/get', [UserController::class, 'index']);
    Route::get('/user/get/{idUser}', [UserController::class, 'show']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::put('/user/update/{idUser}', [UserController::class, 'update']);
    Route::put('/user/update-user/{username}', [UserController::class, 'updateUser']);
    Route::delete('/user/delete/{idUser}', [UserController::class, 'destroy']);
    Route::get('/user/get-role/{idUser}', [UserController::class, 'getUserRole']);
    Route::get('/user/get-id', [UserController::class, 'getLastID']);
    Route::get('/user/get-dosen-roles/{idDosen}', [UserController::class, 'getDosenRoles']);
    Route::get('/user/getDataPenguji/{idUser}', [UserController::class, 'getDataPenguji']);
    Route::get('/user/getDataPembimbing/{idUser}', [UserController::class, 'getDataPembimbing']);



    //Jadwal
    Route::get('/jadwal/get', [JadwalController::class, 'index']);
    Route::get('/jadwal/get/{idJadwal}', [JadwalController::class, 'show']);
    Route::post('/jadwal/create', [JadwalController::class, 'store']);
    Route::put('/jadwal/update/{idJadwal}', [JadwalController::class, 'update']);

    //KoTA
    Route::get('/kota/get', [KotaController::class, 'index']);
    Route::get('/kota/get/{idKota}', [KotaController::class, 'show']);
    Route::post('/kota/create', [KotaController::class, 'store']);
    Route::put('/kota/update/{idKota}', [KotaController::class, 'update']);
    Route::get('/kota/get-id', [KotaController::class, 'getLastID']);
    Route::get('/kota/get-logged-id', [KotaController::class, 'getLoggedID']);
    Route::delete('/kota/delete/{idKota}', [KotaController::class, 'destroy']);

    //Pembimbing
    Route::get('/pembimbing/get-data', [PembimbingController::class, 'getDataPembimbing']);
    Route::get('/pembimbing/get', [PembimbingController::class, 'getListPembimbing']);
    Route::get('/pembimbing/get-pembimbing/{idKota}', [PembimbingController::class, 'getPembimbingFromKota']);
    Route::post('/pembimbing/create', [PembimbingController::class, 'store']);
    Route::post('/pembimbing/create-pembimbing', [PembimbingController::class, 'create']);
    Route::delete('/pembimbing/delete-data/{idPembimbing}', [PembimbingController::class, 'destroy']);
    Route::delete('/pembimbing/delete/{idPembimbing}', [PembimbingController::class, 'deletePembimbing']);

    //Penguji
    Route::get('/penguji/get-data', [PengujiController::class, 'getDataPenguji']);
    Route::get('/penguji/get', [PengujiController::class, 'getListPenguji']);
    Route::post('/penguji/create', [PengujiController::class, 'store']);
    Route::post('/penguji/create-penguji', [PengujiController::class, 'create']);
    Route::delete('/penguji/delete-data/{idPenguji}', [PengujiController::class, 'destroy']);
    Route::delete('/penguji/delete/{idPenguji}', [PengujiController::class, 'deletePenguji']);

    //Dosen
    Route::get('/dosen/get', [DosenController::class,'index']);
    Route::get('/dosen/get/{idDosen}', [DosenController::class,'show']);
    Route::post('/dosen/create', [DosenController::class, 'store']);
    Route::put('/dosen/update/{idDosen}', [DosenController::class, 'update']);
    Route::get('/dosen/get-id', [DosenController::class, 'getLastID']);
    Route::delete('/dosen/delete/{idDosen}', [DosenController::class, 'destroy']);

    //Koordinator
    Route::get('/koordinator/get-prodi/{idUser}', [KoordinatorController::class, 'getProdi']);

    //Bimbingan
    Route::post('/bimbingan/create', [BimbinganController::class, 'store']);
    Route::get('/bimbingan/get-user-kota/{idKota}', [BimbinganController::class, 'getBimbinganFromKota']);
    Route::get('/bimbingan/get-pembimbing/{idPembimbing}', [BimbinganController::class, 'getBimbinganFromPembimbing']);
    Route::delete('/bimbingan/delete/{idBimbingan}', [BimbinganController::class, 'destroy']);
    Route::get('/bimbingan/get-all', [BimbinganController::class, 'getAllBimbingan']);
    Route::get('/bimbingan/get-kota/{idKota}', [BimbinganController::class, 'getBimbinganFromIDKota']);
    Route::get('/bimbingan/get-bimbingan/{idBimbingan}', [BimbinganController::class, 'getBimbinganByID']);
    Route::put('/bimbingan/updateKomentar/{idBimbingan}', [BimbinganController::class, 'updateKomentar']);
    Route::put('/bimbingan/updateBimbingan/{idBimbingan}', [BimbinganController::class, 'updateBimbingan']);

    //Pemberkasan
    Route::get('/berkas/get-all/{jenisSeminar}', [PemberkasanController::class, 'getAllBerkasBySeminar']);
    Route::get('/berkas/get-id/{id}/{seminar_type}', [PemberkasanController::class, 'getBerkasByIDKota']);
    Route::get('/berkas/get-id/{id}/', [PemberkasanController::class, 'getBerkasByIDSeminar']);
    Route::get('/berkas/get/{id}/', [PemberkasanController::class, 'getBerkasByID']);
    Route::get('/berkas/get/{idKota}/{document}/{seminar_type}', [PemberkasanController::class, 'getBerkas']);
    Route::get('/berkas/get-prodi/{prodi}/{seminar_type}', [PemberkasanController::class, 'getBerkasByProdi']);
    Route::get('/berkas/get-kota/{id}/{seminar_type}', [PemberkasanController::class, 'getBerkasByKota']);
    Route::get('/berkas/get-kota/{seminar_type}', [PemberkasanController::class, 'getBerkasByType']);
    Route::post('/berkas/create', [PemberkasanController::class, 'uploadBerkas']);
    Route::put('/berkas/update/{idBerkas}', [PemberkasanController::class, 'updateBerkas']);
    Route::get('/berkas/check-berkas/{id}/{seminar_type}/{jenis_berkas}', [PemberkasanController::class, 'checkIfBerkasExists']);
});



