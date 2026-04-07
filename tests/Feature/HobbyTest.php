<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hobby;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class HobbyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ======================
     * FEATURE TEST (API)
     * ======================
     */

    /** @test */
    public function test_it_can_create_hobby()
    {
        $user = User::factory()->create();

        $payload = [
            'nama_hobi' => 'Membaca',
            'user_id'   => $user->id,
        ];

        $response = $this->postJson('/api/hobbies', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Hobi berhasil ditambahkan.',
                 ]);

        $this->assertDatabaseHas('hobbies', $payload);
    }

    /** @test */
    public function test_it_cannot_create_duplicate_hobby()
    {
        $user = User::factory()->create();

        Hobby::create([
            'nama_hobi' => 'Membaca',
            'user_id'   => $user->id,
        ]);

        $payload = [
            'nama_hobi' => 'Membaca',
            'user_id'   => $user->id,
        ];

        $response = $this->postJson('/api/hobbies', $payload);

        $response->assertStatus(409)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Hobi sudah ada untuk user ini.',
                 ]);
    }

    /** @test */
    public function test_it_returns_validation_error_with_custom_format()
    {
        $response = $this->postJson('/api/hobbies', []);

        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Validasi gagal.',
                 ])
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'errors'
                 ]);
    }

    /** @test */
    public function test_it_can_delete_hobby()
    {
        $hobby = Hobby::factory()->create();

        $response = $this->deleteJson("/api/hobbies/{$hobby->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Hobi berhasil dihapus.',
                 ]);

        $this->assertDatabaseMissing('hobbies', [
            'id' => $hobby->id,
        ]);
    }

    /**
     * ======================
     * EXCEPTION HANDLING TEST 🔥
     * ======================
     */

    /** @test */
    public function it_returns_model_not_found_error()
    {
        $response = $this->deleteJson('/api/hobbies/999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Hobby tidak ditemukan.',
                 ]);
    }

    /** @test */
    public function it_returns_route_not_found_error()
    {
        $response = $this->getJson('/api/hobby-tidak-ada');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Endpoint tidak ditemukan.',
                 ]);
    }

    /** @test */
    public function it_returns_method_not_allowed_error()
    {
        $response = $this->putJson('/api/hobbies', []);

        $response->assertStatus(405)
                 ->assertJson([
                     'success' => false,
                     'message' => 'HTTP method tidak diizinkan.',
                 ]);
    }

    /**
     * ======================
     * MODEL TEST
     * ======================
     */

    /** @test */
    public function hobby_has_correct_fillable_attributes()
    {
        $hobby = new Hobby();

        $this->assertEquals(
            ['nama_hobi', 'user_id'],
            $hobby->getFillable()
        );
    }

    /** @test */
    public function hobby_belongs_to_user()
    {
        $user = User::factory()->create();

        $hobby = Hobby::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $hobby->user);
        $this->assertEquals($user->id, $hobby->user->id);
    }

    /** @test */
    public function user_can_have_many_hobbies()
    {
        $user = User::factory()->create();

        Hobby::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $this->assertCount(3, $user->hobbies);
    }

    /**
     * ======================
     * MIGRATION / DB TEST
     * ======================
     */

    /** @test */
    public function hobbies_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('hobbies', [
                'id',
                'nama_hobi',
                'user_id',
                'created_at',
                'updated_at'
            ])
        );
    }

    /** @test */
    public function it_enforces_foreign_key_constraint()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Hobby::create([
            'nama_hobi' => 'Gaming',
            'user_id'   => 999,
        ]);
    }

    /** @test */
    public function it_cascades_delete_when_user_deleted()
    {
        $user = User::factory()->create();

        $hobby = Hobby::factory()->create([
            'user_id' => $user->id,
        ]);

        $user->delete();

        $this->assertDatabaseMissing('hobbies', [
            'id' => $hobby->id,
        ]);
    }
}