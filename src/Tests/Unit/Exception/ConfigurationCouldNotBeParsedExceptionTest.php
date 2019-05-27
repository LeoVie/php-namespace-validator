<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use LeoVie\PhpNf\Exception\ConfigurationCouldNotBeParsedException;
use PHPUnit\Framework\TestCase;

class ConfigurationCouldNotBeParsedExceptionTest extends TestCase
{
    private const CUSTOM_MESSAGE = 'This is a custom message!';

    public function testExceptionMessageIsDefaultMessageWhenNoMessageIsPassed(): void
    {
        $expectedMessage = ConfigurationCouldNotBeParsedException::DEFAULT_MESSAGE;
        try {
            throw new ConfigurationCouldNotBeParsedException();
        } catch (ConfigurationCouldNotBeParsedException $exception) {
            $actualMessage = $exception->getMessage();
        }

        self::assertEquals($expectedMessage, $actualMessage);
    }

    public function testExceptionMessageIsPassedMessageWhenMessageIsPassed(): void
    {
        $expectedMessage = self::CUSTOM_MESSAGE;
        try {
            throw new ConfigurationCouldNotBeParsedException(
                self::CUSTOM_MESSAGE
            );
        } catch (ConfigurationCouldNotBeParsedException $exception) {
            $actualMessage = $exception->getMessage();
        }

        self::assertEquals($expectedMessage, $actualMessage);
    }
}