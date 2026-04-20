<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kota',
        'id_user',
        'prodi',
        'tahun_ajaran',
        'status',
        'nama_mahasiswa1',
        'nama_mahasiswa2',
        'nama_mahasiswa3',
        'nim1',
        'nim2',
        'nim3',
        'judul_ta',
    ];
}
