<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use LeoVie\PhpNamespaceValidator\Exception\ConfigurationFileNotFoundException;
use PHPUnit\Framework\TestCase;

class ConfigurationFileNotFoundExceptionTest extends TestCase
{
    private const CONFIGURATION_PATH = 'foo/bar/configuration.json';
    private const CUSTOM_MESSAGE = 'This is a custom message!';

    public function testExceptionMessageIsDefaultMessageWhenNoMessageIsPassed()
    {
        $expectedMessage = ConfigurationFileNotFoundException::DEFAULT_MESSAGE_PREFIX . self::CONFIGURATION_PATH;
        try {
            throw new ConfigurationFileNotFoundException(self::CONFIGURATION_PATH);
        } catch (ConfigurationFileNotFoundException $exception) {
            $actualMessage = $exception->getMessage();
        }

        $this->assertEquals($expectedMessage, $actualMessage);
    }

    public function testExceptionMessageIsPassedMessageWhenMessageIsPassed()
    {
        $expectedMessage = self::CUSTOM_MESSAGE;
        try {
            throw new ConfigurationFileNotFoundException(
                self::CONFIGURATION_PATH,
                self::CUSTOM_MESSAGE
            );
        } catch (ConfigurationFileNotFoundException $exception) {
            $actualMessage = $exception->getMessage();
        }

        $this->assertEquals($expectedMessage, $actualMessage);
    }
}