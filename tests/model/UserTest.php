<?php

namespace App\Tests\Model;

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
        
        $this->testUser('toto@gmail.com', 'Toto', 'Jean', 19, 'JToto', 'Lyon', ['ROLE_ADMIN', 'ROLE_ORGANIZER'], $userRecord);

        $this->entityManager->remove($userRecord);
        $this->entityManager->flush();
    }
}
