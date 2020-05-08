<?php

declare(strict_types=1);

namespace Smarttly\ExceptionUtils\Tests;

use PHPUnit\Framework\TestCase;
use Smarttly\ExceptionUtils\ExceptionContextTrait;

class ExceptionContextTest extends TestCase
{
    /**
     * @return void
     */
    public function testPushAndPop(): void
    {
        $mock = $this->getMockForTrait(ExceptionContextTrait::class);

        $data = ['key' => 'Dummy'];

        $mock->setContext($data);

        $this->assertEquals($data, $mock->getContext());
    }
}
