<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    private $loginEndpoint = '/api/login';

    public function testRequiredFieldsForLogin()
    {
        $this->json('POST', $this->loginEndpoint, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }
    
    
    public function testSuccessfulLogin()
    {
        $user =  User::factory()->create([
            'password' => bcrypt($password = '123456'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $userData = [
            "email" => $user->email,
            "password" => "123456",
        ];

        $this->json('POST', $this->loginEndpoint, $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'attributes' => [
                        'name',
                        'email',
                        'access_token',
                        'created_at',
                    ]                    
                ],
            ]);
            
    }

    public function testLoginWithIncorrectPassword()
    {
        $user =  User::factory()->create([
            'password' => bcrypt($password = '123456'),
        ]);

        $userData = [
            "email" => $user->email,
            "password" => "111111",
        ];

        $this->json('POST', $this->loginEndpoint, $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                "message"
            ]);            
    }
}