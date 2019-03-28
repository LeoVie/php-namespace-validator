<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use LeoVie\PhpNamespaceValidator\Exception\ConfigurationCouldNotBeParsedException;
use PHPUnit\Framework\TestCase;

class ConfigurationCouldNotBeParsedExceptionTest extends TestCase
{
    private const CUSTOM_MESSAGE = 'This is a custom message!';

    public function testExceptionMessageIsDefaultMessageWhenNoMessageIsPassed()
    {
        $expectedMessage = ConfigurationCouldNotBeParsedException::DEFAULT_MESSAGE;
        try {
            throw new ConfigurationCouldNotBeParsedException();
        } catch (ConfigurationCouldNotBeParsedException $exception) {
            $actualMessage = $exception->getMessage();
        }

        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testExceptionMessageIsPassedMessageWhenMessageIsPassed()
    {
        $expectedMessage = self::CUSTOM_MESSAGE;
        try {
            throw new ConfigurationCouldNotBeParsedException(
                self::CUSTOM_MESSAGE
            );
        } catch (ConfigurationCouldNotBeParsedException $exception) {
            $actualMessage = $exception->getMessage();
        }

        $this->assertEquals($expectedMessage, $actualMessage);
    }
}