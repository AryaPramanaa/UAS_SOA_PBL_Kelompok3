<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $fillable = [
        'nim',
        'nama',
        'email',
        'no_hp',
        'status_aktif',
        'alamat',
        'semester',
        'ktm',
        'prodi_id',
        'user_id'
    ];

    public function pengajuanpkl()
    {
        return $this->hasMany(pengajuanPKL::class );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function pembimbingAkademik()
    {
        return $this->belongsToMany(\App\Models\PembimbingAkademik::class, 'mahasiswa_pembimbing_akademik')->withTimestamps();
    }

    public function pembimbingIndustri()
    {
        return $this->belongsToMany(\App\Models\PembimbingIndustri::class, 'mahasiswa_pembimbing_industri', 'mahasiswa_id', 'pembimbing_industri_id')
            ->withTimestamps();
    }
}
