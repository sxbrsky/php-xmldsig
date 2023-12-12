<?php

namespace Vendor\Tests\Unit;

use Vendor\Project\Foo;
use Vendor\Tests\TestCase;

class FooTest extends TestCase
{
    public function testMethod(): void
    {
        $foo = new Foo();

        self::assertTrue($foo->foo());
    }
}
