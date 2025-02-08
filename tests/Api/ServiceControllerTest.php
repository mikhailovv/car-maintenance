<?php

namespace App\Tests\Api;

use App\ProductCatalog\Part\Infrastructure\Repository\PartRepository;

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
            'quantity' => (float)0.95,
            'mileage' => $mileage = random_int(1000, 100000)
        ];

        $response = $this->post('/api/services', $requestData);

        $expectedResponse = [
            'name' => 'oil change',
            'unit_price' => [
                'amount' => '23',
                'currency' => 'EUR'
            ],
            'quantity' => '0.95',
            'mileage' => $mileage,
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

    public function testAddPartToService()
    {
        $user = $this->getLoggedUser();
        $car = $this->createCar($user);
        $category = $this->createCategory('Filters', 'Air filters');
        $airFilter = $this->createPart('Mahle air filter', $user, $category, $car);
        $salonFilter = $this->createPart('Mahle salon filter', $user, $category, $car);


        $service = $this->createService($user, $car,'Filters change');

        $requestData = [
            [
                'part_id' => $airFilter->getId(),
                'quantity' => 1
            ],
            [
                'part_id' => $salonFilter->getId(),
                'quantity' => 2
            ]
        ];

        $response = $this->post("/api/services/{$service->getId()}/parts", $requestData);
        $this->assertResponseStatusCodeSame(200);
    }
}