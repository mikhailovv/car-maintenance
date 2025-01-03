<?php

namespace App\Tests\Api;

class CarControllerTest extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testCreateCar()
    {
        $this->post('/api/cars', [
            'name' => 'my car',
            'brand' => 'bmw',
            'model' => '3-series',
            'vin' => 'vin number',
            'color' => 'color',
            'registrationNumber' => '320 AAB',
            'producedAt' => '19.04.2023',
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testListCars()
    {
        $this->get('/api/cars');

        $this->assertResponseIsSuccessful();
    }
}
