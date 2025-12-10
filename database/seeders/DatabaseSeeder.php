<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSedder::class);
        $this->call(ProdiSeeder::class);
        // $this->call(Perusahaan::class);
        // $this->call(PembimbingIndustri::class);
        // $this->call(Mahasiswa::class);
        // $this->call(pengajuanPKLSeeder::class);
        // Tambah akun perusahaan dari JSON
        $jsonPath = public_path('perusahaans.json');
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $data = json_decode($json, true);
            if (is_array($data)) {
                foreach ($data as $item) {
                    if (!isset($item['nama_perusahaan'])) continue;
                    // Cek jika sudah ada user dengan username yang sama
                    if (\App\Models\User::where('username', $item['nama_perusahaan'])->where('role', 'perusahaan')->exists()) continue;
                    \App\Models\User::create([
                        'username' => $item['nama_perusahaan'],
                        'email' => strtolower(str_replace(' ', '', $item['nama_perusahaan'])) . rand(100,999) . '@perusahaan.com',
                        'password' => bcrypt('password'),
                        'role' => 'perusahaan',
                        'status' => 'aktif',
                    ]);
                }
            }
        }
       
        
        
    }
}
