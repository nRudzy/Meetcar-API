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
            'lastname'  => 'Tata',
            'firstname' => 'Jeanne',
            'age'       => 43,
            'pseudo'    => 'JTata',
            'email'     => 'tata@gmail.com',
            'password'  => 'password',
            'city'      => 'Bangladesh',
            'roles'     => ['ROLE_ADMIN', 'ROLE_TOTO']
        ]);

        $userRepository = $this->entityManager->getRepository(User::class);
        $userRecord = $userRepository->findOneBy(['email' => 'tata@gmail.com']);
        
        $this->testUser('tata@gmail.com', 'Tata', 'Jeanne', 43, 'JTata', 'Bangladesh', ['ROLE_ADMIN', 'ROLE_TOTO'], $userRecord);

        $this->entityManager->remove($userRecord);
        $this->entityManager->flush();
    }
}
