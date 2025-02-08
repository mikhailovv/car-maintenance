<?php

namespace Api;

use App\Tests\Api\ApiTestCase;

class PartControllerTest extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testCreatePart(): void
    {
        $category = $this->createCategory(
            'Car filters category',
            'Oil filters'
        );
        $car = $this->createCar($this->getLoggedUser());

        // The request needs to be sent as JSON since the controller uses json_decode()
        $responseData = $this->post('/api/parts', [
            'part_number' => '123456',
            'original_part_number' => '123456',
            'name' => 'oil filter',
            'category_id' => $category->getId(),
            'unit_price' => [
                'amount' => 1234, // Amount in cents
                'currency' => 'EUR'
            ],
            'quantity' => 1.0,
            'description' => null,
            'car_id' => $car->getId()
        ]);

        $this->assertResponseStatusCodeSame(201);

        // Optional: Verify response content
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals('123456', $responseData['part_number']);
        $this->assertEquals('oil filter', $responseData['name']);
    }
}