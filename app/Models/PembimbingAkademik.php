<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembimbingAkademik extends Model
{
    use HasFactory;

    protected $table = 'pembimbing_akademik';
    
    protected $fillable = [
        'nama',
        'nip',
        'prodi_id',
        'kapasitas_bimbingan',
        'kontak',
        'email'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'mahasiswa_pembimbing_akademik')
                    ->withTimestamps();
    }
} 