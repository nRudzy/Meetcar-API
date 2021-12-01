<?php

namespace App\Tests;

use App\Entity\User;
use App\Tests\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /** @var EntityMangerInterface */
    private $entityManager;

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

    /** @test */
    public function a_user_can_be_created_in_db()
    {
        $user = new User();
        $user->setEmail('toto@gmail.com');
        $user->setPassword('passwd');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_ORGANIZER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userRepository = $this->entityManager->getRepository(User::class);
        $userRecord = $userRepository->findOneBy(['email' => 'toto@gmail.com']);
        
        $this->assertEquals('toto@gmail.com', $userRecord->getEmail());
        $this->assertEquals('toto@gmail.com', $userRecord->getUsername());
        $this->assertEquals('toto@gmail.com', $userRecord->getUserIdentifier());
        $this->assertTrue(in_array('ROLE_ADMIN', $userRecord->getRoles()));
        $this->assertTrue(in_array('ROLE_ORGANIZER', $userRecord->getRoles()));
        $this->assertTrue(in_array('ROLE_USER', $userRecord->getRoles()));

        $this->entityManager->remove($userRecord);
        $this->entityManager->flush();
    }
}
