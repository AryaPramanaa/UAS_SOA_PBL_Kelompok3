<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mahasiswa;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition()
    {
        return [
            'nim' => $this->faker->unique()->numerify('########'),
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'no_hp' => $this->faker->unique()->e164PhoneNumber,
            'status_aktif' => 'Aktif',
            'alamat' => $this->faker->address,
            'semester' => (string) $this->faker->numberBetween(1,8),
            'ktm' => null,
            'prodi_id' => \App\Models\Prodi::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
