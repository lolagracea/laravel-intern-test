<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hobby;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ======================
     * FEATURE TEST (API)
     * ======================
     */

    /** @test */
    public function test_it_can_get_all_users_with_hobbies()
    {
        $user = User::factory()->create();

        Hobby::factory()->count(2)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Data user berhasil diambil.',
                 ])
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         [
                             'id',
                             'nama',
                             'email',
                             'hobbies'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function test_it_can_create_user()
    {
        $payload = [
            'nama'  => 'Budi',
            'email' => 'budi@example.com',
        ];

        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'User berhasil ditambahkan.',
                 ]);

        $this->assertDatabaseHas('users', $payload);
    }

    /** @test */
    public function test_it_validates_required_fields()
    {
        $response = $this->postJson('/api/users', []);

        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Validasi gagal.',
                 ])
                 ->assertJsonValidationErrors(['nama', 'email']);
    }

    /** @test */
    public function test_it_validates_unique_email()
    {
        User::create([
            'nama'  => 'Budi',
            'email' => 'budi@example.com',
        ]);

        $response = $this->postJson('/api/users', [
            'nama'  => 'Budi2',
            'email' => 'budi@example.com',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /**
     * ======================
     * EXCEPTION HANDLING TEST
     * ======================
     */

    /** @test */
    public function test_it_returns_route_not_found_error()
    {
        $response = $this->getJson('/api/user-tidak-ada');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Endpoint tidak ditemukan.',
                 ]);
    }

    /** @test */
    public function test_it_returns_method_not_allowed_error()
    {
        $response = $this->putJson('/api/users', []);

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
    public function test_user_has_correct_fillable_attributes()
    {
        $user = new User();

        $this->assertEquals(
            ['nama', 'email'],
            $user->getFillable()
        );
    }

    /** @test */
    public function test_user_has_many_hobbies()
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
    public function test_users_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id',
                'nama',
                'email',
                'created_at',
                'updated_at'
            ])
        );
    }

    /** @test */
    public function test_email_must_be_unique_in_database()
    {
        User::create([
            'nama'  => 'Budi',
            'email' => 'budi@example.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'nama'  => 'Budi2',
            'email' => 'budi@example.com',
        ]);
    }
}