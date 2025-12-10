<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganPKL extends Model
{
    use HasFactory;
    protected $table = 'lowonganPKL';
    protected $fillable = [
        'perusahaan_id',
        'divisi',
        'deskripsi',
        'syarat',
        'kuota'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}
