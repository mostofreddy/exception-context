<?php

declare(strict_types=1);

namespace Smarttly\ExceptionUtils\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Smarttly\ExceptionUtils\{
    ExceptionContextTrait,
    ExceptionFormatter
};

class ExceptionFormatterTest extends TestCase
{
    /**
     * @return void
     */
    public function testFormat(): void
    {
        $message = 'Dummy';
        $code = rand();
        $ex = new Exception($message, $code);
        $context = ['data' => 'dummy'];

        ExceptionFormatter::disableTrace();
        $result = ExceptionFormatter::format($ex, $context);

        $expected = [
            'exception' => get_class($ex),
            'message' => $message,
            'code' => $code,
            'file' => __FILE__ . ':' . $ex->getLine(),
            'triggered' => __CLASS__ . '->testFormat()',
            'context' => $context
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testFormatWithContext(): void
    {
        $message = 'Dummy';
        $code = rand();
        $defaultContext = ['class' => 'ExceptionContextTrait'];
        $context = ['key' => 'Dummy'];

        $ex = new class ($message, $code) extends Exception {
            use ExceptionContextTrait;
        };

        $ex->setContext($context);


        ExceptionFormatter::disableTrace();
        $result = ExceptionFormatter::format($ex, $defaultContext);

        $expected = [
            'exception' => get_class($ex),
            'message' => $message,
            'code' => $code,
            'file' => __FILE__ . ':' . $ex->getLine(),
            'triggered' => __CLASS__ . '->testFormatWithContext()',
            'context' => $context + $defaultContext
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testFormatWithTrace(): void
    {
        $message = 'Dummy';
        $code = rand();
        $ex = new Exception($message, $code);
        $context = ['data' => 'dummy'];

        ExceptionFormatter::enableTrace();
        $result = ExceptionFormatter::format($ex, $context);

        $this->assertTrue(isset($result['trace']));
    }

    /**
     * @return void
     */
    public function testFormatWithoutTrace(): void
    {
        $message = 'Dummy';
        $code = rand();
        $ex = new Exception($message, $code);
        $context = ['data' => 'dummy'];

        ExceptionFormatter::disableTrace();
        $result = ExceptionFormatter::format($ex, $context);

        $this->assertFalse(isset($result['trace']));
    }
}
