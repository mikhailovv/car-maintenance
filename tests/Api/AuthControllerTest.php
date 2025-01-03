<?php

namespace App\Tests\Api;

class AuthControllerTest extends ApiTestCase
{
    public function testLogin()
    {
        $response = $this->post('/api/login', [
            'email' => 'bmw-owner@admin.com',
            'password' => 'bmw-owner',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $response);
        $this->authToken = $response['token'];
    }
}
