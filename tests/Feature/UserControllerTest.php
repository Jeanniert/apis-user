<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    
    protected $headers;
    //protected $user;

    public function setUp(): void
    {
        parent::setUp();
        // Crear un usuario y asignar permisos
        Permission::create(['name' => 'Crear usuario','guard_name' => 'api']);
        Permission::create(['name' => 'Listar usuario','guard_name' => 'api']);
        Permission::create(['name' => 'Modificar usuario','guard_name' => 'api']);
        Permission::create(['name' => 'Eliminar usuario','guard_name' => 'api']);
        Permission::create(['name' => 'Ver detalle de usuario','guard_name' => 'api']);

        // Crear un rol y asignar permisos 
        $role = Role::create(['name' => 'admin','guard_name' => 'api']);
        $role->givePermissionTo(['Crear usuario', 'Listar usuario', 'Modificar usuario', 'Eliminar usuario', 'Ver detalle de usuario']);

        // Crear un usuario y asignar el rol 
        $user = User::factory()->create();
        $user->assignRole($role);

        // Generar un token de acceso para el usuario 
        $token = $user->createToken('TestToken')->plainTextToken;
        $this->headers = ['Authorization' => 'Bearer ' .$token];
    }

    /** @test */
    public function it_can_create_a_user()
    {

        $response = $this->postJson('/api/v1/users', [
            'name' => 'New User',  
            'email' => 'newuser@example.com',
            'password' => bcrypt('password'),
            'age' => 25,
            'birthdate' => '1995-01-01',
            'gender' => 'M',
            'dni' => '12345678',
            'address' => '456 Another St',
            'country' => 'USA',
            'phone' => '9876543210',
            'role' => 'admin'
        ], $this->headers);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }


    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/v1/users/{$user->id}", [
            'name' => 'Updated User',
            'email' => 'updateduser@example.com',
            'age' => 25,
            'birthdate' => '1995-01-01',
            'gender' => 'M',
            'dni' => '12345678',
            'address' => '456 Another St',
            'country' => 'USA',
            'phone' => '9876543210',
            'role' => 'admin'
        ], $this->headers);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'updateduser@example.com']);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson("/api/v1/users/{$user->id}", [], $this->headers);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $user = User::factory()->create();
        $response = $this->getJson("/api/v1/users/{$user->id}", $this->headers);

        $response->assertStatus(200)
            ->assertJson(['id' => $user->id, 'email' => $user->email]);
    }

    /** @test */
    public function it_can_list_users()
    {
        $users = User::factory(3)->create();
        $response = $this->getJson('/api/v1/users', $this->headers);

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }
}
