<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hobi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hobis';

    protected $fillable = [
        'no',
        'nama_mahasiswa',
        'hobi',
        'mahasiswa_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(\App\Models\Mahasiswa::class, 'mahasiswa_id');
    }
}
