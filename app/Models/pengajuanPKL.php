<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pengajuanPKL extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pengajuanPKLs';
    protected $fillable = [
        'mahasiswa_id',
        'perusahaan_id',
        'tanggal_pengajuan',
        'divisi_pilihan',
        'cv',
        'status',
        'alasan_penolakan'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class )->with('prodi');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class );
    }
    
}
