<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pengumuman;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_heading()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Pengumuman');
    }

    public function test_homepage_shows_pengumuman_when_present()
    {
        $peng = Pengumuman::factory()->create(["deskripsi" => "Testing announcement"]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Testing announcement');
    }
}
