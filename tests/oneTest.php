<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class OneTest extends TestCase 
{
    /** @test */
    public function unTest()
    {
        $this->assertEquals(2, 1 + 1);
    }
}
