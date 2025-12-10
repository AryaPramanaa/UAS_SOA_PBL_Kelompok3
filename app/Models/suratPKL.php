<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratPKL extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'suratPKLs';
    
    protected $fillable = [
        'mahasiswa_id',
        'perusahaan_id',
        'nomor_surat',
        'jenis_surat',
        'tanggal_upload',
        'deskripsi',
        'file_path'
    ];

    protected $dates = [
        'tanggal_upload',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(\App\Models\Mahasiswa::class);
    }
}
