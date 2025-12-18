<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pengumuman;

class PengumumanFactory extends Factory
{
    protected $model = Pengumuman::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $end = (clone $start)->modify('+1 week');

        return [
            'tanggal_buka' => $start->format('Y-m-d'),
            'tanggal_tutup' => $end->format('Y-m-d'),
            'tahun_akademik' => $this->faker->randomElement(['2024/2025','2025/2026','2026/2027']),
            'deskripsi' => $this->faker->sentence(8),
        ];
    }
}
