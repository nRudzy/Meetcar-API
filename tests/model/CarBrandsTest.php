<?php

namespace App\Tests\Model;

use App\Entity\CarBrands;
use App\Tests\DatabaseDependentTestCase;

class CarBrandsTest extends DatabaseDependentTestCase
{
    /** @test */
    public function a_carbrand_can_be_created_in_db()
    {
        $carBrand = new CarBrands();
        $carBrand->setName('Nissan');

        $this->entityManager->persist($carBrand);
        $this->entityManager->flush();

        $carBrandRepository = $this->entityManager->getRepository(CarBrands::class);
        $carBrandRecord = $carBrandRepository->findOneBy(['name' => 'Nissan']);
        
        $this->assertEquals('Nissan', $carBrandRecord->getName());

        $this->entityManager->remove($carBrandRecord);
        $this->entityManager->flush();
    }
}
