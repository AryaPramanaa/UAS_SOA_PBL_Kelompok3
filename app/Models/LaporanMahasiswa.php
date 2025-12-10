<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMahasiswa extends Model
{
    protected $table = 'laporanMahasiswas';
    protected $fillable = [
        'pengajuanPKL_id',
        'pembimbingIndustri_id',
        'pembimbingAkademik_id',
        'tanggal_laporan',
        'isi_laporan',
    ];

    public function pengajuanPKL()
    {
        return $this->belongsTo(\App\Models\pengajuanPKL::class, 'pengajuanPKL_id');
    }

    public function pembimbingIndustri()
    {
        return $this->belongsTo(\App\Models\PembimbingIndustri::class, 'pembimbingIndustri_id');
    }

    public function pembimbingAkademik()
    {
        return $this->belongsTo(\App\Models\PembimbingAkademik::class, 'pembimbingAkademik_id');
    }
}
