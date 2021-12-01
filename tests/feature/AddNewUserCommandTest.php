<?php

namespace App\Tests\feature;

use App\Entity\User;
use App\Tests\DatabaseDependentTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AddNewUserCommandTest extends DatabaseDependentTestCase
{
    /** @test */
    public function user_creation_command_behaves_correctly()
    {
        $application = new Application(self::$kernel);

        $command = $application->find('app:create-new-user');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'email'     => 'tata@gmail.com',
            'password'  => 'password',
            'roles'     => ['ROLE_ADMIN', 'ROLE_TOTO']
        ]);

        $userRepository = $this->entityManager->getRepository(User::class);
        $userRecord = $userRepository->findOneBy(['email' => 'tata@gmail.com']);
        
        $this->assertEquals('tata@gmail.com', $userRecord->getEmail());
        $this->assertEquals('tata@gmail.com', $userRecord->getUsername());
        $this->assertEquals('tata@gmail.com', $userRecord->getUserIdentifier());
        $this->assertTrue(in_array('ROLE_ADMIN', $userRecord->getRoles()));
        $this->assertTrue(in_array('ROLE_TOTO', $userRecord->getRoles()));
        $this->assertTrue(in_array('ROLE_USER', $userRecord->getRoles()));

        $this->entityManager->remove($userRecord);
        $this->entityManager->flush();
    }
}
