<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Perusahaan;

class PerusahaanFactory extends Factory
{
    protected $model = Perusahaan::class;

    public function definition()
    {
        return [
            'nama_perusahaan' => $this->faker->company(),
            'alamat' => $this->faker->address(),
            'kontak' => $this->faker->phoneNumber(),
            'bidang_usaha' => $this->faker->word(),
            'status_kerjasama' => $this->faker->randomElement(['aktif','nonaktif']),
            'user_id' => null,
        ];
    }
}
