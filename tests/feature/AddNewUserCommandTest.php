<?php

namespace App\Tests\feature;

use App\Entity\User;
use App\Tests\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AddNewUserCommandTest extends KernelTestCase
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
    }
}
