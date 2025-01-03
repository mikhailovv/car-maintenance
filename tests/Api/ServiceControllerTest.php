<?php

namespace App\Tests\Api;

class ServiceControllerTest extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testCreateService()
    {
        $cars = $this->get('/api/cars');
        $requestData = [
            'name' => 'oil change',
            'currency' => 'EUR',
            'car_id' => $cars[0]['id'],
            'unit_price' => (float)23.34,
            'quantity' => (float)0.95
        ];

        $response = $this->post('/api/services', $requestData);

        $expectedResponse = [
            'name' => 'oil change',
            'unit_price' => [
                'amount' => '23',
                'currency' => 'EUR'
            ],
            'quantity' => '0.95',
            'total_price' => [
                'amount' => '0',
                'currency' => 'EUR'
            ]
        ];

        $this->arrayContainsArrayValues($expectedResponse, $response);
        $this->assertResponseStatusCodeSame(201);
    }

    public function testGetService()
    {
        $response = $this->get('/api/services');
        $this->assertResponseIsSuccessful();
        $this->arrayHasKey('name', $response[0]);
        $this->arrayHasKey('unit_price', $response[0]);
        $this->arrayHasKey('quantity', $response[0]);
    }
}