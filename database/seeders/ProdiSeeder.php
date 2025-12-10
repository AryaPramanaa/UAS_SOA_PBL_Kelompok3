<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodis = [
            // ========== TEKNIK MESIN ==========
            [
                'nama_prodi' => 'D3 Teknik Mesin',
                'nama_kaprodi' => 'Teknik Mesin 1',
                'jurusan' => 'Teknik Mesin',
            ],
            [
                'nama_prodi' => 'D3 Teknik Alat Berat',
                'nama_kaprodi' => 'Teknik Mesin 2',
                'jurusan' => 'Teknik Mesin',
            ],
            [
                'nama_prodi' => 'D4 Teknik Manufaktur',
                'nama_kaprodi' => 'Teknik Mesin 3',
                'jurusan' => 'Teknik Mesin',
            ],
            [
                'nama_prodi' => 'D4 Rekayasa Perancangan Mekanik',
                'nama_kaprodi' => 'Teknik Mesin 4',
                'jurusan' => 'Teknik Mesin',
            ],

            // ========== TEKNIK ELEKTRO ==========
            [
                'nama_prodi' => 'D3 Teknik Listrik',
                'nama_kaprodi' => 'Teknik Elektro 1',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'nama_prodi' => 'D4 Teknologi Rekayasa Instalasi Listrik',
                'nama_kaprodi' => 'Teknik Elektro 2',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'nama_prodi' => 'D3 Teknik Listrik (Kampus Pelalawan)',
                'nama_kaprodi' => 'Teknik Elektro 3',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'nama_prodi' => 'D2 Jalur Cepat Instalasi dan Pemeliharaan Kabel Bertegangan Rendah',
                'nama_kaprodi' => 'Teknik Elektro 4',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'nama_prodi' => 'D3 Teknik Elektronika',
                'nama_kaprodi' => 'Teknik Elektro 5',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'nama_prodi' => 'D4 Teknik Elektronika',
                'nama_kaprodi' => 'Teknik Elektro 6',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'nama_prodi' => 'D3 Teknik Telekomunikasi',
                'nama_kaprodi' => 'Teknik Elektro 7',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'nama_prodi' => 'D4 Teknik Telekomunikasi',
                'nama_kaprodi' => 'Teknik Elektro 8',
                'jurusan' => 'Teknik Elektro',
            ],

            // ========== TEKNIK SIPIL ==========
            [
                'nama_prodi' => 'D3 Teknik Sipil',
                'nama_kaprodi' => 'Teknik Sipil 1',
                'jurusan' => 'Teknik Sipil',
            ],
            [
                'nama_prodi' => 'D3 Teknologi Sipil (Kampus Tanah Datar)',
                'nama_kaprodi' => 'Teknik Sipil 2',
                'jurusan' => 'Teknik Sipil',
            ],
            [
                'nama_prodi' => 'D4 Teknik Perancangan Irigasi & Rawa',
                'nama_kaprodi' => 'Teknik Sipil 3',
                'jurusan' => 'Teknik Sipil',
            ],
            [
                'nama_prodi' => 'D4 Management Rekayasa Konstruksi',
                'nama_kaprodi' => 'Teknik Sipil 4',
                'jurusan' => 'Teknik Sipil',
            ],
            [
                'nama_prodi' => 'D4 Perancangan Jalan & Jembatan',
                'nama_kaprodi' => 'Teknik Sipil 5',
                'jurusan' => 'Teknik Sipil',
            ],
            [
                'nama_prodi' => 'Magister Terapan Rekayasa Perawatan dan Restorasi Jembatan',
                'nama_kaprodi' => 'Teknik Sipil 6',
                'jurusan' => 'Teknik Sipil',
            ],

            // ========== ADMINISTRASI NIAGA ==========
            [
                'nama_prodi' => 'D3 Administrasi Bisnis',
                'nama_kaprodi' => 'Administrasi Niaga 1',
                'jurusan' => 'Administrasi Niaga',
            ],
            [
                'nama_prodi' => 'D4 Usaha Perjalanan Wisata',
                'nama_kaprodi' => 'Administrasi Niaga 2',
                'jurusan' => 'Administrasi Niaga',
            ],
            [
                'nama_prodi' => 'D4 Destinasi Pariwisata',
                'nama_kaprodi' => 'Administrasi Niaga 3',
                'jurusan' => 'Administrasi Niaga',
            ],
            [
                'nama_prodi' => 'D4 Bisnis Digital',
                'nama_kaprodi' => 'Administrasi Niaga 4',
                'jurusan' => 'Administrasi Niaga',
            ],
            [
                'nama_prodi' => 'D4 Logistik Perdagangan Internasional',
                'nama_kaprodi' => 'Administrasi Niaga 5',
                'jurusan' => 'Administrasi Niaga',
            ],

            // ========== AKUNTANSI ==========
            [
                'nama_prodi' => 'D3 Akuntansi',
                'nama_kaprodi' => 'Akuntansi 1',
                'jurusan' => 'Akuntansi',
            ],
            [
                'nama_prodi' => 'D3 Akuntansi (PSDKU Solsel)',
                'nama_kaprodi' => 'Akuntansi 2',
                'jurusan' => 'Akuntansi',
            ],
            [
                'nama_prodi' => 'D4 Akuntansi',
                'nama_kaprodi' => 'Akuntansi 3',
                'jurusan' => 'Akuntansi',
            ],
            [
                'nama_prodi' => 'Magister Terapan Sistem Informasi Akuntansi',
                'nama_kaprodi' => 'Akuntansi 4',
                'jurusan' => 'Akuntansi',
            ],

            // ========== TEKNOLOGI INFORMASI ==========
            [
                'nama_prodi' => 'D4 Teknologi Rekayasa Perangkat Lunak',
                'nama_kaprodi' => 'Teknologi Informasi 1',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D4 Animasi',
                'nama_kaprodi' => 'Teknologi Informasi 2',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D3 Manajemen Informatika',
                'nama_kaprodi' => 'Teknologi Informasi 3',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D3 Teknik Komputer',
                'nama_kaprodi' => 'Teknologi Informasi 4',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D2 Administrasi Jaringan Komputer',
                'nama_kaprodi' => 'Teknologi Informasi 5',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D3 Sistem Informasi (PSDKU Tanah Datar)',
                'nama_kaprodi' => 'Teknologi Informasi 6',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D3 Manajemen Informatika (PSDKU Pelalawan)',
                'nama_kaprodi' => 'Teknologi Informasi 7',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D3 Teknik Komputer (PSDKU Solok Selatan)',
                'nama_kaprodi' => 'Teknologi Informasi 8',
                'jurusan' => 'Teknologi Informasi',
            ],

            // ========== BAHASA INGGRIS ==========
            [
                'nama_prodi' => 'D3 Bahasa Inggris',
                'nama_kaprodi' => 'Bahasa Inggris 1',
                'jurusan' => 'Bahasa Inggris',
            ],
            [
                'nama_prodi' => 'D4 Bahasa Inggris untuk Komunikasi Bisnis dan Professional',
                'nama_kaprodi' => 'Bahasa Inggris 2',
                'jurusan' => 'Bahasa Inggris',
            ],
        ];

        foreach ($prodis as $prodi) {
            // Buat user untuk kaprodi
            $user = User::create([
                'username' => $prodi['nama_kaprodi'],
                'email' => strtolower(str_replace(' ', '_', $prodi['nama_kaprodi'])) . '@kaprodi.simag.test',
                'password' => Hash::make('password'),
                'role' => 'kaprodi',
                'status' => 'Aktif',
            ]);
            // Hubungkan user_id ke prodi
            $prodi['user_id'] = $user->id;
            // Insert prodi
            DB::table('prodis')->insert($prodi);
        }
    }
}