<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseDependentTestCase extends KernelTestCase
{
    /** @var EntityMangerInterface */
    protected $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }
    
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    protected function testUser($email, $lastname, $firstname, $age, $pseudo, $city, $roles, $userRecord): void
    {
        $this->assertEquals($email, $userRecord->getEmail());
        $this->assertEquals($email, $userRecord->getUsername());
        $this->assertEquals($email, $userRecord->getUserIdentifier());
        $this->assertEquals($lastname, $userRecord->getLastName());
        $this->assertEquals($firstname, $userRecord->getFirstName());
        $this->assertEquals($age, $userRecord->getAge());
        $this->assertEquals($pseudo, $userRecord->getPseudo());
        $this->assertEquals($city, $userRecord->getCity());
        $this->assertTrue(in_array('ROLE_USER', $userRecord->getRoles()));

        foreach($roles as $role) {
            $this->assertTrue(in_array($role, $userRecord->getRoles()));
        }
    }
}
