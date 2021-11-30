<?php

namespace App\Tests\feature;

use App\Tests\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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
    }
}