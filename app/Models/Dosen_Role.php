<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen_Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dosen',
        'id_role',
    ];
}
