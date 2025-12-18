<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prodi;

class ProdiFactory extends Factory
{
    protected $model = Prodi::class;

    public function definition()
    {
        return [
            'nama_prodi' => $this->faker->word(),
            'jurusan' => $this->faker->word(),
            'nama_kaprodi' => $this->faker->name(),
            'user_id' => null,
        ];
    }
}
