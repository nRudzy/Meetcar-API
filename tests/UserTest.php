<?php

namespace App\Tests;

use App\Entity\User;
use App\Tests\DatabaseDependentTestCase;

class UserTest extends DatabaseDependentTestCase
{
    /** @test */
    public function a_user_can_be_created_in_db()
    {
        $user = new User();
        $user->setLastname('Toto');
        $user->setFirstname('Jean');
        $user->setAge(19);
        $user->setPseudo('JToto');
        $user->setCity('Lyon');
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
        $this->assertEquals('Toto', $userRecord->getLastName());
        $this->assertEquals('Jean', $userRecord->getFirstName());
        $this->assertEquals(19, $userRecord->getAge());
        $this->assertEquals('JToto', $userRecord->getPseudo());
        $this->assertTrue(in_array('ROLE_ADMIN', $userRecord->getRoles()));
        $this->assertTrue(in_array('ROLE_ORGANIZER', $userRecord->getRoles()));
        $this->assertTrue(in_array('ROLE_USER', $userRecord->getRoles()));

        $this->entityManager->remove($userRecord);
        $this->entityManager->flush();
    }
}
