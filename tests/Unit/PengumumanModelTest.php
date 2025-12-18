<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pengumuman;

class PengumumanModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengumuman_can_be_created_via_factory()
    {
        $peng = Pengumuman::factory()->create();

        $this->assertDatabaseHas('pengumumans', [
            'id' => $peng->id,
        ]);
    }
}
