<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kota',
        'tgl_pengumpulan',
        'jenis_berkas',
        'jenis_seminar',
        'status',
        'url_berkas',
        'nama_berkas'
    ];
}
