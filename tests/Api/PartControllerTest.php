<?php

namespace Api;
use App\ProductCatalog\Part\Domain\Entity\Category;
use App\ProductCatalog\Part\Domain\Repository\CategoryRepositoryInterface;
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

        $this->post('/api/parts', [
            'part_number' => '123456',
            'original_part_number' => '123456',
            'brand' => 'bmw',
            'name' => 'oil filter',
            'category_id' => $category->getId(),
            'unit_price' => 12.34,
            'currency' => 'EUR',
            'quantity' => 1
        ]);

        $this->assertResponseStatusCodeSame(201);
    }


}