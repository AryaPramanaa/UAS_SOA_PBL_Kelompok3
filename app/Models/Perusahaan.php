<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'perusahaans';
    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'kontak',
        'bidang_usaha',
        'status_kerjasama',
        'user_id',
    ];
    public function pengajuanpkl()
    {
        return $this->hasMany(pengajuanPKL::class );
    }
}
