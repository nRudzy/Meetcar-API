<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bridge\PhpUnit\SymfonyTestsListener;

class oneTest extends KernelTestCase
{
    public function unTest()
    {
        self::bootKernel();

        $this->assertEquals(true);
    }
}
