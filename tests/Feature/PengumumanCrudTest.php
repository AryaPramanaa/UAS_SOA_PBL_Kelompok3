<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pengumuman;
use App\Models\User;

class PengumumanCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_operator_pengumuman_index()
    {
        $response = $this->get('/operator/pengumuman');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_index()
    {
        $user = User::factory()->create(['role' => 'operator']);
        Pengumuman::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/operator/pengumuman');

        $response->assertStatus(200);
        $this->assertStringContainsString('Pengumuman', $response->getContent());
    }

    public function test_store_requires_tahun_akademik()
    {
        $user = User::factory()->create(['role' => 'operator']);

        $response = $this->actingAs($user)->post('/operator/pengumuman', [
            // missing 'tahun_akademik'
            'deskripsi' => 'No tahun akademik',
        ]);

        $response->assertSessionHasErrors('tahun_akademik');
    }

    public function test_store_creates_pengumuman()
    {
        $user = User::factory()->create(['role' => 'operator']);

        $payload = [
            'tanggal_buka' => now()->toDateString(),
            'tanggal_tutup' => now()->addWeek()->toDateString(),
            'tahun_akademik' => '2025/2026',
            'deskripsi' => 'New pengumuman',
        ];

        $response = $this->actingAs($user)->post('/operator/pengumuman', $payload);

        $response->assertRedirect(route('operator.pengumuman.index'));
        $this->assertDatabaseHas('pengumumans', ['deskripsi' => 'New pengumuman']);
    }

    public function test_update_modifies_pengumuman()
    {
        $user = User::factory()->create(['role' => 'operator']);
        $peng = Pengumuman::factory()->create(['deskripsi' => 'Old']);

        $response = $this->actingAs($user)->put('/operator/pengumuman/'.$peng->id, [
            'tahun_akademik' => '2025/2026',
            'deskripsi' => 'Updated',
        ]);

        $response->assertRedirect(route('operator.pengumuman.index'));
        $this->assertDatabaseHas('pengumumans', ['id' => $peng->id, 'deskripsi' => 'Updated']);
    }

    public function test_destroy_deletes_pengumuman()
    {
        $user = User::factory()->create(['role' => 'operator']);
        $peng = Pengumuman::factory()->create();

        $response = $this->actingAs($user)->delete('/operator/pengumuman/'.$peng->id);

        $response->assertRedirect(route('operator.pengumuman.index'));
        $this->assertDatabaseMissing('pengumumans', ['id' => $peng->id]);
    }
}
