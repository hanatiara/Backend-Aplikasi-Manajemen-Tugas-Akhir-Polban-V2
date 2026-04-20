<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPenguji extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penguji',
        'id_kota',
    ];
}
