<?php

namespace App\Tests\Model;

use App\Entity\CarBrands;
use App\Entity\CarModels;
use App\Tests\DatabaseDependentTestCase;

class CarModelsTest extends DatabaseDependentTestCase
{
    /** @test */
    public function a_carmodel_can_be_created_in_db()
    {
        $carBrand = new CarBrands();
        $carBrand->setName('Nissan');

        $this->entityManager->persist($carBrand);
        $this->entityManager->flush();

        $carBrandRepository = $this->entityManager->getRepository(CarBrands::class);
        $carBrandRecord = $carBrandRepository->findOneBy(['name' => 'Nissan']);

        $carModel = new CarModels();
        $carModel->setModel('350Z');
        $carModel->setCarBrand($carBrandRecord->getName());
        $carModel->setIdCarBrand($carBrandRecord);

        $this->entityManager->persist($carModel);
        $this->entityManager->flush();

        $carModelRepository = $this->entityManager->getRepository(CarModels::class);
        $carModelRecord = $carModelRepository->findOneBy(['car_brand' => $carBrandRecord->getName()]);
        
        $this->assertEquals('Nissan', $carModelRecord->getCarBrand());
        $this->assertEquals('350Z', $carModelRecord->getModel());
        $this->assertEquals(gettype($carModel->getIdCarBrand()), gettype($carBrandRecord));
        $this->assertEquals($carModel->getIdCarBrand(), $carBrandRecord);

        $this->entityManager->remove($carBrandRecord);
        $this->entityManager->remove($carModelRecord);
        $this->entityManager->flush();
    }
}
