<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Prodi;
use App\Models\User;
use App\Models\Mahasiswa;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_requires_required_fields()
    {
        $response = $this->post('/register/mahasiswa', []);

        $response->assertSessionHasErrors([
            'username','email','password','nim','nama','no_hp','alamat','semester','ktm','prodi_id'
        ]);
    }

    public function test_successful_registration_creates_user_and_mahasiswa()
    {
        $prodi = Prodi::factory()->create();

        $payload = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'nim' => '123456789',
            'nama' => 'Test User',
            'no_hp' => '08123456789',
            'alamat' => 'Jalan Test',
            'semester' => 3,
            'ktm' => UploadedFile::fake()->create('ktm.pdf', 100),
            'prodi_id' => $prodi->id,
        ];

        $response = $this->post('/register/mahasiswa', $payload);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', ['username' => 'testuser', 'email' => 'test@example.com', 'role' => 'mahasiswa']);
        $this->assertDatabaseHas('mahasiswas', ['nim' => '123456789', 'nama' => 'Test User']);

        // KTM path should be persisted on Mahasiswa record
        $mahasiswa = Mahasiswa::where('nim','123456789')->first();
        $this->assertNotNull($mahasiswa->ktm);
        $this->assertStringStartsWith('public/ktm', $mahasiswa->ktm);
    }
}
