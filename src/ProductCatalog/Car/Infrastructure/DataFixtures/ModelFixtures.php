<?php

namespace App\ProductCatalog\Car\Infrastructure\DataFixtures;

use App\ProductCatalog\Car\Domain\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cars = $this->getModels();
        foreach ($cars as $brand => $models) {
            foreach ($models as $modelName) {
                $model = new Model($modelName, $brand);
                $manager->persist($model);
            }
        }

        $manager->flush();
    }


    private function getModels(): array
    {
        return [
            'bmw' => [
                '1 series', '1M', '2 series', '2 series Active Tourer', '2 series Gran Tourer',
                '3 series', '321', '326', '340', '4 series', '5 series', '502', '503', '6 series', '600', '7 series',
                '8 series', 'E3', 'i3', 'i4', 'i5', 'i7', 'i8', 'iX', 'iX1', 'iX3', 'M2', 'M3', 'M4', 'M5', 'M6', 'M8',
                'X1', 'X2', 'X3', 'X3 M', 'X4', 'X4 M', 'X5', 'X5 M', 'X6', 'X6 M', 'X7', 'XM', 'Z1', 'Z3', 'Z4', 'Z8'
            ],
            'mercedes-benz' => [
                "190 (W201)", "190 SL", "A-Class", "A-Class AMG", "AMG GT", "B-Class", "C-Class", "C-Class AMG", "Citan", "CL-Class", "CL-Class AMG", "CLA", "CLA AMG", "CLC-Class", "CLE", "CLE AMG", "CLK-Class", "CLK-Class AMG", "CLS", "CLS AMG", "E-Class", "E-Class AMG",
                "EQA", "EQB", "EQC", "EQE", "EQE AMG", "EQE SUV", "EQS", "EQS AMG", "EQS SUV", "EQV", "G-Class", "G-Class AMG", "G-Class AMG 6x6", "GL-Class", "GL-Class AMG", "GLA", "GLA AMG", "GLB", "GLB AMG", "GLC", "GLC AMG", "GLC Coupe", "GLC Coupe AMG", "GLE", "GLE AMG", "GLE Coupe", "GLE Coupe AMG", "GLK-Class", "GLS", "GLS AMG",
                "M-Class", "M-Class AMG", "Marco Polo", "Maybach EQS SUV", "Maybach G 650 Landaulet", "Maybach GLS", "Maybach S-Class", "Metris", "R-Class", "S-Class", "S-Class AMG", "SL-Class", "SL-Class AMG", "SLC", "SLC AMG", "SLK-Class", "SLK-Class AMG", "SLR McLaren", "SLS AMG", "T-Class", "V-Class", "Vaneo", "Viano", "Vito", "W100", "W108", "W111", "W114", "W115", "W120", "W123", "W124",
                "W128", "W186", "W189", "X-Class"
            ]
        ];
    }
}
