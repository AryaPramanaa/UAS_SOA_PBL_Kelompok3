<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Hobi;

class OperatorHobiTest extends TestCase
{
    use RefreshDatabase;

    protected function makeOperator()
    {
        return User::factory()->create(['role' => 'operator']);
    }

    public function test_operator_can_create_hobi_and_no_assigned_sequentially()
    {
        $operator = $this->makeOperator();
        $m1 = Mahasiswa::factory()->create(['nama' => 'Budi', 'nim' => '123']);

        $response = $this->actingAs($operator)->post(route('operator.hobi.store'), [
            'mahasiswa_id' => $m1->id,
            'hobi' => 'basket',
        ]);

        $response->assertRedirect(route('operator.hobi.index'));

        $this->assertDatabaseHas('hobis', [
            'mahasiswa_id' => $m1->id,
            'hobi' => 'basket',
            'no' => 1,
        ]);

        // create another and expect no = 2
        $m2 = Mahasiswa::factory()->create(['nama' => 'Ani', 'nim' => '456']);
        $this->actingAs($operator)->post(route('operator.hobi.store'), [
            'mahasiswa_id' => $m2->id,
            'hobi' => 'membaca',
        ]);

        $this->assertDatabaseHas('hobis', [
            'mahasiswa_id' => $m2->id,
            'hobi' => 'membaca',
            'no' => 2,
        ]);
    }

    public function test_validation_requires_mahasiswa_and_hobi()
    {
        $operator = $this->makeOperator();

        $response = $this->actingAs($operator)->post(route('operator.hobi.store'), []);

        $response->assertSessionHasErrors(['mahasiswa_id', 'hobi']);
    }

    public function test_operator_can_update_hobi()
    {
        $operator = $this->makeOperator();
        $m1 = Mahasiswa::factory()->create(['nama' => 'Budi', 'nim' => '123']);
        $m2 = Mahasiswa::factory()->create(['nama' => 'Siti', 'nim' => '789']);

        $hobi = Hobi::create([
            'no' => 1,
            'mahasiswa_id' => $m1->id,
            'nama_mahasiswa' => $m1->nama,
            'hobi' => 'sepakbola',
        ]);

        $response = $this->actingAs($operator)->put(route('operator.hobi.update', $hobi), [
            'mahasiswa_id' => $m2->id,
            'hobi' => 'renang',
        ]);

        $response->assertRedirect(route('operator.hobi.index'));

        $this->assertDatabaseHas('hobis', [
            'id' => $hobi->id,
            'mahasiswa_id' => $m2->id,
            'hobi' => 'renang',
        ]);
    }

    public function test_delete_resequences_numbers()
    {
        $operator = $this->makeOperator();
        $m1 = Mahasiswa::factory()->create();
        $m2 = Mahasiswa::factory()->create();
        $m3 = Mahasiswa::factory()->create();

        // create three hobis using the model directly to set initial numbers
        $h1 = Hobi::create(['no' => 1, 'mahasiswa_id' => $m1->id, 'nama_mahasiswa' => $m1->nama, 'hobi' => 'a']);
        $h2 = Hobi::create(['no' => 2, 'mahasiswa_id' => $m2->id, 'nama_mahasiswa' => $m2->nama, 'hobi' => 'b']);
        $h3 = Hobi::create(['no' => 3, 'mahasiswa_id' => $m3->id, 'nama_mahasiswa' => $m3->nama, 'hobi' => 'c']);

        // delete the middle one
        $response = $this->actingAs($operator)->delete(route('operator.hobi.destroy', $h2));
        $response->assertRedirect(route('operator.hobi.index'));

        // remaining should be two entries with no 1 and 2
        $this->assertDatabaseHas('hobis', ['id' => $h1->id, 'no' => 1]);
        $this->assertDatabaseHas('hobis', ['id' => $h3->id, 'no' => 2]);
    }

    public function test_non_operator_cannot_access_routes()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $m = Mahasiswa::factory()->create();

        $response = $this->actingAs($user)->post(route('operator.hobi.store'), [
            'mahasiswa_id' => $m->id,
            'hobi' => 'test',
        ]);

        $response->assertStatus(403);
    }
}
