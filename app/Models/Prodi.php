<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prodi extends Model
{
    use HasFactory;
    protected $table = 'prodis';
    protected $fillable = [
        'nama_prodi',
        'jurusan',
        'nama_kaprodi',
        'user_id',
    ];
}
