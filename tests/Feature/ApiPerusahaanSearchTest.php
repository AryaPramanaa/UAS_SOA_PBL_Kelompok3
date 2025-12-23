<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Perusahaan;

class ApiPerusahaanSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_matching_perusahaan()
    {
        Perusahaan::factory()->create(['nama_perusahaan' => 'Acme Corporation']);
        Perusahaan::factory()->create(['nama_perusahaan' => 'Other Company']);

        $response = $this->getJson('/api/perusahaan/search?q=Acme');

        $response->assertStatus(200);
        $response->assertJsonFragment(['nama_perusahaan' => 'Acme Corporation']);
    }
}
