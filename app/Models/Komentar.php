<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pembimbing',
        'id_bimbingan',
        'tgl_komentar',
        'waktu_komentar',
        'komentar'
    ];
}
